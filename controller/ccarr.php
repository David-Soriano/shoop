<?php
include_once(__DIR__ . "/../model/mcarr.php");
if(!class_exists('Conexion')){
    include_once(__DIR__ . "/../model/conexion.php");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conexion = (new Conexion())->getConexion();
$idUsuario = isset($_SESSION['idusu']) ? $_SESSION['idusu'] : null;
$carritoModel = new CarritoModel($conexion);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    // Obtener datos del JSON recibido
    $idpro = isset($input['idpro']) ? intval($input['idpro']) : null;
    $cantidad = isset($input['cantidad']) ? intval($input['cantidad']) : 1;
    $precio = isset($input['precio']) ? floatval($input['precio']) : 0;
    $accion = isset($input['acc']) ? trim($input['acc']) : null; // Asegurar que acc sea un string

    // Validar datos recibidos
    if (!$idUsuario || !$idpro) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
        exit();
    }

    try {
        if ($accion === "eli") {
            $carritoModel->eliminarProducto($idUsuario, $idpro);
            echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente.']);
            exit();
        }

        // Agregar el producto al carrito con la cantidad y precio correctos
        $result = $carritoModel->agregarProducto($idUsuario, $idpro, $cantidad, $precio);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Producto añadido correctamente.' : 'Error al añadir el producto.'
        ]);
        exit();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit();
    }
} else{
    $dtCarrito = $carritoModel->obtenerCarrito($idUsuario);
    $dtValoresCarrito = $carritoModel->obtenerDetalleProductosFactura($idUsuario);
    $dtTotCarrito = $carritoModel->obtenerTotalesFactura($idUsuario);
}
