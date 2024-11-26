<?php
// Cargar el modelo
require_once('model/mCarrComp.php');

class CarritoController {

    // Método para cargar los productos del carrito
    public function cargarCarrito() {
        $carritoModel = new CarritoModel();
        $productos = $carritoModel->obtenerProductos();

        // Cargamos la vista del carrito y le pasamos los productos
        require_once('views/CarritoView.php');
    }

    // Método para seleccionar todos los productos
    public function seleccionarTodos() {
        // Lógica para seleccionar todos los productos
        // Aquí puedes guardar la selección en una variable de sesión o en la base de datos

        // Por ejemplo, agregar un estado 'seleccionado' a cada producto
        $_SESSION['seleccionados'] = true;
        $this->cargarCarrito();
    }

    // Método para eliminar productos inactivos
    public function eliminarInactivos() {
        // Lógica para eliminar productos inactivos
        // Aquí puedes eliminar de la base de datos o marcar como inactivos en la sesión

        // En este ejemplo, estamos solo eliminando los productos de la sesión
        unset($_SESSION['productos_inactivos']);
        $this->cargarCarrito();
    }
}
