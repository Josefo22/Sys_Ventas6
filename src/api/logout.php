<?php
// Iniciar la sesión antes de cualquier salida
session_start();

// Configurar cabeceras HTTP
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Manejar la solicitud según el método
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    // Destruir la sesión
    session_destroy();
    
    // Devolver respuesta exitosa
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Sesión cerrada correctamente'
    ]);
} else {
    // Método no permitido
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
} 