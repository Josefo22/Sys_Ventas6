<?php
// Configuración y conexión a la base de datos
require_once '../../../config/config.php';
$conexion = mysqli_connect("localhost", "root", "", "sis_venta");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Incluir la biblioteca FPDF
require_once '../fpdf/fpdf.php';

// Clase personalizada para tickets de 80mm
class TicketPDF extends FPDF {
    function Header() {
        // Sin encabezado predeterminado
    }
    
    function Footer() {
        // Sin pie de página predeterminado
    }
    
    // Función para crear líneas punteadas
    function LineaDashed($x1, $y1, $x2, $y2, $width = 1, $nb = 15) {
        $this->SetLineWidth($width);
        $longueur = abs($x2 - $x1);
        $hauteur = abs($y2 - $y1);
        if ($longueur > $hauteur) {
            $nb_segments = $nb;
        } else {
            $nb_segments = floor($nb * $hauteur / $longueur);
        }
        $longueur_segment = $longueur / $nb_segments;
        $hauteur_segment = $hauteur / $nb_segments;
        
        if (($x1 == $x2) || ($y1 == $y2)) {
            $this->Line($x1, $y1, $x2, $y2);
        } else {
            $xc = $x1;
            $yc = $y1;
            $x = $xc;
            $y = $yc;
            
            for ($i = 0; $i < $nb_segments; $i++) {
                if ($i % 2 == 0) {
                    $x = $xc + $longueur_segment;
                    $y = $yc + $hauteur_segment;
                    $this->Line($xc, $yc, $x, $y);
                }
                $xc = $x;
                $yc = $y;
            }
        }
    }
}

// Crear una nueva instancia de TicketPDF
// 80mm = 80/25.4 = 3.15 pulgadas ≈ 80 puntos en FPDF
$ancho = 80;
$pdf = new TicketPDF('P', 'mm', array($ancho, 200)); // Largo adaptable
$pdf->AddPage();
$pdf->SetMargins(2, 5, 2);
$pdf->SetTitle("Ticket Venta");
$pdf->SetAutoPageBreak(true, 5);

// Obtener los parámetros de la URL
$id = isset($_GET['v']) ? intval($_GET['v']) : 0;
$idcliente = isset($_GET['cl']) ? intval($_GET['cl']) : 0;

if ($id <= 0) {
    die("Error: Parámetro de venta no válido.");
}

