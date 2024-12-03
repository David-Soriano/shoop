<?php
class QRModel {
    private $data;

    public function __construct() {
        // Define datos iniciales (puedes conectar a una base de datos aquí)
        $this->data = "https://www.ejemplo.com"; // Contenido del QR
    }

    // Método para obtener el contenido del QR
    public function getQRContent() {
        return $this->data;
    }

    // Método para actualizar el contenido del QR
    public function setQRContent($newData) {
        $this->data = $newData;
    }
}
?>
