<?php
require_once 'PqrModel.php';

class PqrController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new PqrModel($dbConnection);
    }

    // Obtener las PQRs para mostrarlas en la vista
    public function showPqrs() {
        return $this->model->getPqrs();
    }

    // Crear una nueva PQR
    public function createPqr($nombre, $fecha, $descripcion) {
        if ($this->model->createPqr($nombre, $fecha, $descripcion)) {
            header("Location: index.php"); // Redirigir a la vista principal
        } else {
            echo "Error al crear la PQR";
        }
    }

    // Responder a una PQR
    public function respondPqr($id) {
        if ($this->model->respondPqr($id)) {
            header("Location: index.php"); // Redirigir a la vista principal
        } else {
            echo "Error al responder la PQR";
        }
    }
}
