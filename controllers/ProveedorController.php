<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar proveedores
 */
class ProveedorController extends Controller {
    private $proveedorModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->proveedorModel = $this->loadModel('Proveedor');
    }
    
    /**
     * Método para mostrar la lista de proveedores
     */
    public function index() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $proveedores = $this->proveedorModel->getProveedoresActivos();
        $totalProveedores = $this->proveedorModel->getTotalProveedores();
        $proveedoresActivos = $this->proveedorModel->getCountProveedoresActivos();
        $comprasMes = $this->proveedorModel->getTotalComprasMes();
        
        $this->view('proveedor/index', [
            'pageTitle' => 'Gestión de Proveedores',
            'proveedores' => $proveedores,
            'totalProveedores' => $totalProveedores,
            'proveedoresActivos' => $proveedoresActivos,
            'comprasMes' => $comprasMes
        ]);
    }
    
    /**
     * Método para mostrar el formulario de crear proveedor
     */
    public function create() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $this->view('proveedor/create', [
            'pageTitle' => 'Crear Proveedor'
        ]);
    }
    
    /**
     * Método para guardar un nuevo proveedor
     */
    public function store() {
        // Verificar si es una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Proveedor');
            return;
        }
        
        // Datos del formulario
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        
        // Validar datos
        if (empty($nombre)) {
            // Mostrar error
            $_SESSION['error'] = 'El nombre es obligatorio';
            $this->redirect('Proveedor/create');
            return;
        }
        
        // Guardar proveedor
        $result = $this->proveedorModel->saveProveedor($nombre, $telefono, $direccion);
        
        if ($result) {
            $_SESSION['success'] = 'Proveedor registrado con éxito';
            $this->redirect('Proveedor');
        } else {
            $_SESSION['error'] = 'Error al registrar el proveedor';
            $this->redirect('Proveedor/create');
        }
    }
    
    /**
     * Método para mostrar el formulario de editar proveedor
     */
    public function edit($id) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        // Obtener datos del proveedor
        $proveedor = $this->proveedorModel->getProveedor($id);
        
        if (!$proveedor) {
            $_SESSION['error'] = 'Proveedor no encontrado';
            $this->redirect('Proveedor');
            return;
        }
        
        $this->view('proveedor/edit', [
            'pageTitle' => 'Editar Proveedor',
            'proveedor' => $proveedor
        ]);
    }
    
    /**
     * Método para actualizar un proveedor
     */
    public function update() {
        // Verificar si es una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Proveedor');
            return;
        }
        
        // Datos del formulario
        $id = $_POST['id'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        
        // Validar datos
        if (empty($nombre) || empty($id)) {
            // Mostrar error
            $_SESSION['error'] = 'Todos los campos son obligatorios';
            $this->redirect('Proveedor/edit/' . $id);
            return;
        }
        
        // Actualizar proveedor
        $result = $this->proveedorModel->updateProveedor($id, $nombre, $telefono, $direccion);
        
        if ($result) {
            $_SESSION['success'] = 'Proveedor actualizado con éxito';
            $this->redirect('Proveedor');
        } else {
            $_SESSION['error'] = 'Error al actualizar el proveedor';
            $this->redirect('Proveedor/edit/' . $id);
        }
    }
    
    /**
     * Método para eliminar un proveedor
     */
    public function delete($id) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $result = $this->proveedorModel->deleteProveedor($id);
        
        if ($result) {
            $_SESSION['success'] = 'Proveedor eliminado con éxito';
        } else {
            $_SESSION['error'] = 'Error al eliminar el proveedor';
        }
        
        $this->redirect('Proveedor');
    }
    
    /**
     * Método para verificar el acceso
     */
    protected function checkAccess() {
        if (empty($_SESSION['active'])) {
            header('location: ' . BASE_URL . 'Auth');
            return false;
        }
        
        return true;
    }
    
    /**
     * Método para buscar proveedores para autocompletado (AJAX)
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
        
        $proveedores = $this->proveedorModel->searchProveedores($term);
        $result = [];
        
        foreach ($proveedores as $proveedor) {
            $result[] = [
                'id' => $proveedor['idproveedor'],
                'label' => $proveedor['nombre'],
                'telefono' => $proveedor['telefono'],
                'direccion' => $proveedor['direccion']
            ];
        }
        
        // Devolver resultados en formato JSON
        $this->jsonResponse($result);
    }
    
    /**
     * Método para buscar proveedores por nombre (AJAX para autocompletado)
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
        
        $proveedores = $this->proveedorModel->searchProveedores($term);
        $result = [];
        
        foreach ($proveedores as $proveedor) {
            $result[] = [
                'id' => $proveedor['idproveedor'],
                'label' => $proveedor['nombre'],
                'value' => $proveedor['nombre'],
                'telefono' => $proveedor['telefono'],
                'direccion' => $proveedor['direccion']
            ];
        }
        
        // Devolver resultados en formato JSON
        $this->jsonResponse($result);
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
    
    /**
     * Endpoint para obtener el total de compras del mes (AJAX)
     */
    public function obtenerTotalMes() {
        // Verificar si el usuario está logueado
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        $comprasMes = $this->proveedorModel->getTotalComprasMes();
        $this->jsonResponse(['total' => $comprasMes]);
    }
}
?> 