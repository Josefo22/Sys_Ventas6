<?php
/**
 * Archivo de configuración global
 */

// Definir la URL base del sitio
define('BASE_URL', '/Sysventas/');

// Parámetros de la aplicación
define('APP_NAME', 'SysVentas');
define('APP_EMAIL', 'SysVentas@gmail.com');
define('APP_VERSION', '1.0.0');

// Zona horaria
date_default_timezone_set('America/Bogota');

// Manejo de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sesiones
session_start();

// Incluir autoloader
require_once 'autoload.php';
?>