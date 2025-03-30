<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar productos
 */
class ProductoController extends Controller {
    private $productoModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->productoModel = $this->loadModel('Producto');
    }
    
    /**
     * Método para mostrar la lista de productos
     */
    public function index() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $productos = $this->productoModel->getProductosActivos();
        $this->view('productos/index', [
            'pageTitle' => 'Gestión de Productos',
            'productos' => $productos
        ]);
    }
    
    /**
     * Método para mostrar el formulario de crear producto
     */
    public function create() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $this->view('productos/create', [
            'pageTitle' => 'Crear Producto'
        ]);
    }
    
    /**
     * Método para guardar un nuevo producto
     */
    public function store() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos del formulario
        if (empty($_POST['codigo']) || empty($_POST['descripcion']) || 
            empty($_POST['precio']) || empty($_POST['existencia'])) {
            $this->redirect('Producto/create?error=1');
            return;
        }
        
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $existencia = $_POST['existencia'];
        $usuario_id = $_SESSION['idUser'];
        
        // Verificar si el código ya existe
        $existe = $this->productoModel->buscarPorCodigo($codigo);
        if ($existe) {
            $this->redirect('Producto/create?error=2');
            return;
        }
        
        // Guardar el producto
        $resultado = $this->productoModel->crearProducto($codigo, $descripcion, $precio, $existencia, $usuario_id);
        
        if ($resultado) {
            $this->redirect('Producto?success=1');
        } else {
            $this->redirect('Producto/create?error=3');
        }
    }
    
    /**
     * Método para mostrar el formulario de editar producto
     */
    public function edit($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Producto');
            return;
        }
        
        $producto = $this->productoModel->getProducto($id);
        
        if (!$producto) {
            $this->redirect('Producto?error=1');
            return;
        }
        
        $this->view('productos/edit', [
            'pageTitle' => 'Editar Producto',
            'producto' => $producto
        ]);
    }
    
    /**
     * Método para actualizar un producto
     */
    public function update() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos del formulario
        if (empty($_POST['id']) || empty($_POST['codigo']) || 
            empty($_POST['descripcion']) || empty($_POST['precio']) || 
            empty($_POST['existencia'])) {
            $this->redirect('Producto/edit/' . $_POST['id'] . '?error=1');
            return;
        }
        
        $id = $_POST['id'];
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $existencia = $_POST['existencia'];
        
        // Verificar si el código ya existe y no es del mismo producto
        $existe = $this->productoModel->buscarPorCodigo($codigo);
        if ($existe && $existe['codproducto'] != $id) {
            $this->redirect('Producto/edit/' . $id . '?error=2');
            return;
        }
        
        // Actualizar el producto
        $resultado = $this->productoModel->actualizarProducto($id, $codigo, $descripcion, $precio, $existencia);
        
        if ($resultado) {
            $this->redirect('Producto?success=2');
        } else {
            $this->redirect('Producto/edit/' . $id . '?error=3');
        }
    }
    
    /**
     * Método para desactivar un producto
     */
    public function desactivar($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos
        if ($id === null) {
            $this->redirect('Producto?error=1');
            return;
        }
        
        // Cambiar estado del producto
        $resultado = $this->productoModel->cambiarEstado($id, 0);
        
        if ($resultado) {
            $this->redirect('Producto?success=3');
        } else {
            $this->redirect('Producto?error=2');
        }
    }
    
    /**
     * Método para activar un producto
     */
    public function activar($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos
        if ($id === null) {
            $this->redirect('Producto?error=1');
            return;
        }
        
        // Cambiar estado del producto
        $resultado = $this->productoModel->cambiarEstado($id, 1);
        
        if ($resultado) {
            $this->redirect('Producto?success=4');
        } else {
            $this->redirect('Producto?error=2');
        }
    }
    
    /**
     * Método para buscar un producto por código (AJAX)
     */
    public function buscar() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['codigo'])) {
            $this->jsonResponse(['error' => 'Código no proporcionado'], 400);
            return;
        }
        
        $codigo = $_POST['codigo'];
        $producto = $this->productoModel->buscarPorCodigo($codigo);
        
        if ($producto) {
            $this->jsonResponse($producto);
        } else {
            $this->jsonResponse(['error' => 'Producto no encontrado'], 404);
        }
    }
    
    /**
     * Método para buscar productos para autocompletado (AJAX)
     */
    public function buscarAjax() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Verificar si se recibió el término de búsqueda
        $term = isset($_GET['term']) ? $_GET['term'] : '';
        
        if (empty($term)) {
            $this->jsonResponse([]);
            return;
        }
        
        $productos = $this->productoModel->buscarProductos($term);
        $result = [];
        
        foreach ($productos as $producto) {
            $result[] = [
                'id' => $producto['codproducto'],
                'label' => $producto['descripcion'],
                'codigo' => $producto['codigo'],
                'descripcion' => $producto['descripcion'],
                'stock' => $producto['existencia'],
                'precio' => $producto['precio']
            ];
        }
        
        // Devolver resultados en formato JSON
        $this->jsonResponse($result);
    }
    
    /**
     * Método para buscar productos por nombre para el autocompletado (AJAX)
     */
    public function buscarPorNombre() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Verificar si se recibió el término de búsqueda
        $term = isset($_GET['term']) ? $_GET['term'] : '';
        
        if (empty($term)) {
            $this->jsonResponse([]);
            return;
        }
        
        $productos = $this->productoModel->buscarProductos($term);
        $result = [];
        
        foreach ($productos as $producto) {
            $result[] = [
                'id' => $producto['codproducto'],
                'label' => $producto['codigo'] . ' - ' . $producto['descripcion'],
                'value' => $producto['descripcion'],
                'codigo' => $producto['codigo'],
                'descripcion' => $producto['descripcion'],
                'existencia' => $producto['existencia'],
                'precio' => $producto['precio']
            ];
        }
        
        // Devolver resultados en formato JSON
        $this->jsonResponse($result);
    }
    
    /**
     * Método para obtener un producto por su ID (AJAX)
     */
    public function obtenerPorId() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Verificar si se recibió el ID
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
            $this->jsonResponse(['error' => 'ID no proporcionado'], 400);
            return;
        }
        
        $id = $_POST['id'];
        $producto = $this->productoModel->getProducto($id);
        
        if ($producto) {
            // Formatear respuesta para que coincida con lo que espera el cliente
            $response = [
                'id' => $producto['codproducto'],
                'codigo' => $producto['codigo'],
                'descripcion' => $producto['descripcion'],
                'existencia' => $producto['existencia'],
                'precio' => $producto['precio'],
                'precio_venta' => $producto['precio'] // Usar el mismo precio para venta
            ];
            $this->jsonResponse($response);
        } else {
            $this->jsonResponse(['error' => 'Producto no encontrado'], 404);
        }
    }
    
    /**
     * Método para responder en formato JSON
     */
    protected function jsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
?> 