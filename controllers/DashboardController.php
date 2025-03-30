<?php
require_once 'Controller.php';

/**
 * Controlador para el Dashboard
 */
class DashboardController extends Controller {
    private $usuarioModel;
    private $productoModel;
    private $clienteModel;
    private $ventaModel;
    private $cajaModel;
    private $compraModel;
    private $proveedorModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = $this->loadModel('Usuario');
        $this->productoModel = $this->loadModel('Producto');
        $this->clienteModel = $this->loadModel('Cliente');
        $this->ventaModel = $this->loadModel('Venta');
        $this->cajaModel = $this->loadModel('Caja');
        $this->compraModel = $this->loadModel('Compra');
        $this->proveedorModel = $this->loadModel('Proveedor');
    }
    
    /**
     * Método para mostrar el dashboard
     */
    public function index() {
        if (!$this->checkPermission('dashboard')) {
            $this->redirect('Auth');
            return;
        }
        
        // Obtener datos para el dashboard
        $clientes = $this->clienteModel->contarClientesActivos();
        $productos = $this->productoModel->contarProductosActivos();
        $usuarios = $this->usuarioModel->contarUsuariosActivos();
        $ventas = $this->ventaModel->contarVentas();
        
        // Datos para gráficos
        $ventasPorMes = $this->ventaModel->getVentasPorMes();
        $ventasPorDia = $this->ventaModel->getVentasPorDia();
        $productosMasVendidos = $this->ventaModel->getProductosMasVendidos();
        $ventasPorCategoria = $this->ventaModel->getVentasPorCategoria();
        
        // Preparar arrays para los gráficos
        $meses = [];
        $ventasMensuales = [];
        foreach ($ventasPorMes as $venta) {
            $meses[] = $venta['mes'];
            $ventasMensuales[] = $venta['total'];
        }
        
        $dias = [];
        $ventasDiarias = [];
        foreach ($ventasPorDia as $venta) {
            $dias[] = $venta['dia'];
            $ventasDiarias[] = $venta['total'];
        }
        
        $nombresProductos = [];
        $cantidadesProductos = [];
        foreach ($productosMasVendidos as $producto) {
            $nombresProductos[] = $producto['descripcion'];
            $cantidadesProductos[] = $producto['cantidad'];
        }
        
        $categorias = [];
        $ventasPorCat = [];
        foreach ($ventasPorCategoria as $categoria) {
            $categorias[] = $categoria['categoria'];
            $ventasPorCat[] = $categoria['total'];
        }
        
        $this->view('dashboard/index', [
            'pageTitle' => 'Dashboard - Sistema de Ventas',
            'current_page' => 'dashboard',
            'clientes' => $clientes,
            'productos' => $productos,
            'usuarios' => $usuarios,
            'ventas' => $ventas,
            'meses' => $meses,
            'ventasPorMes' => $ventasMensuales,
            'dias' => $dias,
            'ventasPorDia' => $ventasDiarias,
            'nombresProductos' => $nombresProductos,
            'cantidadesProductos' => $cantidadesProductos,
            'categorias' => $categorias,
            'ventasPorCategoria' => $ventasPorCat
        ]);
    }
    
    /**
     * Método para obtener datos para las gráficas (vía AJAX)
     */
    public function getChartData() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        // Datos para las gráficas
        $ventasPorMes = $this->ventaModel->getVentasPorMes();
        $ventasPorDia = $this->ventaModel->getVentasPorDia();
        $productosMasVendidos = $this->ventaModel->getProductosMasVendidos(5);
        $ventasPorCategoria = $this->ventaModel->getVentasPorCategoria();
        
        $data = [
            'ventasPorMes' => $ventasPorMes,
            'ventasPorDia' => $ventasPorDia,
            'productosMasVendidos' => $productosMasVendidos,
            'ventasPorCategoria' => $ventasPorCategoria
        ];
        
        // Devolver datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>