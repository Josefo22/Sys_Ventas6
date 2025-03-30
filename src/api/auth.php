<?php
// Iniciar la sesión antes de cualquier salida
session_start();

// Configurar cabeceras HTTP
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir la conexión a la base de datos
require_once "../../conexion.php";

// Función para generar un token JWT simple
function generarToken($usuario_id, $usuario, $nombre) {
    $tiempo = time();
    $payload = [
        'iat' => $tiempo,
        'exp' => $tiempo + (60 * 60 * 24), // Token válido por 24 horas
        'data' => [
            'id' => $usuario_id,
            'usuario' => $usuario,
            'nombre' => $nombre
        ]
    ];
    
    // Clave secreta para firmar el token (debe ser más segura en producción)
    $clave_secreta = "sysventas_secret_key";
    
    // Codificar el encabezado y el payload
    $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $payload_encoded = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload_encoded", $clave_secreta, true);
    $signature_encoded = base64_encode($signature);
    
    // Generar token
    return "$header.$payload_encoded.$signature_encoded";
}

// Manejar la solicitud según el método
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'POST':
        // Obtener datos enviados en formato JSON
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        
        // Verificar si se proporcionaron los datos necesarios
        if (empty($datos['usuario']) || empty($datos['clave'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Debe proporcionar usuario y contraseña']);
            exit;
        }
        
        // Validar credenciales
        $usuario = mysqli_real_escape_string($conexion, $datos['usuario']);
        $clave = md5(mysqli_real_escape_string($conexion, $datos['clave']));
        
        $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$usuario' AND clave = '$clave' AND estado = 1");
        
        if (mysqli_num_rows($query) > 0) {
            $datos_usuario = mysqli_fetch_assoc($query);
            
            // Crear sesión
            $_SESSION['active'] = true;
            $_SESSION['idUser'] = $datos_usuario['idusuario'];
            $_SESSION['nombre'] = $datos_usuario['nombre'];
            $_SESSION['user'] = $datos_usuario['usuario'];
            
            // Generar token JWT
            $token = generarToken($datos_usuario['idusuario'], $datos_usuario['usuario'], $datos_usuario['nombre']);
            
            // Devolver respuesta exitosa
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso',
                'token' => $token,
                'usuario' => [
                    'id' => $datos_usuario['idusuario'],
                    'nombre' => $datos_usuario['nombre'],
                    'usuario' => $datos_usuario['usuario'],
                    'correo' => $datos_usuario['correo']
                ]
            ]);
        } else {
            // Credenciales inválidas
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario o contraseña incorrectos'
            ]);
        }
        break;
        
    case 'GET':
        // Verificar si hay una sesión activa
        if (!empty($_SESSION['active']) && $_SESSION['active']) {
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'authenticated' => true,
                'usuario' => [
                    'id' => $_SESSION['idUser'],
                    'nombre' => $_SESSION['nombre'],
                    'usuario' => $_SESSION['user']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'authenticated' => false,
                'message' => 'No hay una sesión activa'
            ]);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion); 