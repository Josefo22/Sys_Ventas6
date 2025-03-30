<?php
/**
 * Archivo de prueba para la API de autenticación
 * No debe usarse en producción, solo para fines de desarrollo
 */

// Iniciar la sesión antes de cualquier salida
session_start();

// Configurar cabeceras HTTP
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Incluir el validador de tokens
require_once "token_validator.php";

// Función para realizar una prueba de la API
function test_api() {
    $result = [
        'api_status' => 'API funcionando correctamente',
        'endpoints' => [
            'login' => [
                'url' => '/src/api/auth.php',
                'method' => 'POST',
                'body' => json_encode([
                    'usuario' => 'username',
                    'clave' => 'password'
                ]),
                'description' => 'Inicia sesión y devuelve un token JWT'
            ],
            'check_auth' => [
                'url' => '/src/api/auth.php',
                'method' => 'GET',
                'headers' => [
                    'Authorization: Bearer YOUR_TOKEN'
                ],
                'description' => 'Verifica si hay una sesión activa'
            ],
            'logout' => [
                'url' => '/src/api/logout.php',
                'method' => 'POST',
                'description' => 'Cierra la sesión activa'
            ],
            'recover_password' => [
                'url' => '/src/api/recuperar.php',
                'method' => 'POST',
                'body' => json_encode([
                    'email' => 'user@example.com'
                ]),
                'description' => 'Solicita recuperación de contraseña'
            ]
        ],
        'instructions' => 'Puedes probar estas APIs con herramientas como Postman, cURL o fetch en JavaScript'
    ];
    
    // Verificar el entorno
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    $protocol = $secure ? 'https://' : 'http://';
    $domain = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . $domain;
    
    $result['base_url'] = $base_url;
    $result['full_urls'] = [];
    
    // Crear URLs completas para cada endpoint
    foreach ($result['endpoints'] as $key => $endpoint) {
        $result['full_urls'][$key] = $base_url . $endpoint['url'];
    }
    
    // Si hay un token en la cabecera, verificarlo
    $token_data = verificarAutorizacion();
    if ($token_data) {
        $result['token_validation'] = [
            'status' => 'valid',
            'data' => $token_data
        ];
    }
    
    return $result;
}

// Mostrar los resultados de la prueba
echo json_encode(test_api(), JSON_PRETTY_PRINT); 