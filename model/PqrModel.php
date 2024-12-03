<?php
class PqrModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Obtener todas las PQRs
    public function getPqrs() {
        $query = "SELECT * FROM pqrs ORDER BY fecha DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva PQR
    public function createPqr($nombre, $fecha, $descripcion) {
        $query = "INSERT INTO pqrs (nombre, fecha, descripcion) VALUES (:nombre, :fecha, :descripcion)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Responder a una PQR
    public function respondPqr($id) {
        // Lógica para marcar la PQR como respondida (puedes ajustarlo según tus necesidades)
        $query = "UPDATE pqrs SET respondida = 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
