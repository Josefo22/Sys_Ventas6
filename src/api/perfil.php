<?php
// Iniciar la sesión antes de cualquier salida
session_start();

// Configurar cabeceras HTTP
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar solicitudes OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir la conexión a la base de datos y el validador de tokens
require_once "../../conexion.php";
require_once "token_validator.php";

// Proteger esta ruta - Verifica que el token sea válido
$datos_token = protegerRuta();

// Si llegamos aquí, el token es válido y tenemos los datos del usuario
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener el ID del usuario desde el token
    $id_usuario = $datos_token['data']['id'];
    
    // Consultar los datos completos del usuario
    $query = mysqli_query($conexion, "SELECT idusuario, nombre, usuario, correo, rol FROM usuario WHERE idusuario = $id_usuario AND estado = 1");
    
    if (mysqli_num_rows($query) > 0) {
        $usuario = mysqli_fetch_assoc($query);
        
        // Devolver los datos del perfil
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'usuario' => [
                'id' => $usuario['idusuario'],
                'nombre' => $usuario['nombre'],
                'usuario' => $usuario['usuario'],
                'correo' => $usuario['correo'],
                'rol' => $usuario['rol']
            ]
        ]);
    } else {
        // Usuario no encontrado o inactivo
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró el usuario o está inactivo'
        ]);
    }
} else {
    // Método no permitido
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion); 