<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar la configuración del sistema
 */
class ConfiguracionController extends Controller {
    private $configuracionModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->configuracionModel = $this->loadModel('Configuracion');
    }
    
    /**
     * Método principal - Muestra el panel de configuración
     */
    public function index() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        $this->view('configuracion/index', [
            'pageTitle' => 'Configuración del Sistema'
        ]);
    }
    
    /**
     * Método para mostrar y editar la configuración general
     */
    public function general() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        $config = $this->configuracionModel->getConfiguracion();
        
        $this->view('configuracion/general', [
            'pageTitle' => 'Configuración General',
            'config' => $config
        ]);
    }
    
    /**
     * Método para guardar la configuración general
     */
    public function saveGeneral() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Configuracion/general');
            return;
        }
        
        // Obtener datos del formulario
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $email = $_POST['email'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        
        // Validar datos
        if (empty($nombre) || empty($telefono) || empty($email) || empty($direccion)) {
            $this->redirect('Configuracion/general?error=1');
            return;
        }
        
        // Guardar configuración
        $resultado = $this->configuracionModel->actualizarConfiguracion($nombre, $telefono, $email, $direccion);
        
        if ($resultado) {
            $this->redirect('Configuracion/general?success=1');
        } else {
            $this->redirect('Configuracion/general?error=2');
        }
    }
    
    /**
     * Método para mostrar la página de permisos del sistema
     */
    public function permisos() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        $permisoModel = $this->loadModel('Permiso');
        $permisos = $permisoModel->getPermisos();
        
        $this->view('configuracion/permisos', [
            'pageTitle' => 'Permisos del Sistema',
            'permisos' => $permisos
        ]);
    }
    
    /**
     * Método para crear un nuevo permiso
     */
    public function createPermiso() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Configuracion/permisos');
            return;
        }
        
        $nombre = $_POST['nombre'] ?? '';
        
        if (empty($nombre)) {
            $this->redirect('Configuracion/permisos?error=1');
            return;
        }
        
        $permisoModel = $this->loadModel('Permiso');
        $resultado = $permisoModel->crearPermiso($nombre);
        
        if ($resultado) {
            $this->redirect('Configuracion/permisos?success=1');
        } else {
            $this->redirect('Configuracion/permisos?error=2');
        }
    }
    
    /**
     * Método para actualizar un permiso
     */
    public function updatePermiso() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Configuracion/permisos');
            return;
        }
        
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        
        if (empty($id) || empty($nombre)) {
            $this->redirect('Configuracion/permisos?error=1');
            return;
        }
        
        $permisoModel = $this->loadModel('Permiso');
        $resultado = $permisoModel->actualizarPermiso($id, $nombre);
        
        if ($resultado) {
            $this->redirect('Configuracion/permisos?success=2');
        } else {
            $this->redirect('Configuracion/permisos?error=2');
        }
    }
    
    /**
     * Método para eliminar un permiso
     */
    public function deletePermiso($id = null) {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Configuracion/permisos?error=1');
            return;
        }
        
        $permisoModel = $this->loadModel('Permiso');
        $resultado = $permisoModel->eliminarPermiso($id);
        
        if ($resultado) {
            $this->redirect('Configuracion/permisos?success=3');
        } else {
            $this->redirect('Configuracion/permisos?error=2');
        }
    }
}
?> 