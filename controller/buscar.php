<?php include "../model/conexion.php";
if (isset($_GET['query'])) {
    $searchQuery = htmlspecialchars($_GET['query']); // Obtener el término de búsqueda

    // Preparar la consulta SQL para buscar en nombre o descripción de los productos
    $sql = "SELECT * FROM producto WHERE nompro LIKE :query OR descripcion LIKE :query";

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
                echo "<div class='product row'>";
                echo "<h3>" . htmlspecialchars($product['nompro']) . "</h3>";
                echo "<div class='col'>";
                echo "<img src='' alt='imagen'>";
                echo "</div>";
                echo "<div class='col'>";

                // Mostrar precio con descuento tachado si es mayor a 0
                if ($dtinf['valor_con_descuento'] > 0) {
                    echo "<del>$" . number_format($dtinf['valorunitario'], 0, ",", ".") . "</del>";
                }

                echo "<p>Precio: " . number_format($dtinf['valor_con_descuento'] > 0 ? $dtinf['valor_con_descuento'] : $dtinf['valorunitario'], 0, ",", ".") . " $</p>";

                // Mostrar descuento si existe
                if ($product['pordescu']) {
                    echo "<span>" . htmlspecialchars($product['pordescu']) . "% OFF</span>";
                }

                echo "</div>";
                echo "</div>";


            }
        } else {
            echo "<p>No se encontraron productos que coincidan con '$searchQuery'.</p>";
        }
    } catch (PDOException $e) {
        echo "Error en la búsqueda: " . $e->getMessage();
    }
} else {
    echo "Por favor ingresa un término de búsqueda.";
}
