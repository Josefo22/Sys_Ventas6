<?php
require_once 'Controller.php';

/**
 * Controlador para gestionar los roles de usuario
 */
class RolController extends Controller {
    private $rolModel;
    private $permisoModel;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
        $this->rolModel = $this->loadModel('Rol');
        $this->permisoModel = $this->loadModel('Permiso');
    }
    
    /**
     * Método para mostrar la lista de roles
     */
    public function index() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        $roles = $this->rolModel->getRoles();
        
        $this->view('roles/index', [
            'pageTitle' => 'Gestión de Roles',
            'roles' => $roles
        ]);
    }
    
    /**
     * Método para mostrar el formulario de crear rol
     */
    public function create() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        $permisos = $this->permisoModel->getPermisos();
        
        $this->view('roles/create', [
            'pageTitle' => 'Crear Rol',
            'permisos' => $permisos
        ]);
    }
    
    /**
     * Método para guardar un nuevo rol
     */
    public function store() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Rol');
            return;
        }
        
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $permisos = $_POST['permisos'] ?? [];
        
        if (empty($nombre)) {
            $this->redirect('Rol/create?error=1');
            return;
        }
        
        // Crear rol
        $id_rol = $this->rolModel->crearRol($nombre, $descripcion);
        
        if (!$id_rol) {
            $this->redirect('Rol/create?error=2');
            return;
        }
        
        // Asignar permisos
        if (!empty($permisos)) {
            $this->rolModel->asignarPermisos($id_rol, $permisos);
        }
        
        $this->redirect('Rol?success=1');
    }
    
    /**
     * Método para mostrar el formulario de editar rol
     */
    public function edit($id = null) {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Rol');
            return;
        }
        
        $rol = $this->rolModel->getRol($id);
        
        if (!$rol) {
            $this->redirect('Rol?error=1');
            return;
        }
        
        $permisos = $this->permisoModel->getPermisos();
        $permisosRol = $this->rolModel->getPermisosRol($id);
        
        // Crear array de IDs de permisos asignados para facilitar la comparación en la vista
        $permisosAsignados = [];
        foreach ($permisosRol as $permiso) {
            $permisosAsignados[] = $permiso['id'];
        }
        
        $this->view('roles/edit', [
            'pageTitle' => 'Editar Rol',
            'rol' => $rol,
            'permisos' => $permisos,
            'permisosAsignados' => $permisosAsignados
        ]);
    }
    
    /**
     * Método para actualizar un rol
     */
    public function update() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Rol');
            return;
        }
        
        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $permisos = $_POST['permisos'] ?? [];
        
        if (empty($id) || empty($nombre)) {
            $this->redirect('Rol/edit/' . $id . '?error=1');
            return;
        }
        
        // Actualizar rol
        $resultado = $this->rolModel->actualizarRol($id, $nombre, $descripcion);
        
        if (!$resultado) {
            $this->redirect('Rol/edit/' . $id . '?error=2');
            return;
        }
        
        // Asignar permisos
        $this->rolModel->asignarPermisos($id, $permisos);
        
        $this->redirect('Rol?success=2');
    }
    
    /**
     * Método para cambiar el estado de un rol
     */
    public function changeStatus($id = null) {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($id === null) {
            $this->redirect('Rol?error=1');
            return;
        }
        
        $rol = $this->rolModel->getRol($id);
        
        if (!$rol) {
            $this->redirect('Rol?error=1');
            return;
        }
        
        // Cambiar estado (1 a 0 o 0 a 1)
        $nuevo_estado = $rol['estado'] == 1 ? 0 : 1;
        $resultado = $this->rolModel->cambiarEstado($id, $nuevo_estado);
        
        if ($resultado) {
            $this->redirect('Rol?success=3');
        } else {
            $this->redirect('Rol?error=2');
        }
    }
    
    /**
     * Método para asignar roles a usuarios
     */
    public function asignar() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        $roles = $this->rolModel->getRoles();
        $usuarioModel = $this->loadModel('Usuario');
        $usuarios = $usuarioModel->getUsuariosActivos();
        
        $this->view('roles/asignar', [
            'pageTitle' => 'Asignar Roles a Usuarios',
            'roles' => $roles,
            'usuarios' => $usuarios
        ]);
    }
    
    /**
     * Método para procesar la asignación de rol a un usuario
     */
    public function asignarRol() {
        // Verificar que el usuario tenga permisos de configuración
        if (!$this->checkPermission('configuración')) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('Rol/asignar');
            return;
        }
        
        $id_usuario = $_POST['id_usuario'] ?? '';
        $id_rol = $_POST['id_rol'] ?? '';
        
        if (empty($id_usuario) || empty($id_rol)) {
            $this->redirect('Rol/asignar?error=1');
            return;
        }
        
        $usuarioModel = $this->loadModel('Usuario');
        $resultado = $usuarioModel->cambiarRol($id_usuario, $id_rol);
        
        if ($resultado) {
            $this->redirect('Rol/asignar?success=1');
        } else {
            $this->redirect('Rol/asignar?error=2');
        }
    }
}
?> 