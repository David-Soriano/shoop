<?php
require_once('../vendor/autoload.php'); // Asegúrate de que TCPDF está instalado con Composer
include_once("../controller/cped.php");

// Obtener el ID del pedido
$idped = isset($_REQUEST['idped']) ? $_REQUEST['idped'] : NULL;
$dtSegEnv = segEnv($idped);

// Verificar si se obtuvieron datos
if (!$dtSegEnv || empty($dtSegEnv)) {
    die("No se encontraron datos para la factura.");
}

// Crear nuevo PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Shoop');
$pdf->SetTitle('Factura de Compra');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

// Estilo del título
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Factura de Compra', 0, 1, 'C');
$pdf->Ln(5);

// Información del pedido
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Factura No: {$dtSegEnv[0]['idped']}", 0, 1);
$pdf->Cell(0, 10, "Fecha: {$dtSegEnv[0]['fecha']}", 0, 1);
$pdf->Cell(0, 10, "Estado: {$dtSegEnv[0]['estped']}", 0, 1);
$pdf->Cell(0, 10, "Método de pago: {$dtSegEnv[0]['mpago']} - {$dtSegEnv[0]['npago']}", 0, 1);
$pdf->Ln(5);

// Información del proveedor
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, "Proveedor: {$dtSegEnv[0]['nomprov']}", 0, 1);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Descripcion: {$dtSegEnv[0]['desprv']}", 0, 1);
$pdf->Ln(5);

// Tabla de productos
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(40, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(40, 10, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(40, 10, 'Descuento', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total', 1, 1, 'C');
$pdf->SetFont('helvetica', '', 12);

$totalFactura = 0;
$totalIVA = 0;
$totalDescuento = 0;
foreach ($dtSegEnv as $item) {
    $subtotal = $item['precio_final'] * $item['cantidad'];
    $iva = $item['precio_producto'] * 0.19 * $item['cantidad'];
    $totalFactura += $subtotal;
    $totalIVA += $iva;
    $totalDescuento += $item['valor_descuento'] * $item['cantidad'];

    // Guardar la posición inicial Y
    $yStart = $pdf->GetY();

    // Definir ancho de cada celda
    $wNompro = 40;
    $wCantidad = 30;
    $wPrecio = 40;
    $wDescuento = 40;
    $wTotal = 40;

    // Imprimir el nombre del producto con MultiCell
    $pdf->MultiCell($wNompro, 10, $item['nompro'], 1, 'L', false);

    // Calcular la altura final después de MultiCell
    $yEnd = $pdf->GetY();
    $cellHeight = $yEnd - $yStart; // Altura de la celda más alta

    // Establecer la posición Y para las demás celdas
    $pdf->SetY($yStart);
    $pdf->SetX(10 + $wNompro); // Ajustar la posición después de MultiCell

    // Dibujar las celdas con la misma altura
    $pdf->Cell($wCantidad, $cellHeight, $item['cantidad'], 1, 0, 'C');
    $pdf->Cell($wPrecio, $cellHeight, "$" . number_format($item['precio_producto'], 2), 1, 0, 'C');
    $pdf->Cell($wDescuento, $cellHeight, "$" . number_format($item['valor_descuento'], 2), 1, 0, 'C');
    $pdf->Cell($wTotal, $cellHeight, "$" . number_format($subtotal, 2), 1, 1, 'C');
}

// Totales
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(150, 10, 'TOTAL DESCUENTO', 1, 0, 'R');
$pdf->Cell(40, 10, "$" . number_format($totalDescuento, 2), 1, 1, 'C');
$pdf->Cell(150, 10, 'TOTAL IVA (19%)', 1, 0, 'R');
$pdf->Cell(40, 10, "$" . number_format($totalIVA, 2), 1, 1, 'C');
$pdf->Cell(150, 10, 'TOTAL A PAGAR', 1, 0, 'R');
$pdf->Cell(40, 10, "$" . number_format($totalFactura, 2), 1, 1, 'C');


// Pie de página
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'I', 10);
$pdf->MultiCell(0, 10, "Resolución DIAN No.  000188 de 2024. Esta factura es un documento válido para efectos fiscales.\nDesarrollado por SHOOP Inc Colombia.\nGracias por su compra.", 0, 'C');

// Salida del PDF
$pdf->Output('factura.pdf', 'I');
