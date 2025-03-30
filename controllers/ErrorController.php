<?php
require_once 'Controller.php';

/**
 * Controlador para manejar errores
 */
class ErrorController extends Controller {
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para mostrar página de error 404
     */
    public function notFound() {
        $this->view('errors/404', ['pageTitle' => 'Página no encontrada']);
    }
    
    /**
     * Método para mostrar errores generales
     */
    public function error($message = 'Ha ocurrido un error inesperado') {
        $this->view('errors/general', [
            'pageTitle' => 'Error',
            'message' => $message
        ]);
    }
}
?>