<?php
include "../model/conexion.php";
$bandera = false;  // Inicializamos la bandera como false

if (isset($_GET['query'])) {
    $searchQuery = htmlspecialchars($_GET['query']); // Obtener el término de búsqueda

    // Preparar la consulta SQL para buscar en nombre o descripción de los productos
    $sql = "SELECT p.idpro, p.nompro, p.valorunitario, p.pordescu, p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento, img.imgpro FROM producto AS p LEFT JOIN (SELECT i.idpro, i.imgpro FROM imagen AS i WHERE i.idpro IS NOT NULL ORDER BY i.ordimg ASC LIMIT 1) AS img ON p.idpro = img.idpro WHERE p.nompro LIKE :query OR p.descripcion LIKE :query";

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
            $bandera = true; // Establecer bandera a true si hay resultados
            foreach ($results as $product) {
                echo "<div class='product row'>";
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
                echo "</div>";
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
