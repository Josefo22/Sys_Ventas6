<?php
// Iniciar la sesión antes de cualquier salida si es necesario
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

// Incluir la conexión a la base de datos
require_once "../../conexion.php";

// Manejar la solicitud según el método
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    // Obtener datos enviados en formato JSON
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    
    // Verificar si se proporcionó el correo electrónico
    if (empty($datos['email'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Debe proporcionar un correo electrónico'
        ]);
        exit;
    }
    
    // Validar si el correo existe en la base de datos
    $email = mysqli_real_escape_string($conexion, $datos['email']);
    $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE correo = '$email' AND estado = 1");
    
    if (mysqli_num_rows($query) > 0) {
        $usuario = mysqli_fetch_assoc($query);
        
        // Generar token único para el restablecimiento de contraseña
        $token = bin2hex(random_bytes(32));
        $id_usuario = $usuario['idusuario'];
        
        // En un entorno real, aquí se enviaría un correo con el enlace para restablecer
        // Por ahora, solo simulamos el proceso
        
        // Guardar el token y la fecha de expiración en la base de datos
        // Esta parte requeriría una tabla adicional llamada 'recuperacion_password'
        // La siguiente línea es solo un ejemplo y deberías crearla
        /*
        mysqli_query($conexion, "INSERT INTO recuperacion_password 
                              (id_usuario, token, fecha_expiracion) 
                              VALUES ($id_usuario, '$token', DATE_ADD(NOW(), INTERVAL 1 DAY))");
        */
        
        // Devolver respuesta exitosa
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Se han enviado instrucciones a su correo electrónico',
            'dev_note' => 'En un entorno real, aquí se enviaría un correo con enlace para restablecer contraseña'
        ]);
    } else {
        // Correo no encontrado
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró una cuenta con este correo electrónico'
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