<?php
class Mpro
{
    public $idpro;
    public $nompro;
    public $precio;
    public $descripcion;
    public $estado;
    public $imgpro;

    // Getters
    public function getIdpro()
    {
        return $this->idpro;
    }

    public function getNompro()
    {
        return $this->nompro;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getImgpro()
    {
        return $this->imgpro;
    }

    // Setters
    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }

    public function setNompro($nompro)
    {
        $this->nompro = $nompro;
    }

    public function setPrecio($precio)
    {
        if ($precio < 0) {
            throw new Exception("El precio no puede ser negativo.");
        }
        $this->precio = $precio;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado)
    {
        $estadosValidos = ['activo', 'inactivo'];
        if (!in_array($estado, $estadosValidos)) {
            throw new Exception("Estado no válido.");
        }
        $this->estado = $estado;
    }

    public function setImgpro($imgpro)
    {
        $this->imgpro = $imgpro;
    }
    public function getOnePrd()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.descripcion, p.valorunitario, p.pordescu, p.productvend, p.cantidad, img.imgpro, p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento, CASE WHEN DATEDIFF(NOW(), p.feccreat) <= 20 THEN 1 ELSE 0 END AS es_nuevo, prov.nomprov, prov.dirrecprov, prov.url, prov.estado, prov.desprv FROM producto AS p LEFT JOIN (SELECT idpro, imgpro FROM imagen WHERE idpro = :idpro ORDER BY ordimg ASC LIMIT 1) AS img ON p.idpro = img.idpro LEFT JOIN prodxprov AS pp ON p.idpro = pp.idpro LEFT JOIN proveedor AS prov ON pp.idprov = prov.idprov WHERE p.idpro = :idpro;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpro = $this->getIdpro();
            $result->bindParam(':idpro', $idpro);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener detalle del producto. Inténtalo más tarde";
        }
        return $res;
    }

    public function getInfPar()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro,p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento FROM producto AS p LEFT JOIN imagen AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' GROUP BY p.idpro;
";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos. Intentalo mas tarde";
        }
        return $res;
    }
    //Productos en oferta
    public function getInfOfertas()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' AND p.pordescu > 0
            GROUP BY p.idpro
            LIMIT 5"; // Limitar el número de productos
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos en oferta. Intentalo más tarde";
        }
        return $res;
    }
    //Productos Más vendidos
    public function getInfMasVendidos()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' 
            GROUP BY p.idpro
            ORDER BY p.productvend DESC
            LIMIT 5";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos más vendidos. Intentalo más tarde";
        }
        return $res;
    }
    //Productos por temporadas
    public function getInfTemporada()
    {
        $res = "";

        // Array que asocia cada mes con una temporada
        $temporadas = [
            1 => "verano",
            2 => "verano",
            3 => "primavera",
            4 => "primavera",
            5 => "primavera",
            6 => "verano",
            7 => "verano",
            8 => "verano",
            9 => "otoño",
            10 => "halloween",
            11 => "otoño",
            12 => "navidad"
        ];

        // Obtener el mes actual y la temporada correspondiente
        $mesActual = date('n'); // 'n' devuelve el número de mes sin ceros a la izquierda (1-12)
        $temporadaActual = $temporadas[$mesActual];

        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' AND p.temporada = :temporadaActual
            GROUP BY p.idpro
            LIMIT 5";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':temporadaActual', $temporadaActual, PDO::PARAM_STR);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos de temporada. Intentalo más tarde";
        }

        return $res;
    }

    public function getCarPrd()
    {
        $res = "";
        $sql = "SELECT idcar, idpro, descripcion FROM caracteristicas WHERE idpro = :idpro;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpro = $this->getIdpro();
            $result->bindParam(':idpro', $idpro);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener detalle del producto. Intentalo mas tarde";
        }
        return $res;
    }
    public function getImagesByProduct($idpro = NULL, $lugimg = NULL)
    {
        $res = "";
        $sql = "SELECT imgpro, nomimg FROM imagen WHERE (:idpro IS NULL OR idpro = :idpro) AND (:lugimg IS NULL OR lugimg = :lugimg) ORDER BY ordimg;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);

            // Asigna los valores de los parámetros. Usar bindValue para manejar NULL correctamente.
            $result->bindValue(':idpro', $idpro);
            $result->bindValue(':lugimg', $lugimg);

            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener las imágenes del producto. Intentalo más tarde.";
        }
        return $res;
    }



}
