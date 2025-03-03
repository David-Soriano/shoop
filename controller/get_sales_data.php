<?php
header('Content-Type: application/json');
require_once '../model/conexion.php'; // Asegúrate de tener tu conexión a la base de datos

$timeframe = $_GET['timeframe'] ?? 'Anual';

try {
    $conexion = new Conexion();
    $db = $conexion->getConexion();

    switch ($timeframe) {
        case 'Anual':
            $sql = "SELECT YEAR(fechareg) as periodo, SUM(preciocom) as ventas FROM compra GROUP BY YEAR(fechareg)";
            break;
        case 'Mensual':
            $sql = "SELECT MONTHNAME(fechareg) as periodo, SUM(preciocom) as ventas FROM compra GROUP BY MONTH(fechareg)";
            break;
        case 'Semanal':
            $sql = "SELECT CONCAT('Semana ', WEEK(fechareg)) as periodo, SUM(preciocom) as ventas FROM compra GROUP BY WEEK(fechareg)";
            break;
        case 'Diario':
            $sql = "SELECT DATE_FORMAT(fechareg, '%a') as periodo, SUM(preciocom) as ventas FROM compra GROUP BY DAYOFWEEK(fechareg)";
            break;
        default:
            echo json_encode(['error' => 'Intervalo no válido']);
            exit;
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
