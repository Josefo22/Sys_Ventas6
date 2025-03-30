<?php
/**
 * Función autoload para cargar clases automáticamente
 */
spl_autoload_register(function($class) {
    // Lista de directorios donde buscar clases
    $directories = [
        'controllers/',
        'models/',
        'helpers/'
    ];
    
    // Recorrer directorios
    foreach ($directories as $directory) {
        $file = __DIR__ . '/../' . $directory . $class . '.php';
        
        // Si el archivo existe, cargarlo
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
?>