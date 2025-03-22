<?php
header('Content-Type: application/json');
require_once '../model/conexion.php'; // Ajusta la ruta según sea necesario

$timeframe = $_GET['timeframe'] ?? 'Anual';
$groupByCategory = isset($_GET['groupByCategory']) && $_GET['groupByCategory'] === 'true';
$mode = $_GET['mode'] ?? 'default';
$idprov = $_GET['idprov'] ?? null; // ID del proveedor opcional

$logFile = 'C:/xampp/htdocs/SHOOP/errors/debug_log.log'; // Archivo de log
file_put_contents($logFile, "=== NUEVA EJECUCIÓN ===\n", FILE_APPEND); // Separador en log

try {
    $conexion = new Conexion();
    $db = $conexion->getConexion();

    if ($mode === 'heatmap') {
        $sql = "SELECT DATE(c.fechareg) as fecha, COUNT(*) as cantidad 
                FROM compra c" . ($idprov ? " 
                INNER JOIN detallecompra dc ON c.idcom = dc.idcom
                INNER JOIN producto p ON dc.idpro = p.idpro
                INNER JOIN prodxprov pxp ON p.idpro = pxp.idpro
                WHERE pxp.idprov = :idprov" : "") . " 
                GROUP BY DATE(c.fechareg)";

        $stmt = $db->prepare($sql);
        if ($idprov)
            $stmt->bindParam(':idprov', $idprov, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ventas = [];
        $weekdays = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

        foreach ($result as $row) {
            $dateObj = new DateTime($row['fecha']);
            $weekday = (int) $dateObj->format('w');

            $ventas[] = [
                "x" => $weekday,
                "y" => 0,
                "value" => (int) $row["cantidad"],
                "date" => $dateObj->getTimestamp() * 1000,
                "custom" => ["day" => $weekdays[$weekday]]
            ];
        }
        echo json_encode($ventas);
        exit;
    }

    $baseQuery = "SELECT {select_fields} 
    FROM compra c
    INNER JOIN pedido pd ON c.idped = pd.idped
    INNER JOIN detalle_pedido dp ON pd.idped = dp.idped
    INNER JOIN producto p ON dp.idpro = p.idpro";

    if ($groupByCategory) {
        $selectFields = "v.nomval AS categoria, {periodo_field} AS periodo, COUNT(c.idcom) AS cantidad_ventas, SUM(c.preciocom) AS ventas";
        $joinCategory = "INNER JOIN valor v ON p.idval = v.idval";
        $groupBy = "GROUP BY categoria, periodo"; // Se agrupa por categoría y periodo
    } else {
        $selectFields = "{periodo_field} AS periodo, SUM(c.preciocom) AS ventas";
        $joinCategory = "";
        $groupBy = "GROUP BY periodo";
    }

    // Determinar el campo de periodo según el intervalo
    switch ($timeframe) {
        case 'Anual':
            $periodoField = "YEAR(c.fechareg)";
            break;
        case 'Mensual':
            $periodoField = "MONTHNAME(c.fechareg)";
            break;
        case 'Semanal':
            $periodoField = "CONCAT('Semana ', WEEK(c.fechareg))";
            break;
        case 'Diario':
            $periodoField = "DATE_FORMAT(c.fechareg, '%a')";
            break;
        default:
            echo json_encode(['error' => 'Intervalo no válido']);
            exit;
    }

    // Añadir el INNER JOIN de proveedor si aplica
    if ($idprov) {
        $baseQuery .= " INNER JOIN prodxprov pxp ON p.idpro = pxp.idpro";
        $whereClause = "WHERE pxp.idprov = :idprov";
    } else {
        $whereClause = "";
    }

    // Construir la consulta final
    $sql = str_replace("{select_fields}", $selectFields, $baseQuery);
    $sql = str_replace("{periodo_field}", $periodoField, $sql);
    $sql .= " $joinCategory $whereClause $groupBy ORDER BY periodo;";

   
    $stmt = $db->prepare($sql);
    if ($idprov)
        $stmt->bindParam(':idprov', $idprov, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
