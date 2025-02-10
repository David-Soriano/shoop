<?php
session_start();

if (!isset($_SESSION['respag'])) {
    $_SESSION['respag'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['respag']);

    // Leer los datos JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Verificar si es un solo producto o una lista de productos
    if (!$data || (!isset($data['id']) && !is_array($data))) {
        echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
        exit;
    }

    if (isset($data['id'])) {
        // Es un solo producto, lo convertimos en un array con un solo elemento
        $productos = [$data];
    } else {
        // Es un array de productos
        $productos = $data;
    }

    foreach ($productos as $producto) {
        if (!isset($producto['id'], $producto['nombre'], $producto['precio'], $producto['cantidad'], $producto['imagen'])) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos en un producto']);
            exit;
        }

        $_SESSION['respag'][] = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $producto['cantidad'],
            'imagen' => $producto['imagen']
        ];
    }

    echo json_encode(['status' => 'success', 'message' => 'Producto(s) añadido(s) al respag']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
exit;

