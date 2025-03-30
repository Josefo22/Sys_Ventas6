<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar ventas
 */
class VentaController extends Controller {
    private $ventaModel;
    private $clienteModel;
    private $productoModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->ventaModel = $this->loadModel('Venta');
        $this->clienteModel = $this->loadModel('Cliente');
        $this->productoModel = $this->loadModel('Producto');
    }
    
    /**
     * Método para mostrar la lista de ventas
     */
    public function index() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $ventas = $this->ventaModel->getVentas();
        $this->view('ventas/index', [
            'pageTitle' => 'Historial de Ventas',
            'ventas' => $ventas
        ]);
    }
    
    /**
     * Método para mostrar el formulario de nueva venta
     */
    public function create() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $clientes = $this->clienteModel->getClientesActivos();
        $this->view('ventas/create', [
            'pageTitle' => 'Nueva Venta',
            'clientes' => $clientes
        ]);
    }
    
    /**
     * Método para agregar un producto al carrito (AJAX)
     */
    public function agregarProducto() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Validar datos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
            empty($_POST['id_producto']) || 
            empty($_POST['cantidad']) || 
            empty($_POST['precio'])) {
            $this->jsonResponse(['error' => 'Datos incompletos'], 400);
            return;
        }
        
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $id_usuario = $_SESSION['idUser'];
        
        // Verificar si hay suficiente stock
        $producto = $this->productoModel->getProducto($id_producto);
        if (!$producto) {
            $this->jsonResponse(['error' => 'Producto no encontrado'], 404);
            return;
        }
        
        if ($producto['existencia'] < $cantidad) {
            $this->jsonResponse(['error' => 'Stock insuficiente', 'stock' => $producto['existencia']], 400);
            return;
        }
        
        // Agregar al carrito
        $resultado = $this->ventaModel->agregarAlCarrito($id_producto, $id_usuario, $cantidad, $precio);
        
        if ($resultado) {
            $carrito = $this->ventaModel->getCarrito($id_usuario);
            $total = $this->ventaModel->getTotalCarrito($id_usuario);
            
            $this->jsonResponse([
                'message' => 'Producto agregado al carrito',
                'carrito' => $carrito,
                'total' => $total
            ]);
        } else {
            $this->jsonResponse(['error' => 'Error al agregar al carrito'], 500);
        }
    }
    
    /**
     * Método para eliminar un producto del carrito (AJAX)
     */
    public function eliminarDelCarrito() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Validar datos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
            $this->jsonResponse(['error' => 'ID no proporcionado'], 400);
            return;
        }
        
        $id = $_POST['id'];
        $id_usuario = $_SESSION['idUser'];
        
        // Eliminar del carrito
        $resultado = $this->ventaModel->eliminarDelCarrito($id);
        
        if ($resultado) {
            $carrito = $this->ventaModel->getCarrito($id_usuario);
            $total = $this->ventaModel->getTotalCarrito($id_usuario);
            
            $this->jsonResponse([
                'message' => 'Producto eliminado del carrito',
                'carrito' => $carrito,
                'total' => $total
            ]);
        } else {
            $this->jsonResponse(['error' => 'Error al eliminar del carrito'], 500);
        }
    }
    
    /**
     * Método para procesar una venta
     */
    public function procesarVenta() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['status' => false, 'message' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        // Validar datos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_cliente']) || empty($_POST['total']) || empty($_POST['productos'])) {
            $this->jsonResponse(['status' => false, 'message' => 'Datos incompletos'], 400);
            return;
        }
        
        $id_cliente = $_POST['id_cliente'];
        $total = $_POST['total'];
        $id_usuario = $_SESSION['idUser'];
        $productos = json_decode($_POST['productos'], true);
        
        // Verificar si hay productos
        if (empty($productos)) {
            $this->jsonResponse(['status' => false, 'message' => 'No hay productos en la venta'], 400);
            return;
        }
        
        // Verificar stock suficiente
        foreach ($productos as $producto) {
            $stock_actual = $this->productoModel->getProducto($producto['id'])['existencia'];
            if ($stock_actual < $producto['cantidad']) {
                $this->jsonResponse(['status' => false, 'message' => 'No hay suficiente stock para el producto ' . $producto['descripcion']], 400);
                return;
            }
        }
        
        // Registrar la venta
        $id_venta = $this->ventaModel->registrarVenta($id_cliente, $total, $id_usuario);
        
        if (!$id_venta) {
            $this->jsonResponse(['status' => false, 'message' => 'Error al registrar la venta'], 500);
            return;
        }
        
        // Registrar los detalles de la venta
        $error = false;
        foreach ($productos as $producto) {
            $result = $this->ventaModel->registrarDetalleVenta(
                $id_venta,
                $producto['id'],
                $producto['cantidad'],
                $producto['precio']
            );
            
            if (!$result) {
                $error = true;
                break;
            }
            
            // Actualizar stock del producto
            $this->productoModel->disminuirStock($producto['id'], $producto['cantidad']);
        }
        
        if ($error) {
            $this->jsonResponse(['status' => false, 'message' => 'Error al registrar los detalles de la venta'], 500);
            return;
        }
        
        $this->jsonResponse(['status' => true, 'id_venta' => $id_venta]);
    }
    
    /**
     * Método para mostrar la factura de una venta
     */
    public function factura($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Venta');
            return;
        }
        
        $venta = $this->ventaModel->getVenta($id);
        
        if (!$venta) {
            $this->redirect('Venta?error=1');
            return;
        }
        
        $detalle = $this->ventaModel->getDetalleVenta($id);
        
        $this->view('ventas/factura', [
            'pageTitle' => 'Factura #' . $id,
            'venta' => $venta,
            'detalle' => $detalle
        ]);
    }
    
    /**
     * Método para anular una venta
     */
    public function anular($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        if ($id === null) {
            $this->redirect('Venta?error=1');
            return;
        }
        
        $resultado = $this->ventaModel->anularVenta($id);
        
        if ($resultado) {
            $this->redirect('Venta?success=1');
        } else {
            $this->redirect('Venta?error=2');
        }
    }
    
    /**
     * Método para obtener el carrito actual (AJAX)
     */
    public function getCarrito() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        $id_usuario = $_SESSION['idUser'];
        $carrito = $this->ventaModel->getCarrito($id_usuario);
        $total = $this->ventaModel->getTotalCarrito($id_usuario);
        
        $this->jsonResponse([
            'carrito' => $carrito,
            'total' => $total
        ]);
    }
    
    /**
     * Método para procesar una venta con datos enviados por JSON
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
        if (empty($data['id_cliente']) || empty($data['total']) || empty($data['productos'])) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Datos incompletos'], 400);
            return;
        }
        
        $id_cliente = $data['id_cliente'];
        $total = $data['total'];
        $id_usuario = $_SESSION['idUser'];
        $productos = $data['productos'];
        
        // Verificar si hay productos
        if (empty($productos)) {
            $this->jsonResponse(['status' => 'error', 'message' => 'No hay productos en la venta'], 400);
            return;
        }
        
        // Verificar stock suficiente
        foreach ($productos as $producto) {
            $stock_actual = $this->productoModel->getProducto($producto['id'])['existencia'];
            if ($stock_actual < $producto['cantidad']) {
                $this->jsonResponse([
                    'status' => 'error', 
                    'message' => 'No hay suficiente stock para el producto ' . $producto['descripcion'],
                    'producto' => $producto['descripcion'],
                    'stock_actual' => $stock_actual,
                    'cantidad_solicitada' => $producto['cantidad']
                ], 400);
                return;
            }
        }
        
        // Registrar la venta
        $id_venta = $this->ventaModel->registrarVenta($id_cliente, $total, $id_usuario);
        
        if (!$id_venta) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Error al registrar la venta'], 500);
            return;
        }
        
        // Registrar los detalles de la venta
        $error = false;
        foreach ($productos as $producto) {
            $result = $this->ventaModel->registrarDetalleVenta(
                $id_venta,
                $producto['id'],
                $producto['cantidad'],
                $producto['precio']
            );
            
            if (!$result) {
                $error = true;
                break;
            }
            
            // Actualizar stock del producto
            $this->productoModel->disminuirStock($producto['id'], $producto['cantidad']);
        }
        
        if ($error) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Error al registrar los detalles de la venta'], 500);
            return;
        }
        
        $this->jsonResponse(['status' => 'success', 'id_venta' => $id_venta]);
    }
    
    /**
     * Método para generar el PDF de una venta
     */
    public function pdf($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Venta');
            return;
        }
        
        // Obtener datos de la venta para conseguir el id del cliente
        $venta = $this->ventaModel->getVenta($id);
        
        if (!$venta) {
            $this->redirect('Venta?error=1');
            return;
        }
        
        // Redirigir al script de generación de PDF
        header('Location: ' . BASE_URL . 'src/pdf/ventas/generar.php?v=' . $id . '&cl=' . $venta['id_cliente']);
        exit;
    }
}
?> 