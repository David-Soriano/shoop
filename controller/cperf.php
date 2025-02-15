<?php
require_once '../model/conexion.php'; 
require_once '../model/mpag.php';

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // OBTENER PERMISOS
    $mpag = new Mpag();
    $dataPg = $mpag->getPagxPer();
    echo json_encode($dataPg);
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ACTUALIZAR PERMISOS
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['permisos']) || !is_array($data['permisos'])) {
        echo json_encode(["error" => "No se recibieron datos válidos"]);
        exit;
    }

    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        foreach ($data['permisos'] as $permiso) {
            $idpag = $permiso['idpag'];
            $idpef = $permiso['idpef'];
            $tiene_permiso = $permiso['tiene_permiso'];

            if ($tiene_permiso == 1) {
                // Verificar si ya existe antes de insertarlo
                $checkSql = "SELECT COUNT(*) FROM pagxperfil WHERE idpag = :idpag AND idpef = :idpef";
                $checkStmt = $conexion->prepare($checkSql);
                $checkStmt->bindParam(':idpag', $idpag, PDO::PARAM_INT);
                $checkStmt->bindParam(':idpef', $idpef, PDO::PARAM_INT);
                $checkStmt->execute();
                $exists = $checkStmt->fetchColumn();

                if ($exists == 0) {
                    // Solo insertar si no existe
                    $sql = "INSERT INTO pagxperfil (idpag, idpef) VALUES (:idpag, :idpef)";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':idpag', $idpag, PDO::PARAM_INT);
                    $stmt->bindParam(':idpef', $idpef, PDO::PARAM_INT);
                    $stmt->execute();
                }
            } else {
                // Si el permiso existe y se quitó, eliminarlo
                $sql = "DELETE FROM pagxperfil WHERE idpag = :idpag AND idpef = :idpef";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':idpag', $idpag, PDO::PARAM_INT);
                $stmt->bindParam(':idpef', $idpef, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        echo json_encode(["message" => "Permisos actualizados correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al actualizar permisos", "message" => $e->getMessage()]);
    }
    exit;
}

// Si no es ni GET ni POST, devolver un error
echo json_encode(["error" => "Método no permitido"]);
exit;
