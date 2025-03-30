<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar usuarios
 */
class UsuarioController extends Controller {
    private $usuarioModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = $this->loadModel('Usuario');
    }
    
    /**
     * Método para mostrar la lista de usuarios
     */
    public function index() {
        // Verificar si el usuario está logueado y tiene permiso de usuarios
        if (!$this->checkPermission('usuarios')) {
            return;
        }
        
        $usuarios = $this->usuarioModel->getUsuariosActivos();
        $this->view('usuarios/index', [
            'pageTitle' => 'Gestión de Usuarios',
            'usuarios' => $usuarios
        ]);
    }
    
    /**
     * Método para mostrar el formulario de crear usuario
     */
    public function create() {
        // Verificar si el usuario está logueado y tiene permiso de usuarios
        if (!$this->checkPermission('usuarios')) {
            return;
        }
        
        // Obtener roles disponibles
        $rolModel = $this->loadModel('Rol');
        $roles = $rolModel->getRoles();
        
        $this->view('usuarios/create', [
            'pageTitle' => 'Crear Usuario',
            'roles' => $roles
        ]);
    }
    
    /**
     * Método para guardar un nuevo usuario
     */
    public function store() {
        // Verificar si el usuario está logueado y tiene permiso de usuarios
        if (!$this->checkPermission('usuarios')) {
            return;
        }
        
        // Validar datos del formulario
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave'])) {
            $this->redirect('Usuario/create?error=1');
            return;
        }
        
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $id_rol = !empty($_POST['id_rol']) ? $_POST['id_rol'] : null;
        
        // Guardar el usuario
        $resultado = $this->usuarioModel->crearUsuario($nombre, $correo, $usuario, $clave, $id_rol);
        
        if ($resultado) {
            $this->redirect('Usuario?success=1');
        } else {
            $this->redirect('Usuario/create?error=2');
        }
    }
    
    /**
     * Método para mostrar el formulario de editar usuario
     */
    public function edit($id = null) {
        // Verificar si el usuario está logueado y tiene permiso de usuarios
        if (!$this->checkPermission('usuarios')) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Usuario');
            return;
        }
        
        $usuario = $this->usuarioModel->getById($id);
        
        if (!$usuario) {
            $this->redirect('Usuario?error=1');
            return;
        }
        
        // Obtener roles disponibles
        $rolModel = $this->loadModel('Rol');
        $roles = $rolModel->getRoles();
        
        $this->view('usuarios/edit', [
            'pageTitle' => 'Editar Usuario',
            'usuario' => $usuario,
            'roles' => $roles
        ]);
    }
    
    /**
     * Método para actualizar un usuario
     */
    public function update() {
        // Verificar si el usuario está logueado y tiene permiso de usuarios
        if (!$this->checkPermission('usuarios')) {
            return;
        }
        
        // Validar datos del formulario
        if (empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])) {
            $this->redirect('Usuario/edit/' . $_POST['id'] . '?error=1');
            return;
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $id_rol = !empty($_POST['id_rol']) ? $_POST['id_rol'] : null;
        
        // Actualizar el usuario
        $resultado = $this->usuarioModel->actualizarUsuario($id, $nombre, $correo, $usuario, $id_rol);
        
        if ($resultado) {
            $this->redirect('Usuario?success=2');
        } else {
            $this->redirect('Usuario/edit/' . $id . '?error=2');
        }
    }
    
    /**
     * Método para eliminar un usuario
     */
    public function delete($id = null) {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            $this->redirect('Auth');
            return;
        }
        
        // Validar datos
        if ($id === null) {
            $this->redirect('Usuario?error=1');
            return;
        }
        
        // Cambiar estado en lugar de eliminar
        $resultado = $this->usuarioModel->cambiarEstado($id, 0);
        
        if ($resultado) {
            $this->redirect('Usuario?success=3');
        } else {
            $this->redirect('Usuario?error=2');
        }
    }
    
    /**
     * Método para ver el perfil del usuario
     */
    public function profile() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        $id = $_SESSION['idUser'];
        $usuario = $this->usuarioModel->getById($id);
        
        if (!$usuario) {
            $this->redirect('Dashboard');
            return;
        }
        
        $this->view('usuarios/profile', [
            'pageTitle' => 'Mi Perfil',
            'usuario' => $usuario
        ]);
    }
    
    /**
     * Método para cambiar la contraseña del usuario
     */
    public function changePassword() {
        // Verificar si el usuario está logueado
        if (!$this->checkAccess()) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Usuario/profile');
            return;
        }
        
        // Validar datos
        if (empty($_POST['clave_actual']) || empty($_POST['clave_nueva']) || empty($_POST['clave_confirmar'])) {
            $this->redirect('Usuario/profile?error=1');
            return;
        }
        
        $id = $_SESSION['idUser'];
        $clave_actual = $_POST['clave_actual'];
        $clave_nueva = $_POST['clave_nueva'];
        $clave_confirmar = $_POST['clave_confirmar'];
        
        // Verificar que las claves nuevas coincidan
        if ($clave_nueva !== $clave_confirmar) {
            $this->redirect('Usuario/profile?error=2');
            return;
        }
        
        // Verificar clave actual
        $usuario = $this->usuarioModel->validarUsuario($_SESSION['user'], $clave_actual);
        
        if (!$usuario) {
            $this->redirect('Usuario/profile?error=3');
            return;
        }
        
        // Cambiar clave
        $resultado = $this->usuarioModel->cambiarClave($id, $clave_nueva);
        
        if ($resultado) {
            $this->redirect('Usuario/profile?success=1');
        } else {
            $this->redirect('Usuario/profile?error=4');
        }
    }
    
    /**
     * Método para enviar respuestas JSON
     */
    protected function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}
?> 