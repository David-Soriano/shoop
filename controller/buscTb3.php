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
function buscarUsuarios($busqueda, $limit, $offset) {
    $res = "";

    // Consulta SQL con filtro de búsqueda
    if (!empty($busqueda)) {
        $sql = "SELECT 
                    u.idusu, 
                    u.nomusu, 
                    u.apeusu, 
                    u.docusu, 
                    u.emausu, 
                    u.celusu, 
                    u.genusu, 
                    u.dirrecusu, 
                    u.tipdoc, 
                    u.idubi, 
                    u.idpef, 
                    u.estusu, 
                    p.nompef
                FROM usuario AS u 
                INNER JOIN perfil AS p ON p.idpef = u.idpef 
                WHERE u.nomusu LIKE :searchTerm 
                   OR u.apeusu LIKE :searchTerm 
                   OR u.emausu LIKE :searchTerm 
                   OR u.celusu LIKE :searchTerm 
                   OR p.nompef LIKE :searchTerm
                   OR u.estusu LIKE :searchTerm
                LIMIT :limit OFFSET :offset";
    } else {
        $sql = "SELECT 
                    u.idusu, 
                    u.nomusu, 
                    u.apeusu, 
                    u.docusu, 
                    u.emausu, 
                    u.celusu, 
                    u.genusu, 
                    u.dirrecusu, 
                    u.tipdoc, 
                    u.idubi, 
                    u.idpef, 
                    u.estusu, 
                    p.nompef
                FROM usuario AS u 
                INNER JOIN perfil AS p ON p.idpef = u.idpef 
                LIMIT :limit OFFSET :offset";
    }

    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);

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
$offset = ($currentPage - 1) * $resultsPerPage;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$dtAllUsers = buscarUsuarios($searchTerm, $resultsPerPage, $offset); // Llama a la función de búsqueda para usuarios.

if (isset($dtAllUsers) && count($dtAllUsers) > 0) {
    foreach ($dtAllUsers as $dtu) {
        echo '<tr>';
        echo '<td>';
        echo '<div class="widget-26-job-starred">';
        echo '<input class="product-checkbox" type="checkbox" name="" id="" value="' . $dtu['idusu'] . '">';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-emp-img">';
        echo '<p class="text-muted m-0"><span class="location">' . $dtu['idusu'] . '</span></p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-title">';
        echo '<p>' . $dtu['nomusu'] . ' ' . $dtu['apeusu'] . ' - ' . $dtu['genusu'] . '</p>';
        echo '<p class="text-muted m-0"><span class="location">' . $dtu['tipdoc'] . ' - ' . $dtu['docusu'] . '</span></p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-info">';
        echo '<p class="text-muted m-0"><span class="location">' . $dtu['emausu'] . '</span></p>';
        echo '<p>' . $dtu['celusu'] . '</p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-category indicator-wrap bg-soft-success" style="';
        if ($dtu['estusu'] == 'Inactivo') {
            echo 'background-color: #ff96967a;';
        }
        echo '">';
        echo '<i class="indicator bg-success" style="';
        if ($dtu['estusu'] == 'Inactivo') {
            echo 'background-color: rgb(224, 67, 46)!important;';
        }
        echo '"></i>';
        echo '<span>' . $dtu['estusu'] . '</span>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        if ($dtu['nompef']) {
            echo '<div class="widget-26-job-category indicator-wrap bg-soft-success" style="';
            if ($dtu['nompef'] == 'Administrador') {
                echo 'background-color: #ffce4aa6;';
            }
            echo '">';
            echo '<i class="indicator bg-success" style="';
            if ($dtu['nompef'] == 'Administrador') {
                echo 'background-color: rgb(165, 128, 0)!important;';
            }
            echo '"></i>';
            echo '<span>' . $dtu['nompef'] . '</span>';
            echo '</div>';
        }
        echo '</td>';
        echo '</tr>';
    }
} else {
    // Si no se encuentran usuarios
    echo '<tr><td colspan="6">No se encontraron usuarios.</td></tr>';
}

