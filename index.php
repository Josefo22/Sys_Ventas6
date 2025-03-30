<?php
// Archivo principal que actúa como enrutador
require_once 'config/config.php';

// Definir controlador, método y parámetros por defecto
$controller = 'Auth';
$method = 'index';
$params = [];

// Verificar si la URL tiene parámetros
if (isset($_GET['url'])) {
    $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    
    // Obtener el controlador
    $controller = ucfirst($url[0]);
    
    // Verificar si existe el método
    if (isset($url[1])) {
        $method = $url[1];
    }
    
    // Obtener parámetros adicionales
    if (isset($url[2])) {
        $params = array_slice($url, 2);
    }
}

// Verificar si el controlador existe
$controllerFile = 'controllers/' . $controller . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerName = $controller . 'Controller';
    $controller = new $controllerName();
    
    // Verificar si el método existe
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        // Método no encontrado
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->notFound();
    }
} else {
    // Controlador no encontrado
    require_once 'controllers/ErrorController.php';
    $controller = new ErrorController();
    $controller->notFound();
}