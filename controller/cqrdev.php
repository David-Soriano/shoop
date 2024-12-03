<?php
require_once 'QRModel.php';

class QRController {
    private $model;

    public function __construct() {
        // Instanciar el modelo
        $this->model = new QRModel();
    }

    // Método para obtener los datos para la vista
    public function getQRContent() {
        return $this->model->getQRContent();
    }

    // Método para actualizar los datos del QR
    public function updateQRContent($newData) {
        $this->model->setQRContent($newData);
    }
}
?>
