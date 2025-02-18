<?php
include __DIR__ . '/../model/mpag.php';
if (!class_exists('Conexion')) {
    include "../model/conexion.php";
}
$pag = new Mpag();

$idpag = isset($_REQUEST['idpag']) ? $_REQUEST['idpag'] : NULL;
$nompag = isset($_POST['nompag']) ? $_POST['nompag'] : NULL;
$rutpag = isset($_POST['rutpag']) ? $_POST['rutpag'] : NULL;
$mospag = isset($_POST['mospag']) ? $_POST['mospag'] : NULL;
$icopag = isset($_POST['icopag']) ? $_POST['icopag'] : NULL;

$lugpag = isset($_POST['lugpag']) ? $_POST['lugpag'] : NULL;
$idpef = isset($_POST['idpef']) ? $_POST['idpef'] : 1; // Si no selecciona, por defecto es Cliente (1)

$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;

$pag->setIdpag($idpag);

function getRut($pg)
{
    $pag = new Mpag();
    $lugpag = $pg['lugpag'] ?? null; // Maneja el valor de lugpag si está vacío
    return $pag->getOne($pg, 1, $lugpag);
}


$isLoggedIn = isset($_SESSION['idusu']); // Verificar si el usuario ha iniciado sesión
$dtMenu = $pag->getMenu($isLoggedIn);
$dtAll = $pag->getAll();
$dtMenPf = $pag->getMenuPerf($isLoggedIn);
$dtMenHead = $pag->getMenHeader(2);
// $dtMenHeadPf = $pag->getMenHeader(3);

if ($ope == 'savePg') {
    $pag->setNompag($nompag);
    $pag->setIcopag($icopag);
    $pag->setLugpag($lugpag);
    $pag->setIdpef($idpef);
    $resultado = $pag->savePag();
    if ($resultado) {
        header("Location: ../views/admin.php?pg=30&error=2"); // Redirigir con éxito
    } else {
        header("Location: ../views/admin.php?pg=30&error=1"); // Redirigir con error
    }
} elseif ($ope == 'eliPg') {
    header("Content-Type: application/json"); // Asegura respuesta en JSON

    if ($idpag) {
        $pag = new Mpag();
        $pag->setIdpag($idpag);

        if ($pag->delPag()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "No se pudo eliminar la página"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "ID de página no recibido"]);
    }
}

?>