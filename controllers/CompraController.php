<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar compras
 */
class CompraController extends Controller {
    private $compraModel;
    private $proveedorModel;
    private $productoModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->compraModel = $this->loadModel('Compra');
        $this->proveedorModel = $this->loadModel('Proveedor');
        $this->productoModel = $this->loadModel('Producto');
    }
    
    /**
     * Método para mostrar la lista de compras
     */
    public function index() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $compras = $this->compraModel->getCompras();
        $this->view('compras/index', [
            'pageTitle' => 'Historial de Compras',
            'compras' => $compras
        ]);
    }
    
    /**
     * Método para mostrar el formulario de nueva compra
     */
    public function create() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        // Obtener lista de proveedores para el formulario
        $proveedores = $this->proveedorModel->getProveedoresActivos();
        
        $this->view('compras/create', [
            'pageTitle' => 'Nueva Compra',
            'proveedores' => $proveedores
        ]);
    }
    
    /**
     * Método para agregar un producto al carrito de compras (AJAX)
     */
    public function agregarProducto() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_producto']) || empty($_POST['cantidad']) || empty($_POST['precio'])) {
            $this->jsonResponse(['error' => 'Datos incompletos'], 400);
            return;
        }
        
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $id_usuario = $_SESSION['idUser'];
        
        $resultado = $this->compraModel->agregarAlCarritoCompra($id_producto, $id_usuario, $cantidad, $precio);
        
        if ($resultado) {
            $this->jsonResponse(['success' => 'Producto agregado al carrito']);
        } else {
            $this->jsonResponse(['error' => 'Error al agregar el producto'], 500);
        }
    }
    
    /**
     * Método para obtener los productos en el carrito de compras (AJAX)
     */
    public function getCarritoCompra() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        $id_usuario = $_SESSION['idUser'];
        $productos = $this->compraModel->getCarritoCompra($id_usuario);
        $total = $this->compraModel->getTotalCarritoCompra($id_usuario);
        
        $this->jsonResponse([
            'productos' => $productos,
            'total' => $total
        ]);
    }
    
    /**
     * Método para eliminar un producto del carrito (AJAX)
     */
    public function eliminarProducto() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
            $this->jsonResponse(['error' => 'Datos incompletos'], 400);
            return;
        }
        
        $id = $_POST['id'];
        
        $resultado = $this->compraModel->eliminarDelCarritoCompra($id);
        
        if ($resultado) {
            $this->jsonResponse(['success' => 'Producto eliminado del carrito']);
        } else {
            $this->jsonResponse(['error' => 'Error al eliminar el producto'], 500);
        }
    }
    
    /**
     * Método para procesar una compra
     */
    public function procesarCompra() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['status' => false, 'message' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Validar datos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_proveedor']) || empty($_POST['total']) || empty($_POST['productos'])) {
            $this->jsonResponse(['status' => false, 'message' => 'Datos incompletos'], 400);
            return;
        }
        
        $id_proveedor = $_POST['id_proveedor'];
        $total = $_POST['total'];
        $id_usuario = $_SESSION['idUser'];
        $productos = json_decode($_POST['productos'], true);
        
        // Verificar si hay productos
        if (empty($productos)) {
            $this->jsonResponse(['status' => false, 'message' => 'No hay productos en la compra'], 400);
            return;
        }
        
        // Registrar la compra
        $id_compra = $this->compraModel->registrarCompra($id_proveedor, $total, $id_usuario);
        
        if (!$id_compra) {
            $this->jsonResponse(['status' => false, 'message' => 'Error al registrar la compra'], 500);
            return;
        }
        
        // Registrar los detalles de la compra
        $error = false;
        foreach ($productos as $producto) {
            $result = $this->compraModel->registrarDetalleCompra(
                $id_compra,
                $producto['id'],
                $producto['cantidad'],
                $producto['precio']
            );
            
            if (!$result) {
                $error = true;
                break;
            }
            
            // Actualizar stock del producto
            $this->productoModel->actualizarStock($producto['id'], $producto['cantidad']);
        }
        
        if ($error) {
            $this->jsonResponse(['status' => false, 'message' => 'Error al registrar los detalles de la compra'], 500);
            return;
        }
        
        $this->jsonResponse(['status' => true, 'id_compra' => $id_compra]);
    }
    
    /**
     * Método para procesar una compra con datos enviados por JSON
     */
    public function store() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['status' => 'error', 'message' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Obtener y decodificar datos JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        // Validar datos
        if (empty($data['id_proveedor']) || empty($data['total']) || empty($data['productos'])) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Datos incompletos'], 400);
            return;
        }
        
        $id_proveedor = $data['id_proveedor'];
        $total = $data['total'];
        $id_usuario = $_SESSION['idUser'];
        $productos = $data['productos'];
        
        // Verificar si hay productos
        if (empty($productos)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'No hay productos en la compra'], 400);
            return;
        }
        
        // Registrar la compra
        $id_compra = $this->compraModel->registrarCompra($id_proveedor, $total, $id_usuario);
        
        if (!$id_compra) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Error al registrar la compra'], 500);
            return;
        }
        
        // Registrar los detalles de la compra
        $error = false;
        foreach ($productos as $producto) {
            $result = $this->compraModel->registrarDetalleCompra(
                $id_compra,
                $producto['id'],
                $producto['cantidad'],
                $producto['precio']
            );
            
            if (!$result) {
                $error = true;
                break;
            }
            
            // Actualizar stock del producto
            $this->productoModel->actualizarStock($producto['id'], $producto['cantidad']);
        }
        
        if ($error) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Error al registrar los detalles de la compra'], 500);
            return;
        }
        
        $this->jsonResponse(['status' => 'success', 'id_compra' => $id_compra]);
    }
    
    /**
     * Método para ver detalles de una compra
     */
    public function ver($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Compra');
            return;
        }
        
        $compra = $this->compraModel->getCompra($id);
        
        if (!$compra) {
            $this->redirect('Compra?error=1');
            return;
        }
        
        $detalle = $this->compraModel->getDetalleCompra($id);
        
        $this->view('compras/ver', [
            'pageTitle' => 'Detalle de Compra #' . $id,
            'compra' => $compra,
            'detalle' => $detalle
        ]);
    }
    
    /**
     * Método para generar el PDF de una compra
     */
    public function generarPDF($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Compra');
            return;
        }
        
        // Redirigir al script de generación de PDF
        header('Location: ' . BASE_URL . 'src/pdf/compras/generar.php?c=' . $id);
        exit;
    }
} 