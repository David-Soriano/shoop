<?php
include_once(__DIR__ . '/../model/conexion.php');
include_once(__DIR__ . '/../model/mfav.php');

$conexion = (new Conexion())->getConexion();
$favoritosModel = new FavoritosModel($conexion);

$dtFavoritos = $favoritosModel->getFavoritos($_SESSION['idusu']);

// Verifica si la petición es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idusu = $_POST['idusu'] ?? null;
    $idpro = $_POST['idpro'] ?? null;
    $accion = $_POST['accion'] ?? null;

    // Depuración: Mostrar los valores recibidos
    if (!$idusu || !$idpro || !$accion) {
        echo json_encode(['success' => false, 'error' => 'Datos faltantes', 'data' => $_POST]);
        exit;
    }

    if ($accion == 'agregar') {
        $resultado = $favoritosModel->agregarFavorito($idusu, $idpro);
    }
    if ($accion == 'eliminar') {
        $resultado = $favoritosModel->eliminarFavorito($idusu, $idpro);
        echo json_encode([
            'success' => $resultado,
            'idusu' => $idusu,
            'idpro' => $idpro
        ]);
        exit;
    }
}


