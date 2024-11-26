<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);


include "../model/conexion.php";
include "../model/mpro.php";

header('Content-Type: application/json'); 

$mpro = new Mpro();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['idpro'])) {
        $idpro = explode(',', $_GET['idpro']);
        $productos = [];

        foreach ($idpro as $id) {
            $id = intval($id); 
            $producto = $mpro->getProductoById($id);
            if ($producto) {
                $productos[] = $producto;
            }
        }

        if (!empty($productos)) {
            echo json_encode($productos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            echo json_encode(null);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID del producto no proporcionado.']);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_clean(); 
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    $idsPro = isset($data['idpro']) ? explode(',', $data['idpro']) : [];
    
    if (empty($idsPro)) {
        echo json_encode(['success' => false, 'error' => 'ID(s) de producto no proporcionado(s).']);
        exit;
    }

    $resultados = ['success' => true, 'ids_fallidos' => []];

    foreach ($idsPro as $idpro) {
        $mpro->setIdpro(intval($idpro));
        if (!$mpro->deleteProducto()) {
            $resultados['success'] = false;
            $resultados['ids_fallidos'][] = intval($idpro);
        }
    }

    if (!empty($resultados['ids_fallidos'])) {
        $resultados['error'] = 'No se pudieron eliminar algunos productos.';
    }

    echo json_encode($resultados);
    exit;
}


