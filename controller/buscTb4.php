<?php
ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict');
session_start();
include("../model/conexion.php");
include "../model/mpancon.php";
include "../model/mpro.php";

$control = new Mpancon();
$mpro = new Mpro();
function buscarPedidos($busqueda, $limit, $offset, $idprov)
{
    $res = "";

    // Consulta SQL con filtro de búsqueda
    if (!empty($busqueda)) {
        $sql = "SELECT pr.idprov, pxp.idpro, pxp.idprodprv, p.nompro, p.precio, p.pordescu, dp.iddet, dp.idped, dp.cantidad, ped.idusu, ped.total, ped.fecha, ped.estped, i.imgpro, i.nomimg FROM proveedor pr INNER JOIN prodxprov pxp ON pr.idprov = pxp.idprov INNER JOIN producto p ON pxp.idpro = p.idpro INNER JOIN detalle_pedido dp ON p.idpro = dp.idpro INNER JOIN pedido ped ON dp.idped = ped.idped LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON p.idpro = i.idpro WHERE pr.idprov = :idprov AND (p.nompro LIKE :searchTerm OR p.precio LIKE :searchTerm OR ped.fecha LIKE :searchTerm OR ped.estped LIKE :searchTerm) LIMIT :limit OFFSET :offset;";
    } else {
        $sql = "SELECT pr.idprov, pxp.idpro, pxp.idprodprv, p.nompro, p.precio, p.pordescu, dp.iddet, dp.idped, dp.cantidad, ped.idusu, ped.total, ped.fecha, ped.estped, i.imgpro, i.nomimg FROM proveedor pr INNER JOIN prodxprov pxp ON pr.idprov = pxp.idprov INNER JOIN producto p ON pxp.idpro = p.idpro INNER JOIN detalle_pedido dp ON p.idpro = dp.idpro INNER JOIN pedido ped ON dp.idped = ped.idped LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON p.idpro = i.idpro WHERE pr.idprov = :idprov
                LIMIT :limit OFFSET :offset";
    }

    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);
        $result->bindValue(':idprov', $idprov, PDO::PARAM_INT);
        // Asignar los valores dinámicos para limit y offset
        $result->bindValue(':limit', $limit, PDO::PARAM_INT);
        $result->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Si hay búsqueda, asignamos el parámetro :searchTerm
        if (!empty($busqueda)) {
            $result->bindValue(':searchTerm', '%' . $busqueda . '%', PDO::PARAM_STR);
        }

        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error al mostrar usuarios registrados. Inténtalo más tarde.";
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
$dtAllPed = buscarPedidos($searchTerm, $resultsPerPage, $offset, $_SESSION['idprov']); // Llama a la función de búsqueda para usuarios.

if (isset($dtAllPed) && count($dtAllPed) > 0) {
    foreach ($dtAllPed as $dtp) {
        echo '<tr>';
        echo '<td>';
        echo '<div class="widget-26-job-starred">';
        echo '<input class="product-checkbox" type="checkbox" name="idped" id="" value="' . $dtp['idped'] . '">';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-emp-img">';
        echo '<img src="../' . $dtp['imgpro'] . '" alt="' . $dtp['nomimg'] . '">';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-title">';
        echo '<a href="#">' . $dtp['nompro'] . '</a>';
        echo '<p class="m-0"><a href="#" class="employer-name">$' . number_format($dtp['total'], 0, ',', '.') . '</a></p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-info">';
        echo '<p class="type m-0">Fecha</p>';
        echo '<p class="text-muted m-0"><span class="location">' . $dtp['fecha'] . '</span></p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-salary">';
        echo '<p class="type m-0">Cantidad</p>';
        echo $dtp['cantidad'];
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-category indicator-wrap bg-soft-success" style="';
        if ($dtp['estped'] == 'Aprobado') {
            echo 'background-color: #91f3657a;';
        } elseif ($dtp['estped'] == 'Enviado') {
            echo 'background-color: #A6D8FF;';
        } elseif ($dtp['estped'] == 'En Tránsito') {
            echo 'background-color: #FFC285;';
        } elseif ($dtp['estped'] == 'En Reparto') {
            echo 'background-color: #FFED95;';
        } elseif ($dtp['estped'] == 'Recibido') {
            echo 'background-color: #ffcde7;';
        }
        echo '">';
        echo '<i class="indicator" style="';
        if ($dtp['estped'] == 'Aprobado') {
            echo 'background-color: #198754;';
        } elseif ($dtp['estped'] == 'Enviado') {
            echo 'background-color: #1E90FF;';
        } elseif ($dtp['estped'] == 'En Tránsito') {
            echo 'background-color: #FF8C00;';
        } elseif ($dtp['estped'] == 'En Reparto') {
            echo 'background-color: #FFD700;';
        } elseif ($dtp['estped'] == 'Recibido') {
            echo 'background-color: #cd323b;';
        }
        echo '"></i>';
        echo '<span>' . $dtp['estped'] . '</span>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';

    }
} else {
    // Si no se encuentran usuarios
    echo '<tr><td colspan="6">No se encontraron pedidos.</td></tr>';
}

