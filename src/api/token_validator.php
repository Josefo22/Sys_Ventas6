<?php
/**
 * Validador de Token JWT
 * Este archivo proporciona funciones para validar tokens JWT
 */

// Asegurarse de que la sesión esté iniciada si se va a utilizar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Función para validar un token JWT
 * @param string $token El token JWT a validar
 * @return array|bool Un array con los datos del token si es válido, false si no lo es
 */
function validarToken($token) {
    // Clave secreta para verificar la firma (debe coincidir con la usada en auth.php)
    $clave_secreta = "sysventas_secret_key";
    
    // Separar las partes del token
    $partes_token = explode('.', $token);
    
    // Verificar que el token tenga las 3 partes necesarias
    if (count($partes_token) != 3) {
        return false;
    }
    
    $header = $partes_token[0];
    $payload = $partes_token[1];
    $firma_proporcionada = $partes_token[2];
    
    // Verificar la firma
    $firma_calculada = hash_hmac('sha256', "$header.$payload", $clave_secreta, true);
    $firma_calculada_encoded = base64_encode($firma_calculada);
    
    if ($firma_proporcionada !== $firma_calculada_encoded) {
        return false;
    }
    
    // Decodificar el payload
    $payload_decoded = json_decode(base64_decode($payload), true);
    
    // Verificar si el token ha expirado
    if (isset($payload_decoded['exp']) && $payload_decoded['exp'] < time()) {
        return false;
    }
    
    return $payload_decoded;
}

/**
 * Función para verificar token en cabecera de autorización
 * @return array|bool Datos del usuario si el token es válido, false si no hay token o es inválido
 */
function verificarAutorizacion() {
    // Obtener todas las cabeceras
    $headers = getallheaders();
    
    // Verificar si existe la cabecera de autorización
    if (!isset($headers['Authorization']) && !isset($headers['authorization'])) {
        return false;
    }
    
    // Obtener el token de la cabecera (puede estar en diferentes formatos de clave)
    $authorization = isset($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];
    
    // Verificar el formato Bearer token
    if (strpos($authorization, 'Bearer ') !== 0) {
        return false;
    }
    
    // Extraer el token sin el prefijo Bearer
    $token = substr($authorization, 7);
    
    // Validar el token
    return validarToken($token);
}

/**
 * Función de middleware para proteger rutas de API
 * Si no hay un token válido, termina la ejecución con un error 401
 * @return array Datos del usuario si el token es válido
 */
function protegerRuta() {
    $datos_usuario = verificarAutorizacion();
    
    if (!$datos_usuario) {
        // No hay token válido, enviar respuesta de error
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'Acceso no autorizado. Token inválido o expirado.'
        ]);
        exit;
    }
    
    // El token es válido, devolver los datos del usuario
    return $datos_usuario;
} 