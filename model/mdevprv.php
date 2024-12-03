<?php
class ReturnModel {
    // Simula la base de datos (puedes reemplazarlo con una consulta real)
    private $productData = [
        "id" => 1,
        "name" => "Nombre Producto",
        "status" => "Producto devuelto correctamente.",
        "refundMessage" => "En unos minutos devolveremos tu dinero."
    ];

    // Método para obtener los detalles del producto
    public function getProductDetails($productId) {
        // Aquí puedes usar una consulta SQL para obtener los datos reales
        if ($productId == $this->productData['id']) {
            return $this->productData;
        } else {
            return null; // Producto no encontrado
        }
    }
}
