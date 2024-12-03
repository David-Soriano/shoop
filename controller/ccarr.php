<?php
// Controlador ajustado
include "model/mcarr.php";

$conexion = (new Conexion())->getConexion();
$idUsuario = $isLoggedIn ? $_SESSION['idusu'] : null;
$carritoModel = new CarritoModel($idUsuario, $conexion);
$productosCarrito = $carritoModel->obtenerCarrito();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['productId'];

    if (!$idUsuario || !$productId) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
        exit;
    }

    try {
        $result = $carritoModel->agregarProducto($productId);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Producto añadido correctamente.' : 'Error al añadir el producto.'
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}


