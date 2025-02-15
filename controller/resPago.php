<?php
session_start();

if (!isset($_SESSION['respag'])) {
    $_SESSION['respag'] = [];
}

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['respag']); // Reiniciar sesión

    // Leer los datos JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Verificar si los datos son válidos
    if (!is_array($data) || empty($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Datos inválidos o vacíos']);
        exit;
    }

    // Verificar si es un solo producto o una lista
    $productos = isset($data[0]) && is_array($data[0]) ? $data : [$data];

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

    // **IMPORTANTE: Devolver una respuesta JSON de éxito**
    echo json_encode(['status' => 'success', 'message' => 'Productos guardados correctamente']);
    exit;
}

// Si no es una solicitud POST
echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
exit;


