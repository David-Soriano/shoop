<?php
include "../model/madmin.php";
include "../model/mpag.php";
include "../model/musu.php";
include "../model/mpqr.php";

$admin = new Madmin();
$pag = new Mpag();
$usu = new Musu();
$mpqr = new Mpqr();

$dtPqr = $mpqr->getAllPqr();
$dtImg = $admin->getImgItem();
$dtPag = $admin->getPaginas();
$dtProductVend = $admin->getProdtVend() ?? 0;
$dtComision = $admin->getValorComis() ?? 0;
$dtClientes = $admin->getClientReg() ?? 0;
$dtPedEnv = $admin->getPedEnv() ?? 0;
function getPagAdm($pg){
    $pag = new Mpag();
    return $pag->getOne($pg, 2, null);
}
// Controlador de páginas
$resultsPerPage = 10; // Resultados por página
$currentPage = (int) ($_GET['page'] ?? 1);
$offset = ($currentPage - 1) * $resultsPerPage;

// Obtener total de páginas registradas
$totalPagesRegistered = $pag->getTotalPages();
$totalUsersRegistered = $usu->getTotalUsers();
$totalPages = ceil($totalPagesRegistered / $resultsPerPage);
$totalUsers = ceil($totalUsersRegistered / $resultsPerPage);

// Obtener las páginas correspondientes a la página actual
$dtPags = $pag->getPages($resultsPerPage, $offset); // Implementa este método en tu modelo
$dtUsu = $usu->getUsers($resultsPerPage, $offset); // Implementa

$start = $offset + 1;
$end = min($offset + $resultsPerPage, $totalPagesRegistered);
$end2 = min($offset + $resultsPerPage, $totalUsersRegistered);
$recordsMessage = "Mostrando: <b>{$start}-{$end}</b> de <b>{$totalPagesRegistered}</b> resultados";
$recordsMessage2 = "Mostrando: <b>{$start}-{$end2}</b> de <b>{$totalUsersRegistered}</b> resultados";