<?php
require_once('../vendor/autoload.php');
require_once('../model/conexion.php');
require_once('../controller/cpancon.php');

$model = new Conexion();
$conexion = $model->getConexion();

$ventas_mes = $dtVentasMes;

// Validar que se reciba la imagen
$chart_image = $_POST['chart_image'] ?? null;
$dtIngresosTotales = $dtIngresosTotales[0]['ingresos_totales'] ?? 0;
// Crear PDF
try {
    $pdf = new TCPDF();
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage();

    // **Encabezado con Logo y Título**
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte de Ventas', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, 'Resumen de ventas general', 0, 1, 'C');
    $pdf->Ln(5);

    // **Ingresos Totales**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, "Ingresos Totales: $" . number_format($dtIngresosTotales, 2, ',', '.'), 0, 1, 'L');
    $pdf->Ln(5);

    // **Tabla: Productos Más Vendidos**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Productos Más Vendidos:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    // **Encabezados**
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(100, 8, 'Producto', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Cantidad Vendida', 1, 1, 'C', true);

    foreach ($dtProdMVend as $producto) {
        $pdf->Cell(100, 8, $producto['nompro'], 1);
        $pdf->Cell(40, 8, $producto['total_vendido'], 1, 1, 'C');
    }

    $pdf->Ln(5);

    // **Tabla: Productos Menos Vendidos**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Productos Menos Vendidos:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(100, 8, 'Producto', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Cantidad Vendida', 1, 1, 'C', true);

    foreach ($dtMenVen as $producto) {
        $pdf->Cell(100, 8, $producto['nompro'], 1);
        $pdf->Cell(40, 8, $producto['total_vendido'], 1, 1, 'C');
    }

    $pdf->Ln(5);

    // **Tabla: Ventas Mensuales**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Ventas Mensuales:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);

    // Encabezados de la tabla
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(45, 10, 'Mes', 1, 0, 'C', true);
    $pdf->Cell(45, 10, 'Cantidad Ventas', 1, 0, 'C', true);
    $pdf->Cell(45, 10, 'Valor Total', 1, 1, 'C', true);

    $total_ventas = 0;
    $total_valor_ventas = 0;

    foreach ($ventas_mes as $row) {
        $meses = [
            1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
            5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
            9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
        ];
        
        $nombre_mes = $meses[intval($row['mes'])];
        $pdf->Cell(45, 10, $nombre_mes, 1, 0, 'C');
        
        $pdf->Cell(45, 10, number_format($row['total_ventas'], 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell(45, 10, "$" . number_format($row['valor_tot_ventas'], 2, ',', '.'), 1, 1, 'C');

        $total_ventas += $row['total_ventas'];
        $total_valor_ventas += $row['valor_tot_ventas'];
    }

    // **Totales de la tabla**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(45, 10, 'TOTAL:', 1, 0, 'C');
    $pdf->Cell(45, 10, number_format($total_ventas, 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell(45, 10, "$" . number_format($total_valor_ventas, 2, ',', '.'), 1, 1, 'C');

    // **Agregar Gráfico (Si está disponible)**
    // if (!empty($chart_image)) {
    //     $chart_image = str_replace('data:image/png;base64,', '', $chart_image);
    //     $chart_image = base64_decode($chart_image);
    //     file_put_contents('chart.png', $chart_image);
    //     $pdf->Ln(10);
    //     $pdf->Image('chart.png', 15, $pdf->GetY(), 180);
    // }

    // **Salida del PDF**
    $pdf->Output('reporte_ventas.pdf', 'I');

} catch (Exception $e) {
    error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
    exit;
}
