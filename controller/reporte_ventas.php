<?php
require_once('../vendor/autoload.php');
require_once('../model/conexion.php');
require_once('../controller/cpancon.php');

$model = new Conexion();
$conexion = $model->getConexion();

$ventas_mes = $dtVentasMes;
$cantidad_reembolsos = $dtCantReem[0]['COUNT(*)'] ?? 0;

$dtIngresosTotales = $dtIngresosTotales[0]['ingresos_totales'] ?? 0;
// Crear PDF
try {
    $pdf = new TCPDF();

    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage();

    
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte de Ventas', 0, 1, 'C');
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, 'Resumen de ventas general', 0, 1, 'C');
    $pdf->Ln(5);

    // **Ingresos Totales**
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, "Negocio: " . $dtProvRp[0]['nomprov'], 0, 1, 'L');
    $pdf->Ln(1);

    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, "Dirección: " . $dtProvRp[0]['dirrecprov'], 0, 1, 'L');
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, "Ingresos Totales: $" . number_format($dtIngresosTotales, 2, ',', '.'), 0, 1, 'C');
    $pdf->Ln(5);

    // **Tabla: Productos Más Vendidos**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Productos Más Vendidos:', 0, 1, 'L'); // Centrar título
    $pdf->SetFont('helvetica', '', 10);

    // **Definir anchos de columnas**
    $ancho_producto = 100;
    $ancho_cantidad = 40;
    $ancho_total = $ancho_producto + $ancho_cantidad;

    // **Calcular margen izquierdo para centrar la tabla**
    $pagina_ancho = $pdf->GetPageWidth();
    $margen_izquierdo = ($pagina_ancho - $ancho_total) / 2;
    $pdf->SetX($margen_izquierdo);

    // **Encabezados**
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell($ancho_producto, 8, 'Producto', 1, 0, 'C', true);
    $pdf->Cell($ancho_cantidad, 8, 'Cantidad Vendida', 1, 1, 'C', true);

    // **Contenido de la tabla**
    foreach ($dtProdMVend as $producto) {
        $pdf->SetX($margen_izquierdo); // Centrar cada fila
        $pdf->Cell($ancho_producto, 8, $producto['nompro'], 1);
        $pdf->Cell($ancho_cantidad, 8, $producto['total_vendido'], 1, 1, 'C');
    }

    // **Espaciado final**
    $pdf->Ln(5);


    // **Tabla: Productos Menos Vendidos**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Productos Menos Vendidos:', 0, 1, 'L'); // Centrar título
    $pdf->SetFont('helvetica', '', 10);

    // **Definir anchos de columnas**
    $ancho_producto = 100;
    $ancho_cantidad = 40;
    $ancho_total = $ancho_producto + $ancho_cantidad;

    // **Calcular margen izquierdo para centrar la tabla**
    $pagina_ancho = $pdf->GetPageWidth();
    $margen_izquierdo = ($pagina_ancho - $ancho_total) / 2;
    $pdf->SetX($margen_izquierdo);

    // **Encabezados**
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell($ancho_producto, 8, 'Producto', 1, 0, 'C', true);
    $pdf->Cell($ancho_cantidad, 8, 'Cantidad Vendida', 1, 1, 'C', true);

    // **Contenido de la tabla**
    foreach ($dtMenVen as $producto) {
        $pdf->SetX($margen_izquierdo); // Centrar cada fila
        $pdf->Cell($ancho_producto, 8, $producto['nompro'], 1);
        $pdf->Cell($ancho_cantidad, 8, $producto['total_vendido'], 1, 1, 'C');
    }

    $pdf->Ln(5); // Espaciado

    // **Tabla: Ventas Mensuales**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Ventas Mensuales:', 0, 1, 'L'); // Centrar título
    $pdf->SetFont('helvetica', '', 12);

    // **Definir anchos de columnas**
    $ancho_mes = 45;
    $ancho_cantidad = 45;
    $ancho_valor = 45;
    $ancho_total = $ancho_mes + $ancho_cantidad + $ancho_valor;

    // **Calcular margen izquierdo para centrar la tabla**
    $margen_izquierdo = ($pagina_ancho - $ancho_total) / 2;
    $pdf->SetX($margen_izquierdo);

    // **Encabezados**
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell($ancho_mes, 10, 'Mes', 1, 0, 'C', true);
    $pdf->Cell($ancho_cantidad, 10, 'Cantidad Ventas', 1, 0, 'C', true);
    $pdf->Cell($ancho_valor, 10, 'Valor Total', 1, 1, 'C', true);

    $total_ventas = 0;
    $total_valor_ventas = 0;

    foreach ($ventas_mes as $row) {
        $meses = [
            1 => "Enero",
            2 => "Febrero",
            3 => "Marzo",
            4 => "Abril",
            5 => "Mayo",
            6 => "Junio",
            7 => "Julio",
            8 => "Agosto",
            9 => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];

        $nombre_mes = $meses[intval($row['mes'])];
        $pdf->SetX($margen_izquierdo); // Centrar cada fila
        $pdf->Cell($ancho_mes, 10, $nombre_mes, 1, 0, 'C');
        $pdf->Cell($ancho_cantidad, 10, number_format($row['total_ventas'], 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell($ancho_valor, 10, "$" . number_format($row['valor_tot_ventas'], 2, ',', '.'), 1, 1, 'C');

        $total_ventas += $row['total_ventas'];
        $total_valor_ventas += $row['valor_tot_ventas'];
    }

    // **Totales de la tabla**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetX($margen_izquierdo);
    $pdf->Cell($ancho_mes, 10, 'TOTAL:', 1, 0, 'C');
    $pdf->Cell($ancho_cantidad, 10, number_format($total_ventas, 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell($ancho_valor, 10, "$" . number_format($total_valor_ventas, 2, ',', '.'), 1, 1, 'C');

    // Obtener ancho de página
    $ancho_pagina = $pdf->GetPageWidth();

    // **Tabla: Ventas por Semana**
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Ventas por Semana:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    // Definir ancho total de la tabla
    $ancho_tabla = 150;
    $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);

    // Encabezados
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(30, 8, 'Año', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Semana', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Cantidad Ventas', 1, 0, 'C', true);
    $pdf->Cell(50, 8, 'Valor Total', 1, 1, 'C', true);

    $total_ventas_semana = 0;
    $total_valor_semana = 0;

    foreach ($dtVentasSemana as $row) {
        $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);
        $pdf->Cell(30, 8, $row['anio'], 1, 0, 'C');
        $pdf->Cell(30, 8, $row['semana'], 1, 0, 'C');
        $pdf->Cell(40, 8, number_format($row['total_ventas'], 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell(50, 8, "$" . number_format($row['valor_tot_ventas'], 2, ',', '.'), 1, 1, 'C');

        $total_ventas_semana += $row['total_ventas'];
        $total_valor_semana += $row['valor_tot_ventas'];
    }

    // **Totales de la tabla**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);
    $pdf->Cell(60, 8, 'TOTAL:', 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($total_ventas_semana, 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell(50, 8, "$" . number_format($total_valor_semana, 2, ',', '.'), 1, 1, 'C');

    // **Tabla: Ventas por Día**
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Ventas por Día:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    // Definir ancho total de la tabla
    $ancho_tabla = 140;
    $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);

    // Encabezados
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(50, 8, 'Fecha', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Cantidad Ventas', 1, 0, 'C', true);
    $pdf->Cell(50, 8, 'Valor Total', 1, 1, 'C', true);

    $total_ventas_dia = 0;
    $total_valor_dia = 0;

    foreach ($dtVentasDia as $row) {
        $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);
        $pdf->Cell(50, 8, date("d/m/Y", strtotime($row['dia'])), 1, 0, 'C');
        $pdf->Cell(40, 8, number_format($row['total_ventas'], 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell(50, 8, "$" . number_format($row['valor_tot_ventas'], 2, ',', '.'), 1, 1, 'C');

        $total_ventas_dia += $row['total_ventas'];
        $total_valor_dia += $row['valor_tot_ventas'];
    }

    // **Totales de la tabla**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);
    $pdf->Cell(50, 8, 'TOTAL:', 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($total_ventas_dia, 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell(50, 8, "$" . number_format($total_valor_dia, 2, ',', '.'), 1, 1, 'C');

    // **Tabla: Ventas por Categoría y Día**
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Ventas por Categoría y Día:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    // Definir ancho total de la tabla
    $ancho_tabla = 160;
    $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);

    // Encabezados
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(50, 8, 'Categoría', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Día', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Cantidad Ventas', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Valor Total', 1, 1, 'C', true);

    $total_cantidad = 0;
    $total_ventas = 0;

    // Array de traducción de días de la semana
    $dias_espanol = [
        'Mon' => 'Lunes',
        'Tue' => 'Martes',
        'Wed' => 'Miércoles',
        'Thu' => 'Jueves',
        'Fri' => 'Viernes',
        'Sat' => 'Sábado',
        'Sun' => 'Domingo'
    ];

    foreach ($dtVentasCatego as $row) {
        $dia_traducido = $dias_espanol[$row['periodo']] ?? $row['periodo']; // Traducir día

        $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);
        $pdf->Cell(50, 8, $row['categoria'], 1, 0, 'C');
        $pdf->Cell(30, 8, $dia_traducido, 1, 0, 'C'); // Imprimir día traducido
        $pdf->Cell(40, 8, number_format($row['cantidad_ventas'], 0, ',', '.'), 1, 0, 'C');
        $pdf->Cell(40, 8, "$" . number_format($row['ventas'], 2, ',', '.'), 1, 1, 'C');

        $total_cantidad += $row['cantidad_ventas'];
        $total_ventas += $row['ventas'];
    }

    // **Totales de la tabla**
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetX(($ancho_pagina - $ancho_tabla) / 2);
    $pdf->Cell(80, 8, 'TOTAL:', 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($total_cantidad, 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell(40, 8, "$" . number_format($total_ventas, 2, ',', '.'), 1, 1, 'C');

    // Total de reembolsos
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, "Total de Reembolsos: " . number_format($cantidad_reembolsos, 0, ',', '.'), 0, 1, 'L');
    // **Agregar Gráfico (Si está disponible)**
    // if (!empty($chart_image)) {
    //     $chart_image = str_replace('data:image/png;base64,', '', $chart_image);
    //     $chart_image = base64_decode($chart_image);
    //     file_put_contents('chart.png', $chart_image);
    //     $pdf->Ln(10);
    //     $pdf->Image('chart.png', 15, $pdf->GetY(), 180);
    // }

    $pdf->SetY(-30); // Posiciona el pie de página 30 mm desde el final
    $pdf->SetFont('helvetica', 'I', 9);
    $pdf->MultiCell(
        0,
        5,
        "Este reporte ha sido generado por SHOO Inc. con el objetivo de proporcionar un análisis detallado sobre el comportamiento de las ventas en distintos periodos de tiempo. 
    A través de este informe, se busca identificar tendencias de compra, evaluar el rendimiento de las distintas categorías de productos y ofrecer información clave para la toma de decisiones estratégicas. 
    El propósito final es optimizar la gestión comercial, mejorar la experiencia del cliente y maximizar la rentabilidad del negocio mediante datos precisos y actualizados.",
        0,
        'C'
    );

    // **Salida del PDF**
    $pdf->Output('reporte_ventas.pdf', 'I');

} catch (Exception $e) {
    error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
    exit;
}
