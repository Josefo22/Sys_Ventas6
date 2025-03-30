<?php
/**
 * Clase Controller base
 * Todos los controladores deben extender de esta clase
 */
class Controller {
    /**
     * Constructor de la clase
     */
    public function __construct() {
        // Inicialización común para todos los controladores
    }
    
    /**
     * Carga una vista
     * @param string $view Nombre de la vista
     * @param array $data Datos para pasar a la vista
     */
    protected function view($view, $data = []) {
        // Extraer los datos para que estén disponibles en la vista
        extract($data);
        
        // Path de la vista
        $viewPath = 'views/' . $view . '.php';
        
        // Verificar si la vista existe
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('La vista "' . $viewPath . '" no existe');
        }
    }
    
    /**
     * Carga un modelo
     * @param string $model Nombre del modelo
     * @return object Instancia del modelo
     */
    protected function loadModel($model) {
        $modelName = $model . 'Model';
        $modelPath = 'models/' . $modelName . '.php';
        
        // Verificar si el archivo del modelo existe
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $modelName();
        } else {
            die('El modelo "' . $modelPath . '" no existe');
        }
    }
    
    /**
     * Redirecciona a una URL específica
     * @param string $url URL a redireccionar
     */
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    /**
     * Verifica si el usuario está logueado
     * @return bool True si está logueado, false si no
     */
    protected function isLoggedIn() {
        return isset($_SESSION['active']) && $_SESSION['active'] === true;
    }
    
    /**
     * Verifica si el usuario tiene acceso
     * @return bool True si tiene acceso, false si no
     */
    protected function checkAccess() {
        if (!$this->isLoggedIn()) {
            $this->redirect('Auth');
            return false;
        }
        return true;
    }
    
    /**
     * Verifica si el usuario tiene un permiso específico
     * @param string $permiso Nombre del permiso a verificar
     * @return bool True si tiene el permiso, false si no
     */
    protected function hasPermission($permiso) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        // Si es el usuario administrador (id=1), siempre tiene permisos
        if ($_SESSION['idUser'] == 1) {
            return true;
        }
        
        // Verificar el permiso usando el modelo de permisos
        $permisoModel = $this->loadModel('Permiso');
        return $permisoModel->hasPermission($_SESSION['idUser'], $permiso);
    }
    
    /**
     * Verifica si el usuario tiene acceso y un permiso específico
     * @param string $permiso Nombre del permiso a verificar
     * @return bool True si tiene acceso y el permiso, false si no
     */
    protected function checkPermission($permiso) {
        if (!$this->checkAccess()) {
            return false;
        }
        
        // Verificar el permiso
        if (!$this->hasPermission($permiso)) {
            $this->redirect('Dashboard?error=permission');
            return false;
        }
        
        return true;
    }
    
    /**
     * Método para enviar respuestas JSON
     * @param array $data Datos a enviar como JSON
     * @param int $status Código de estado HTTP
     */
    protected function jsonResponse($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}
?>