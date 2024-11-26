<?php
// Configuración de errores
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Inclusión de modelos necesarios
include "../model/conexion.php";
include "../model/mpro.php";

header('Content-Type: application/json'); // Configurar tipo de respuesta JSON

$mpro = new Mpro();

// Verificar si la solicitud es GET o POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Manejar la solicitud GET
    if (isset($_GET['idpro'])) {
        $idpro = explode(',', $_GET['idpro']); // Convertir los IDs en un array
        $productos = []; // Array para almacenar los productos

        foreach ($idpro as $id) {
            $id = intval($id); // Sanitizar el valor
            $producto = $mpro->getProductoById($id); // Obtener el producto por ID
            if ($producto) {
                $productos[] = $producto; // Agregar el producto al array
            }
        }

        if (!empty($productos)) {
            echo json_encode($productos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            echo json_encode(null); // No se encontraron productos
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'ID del producto no proporcionado.']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); 
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar que se reciba un ID válido
    $idpro = isset($data['idpro']) ? intval($data['idpro']) : null;
    var_dump($idpro);
    die();
    if (!$idpro) {
        echo json_encode(['success' => false, 'error' => 'ID de producto inválido.']);
        exit;
    }

    $mpro->setIdpro($idpro);

    if ($mpro->deleteProducto()) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el producto.']);
    }
} else {
    http_response_code(405); // Método no permitido
    echo json_encode(['error' => 'Método no permitido.']);
}
