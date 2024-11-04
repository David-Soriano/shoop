<?php
include "model/mpro.php";
include "model/Producto.php";

$productos = mostrarProductos();
function mostrarProductos() {
    $mpro = new mpro();
    
    try {
        // Llama a obtenerProductos en el modelo
        $productosData = $mpro->obtenerProductos();
        $productos = [];

        // Convierte cada registro en un objeto Producto
        foreach ($productosData as $productoData) {
            // Verifica que los datos requeridos existan
            if (isset($productoData['idpro'], $productoData['nompro'], $productoData['precio'], $productoData['descripcion'], $productoData['estado'], $productoData['imgpro'])) {
                $producto = new producto(
                    $productoData['idpro'],
                    $productoData['nompro'],
                    $productoData['precio'],
                    $productoData['descripcion'],
                    $productoData['estado'],
                    $productoData['imgpro']
                );
                $productos[] = $producto;
            } else {
                // Manejar el caso donde faltan datos
                error_log("Datos incompletos para el producto: " . json_encode($productoData));
            }
        }
        if (empty($productos)) {
            error_log("No se encontraron productos para mostrar.");
        }        
        
    } catch (Exception $e) {
        // Manejar excepciones
        error_log("Error al obtener productos: " . $e->getMessage());
    }
    return $productos;
}
$data = ['productos' => $productos, 'isLoggedIn' => $isLoggedIn]; // Suponiendo que tienes la variable $isLoggedIn definida
render('views/vwTienda', $data);
function render($view, $data) {
    extract($data);
    include "$view.php";
}
