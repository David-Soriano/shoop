<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar el JSON enviado por fetch
    $input = json_decode(file_get_contents('php://input'), true);

    // Verificar que las claves existen en el array decodificado
    if (!isset($input['id'], $input['nombre'], $input['precio'], $input['cantidad'], $input['imagen'])) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        exit;
    }

    // Crear el producto con los datos decodificados
    $producto = [
        'id' => $input['id'],
        'nombre' => $input['nombre'],
        'precio' => $input['precio'],
        'cantidad' => $input['cantidad'],
        'imagen' => $input['imagen'],
    ];

    // Verificar si el producto ya está en el carrito
    $existe = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] === $producto['id']) {
            // Si ya existe, solo actualiza la cantidad
            $item['cantidad'] += $producto['cantidad'];
            $item['subtotal'] = $item['cantidad'] * $item['precio'];
            $existe = true;
            break;
        }
    }

    // Si el producto no existe, agregarlo al carrito
    if (!$existe) {
        $producto['subtotal'] = $producto['cantidad'] * $producto['precio'];
        $_SESSION['carrito'][] = $producto;
    }

    echo json_encode(['status' => 'success', 'message' => 'Producto añadido al carrito']);
    exit;
}
?>