// Validar existencia de la venta
$venta = mysqli_query($conexion, "SELECT v.*, c.nombre as cliente, u.nombre as usuario 
                                 FROM ventas v 
                                 INNER JOIN cliente c ON v.id_cliente = c.idcliente 
                                 INNER JOIN usuario u ON v.id_usuario = u.idusuario 
                                 WHERE v.id = $id");

if (!$venta || mysqli_num_rows($venta) == 0) {
    die("Error: No se encontró la venta con el ID especificado.");
}

$datosVenta = mysqli_fetch_assoc($venta);

// Obtener los detalles de la venta
$detalles = mysqli_query($conexion, "SELECT d.*, p.descripcion 
                                   FROM detalle_venta d 
                                   INNER JOIN producto p ON d.id_producto = p.codproducto 
                                   WHERE d.id_venta = $id");

// Obtener información de la empresa (configuración)
$config = mysqli_query($conexion, "SELECT * FROM configuracion LIMIT 1");
$datosEmpresa = mysqli_fetch_assoc($config);

// DISEÑO DEL TICKET
// ------------------

// Título SysVentas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($ancho-4, 6, "", 0, 1, 'C');

// Encabezado con datos de la empresa
$pdf->SetFont('Arial', 'B', 10);
if ($datosEmpresa) {
    $pdf->Cell($ancho-4, 5, mb_convert_encoding($datosEmpresa['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    // Información de contacto de la empresa - Ahora más compacta
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("Tel: " . $datosEmpresa['telefono'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("Dir: " . $datosEmpresa['direccion'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("Email: " . $datosEmpresa['email'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "NIT: 1059697752-7", 0, 1, 'C');
} else {
    $pdf->Cell($ancho-4, 5, "Empresa", 0, 1, 'C');
    
    // Información de contacto de la empresa - Ahora más compacta
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($ancho-4, 3, "Tel: N/A", 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "Dir: N/A", 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "Email: N/A", 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "NIT: 1059697752-7", 0, 1, 'C');
}

// Línea divisoria
$pdf->Ln(1);
$pdf->LineaDashed(2, $pdf->GetY(), $ancho-2, $pdf->GetY(), 0.1);
$pdf->Ln(1);

// Título del ticket y número de factura
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell($ancho-4, 5, mb_convert_encoding("FACTURA DE VENTA", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell($ancho-4, 5, mb_convert_encoding("N° " . $id, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell($ancho-4, 5, mb_convert_encoding("Fecha: " . date('d/m/Y H:i', strtotime($datosVenta['fecha'])), 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// Aviso de no responsable de IVA
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell($ancho-4, 4, mb_convert_encoding("**NO RESPONSABLE DE IVA**", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Ln(1);

// Línea divisoria
$pdf->LineaDashed(2, $pdf->GetY(), $ancho-2, $pdf->GetY(), 0.1);
$pdf->Ln(1);

// Información del cliente en forma compacta
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell($ancho-4, 4, mb_convert_encoding("DATOS DEL CLIENTE", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// Datos del cliente
$cliente = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$datosCliente = mysqli_fetch_assoc($cliente);

$pdf->SetFont('Arial', '', 7);
if ($datosCliente) {
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("Nombre: " . $datosCliente['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("Tel: " . $datosCliente['telefono'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("Dir: " . $datosCliente['direccion'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, mb_convert_encoding("CC: " . $datosCliente['cedula'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
} else {
    $pdf->Cell($ancho-4, 3, "Nombre: N/A", 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "Tel: N/A", 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "Dir: N/A", 0, 1, 'C');
    $pdf->Cell($ancho-4, 3, "CC: N/A", 0, 1, 'C');
}

// Línea divisoria
$pdf->Ln(1);
$pdf->LineaDashed(2, $pdf->GetY(), $ancho-2, $pdf->GetY(), 0.1);
$pdf->Ln(1);

// Cabecera de tabla de productos
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell($ancho-4, 3, mb_convert_encoding("DETALLE DE PRODUCTOS", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Ln(1);

// Diseño compacto para la cabecera de la tabla
$pdf->Cell(30, 3, "PRODUCTO", 0, 0, 'C');
$pdf->Cell(10, 3, "CANT", 0, 0, 'C');
$pdf->Cell(17, 3, "PRECIO", 0, 0, 'C');
$pdf->Cell(17, 3, "TOTAL", 0, 1, 'C');

// Línea divisoria
$pdf->LineaDashed(2, $pdf->GetY(), $ancho-2, $pdf->GetY(), 0.1);
$pdf->Ln(1);

// Variable para almacenar la suma total
$total = 0;

// Bucle while para imprimir los detalles de los productos
$pdf->SetFont('Arial', '', 7);
while ($row = mysqli_fetch_assoc($detalles)) {
    // Nombre del producto (con posible corte si es muy largo)
    $descripcion = mb_convert_encoding($row['descripcion'], 'ISO-8859-1', 'UTF-8');
    if (strlen($descripcion) > 20) {
        $descripcion = substr($descripcion, 0, 18) . '..';
    }
    $pdf->Cell(30, 3, $descripcion, 0, 0, 'L');
    
    // Cantidad, precio y subtotal
    $pdf->Cell(10, 3, $row['cantidad'], 0, 0, 'C');
    $pdf->Cell(17, 3, '$' . number_format($row['precio'], 0, ',', '.'), 0, 0, 'R');
    $subtotal = $row['cantidad'] * $row['precio'];
    $pdf->Cell(17, 3, '$' . number_format($subtotal, 0, ',', '.'), 0, 1, 'R');

    // Sumar al total
    $total += $subtotal;
}

// Línea divisoria
$pdf->Ln(1);
$pdf->LineaDashed(2, $pdf->GetY(), $ancho-2, $pdf->GetY(), 0.1);
$pdf->Ln(1);

// Imprimir el total al final del detalle de productos
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell($ancho-22, 4, "TOTAL:", 0, 0, 'R');
$pdf->Cell(18, 4, "$" . number_format($total, 0, ',', '.'), 0, 1, 'R');

// Línea divisoria
$pdf->Ln(1);
$pdf->LineaDashed(2, $pdf->GetY(), $ancho-2, $pdf->GetY(), 0.1);
$pdf->Ln(3);

// Mensaje de agradecimiento
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell($ancho-4, 4, mb_convert_encoding("¡GRACIAS POR SU COMPRA!", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// Vendedor
$pdf->SetFont('Arial', '', 7);
$pdf->Cell($ancho-4, 3, mb_convert_encoding("Atendido por: " . $datosVenta['usuario'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// Información adicional
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell($ancho-4, 3, mb_convert_encoding("Este documento es un soporte de venta", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell($ancho-4, 3, mb_convert_encoding("Conserve su factura", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// QR Code para verificación (opcional)
// Si deseas implementar un código QR, asegúrate de tener la librería necesaria

// Salida del PDF
$pdf->Output("venta_$id.pdf", "I");
?> 