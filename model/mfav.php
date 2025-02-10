<?php
class FavoritosModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function agregarFavorito($idusu, $idpro)
    {
        $sql = "INSERT INTO favoritos (idusu) VALUES (:idusu)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(":idusu", $idusu);
        $stmt->execute();
        $idfav = $this->conexion->lastInsertId();

        $sqlDetalle = "INSERT INTO detallefavoritos (idfav, idpro) VALUES (:idfav, :idpro)";
        $stmtDetalle = $this->conexion->prepare($sqlDetalle);
        $stmtDetalle->bindParam(":idfav", $idfav);
        $stmtDetalle->bindParam(":idpro", $idpro);
        return $stmtDetalle->execute();
    }

    public function eliminarFavorito($idusu, $idpro)
    {
        try {
            // 1️⃣ Obtener el idfav del usuario
            $sql = "SELECT f.idfav FROM favoritos f 
        INNER JOIN detallefavoritos df ON f.idfav = df.idfav
        WHERE f.idusu = :idusu AND df.idpro = :idpro";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(":idusu", $idusu);
            $stmt->bindParam(":idpro", $idpro);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


            if (!$resultado) {
                error_log("⚠️ No se encontró un favorito para el usuario ID = $idusu", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
                return false; // No encontró el favorito
            }

            $idfav = $resultado["idfav"];

            // 2️⃣ Eliminar de detallefavoritos
            $sqlDetalle = "DELETE FROM detallefavoritos WHERE idfav = :idfav AND idpro = :idpro";
            $stmtDetalle = $this->conexion->prepare($sqlDetalle);
            $stmtDetalle->bindParam(":idfav", $idfav);
            $stmtDetalle->bindParam(":idpro", $idpro);
            $stmtDetalle->execute();

            if ($stmtDetalle->rowCount() == 0) {
                error_log("⚠️ No se eliminó ningún registro en detallefavoritos para idfav=$idfav y idpro=$idpro", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
                return false;
            }

            // 3️⃣ Verificar si aún quedan productos en detallefavoritos
            $sqlVerificar = "SELECT COUNT(*) AS total FROM detallefavoritos WHERE idfav = :idfav";
            $stmtVerificar = $this->conexion->prepare($sqlVerificar);
            $stmtVerificar->bindParam(":idfav", $idfav);
            $stmtVerificar->execute();
            $total = $stmtVerificar->fetch(PDO::FETCH_ASSOC)["total"];

            // 4️⃣ Si no hay más productos, eliminar de favoritos
            if ($total == 0) {
                $sqlEliminarFav = "DELETE FROM favoritos WHERE idfav = :idfav";
                $stmtEliminarFav = $this->conexion->prepare($sqlEliminarFav);
                $stmtEliminarFav->bindParam(":idfav", $idfav);
                $stmtEliminarFav->execute();
            }

            error_log("✅ Favorito eliminado correctamente para usuario ID = $idusu, producto ID = $idpro", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return true;
        } catch (Exception $e) {
            error_log("❌ Error SQL en eliminarFavorito: " . $e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }


    public function getFavoritos($idusu)
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.precio, p.estado, p.pordescu, p.idval, p.productvend, df.iddetfav, df.idfav, df.idpro, f.idfav, f.idusu, p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento, i.imgpro, i.nomimg, v.nomval FROM producto AS p INNER JOIN detallefavoritos AS df ON p.idpro = df.idpro INNER JOIN favoritos AS f ON df.idfav = f.idfav INNER JOIN valor AS v ON p.idval = v.idval LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON p.idpro = i.idpro WHERE p.estado = 'activo' AND f.idusu = :idusu;";
        try {
            $con = $this->conexion->prepare($sql);
            $con->bindParam(':idusu', $idusu);
            $con->execute();
            $res = $con->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener favoritos. Intentalo más tarde";
        }
        return $res;
    }
}
