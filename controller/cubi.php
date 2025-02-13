<?php
include "../model/mubi.php";
require_once "../model/conexion.php";

$mubi = new Mubi();
$dat = $mubi->getAll();
$dtDtp = $mubi->getDep(0);

if (isset($_POST['idubi'])) {
    
    $ciudades = $mubi->getDep($_POST['idubi']); // Obtener ciudades del departamento seleccionado

    echo json_encode($ciudades);
}