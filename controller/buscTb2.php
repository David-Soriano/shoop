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
function buscarPaginas($busqueda, $limit, $offset)
{
    $res = "";
    // Si hay búsqueda, se agrega el filtro por nombre de la página o perfil
    if (!empty($busqueda)) {
        $sql = "SELECT 
        p.idpag AS 'ID Página', 
        p.nompag AS 'Nombre Página', 
        p.rutpag AS 'Ruta Página', 
        p.mospag AS 'Mostrar Página', 
        p.icopag AS 'Ícono', 
        p.lugpag AS 'Lugar Página', 
        p.actpag AS 'Ver Pagina',
        pe.idpef AS 'ID Perfil', 
        pe.nompef AS 'Perfil', 
        pe.pagini AS 'Página Inicial' 
    FROM pagina p 
    LEFT JOIN pagxperfil pxp ON p.idpag = pxp.idpag 
    LEFT JOIN perfil pe ON pxp.idpef = pe.idpef 
    WHERE (p.nompag LIKE :searchTerm OR pe.nompef LIKE :searchTerm) 
    AND p.estpagn = 'Activo'
    LIMIT :limit OFFSET :offset;
    ";
    } else {
        $sql = "SELECT 
                    p.idpag AS 'ID Página', 
                    p.nompag AS 'Nombre Página', 
                    p.rutpag AS 'Ruta Página', 
                    p.mospag AS 'Mostrar Página', 
                    p.icopag AS 'Ícono', 
                    p.lugpag AS 'Lugar Página',
                    p.actpag AS 'Ver Pagina',
                    pe.idpef AS 'ID Perfil', 
                    pe.nompef AS 'Perfil', 
                    pe.pagini AS 'Página Inicial' 
                FROM pagina p 
                LEFT JOIN pagxperfil pxp ON p.idpag = pxp.idpag 
                LEFT JOIN perfil pe ON pxp.idpef = pe.idpef 
                WHERE p.estpagn = 'Activo'
                LIMIT :limit OFFSET :offset";
    }

    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);

        // Asignar los valores dinámicos para limit y offset
        $result->bindValue(':limit', $limit, PDO::PARAM_INT);
        $result->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Si hay búsqueda, agregamos el parámetro :searchTerm
        if (!empty($busqueda)) {
            $result->bindValue(':searchTerm', '%' . $busqueda . '%', PDO::PARAM_STR);
        }

        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error al mostrar páginas registradas. Inténtalo más tarde.";
    }

    return $res;
}

$resultsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($currentPage - 1) * $resultsPerPage;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$dtAllPages = buscarPaginas($searchTerm, $resultsPerPage, $offset); // Llama a la función de búsqueda específica.

if (isset($dtAllPages) && count($dtAllPages) > 0) {
    foreach ($dtAllPages as $dtp) {
        echo '<tr>';
        echo '<td>';
        echo '<div class="widget-26-job-starred">';
        echo '<input class="product-checkbox" type="checkbox" name="" id="" value="' . $dtp['ID Página'] . '">';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-emp-img">';
        echo '<p class="text-muted m-0"><span class="location">' . $dtp['ID Página'] . '</span></p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-title">';
        echo '<p>' . $dtp['Nombre Página'] . '</p>';
        echo '<a href="#">' . $dtp['Ruta Página'] . '</a>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-info">';
        echo '<p class="text-muted m-0"><span class="location">' . $dtp['Lugar Página'] . '</span></p>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-salary">';
        echo '<i class="' . $dtp['Ícono'] . '"></i>';
        echo '</div>';
        echo '</td>';
        echo '<td>';
        if ($dtp['Perfil']) {
            echo '<div class="widget-26-job-category indicator-wrap bg-soft-success" style="';
            if ($dtp['Perfil'] == 'Administrador') {
                echo 'background-color: #ffce4aa6;';
            }
            echo '">';
            echo '<i class="indicator bg-success" style="';
            if ($dtp['Perfil'] == 'Administrador') {
                echo 'background-color: rgb(165, 128, 0)!important;';
            }
            echo '"></i>';
            echo '<span>' . $dtp['Perfil'] . '</span>';
            echo '</div>';
        }
        echo '</td>';
        echo '<td>';
        echo '<div class="widget-26-job-info">';
        if ($dtp['Ver Pagina'] == 1)
            echo "<p style='color: #00a650; font-weight: 600;'>Visible</p>";
        else
            echo "<p style='color:rgb(166, 39, 0); font-weight: 600;'>Deshabilitada</p>";
        echo '</td>';
        echo '</tr>';
    }
} else {
    // Si no se encuentran páginas
    echo '<tr><td colspan="6">No se encontraron páginas.</td></tr>';
}
