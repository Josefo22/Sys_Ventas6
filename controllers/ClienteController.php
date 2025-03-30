<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar clientes
 */
class ClienteController extends Controller {
    private $clienteModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->clienteModel = $this->loadModel('Cliente');
    }
    
    /**
     * Método para mostrar la lista de clientes
     */
    public function index() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $clientes = $this->clienteModel->getClientesActivos();
        $this->view('clientes/index', [
            'pageTitle' => 'Gestión de Clientes',
            'clientes' => $clientes
        ]);
    }
    
    /**
     * Método para mostrar el formulario de crear cliente
     */
    public function create() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $this->view('clientes/create', [
            'pageTitle' => 'Crear Cliente'
        ]);
    }
    
    /**
     * Método para guardar un nuevo cliente
     */
    public function store() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos del formulario
        if (empty($_POST['nombre']) || empty($_POST['telefono']) || 
            empty($_POST['direccion']) || empty($_POST['cedula'])) {
            $this->redirect('Cliente/create?error=1');
            return;
        }
        
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $cedula = $_POST['cedula'];
        $usuario_id = $_SESSION['idUser'];
        
        // Verificar si la cédula ya existe
        $existe = $this->clienteModel->buscarPorCedula($cedula);
        if ($existe) {
            $this->redirect('Cliente/create?error=2');
            return;
        }
        
        // Guardar el cliente
        $resultado = $this->clienteModel->crearCliente($nombre, $telefono, $direccion, $cedula, $usuario_id);
        
        if ($resultado) {
            $this->redirect('Cliente?success=1');
        } else {
            $this->redirect('Cliente/create?error=3');
        }
    }
    
    /**
     * Método para mostrar el formulario de editar cliente
     */
    public function edit($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Cliente');
            return;
        }
        
        $cliente = $this->clienteModel->getCliente($id);
        
        if (!$cliente) {
            $this->redirect('Cliente?error=1');
            return;
        }
        
        $this->view('clientes/edit', [
            'pageTitle' => 'Editar Cliente',
            'cliente' => $cliente
        ]);
    }
    
    /**
     * Método para actualizar un cliente
     */
    public function update() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos del formulario
        if (empty($_POST['id']) || empty($_POST['nombre']) || 
            empty($_POST['telefono']) || empty($_POST['direccion']) || 
            empty($_POST['cedula'])) {
            $this->redirect('Cliente/edit/' . $_POST['id'] . '?error=1');
            return;
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $cedula = $_POST['cedula'];
        
        // Verificar si la cédula ya existe y no es del mismo cliente
        $existe = $this->clienteModel->buscarPorCedula($cedula);
        if ($existe && $existe['idcliente'] != $id) {
            $this->redirect('Cliente/edit/' . $id . '?error=2');
            return;
        }
        
        // Actualizar el cliente
        $resultado = $this->clienteModel->actualizarCliente($id, $nombre, $telefono, $direccion, $cedula);
        
        if ($resultado) {
            $this->redirect('Cliente?success=2');
        } else {
            $this->redirect('Cliente/edit/' . $id . '?error=3');
        }
    }
    
    /**
     * Método para eliminar un cliente
     */
    public function delete($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos
        if ($id === null) {
            $this->redirect('Cliente?error=1');
            return;
        }
        
        // Cambiar estado del cliente
        $resultado = $this->clienteModel->cambiarEstado($id, 0);
        
        if ($resultado) {
            $this->redirect('Cliente?success=3');
        } else {
            $this->redirect('Cliente?error=2');
        }
    }
    
    /**
     * Método para buscar un cliente por cédula (AJAX)
     */
    public function buscar() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['cedula'])) {
            $this->jsonResponse(['error' => 'Cédula no proporcionada'], 400);
            return;
        }
        
        $cedula = $_POST['cedula'];
        $cliente = $this->clienteModel->buscarPorCedula($cedula);
        
        if ($cliente) {
            $this->jsonResponse($cliente);
        } else {
            $this->jsonResponse(['error' => 'Cliente no encontrado'], 404);
        }
    }
    
    /**
     * Método para buscar clientes para autocompletado (AJAX)
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
        
        $clientes = $this->clienteModel->buscarClientes($term);
        $result = [];
        
        foreach ($clientes as $cliente) {
            $result[] = [
                'id' => $cliente['idcliente'],
                'label' => $cliente['nombre'],
                'telefono' => $cliente['telefono'],
                'direccion' => $cliente['direccion']
            ];
        }
        
        // Devolver resultados en formato JSON
        $this->jsonResponse($result);
    }
    
    /**
     * Método para buscar clientes por nombre (AJAX para autocompletado)
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
        
        $clientes = $this->clienteModel->buscarClientes($term);
        $result = [];
        
        foreach ($clientes as $cliente) {
            $result[] = [
                'id' => $cliente['idcliente'],
                'label' => $cliente['nombre'],
                'value' => $cliente['nombre'],
                'telefono' => $cliente['telefono'],
                'direccion' => $cliente['direccion']
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
}
?> 