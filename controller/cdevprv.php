<?php
require_once "ReturnModel.php";

class ReturnController {
    private $model;

    public function __construct() {
        $this->model = new ReturnModel();
    }

    public function handleRequest() {
        // Simula obtener el ID del producto desde una solicitud GET
        $productId = isset($_GET['id']) ? $_GET['id'] : 1;

        // Obtener los detalles del producto desde el modelo
        $productDetails = $this->model->getProductDetails($productId);

        // Verifica si el producto existe y carga la vista
        if ($productDetails) {
            include "ReturnView.php";
        } else {
            echo "Producto no encontrado.";
        }
    }
}
