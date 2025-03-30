<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar la autenticación
 */
class AuthController extends Controller {
    private $usuarioModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = $this->loadModel('Usuario');
    }
    
    /**
     * Método para mostrar el formulario de login
     */
    public function index() {
        // Si ya está logueado, redireccionar al dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('Dashboard');
        }
        
        // Mostrar vista de login
        $this->view('auth/login', ['pageTitle' => 'Iniciar Sesión']);
    }
    
    /**
     * Método para procesar el login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                    
                    // Cargar permisos del usuario
                    $permisoModel = $this->loadModel('Permiso');
                    $permisos = $permisoModel->getPermisosUsuario($user['idusuario']);
                    
                    // Preparar array de permisos para la sesión
                    $_SESSION['permisos'] = [];
                    foreach ($permisos as $permiso) {
                        $_SESSION['permisos'][$permiso['nombre']] = 1;
                    }
                    
                    $this->redirect('Dashboard');
                } else {
                    $this->redirect('Auth/index?error=1');
                }
            } else {
                $this->redirect('Auth/index?error=2');
            }
        } else {
            $this->redirect('Auth/index');
        }
    }
    
    /**
     * Método para cerrar sesión
     */
    public function logout() {
        session_destroy();
        $this->redirect('Auth');
    }
    
    /**
     * Método para mostrar el formulario de recuperación de contraseña
     */
    public function recover() {
        $this->view('auth/recover', ['pageTitle' => 'Recuperar Contraseña']);
    }
    
    /**
     * Método para procesar la recuperación de contraseña
     */
    public function processRecover() {
        // Código para procesar la recuperación de contraseña
        // (Este método se implementaría más adelante)
    }
}
?>