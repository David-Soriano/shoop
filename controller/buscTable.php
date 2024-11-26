<?php
session_start();
include("../model/conexion.php");
include "../model/mpancon.php";
include "../model/mpro.php";

$control = new Mpancon();
$mpro = new Mpro();
function busqueda($idprov, $busqueda, $limit, $offset)
{
    $res = "";
    // Si hay búsqueda, se agrega el filtro por nombre del producto
    if(!empty($busqueda)){
        $sql = "SELECT p.idpro, p.nompro, p.precio, p.cantidad, 
                        p.feccreat, p.fecupdate, p.fechfinofer, 
                        p.pordescu, v.idval, v.nomval, p.productvend, 
                        pr.idprov, i.imgpro, i.nomimg 
                FROM producto p 
                JOIN prodxprov pxp ON p.idpro = pxp.idpro
                JOIN proveedor pr ON pxp.idprov = pr.idprov
                JOIN valor v ON p.idval = v.idval
                LEFT JOIN imagen i ON p.idpro = i.idpro AND i.ordimg = (
                    SELECT MIN(ordimg) FROM imagen WHERE imagen.idpro = p.idpro
                )
                WHERE pr.idprov = :idprov AND (p.nompro LIKE :searchTerm OR i.nomimg LIKE :searchTerm OR p.precio LIKE :searchTerm) AND p.estado = 'activo'
                ORDER BY p.feccreat DESC LIMIT $limit OFFSET $offset";
    } else{
        $sql = "SELECT p.idpro, p.nompro, p.precio, p.cantidad, 
                        p.feccreat, p.fecupdate, p.fechfinofer, 
                        p.pordescu, v.idval, v.nomval, p.productvend, 
                        pr.idprov, i.imgpro, i.nomimg 
                FROM producto p 
                JOIN prodxprov pxp ON p.idpro = pxp.idpro
                JOIN proveedor pr ON pxp.idprov = pr.idprov
                JOIN valor v ON p.idval = v.idval
                LEFT JOIN imagen i ON p.idpro = i.idpro AND i.ordimg = (
                    SELECT MIN(ordimg) FROM imagen WHERE imagen.idpro = p.idpro
                )
                WHERE pr.idprov = :idprov AND p.estado = 'activo'
                ORDER BY p.feccreat DESC LIMIT $limit OFFSET $offset";
    }
    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);
        $result->bindValue(':idprov', $idprov, PDO::PARAM_INT);

        // Si hay búsqueda, agregamos el parámetro :searchTerm
        if (!empty($busqueda)) {
            $result->bindValue(':searchTerm', '%' . $busqueda . '%');
        }

        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error al mostrar productos registrados. Inténtalo más tarde.";
    }
    return $res;
}

$resultsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$idusus = isset($_SESSION['idusu']) ? $_SESSION['idusu'] : null;
$offset = ($currentPage - 1) * $resultsPerPage;

$control->getIdPrv($idusus);

// Obtener el total de productos del proveedor
$totalResults = $mpro->getCantPrd($_SESSION['idprov']);

// Calcular el número total de páginas
$totalPages = ceil($totalResults / $resultsPerPage);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
// Calcular el número total de páginas

$dtAllPrd = busqueda($_SESSION['idprov'], $searchTerm, $resultsPerPage, $offset);

if (isset($dtAllPrd) && count($dtAllPrd) > 0) {
    foreach ($dtAllPrd as $dtp) {
        echo '<tr>';
        echo '<td><div class="widget-26-job-starred"><input type="checkbox" name="" id="" value ="'.$dtp['idpro'].'"></div></td>';
        echo '<td><div class="widget-26-job-emp-img"><img src="../' . $dtp['imgpro'] . '" alt="' . $dtp['nomimg'] . '"></div></td>';
        echo '<td><div class="widget-26-job-title"><a href="#">' . $dtp['nompro'] . '</a>';
        echo '<p class="m-0"><a href="#" class="employer-name">' . $dtp['nomval'] . '</a>';
        echo '<span class="text-muted time"> ' . $dtp['productvend'] . ' vendidos</span></p></div></td>';
        echo '<td><div class="widget-26-job-info"><p class="type m-0">Stock</p>';
        echo '<p class="text-muted m-0"><span class="location">' . $dtp['cantidad'] . '</span></p></div></td>';
        echo '<td><div class="widget-26-job-salary"><p class="type m-0">Precio</p>';
        echo '$' . number_format($dtp['precio'], 0, ',', '.') . '</div></td>';
        if ($dtp['pordescu'] > 0) {
            echo '<td><div class="widget-26-job-category indicator-wrap bg-soft-success"><i class="indicator bg-success"></i>';
            echo '<span>En oferta</span></div></td>';
        }
        echo '</tr>';
    }
} else {
    // Si no se encuentran productos
    echo '<tr><td colspan="6">No se encontraron productos.</td></tr>';
}