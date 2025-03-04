<?php
header('Content-Type: application/json');
require_once '../model/conexion.php'; // Ajusta la ruta según sea necesario

$timeframe = $_GET['timeframe'] ?? 'Anual';
$groupByCategory = isset($_GET['groupByCategory']) && $_GET['groupByCategory'] === 'true';
$mode = $_GET['mode'] ?? 'default'; // Nuevo parámetro para elegir la consulta

try {
    $conexion = new Conexion();
    $db = $conexion->getConexion();

    if ($mode === 'heatmap') {
        try {
            // Consulta para el Heatmap (ventas agrupadas por fecha)
            $sql = "SELECT DATE(fechareg) as fecha, COUNT(*) as cantidad FROM compra GROUP BY DATE(fechareg)";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $ventas = [];
            $weekdays = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

            foreach ($result as $row) {
                $dateObj = new DateTime($row['fecha']);
                $weekday = (int) $dateObj->format('w'); // 0 = Domingo, 6 = Sábado

                $ventas[] = [
                    "x" => $weekday,
                    "y" => 0, // Mantén 0 porque es un solo nivel en el heatmap
                    "value" => (int) $row["cantidad"],
                    "date" => $dateObj->getTimestamp() * 1000, // Para JavaScript
                    "custom" => ["day" => $weekdays[$weekday]]
                ];
            }

            echo json_encode($ventas);
            exit;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        }
    }

    if ($groupByCategory) {
        // Consulta para ventas por categoría y período de tiempo
        switch ($timeframe) {
            case 'Anual':
                $sql = "SELECT v.nomval AS categoria, YEAR(c.fechareg) AS periodo, COUNT(c.idcom) AS cantidad_ventas, SUM(c.preciocom) AS ventas
                        FROM compra c
                        JOIN pedido pd ON c.idped = pd.idped
                        JOIN detalle_pedido dp ON pd.idped = dp.idped
                        JOIN producto p ON dp.idpro = p.idpro
                        JOIN valor v ON p.idval = v.idval
                        GROUP BY v.nomval, YEAR(c.fechareg)
                        ORDER BY YEAR(c.fechareg), v.nomval";
                break;
            case 'Mensual':
                $sql = "SELECT v.nomval AS categoria, MONTHNAME(c.fechareg) AS periodo,COUNT(c.idcom) AS cantidad_ventas, SUM(c.preciocom) AS ventas
                        FROM compra c
                        JOIN pedido pd ON c.idped = pd.idped
                        JOIN detalle_pedido dp ON pd.idped = dp.idped
                        JOIN producto p ON dp.idpro = p.idpro
                        JOIN valor v ON p.idval = v.idval
                        GROUP BY v.nomval, MONTH(c.fechareg)
                        ORDER BY MONTH(c.fechareg), v.nomval";
                break;
            case 'Semanal':
                $sql = "SELECT v.nomval AS categoria, CONCAT('Semana ', WEEK(c.fechareg)) AS periodo, COUNT(c.idcom) AS cantidad_ventas, SUM(c.preciocom) AS ventas
                        FROM compra c
                        JOIN pedido pd ON c.idped = pd.idped
                        JOIN detalle_pedido dp ON pd.idped = dp.idped
                        JOIN producto p ON dp.idpro = p.idpro
                        JOIN valor v ON p.idval = v.idval
                        GROUP BY v.nomval, WEEK(c.fechareg)
                        ORDER BY WEEK(c.fechareg), v.nomval";
                break;
            case 'Diario':
                $sql = "SELECT v.nomval AS categoria, DATE_FORMAT(c.fechareg, '%a') AS periodo, COUNT(c.idcom) AS cantidad_ventas, SUM(c.preciocom) AS ventas
                        FROM compra c
                        JOIN pedido pd ON c.idped = pd.idped
                        JOIN detalle_pedido dp ON pd.idped = dp.idped
                        JOIN producto p ON dp.idpro = p.idpro
                        JOIN valor v ON p.idval = v.idval
                        GROUP BY v.nomval, DAYOFWEEK(c.fechareg)
                        ORDER BY DAYOFWEEK(c.fechareg), v.nomval";
                break;
            default:
                echo json_encode(['error' => 'Intervalo no válido']);
                exit;
        }
    } else {
        // Consulta para ventas generales por período de tiempo
        switch ($timeframe) {
            case 'Anual':
                $sql = "SELECT YEAR(fechareg) AS periodo, SUM(preciocom) AS ventas FROM compra GROUP BY YEAR(fechareg)";
                break;
            case 'Mensual':
                $sql = "SELECT MONTHNAME(fechareg) AS periodo, SUM(preciocom) AS ventas FROM compra GROUP BY MONTH(fechareg)";
                break;
            case 'Semanal':
                $sql = "SELECT CONCAT('Semana ', WEEK(fechareg)) AS periodo, SUM(preciocom) AS ventas FROM compra GROUP BY WEEK(fechareg)";
                break;
            case 'Diario':
                $sql = "SELECT DATE_FORMAT(fechareg, '%a') AS periodo, SUM(preciocom) AS ventas FROM compra GROUP BY DAYOFWEEK(fechareg)";
                break;
            default:
                echo json_encode(['error' => 'Intervalo no válido']);
                exit;
        }
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($groupByCategory) {
        $formattedData = [];
        $categories = [];
        $cantidadVentasData = [];

        foreach ($data as $row) {
            $periodo = $row['periodo'];
            if (!in_array($periodo, $categories)) {
                $categories[] = $periodo;
            }
        }

        foreach ($data as $row) {
            $categoria = $row['categoria'];
            $ventas = (float) $row['ventas'];
            $cantidadVentas = (int) $row['cantidad_ventas'];
            $periodo = $row['periodo'];

            if (!isset($formattedData[$categoria])) {
                $formattedData[$categoria] = [
                    'name' => $categoria,
                    'data' => array_fill(0, count($categories), 0)
                ];
            }

            if (!isset($cantidadVentasData[$categoria])) {
                $cantidadVentasData[$categoria] = [
                    'name' => $categoria,
                    'data' => array_fill(0, count($categories), 0)
                ];
            }

            $index = array_search($periodo, $categories);
            if ($index !== false) {
                $formattedData[$categoria]['data'][$index] = $ventas;
                $cantidadVentasData[$categoria]['data'][$index] = $cantidadVentas;
            }
        }

        echo json_encode([
            'categories' => $categories,
            'series' => array_values($formattedData),
            'seriesCantidad' => array_values($cantidadVentasData)
        ]);
    } else {
        echo json_encode($data);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
