<?php
include_once(__DIR__ . '/../model/conexion.php');
include_once(__DIR__ . '/../model/mfav.php');

$conexion = (new Conexion())->getConexion();
$favoritosModel = new FavoritosModel($conexion);
// Verifica si la petición es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idusu = $_POST['idusu'] ?? null;
    $idpro = $_POST['idpro'] ?? null;
    $accion = $_POST['accion'] ?? null;

    // Depuración: Mostrar los valores recibidos
    if (!$idusu || !$idpro || !$accion) {
        echo json_encode(['success' => false, 'error' => 'Datos faltantes', 'data' => $_POST]);
        exit;
    }

    // Acción para verificar si el producto está en favoritos
    if ($accion == 'verificar') {
        // Lógica para verificar si el producto está en favoritos
        $query = "SELECT COUNT(*)
        FROM favoritos f
        INNER JOIN detallefavoritos df ON f.idfav = df.idfav
        WHERE f.idusu = ? AND df.idpro = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$idusu, $idpro]);
        $isFavorite = $stmt->fetchColumn() > 0;

        echo json_encode([
            'success' => true,
            'isFavorite' => $isFavorite
        ]);
        exit;
    }

    // Acción para agregar el producto a favoritos
    if ($accion == 'agregar') {
        $resultado = $favoritosModel->agregarFavorito($idusu, $idpro);
        echo json_encode(['success' => $resultado]);
        exit;
    }

    // Acción para eliminar el producto de favoritos
    if ($accion == 'eliminar') {
        $resultado = $favoritosModel->eliminarFavorito($idusu, $idpro);

        if (!$resultado) {
            error_log("⚠️ Error eliminando favorito: ID Usuario = $idusu, ID Producto = $idpro", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        } else {
            error_log("✅ Favorito eliminado correctamente: ID Usuario = $idusu, ID Producto = $idpro", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        }

        echo json_encode([
            'success' => $resultado,
            'idusu' => $idusu,
            'idpro' => $idpro
        ]);
        exit;
    }

} else {
    if (isset($_SESSION['idusu'])) {
        $dtFavoritos = $favoritosModel->getFavoritos($_SESSION['idusu']);
    }
}
