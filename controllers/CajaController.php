<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar la caja y ventas diarias
 */
class CajaController extends Controller {
    private $cajaModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->cajaModel = $this->loadModel('Caja');
    }
    
    /**
     * Método para mostrar el resumen de caja diaria
     */
    public function index() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        // Obtener la fecha actual o la fecha seleccionada
        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
        
        // Obtener datos de ventas del día
        $ventas = $this->cajaModel->getVentasDia($fecha);
        $totalVentas = $this->cajaModel->getTotalVentasDia($fecha);
        $numeroVentas = $this->cajaModel->getNumeroVentasDia($fecha);
        $productosMasVendidos = $this->cajaModel->getProductosMasVendidosDia($fecha);
        
        // Obtener datos de compras del día
        $compras = $this->cajaModel->getComprasDia($fecha);
        $totalCompras = $this->cajaModel->getTotalComprasDia($fecha);
        $numeroCompras = $this->cajaModel->getNumeroComprasDia($fecha);
        $productosMasComprados = $this->cajaModel->getProductosMasCompradosDia($fecha);
        
        // Calcular el balance (ventas - compras)
        $balance = $totalVentas - $totalCompras;
        
        $this->view('caja/index', [
            'pageTitle' => 'Caja Diaria',
            'ventas' => $ventas,
            'totalVentas' => $totalVentas,
            'numeroVentas' => $numeroVentas,
            'productosMasVendidos' => $productosMasVendidos,
            'compras' => $compras,
            'totalCompras' => $totalCompras,
            'numeroCompras' => $numeroCompras,
            'productosMasComprados' => $productosMasComprados,
            'balance' => $balance,
            'fecha' => $fecha
        ]);
    }
} 