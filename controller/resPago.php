<?php
session_start();

// Inicializar el respag si no existe
if (!isset($_SESSION['respag'])) {
    $_SESSION['respag'] = [];
}

// Procesar la solicitud solo si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['respag']);
    // Leer el cuerpo de la solicitud en formato JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Convertir JSON a un array asociativo

    // Verificar que los datos sean válidos
    if (!$data || !isset($data['id'], $data['nombre'], $data['precio'], $data['cantidad'], $data['imagen'])) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o inválidos']);
        exit;
    }

    // Crear el producto con los datos recibidos
    $producto = [
        'id' => $data['id'],
        'nombre' => $data['nombre'],
        'precio' => $data['precio'],
        'cantidad' => $data['cantidad'],
        'imagen' => $data['imagen']
    ];

    // Verificar si el producto ya existe en el respag
    $existe = false;
    foreach ($_SESSION['respag'] as $item) {
        if ($item['id'] === $producto['id']) {
            $existe = true;
            break;
        }
    }

    if ($existe) {
        echo json_encode(['status' => 'info', 'message' => 'El producto ya está en el respag']);
    } else {
        // Agregar el producto al respag (almacenado en la sesión)
        $_SESSION['respag'][] = $producto;
        echo json_encode(['status' => 'success', 'message' => 'Producto añadido al respag']);
    }
    exit;
}

// Si no es una solicitud POST, devolver un error
echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
exit;

?>
