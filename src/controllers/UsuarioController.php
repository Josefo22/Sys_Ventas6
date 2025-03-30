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
        // Verificar permisos
        if (!$this->hasPermission('usuarios')) {
            $this->redirect('index.php');
        }
        
        $usuarios = $this->usuarioModel->getUsuariosActivos();
        $this->view('usuarios/index', ['usuarios' => $usuarios]);
    }
    
    /**
     * Método para mostrar el formulario de crear usuario
     */
    public function create() {
        // Verificar permisos
        if (!$this->hasPermission('usuarios')) {
            $this->redirect('index.php');
        }
        
        $this->view('usuarios/create');
    }
    
    /**
     * Método para guardar un nuevo usuario
     */
    public function store() {
        // Verificar permisos
        if (!$this->hasPermission('usuarios')) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
        
        // Validar datos del formulario
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave'])) {
            $this->jsonResponse(['error' => 'Todos los campos son obligatorios'], 400);
        }
        
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        
        // Guardar el usuario
        $resultado = $this->usuarioModel->crearUsuario($nombre, $correo, $usuario, $clave);
        
        if ($resultado) {
            $this->jsonResponse(['message' => 'Usuario creado correctamente', 'id' => $resultado]);
        } else {
            $this->jsonResponse(['error' => 'Error al crear el usuario'], 500);
        }
    }
    
    /**
     * Método para mostrar el formulario de editar usuario
     */
    public function edit($id) {
        // Verificar permisos
        if (!$this->hasPermission('usuarios')) {
            $this->redirect('index.php');
        }
        
        $usuario = $this->usuarioModel->getById($id);
        
        if (!$usuario) {
            $this->redirect('usuarios.php');
        }
        
        $this->view('usuarios/edit', ['usuario' => $usuario]);
    }
    
    /**
     * Método para actualizar un usuario
     */
    public function update() {
        // Verificar permisos
        if (!$this->hasPermission('usuarios')) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
        
        // Validar datos del formulario
        if (empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])) {
            $this->jsonResponse(['error' => 'Todos los campos son obligatorios'], 400);
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        
        // Actualizar el usuario
        $resultado = $this->usuarioModel->actualizarUsuario($id, $nombre, $correo, $usuario);
        
        if ($resultado) {
            $this->jsonResponse(['message' => 'Usuario actualizado correctamente']);
        } else {
            $this->jsonResponse(['error' => 'Error al actualizar el usuario'], 500);
        }
    }
    
    /**
     * Método para eliminar un usuario
     */
    public function delete() {
        // Verificar permisos
        if (!$this->hasPermission('usuarios')) {
            $this->jsonResponse(['error' => 'No tiene permisos para realizar esta acción'], 403);
        }
        
        // Validar datos
        if (empty($_POST['id'])) {
            $this->jsonResponse(['error' => 'ID de usuario no válido'], 400);
        }
        
        $id = $_POST['id'];
        
        // Cambiar estado en lugar de eliminar
        $resultado = $this->usuarioModel->cambiarEstado($id, 0);
        
        if ($resultado) {
            $this->jsonResponse(['message' => 'Usuario eliminado correctamente']);
        } else {
            $this->jsonResponse(['error' => 'Error al eliminar el usuario'], 500);
        }
    }
    
    /**
     * Método para autenticar usuarios
     */
    public function login() {
        if (isset($_POST['usuario']) && isset($_POST['clave'])) {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            
            $user = $this->usuarioModel->validarUsuario($usuario, $clave);
            
            if ($user) {
                // Establecer variables de sesión
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $user['idusuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['user'] = $user['usuario'];
                
                $this->redirect('src/index.php');
            } else {
                $this->redirect('index.php?error=1');
            }
        } else {
            $this->redirect('index.php');
        }
    }
    
    /**
     * Método para cerrar sesión
     */
    public function logout() {
        session_destroy();
        $this->redirect('../index.php');
    }
}
?>