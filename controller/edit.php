<?php ini_set('display_errors', 0);
error_reporting(E_ALL);
include "../model/conexion.php";
include "../model/mpro.php";

$mpro = new Mpro();

if (isset($_GET['idpro'])) {
    $idpro = explode(',', $_GET['idpro']); // Convertir los IDs en un array
    $productos = []; // Array para almacenar los productos

    foreach ($idpro as $id) {
        $id = intval($id);  // Sanitizar el valor
        $producto = $mpro->getProductoById($id); // Obtener el producto por ID
        if ($producto) {
            $productos[] = $producto; // Agregar el producto al array
        }
    }

    header('Content-Type: application/json'); // Configurar tipo de contenido JSON

    if (!empty($productos)) {
        ob_clean(); // Limpia cualquier salida previa
        echo json_encode($productos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); // Genera el JSON con las opciones
        exit; // Termina el script para evitar más salidas
    } else {
        echo json_encode(null); // Si no hay productos, responde con null
    }
    
} else {
    http_response_code(400); // Bad Request
    header('Content-Type: application/json');
    echo json_encode(['error' => 'ID del producto no proporcionado.']);
}
