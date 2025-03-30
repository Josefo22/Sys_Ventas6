<?php
/**
 * Clase base para los controladores
 */
class Controller {
    /**
     * Constructor de la clase
     */
    public function __construct() {
        // Inicializar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Método para cargar un modelo
     */
    protected function loadModel($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }
    
    /**
     * Método para cargar una vista
     */
    protected function view($view, $data = []) {
        // Extraer datos para que estén disponibles en la vista
        extract($data);
        
        $view_file = __DIR__ . '/../views/' . $view . '.php';
        
        if (file_exists($view_file)) {
            require_once $view_file;
        } else {
            die('La vista ' . $view . ' no existe');
        }
    }
    
    /**
     * Método para redireccionar
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Método para verificar si el usuario está logueado
     */
    protected function isLoggedIn() {
        return isset($_SESSION['active']) && $_SESSION['active'] == true;
    }
    
    /**
     * Método para verificar permisos de usuario
     */
    protected function hasPermission($permission) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        // Verificar si el usuario tiene el permiso específico
        $permisosModel = $this->loadModel('Permiso');
        return $permisosModel->hasPermission($_SESSION['idUser'], $permission);
    }
    
    /**
     * Método para responder en formato JSON
     */
    protected function jsonResponse($data, $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
?> 