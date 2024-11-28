<?php
include dirname(__DIR__) . "/model/conexion.php";
ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict'); 
session_start();
$isLoggedIn = isset($_SESSION['idusu']);
if (isset($_GET['query'])) {
    $searchQuery = htmlspecialchars($_GET['query']); // Obtener el término de búsqueda

    // Preparar la consulta SQL para buscar en nombre o descripción de los productos
    $sql = "SELECT 
    p.idpro,
    p.nompro,
    p.valorunitario,
    p.pordescu,
    (p.valorunitario - (p.valorunitario * (p.pordescu / 100))) AS valor_con_descuento,
    i.imgpro
FROM 
    producto AS p
LEFT JOIN 
    imagen AS i ON p.idpro = i.idpro
WHERE 
    p.estado = 'activo' 
    AND (p.nompro LIKE :query OR p.descripcion LIKE :query)
ORDER BY 
    i.ordimg ASC 
LIMIT 1;";

    try {
        $model = new Conexion();
        $conexion = $model->getConexion();
        // Conectar a la base de datos
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':query', '%' . $searchQuery . '%'); // Buscar coincidencias parciales
        $stmt->execute();

        // Verificar si hay resultados
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            // Mostrar productos encontrados
            foreach ($results as $product) {
                echo "<a href='" . ($isLoggedIn ? "home.php?pg=001&idpro=" . $product['idpro'] : "index.php?pg=001&idpro=" . $product['idpro']) . "'><div class='product row'>";
                echo "<h3>" . htmlspecialchars($product['nompro']) . "</h3>";
                echo "<div class='col-5 bx-sh-img'>";
                echo "<img src='" . $product['imgpro'] . "' alt='" . $product['nompro'] . "'>";
                echo "</div>";
                echo "<div class='col'>";

                // Mostrar precio con descuento tachado si es mayor a 0
                if ($product['valor_con_descuento'] > 0) {
                    echo "<del>$" . number_format($product['valorunitario'], 0, ",", ".") . "</del>";
                }

                echo "<p>" . number_format($product['valor_con_descuento'] > 0 ? $product['valor_con_descuento'] : $product['valorunitario'], 0, ",", ".") . " $</p>";

                // Mostrar descuento si existe
                if ($product['pordescu']) {
                    echo "<span>" . htmlspecialchars($product['pordescu']) . "% OFF</span>";
                }

                echo "</div>";
                echo "</div></a>";
            }
        } else {
            echo "<p id='res-nf'>No se encontraron productos que coincidan con '$searchQuery'.</p>";
        }
    } catch (PDOException $e) {
        echo "Error en la búsqueda: " . $e->getMessage();
    }
} else {
    echo "Por favor ingresa un término de búsqueda.";
}
