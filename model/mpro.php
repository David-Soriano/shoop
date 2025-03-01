<?php
class Mpro
{
    private $idpro;
    private $nompro;
    private $descripcion;
    private $cantidad;
    private $idval;
    private $valorunitario;
    private $pordescu;
    private $precio;
    private $estado;
    private $imgpro;
    private $nomimg;
    private $tipimg;
    private $ordimg;
    private $fechfinofer;
    private $fechiniofer;
    //Características
    private $descripcionCr;
    //Proveedor
    private $idprov;

    // Getters
    // Getters y Setters para idpro
    public function getIdpro()
    {
        return $this->idpro;
    }

    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }

    // Getters y Setters para nompro
    public function getNompro()
    {
        return $this->nompro;
    }

    public function setNompro($nompro)
    {
        $this->nompro = $nompro;
    }

    // Getters y Setters para descripcion
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    // Getters y Setters para cantidad
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    // Getters y Setters para idval
    public function getIdval()
    {
        return $this->idval;
    }

    public function setIdval($idval)
    {
        $this->idval = $idval;
    }

    // Getters y Setters para valorunitario
    public function getValorunitario()
    {
        return $this->valorunitario;
    }

    public function setValorunitario($valorunitario)
    {
        $this->valorunitario = $valorunitario;
    }

    // Getters y Setters para pordescu
    public function getPordescu()
    {
        return $this->pordescu;
    }

    public function setPordescu($pordescu)
    {
        $this->pordescu = $pordescu;
    }

    // Getters y Setters para precio
    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    // Getters y Setters para estado
    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    // Getters y Setters para imgpro
    public function getImgpro()
    {
        return $this->imgpro;
    }

    public function setImgpro($imgpro)
    {
        $this->imgpro = $imgpro;
    }

    // Getters y Setters para nomimg
    public function getNomimg()
    {
        return $this->nomimg;
    }

    public function setNomimg($nomimg)
    {
        $this->nomimg = $nomimg;
    }

    // Getters y Setters para tipimg
    public function getTipimg()
    {
        return $this->tipimg;
    }

    public function setTipimg($tipimg)
    {
        $this->tipimg = $tipimg;
    }

    // Getters y Setters para ordimg
    public function getOrdimg()
    {
        return $this->ordimg;
    }
    public function getDescripcionCr()
    {
        return $this->descripcionCr;
    }
    public function setOrdimg($ordimg)
    {
        $this->ordimg = $ordimg;
    }
    public function setDescripcionCr($descripcionCr)
    {
        $this->descripcionCr = $descripcionCr;
    }
    public function getFechiniofer()
    {
        return $this->fechiniofer;
    }
    public function setFechiniofer($fechiniofer)
    {
        $this->fechiniofer = $fechiniofer;
    }
    public function getFechfinofer()
    {
        return $this->fechfinofer;
    }
    public function setFechfinofer($fechfinofer)
    {
        $this->fechfinofer = $fechfinofer;
    }
    public function getIdprov()
    {
        return $this->idprov;
    }
    public function setIdprov($idprov)
    {
        $this->idprov = $idprov;
    }
    //Traer un producto en especifico
    public function getOnePrd()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.descripcion, p.valorunitario, p.precio, p.pordescu, p.productvend, p.cantidad, img.imgpro, p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento, CASE WHEN DATEDIFF(NOW(), p.feccreat) <= 20 THEN 1 ELSE 0 END AS es_nuevo, prov.nomprov, prov.dirrecprov, prov.urlt, prov.estprv, prov.desprv FROM producto AS p LEFT JOIN (SELECT idpro, imgpro FROM imagen WHERE idpro = :idpro ORDER BY ordimg ASC LIMIT 1) AS img ON p.idpro = img.idpro LEFT JOIN prodxprov AS pp ON p.idpro = pp.idpro LEFT JOIN proveedor AS prov ON pp.idprov = prov.idprov WHERE p.idpro = :idpro AND p.estado = 'activo';";
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
    //Traer todos los productos a la pagina inicial
    public function getInfPar()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, i.imgpro, p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento FROM producto AS p LEFT JOIN imagen AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' GROUP BY p.idpro;
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
    //Productos en oferta limitado
    public function getInfOfertas()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, i.imgpro, 
            p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' AND p.pordescu > 0
            GROUP BY p.idpro
            LIMIT 4"; // Limitar el número de productos
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
    //TODOS Productos en oferta ordenados
    public function getInfOfertasAll()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, i.imgpro, 
            p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' AND p.pordescu > 0
            GROUP BY p.idpro ORDER BY p.fechiniofer DESC";
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
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, i.imgpro, CASE WHEN p.pordescu > 0 THEN p.precio - (p.precio * (p.pordescu / 100)) ELSE 0 END AS valor_con_descuento FROM producto AS p LEFT JOIN imagen AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' AND p.productvend > 0 GROUP BY p.idpro ORDER BY p.productvend DESC LIMIT 4;";
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
    public function getInfMasVendidosAll()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, i.imgpro, 
            p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' AND p.productvend > 0
            GROUP BY p.idpro
            ORDER BY p.productvend DESC";
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
    //Productos vistos recientemente
    public function getProVistos()
    {
        $res = [];

        // Verificar si la cookie de productos vistos existe y contiene productos
        if (isset($_COOKIE['provis']) && !empty($_COOKIE['provis'])) {
            // Obtener los IDs de productos vistos desde la cookie
            $idsProductos = $_COOKIE['provis'];

            // Consulta SQL para obtener los detalles de los productos
            $sql = "SELECT p.idpro, p.nompro, p.valorunitario, p.precio, p.pordescu, i.imgpro,
       p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento FROM producto AS p LEFT JOIN (SELECT idpro, imgpro FROM imagen WHERE ordimg = (SELECT MIN(ordimg) FROM imagen WHERE idpro = imagen.idpro)) AS i ON p.idpro = i.idpro WHERE p.idpro IN ($idsProductos) AND p.estado = 'activo' ORDER BY FIELD(p.idpro, $idsProductos) DESC;"; // Mantener el orden de los productos

            try {
                $modelo = new Conexion();
                $conexion = $modelo->getConexion();
                $result = $conexion->prepare($sql);
                $result->execute();
                $res = $result->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
                echo "Error al obtener productos recientemente vistos. Intentalo más tarde";
            }
        }

        return $res;
    }
    public function getProductosNuevos()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, p.feccreat, i.imgpro, i.ordimg, p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento, CASE WHEN DATEDIFF(NOW(), p.feccreat) <= 20 THEN 1 ELSE 0 END AS es_nuevo FROM producto AS p LEFT JOIN ( SELECT idpro, imgpro, ordimg FROM imagen WHERE ordimg = 1) AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' AND DATEDIFF(NOW(), p.feccreat) <= 20 ORDER BY p.feccreat DESC;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos nuevos. Intentalo más tarde";
        }
        return $res;
    }
    //Productos por categoría
    public function getCatego($categoria)
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.precio, p.cantidad, p.tipro, p.valorunitario, p.precio, p.feccreat, p.estado, p.pordescu, p.idval, v.nomval AS categoria, i.imgpro, p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento FROM producto p JOIN valor v ON p.idval = v.idval JOIN dominio d ON v.iddom = d.iddom LEFT JOIN (SELECT idpro, imgpro FROM imagen ORDER BY ordimg ASC) AS i ON p.idpro = i.idpro WHERE d.nomdom = 'Categorías' AND v.nomval = :categoria AND p.estado = 'activo' GROUP BY p.idpro";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos por categoría. Inténtalo más tarde.";
        }
        return $res;
    }

    //Traer características de un producto
    public function getCarPrd()
    {
        $res = "";
        $sql = "SELECT idcar, idpro, descripcioncr FROM caracteristicas WHERE idpro = :idpro;";
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
            echo "Error al obtener características del producto. Intentalo mas tarde";
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

    public function saveProductoConImagenes($imagenes, $caracteristicas)
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $conexion->beginTransaction();

            // Inserta el producto
            $idProducto = $this->insertProducto($conexion);

            // Inserta las imágenes asociadas al producto
            if ($idProducto) {

                $this->insertImagenes($conexion, $idProducto, $imagenes);
                $this->saveCaracterísticas($conexion, $idProducto, $caracteristicas); //
            }

            $conexion->commit();
            return $idProducto; // Retorna el ID del producto insertado
        } catch (PDOException $e) {
            $conexion->rollBack();
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al registrar producto e imágenes. Inténtalo más tarde.";
            return null;
        }
    }
    private function insertProducto($conexion)
    {
        $sql = "INSERT INTO producto(nompro, descripcion, cantidad, idval, valorunitario, fechiniofer, fechfinofer, precio, pordescu) 
                VALUES (:nompro, :descripcion, :cantidad, :idval, :valorunitario, :fechiniofer, :fechfinofer, :precio, :pordescu)";
        $stmt = $conexion->prepare($sql);

        $params = [
            ':nompro' => $this->getNompro(),
            ':descripcion' => $this->getDescripcion(),
            ':cantidad' => $this->getCantidad(),
            ':idval' => $this->getIdval(),
            ':valorunitario' => $this->getValorunitario(),
            ':fechiniofer' => $this->getFechiniofer(),
            ':fechfinofer' => $this->getFechfinofer(),
            ':pordescu' => $this->getPordescu(),
            ':precio' => $this->getPrecio(),
        ];
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();
        $idproducto = $conexion->lastInsertId(); // Retorna el ID del producto recién insertado
        return $idproducto;
    }
    private function insertImagenes($conexion, $idProducto, $imagenes)
    {
        $sql = "INSERT INTO imagen(imgpro, nomimg, tipimg, idpro, ordimg) 
                VALUES (:imgpro, :nomimg, :tipimg, :idpro, :ordimg)";
        $stmt = $conexion->prepare($sql);
        echo "<pre>";
            print_r($imagenes);
            echo "</pre>";
        foreach ($imagenes as $index => $imagen) {
            $params = [
                ':imgpro' => $imagen['imgpro'],
                ':nomimg' => $imagen['nomimg'],
                ':tipimg' => $imagen['tipimg'],
                ':idpro' => $idProducto,
                ':ordimg' => isset($imagen['principal']) && $imagen['principal'] ? 1 : $index + 1
            ];

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }

            $stmt->execute();
        }
    }
    function saveCaracterísticas($conexion, $idpro, $caracteristicas)
    {
        foreach ($caracteristicas as $descripcion) {
            // Asegúrate de limpiar los datos antes de usarlos (prevención de inyección SQL)
            $descripcionLimpia = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');

            // Aquí puedes insertar cada característica en la base de datos
            $sql = "INSERT INTO caracteristicas (descripcioncr, idpro) VALUES (:descripcioncr, :idpro)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':descripcioncr', $descripcionLimpia);
            $stmt->bindParam(':idpro', $idpro); // Asegúrate de que $idProducto esté definido
            $stmt->execute();
        }
    }
    function getAllPrd($idprov, $limit, $offset)
    {
        $res = "";
        // Si no hay búsqueda, la consulta no tiene filtro por nombre del producto
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
                ORDER BY p.feccreat DESC
                LIMIT $limit OFFSET $offset";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(':idprov', $idprov, PDO::PARAM_INT);

            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al mostrar productos registrados. Inténtalo más tarde.";
        }
        return $res;
    }

    function getCantPrd($idprov)
    {
        $total = 0; // Inicializar la variable en caso de error
        $sql = "SELECT COUNT(*) AS total FROM producto p 
                JOIN prodxprov pxp ON p.idpro = pxp.idpro
                JOIN proveedor pr ON pxp.idprov = pr.idprov
                WHERE pr.idprov = :idprov AND p.estado = 'activo'";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(':idprov', $idprov);
            $result->execute();
            $res = $result->fetch(PDO::FETCH_ASSOC); // Usar fetch para un único resultado
            if ($res) {
                $total = $res['total']; // Acceder directamente al valor
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al mostrar productos registrados. Inténtalo más tarde.";
        }
        return $total; // Retorna el total correctamente
    }
    public function updateProducto()
    {
        $sql = "UPDATE producto SET 
                    nompro = :nompro, 
                    descripcion = :descripcion, 
                    cantidad = :cantidad, 
                    idval = :idval, 
                    valorunitario = :valorunitario, 
                    pordescu = :pordescu, 
                    precio = :precio, 
                    fechiniofer = :fechiniofer, 
                    fechfinofer = :fechfinofer
                WHERE idpro = :idpro";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $stmt = $conexion->prepare($sql);

            $nompro = $this->getNompro();
            $descripcion = $this->getDescripcion();
            $cantidad = $this->getCantidad();
            $idval = $this->getIdval();
            $valorunitario = $this->getValorunitario();
            $pordescu = $this->getPordescu();
            $precio = $this->getPrecio();
            $fechiniofer = $this->getFechiniofer();
            $fechfinofer = $this->getFechfinofer();
            $idpro = $this->getIdpro();

            $stmt->bindParam(':nompro', $nompro);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':idval', $idval);
            $stmt->bindParam(':valorunitario', $valorunitario);
            $stmt->bindParam(':pordescu', $pordescu);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':fechiniofer', $fechiniofer);
            $stmt->bindParam(':fechfinofer', $fechfinofer);
            $stmt->bindParam(':idpro', $idpro);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }


    public function updateImagenesProducto($imagenes)
    {
        $sqlDelete = "DELETE FROM imagen WHERE idpro = :idpro";
        $sqlInsert = "INSERT INTO imagen (imgpro, nomimg, tipimg, ordimg, idpro) 
                      VALUES (:imgpro, :nomimg, :tipimg, :ordimg, :idpro)";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            // Eliminar imágenes antiguas
            $stmt = $conexion->prepare($sqlDelete);
            $idpro = $this->getIdpro();
            $stmt->bindParam(':idpro', $idpro);
            $stmt->execute();

            // Insertar nuevas imágenes
            $stmtInsert = $conexion->prepare($sqlInsert);
            $idpro = $this->getIdpro();
            foreach ($imagenes as $index => $imagen) {
                $params = [
                    ':imgpro' => $imagen['imgpro'],
                    ':nomimg' => $imagen['nomimg'],
                    ':tipimg' => $imagen['tipimg'],
                    ':idpro' => $idpro,
                    ':ordimg' => $imagen['ordimg']
                ];
                foreach ($params as $key => $value) {
                    $stmtInsert->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }

                $stmtInsert->execute();
            }
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }


    public function updateCaracteristicas($caracteristicas, $idpro)
    {
        $sqlDelete = "DELETE FROM caracteristicas WHERE idusu = :idusu";
        $sqlInsert = "INSERT INTO caracteristicas (descripcioncr, idpro) 
                      VALUES (:descripcioncr, :idpro)";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            // Eliminar características antiguas
            $stmt = $conexion->prepare($sqlDelete);
            $stmt->bindParam(':idpro', $idpro);
            $stmt->execute();

            // Insertar nuevas características
            $stmtInsert = $conexion->prepare($sqlInsert);
            foreach ($caracteristicas as $carac) {
                $stmtInsert->bindParam(':descripcioncr', $carac);
                $stmtInsert->bindParam(':idpro', $idpro);
                $stmtInsert->execute();
            }

            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }


    function getProductoById($idpro)
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = "SELECT 
            p.idpro, 
            p.nompro, 
            p.descripcion, 
            p.cantidad, 
            p.idval, 
            p.valorunitario,
            p.fechiniofer,
            p.fechfinofer, 
            p.precio, 
            p.pordescu, 
            COALESCE(
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        '{\"idimag\":', i.idimag, 
                        ', \"imgpro\":\"', i.imgpro, 
                        '\", \"nomimg\":\"', i.nomimg, 
                        '\", \"tipimg\":\"', i.tipimg, 
                        '\", \"ordimg\":', i.ordimg, '}'
                    ) SEPARATOR ','), 
                '') AS imagenes, 
            COALESCE(
                GROUP_CONCAT(
                    CONCAT(
                        '{\"idcar\":', c.idcar, 
                        ', \"descripcioncr\":\"', c.descripcioncr, '\"}'
                    ) SEPARATOR ','), 
                '') AS caracteristicas
        FROM 
            producto p
        LEFT JOIN 
            imagen i ON p.idpro = i.idpro
        LEFT JOIN 
            caracteristicas c ON p.idpro = c.idpro
        WHERE 
            p.idpro = :idpro AND p.estado = 'activo'
        GROUP BY 
            p.idpro";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idpro', $idpro, PDO::PARAM_INT);
            $stmt->execute();

            // Depurar el contenido de $stmt
            if ($stmt->rowCount() === 0) {
                throw new Exception("No se encontró el producto con el ID proporcionado.");
            }

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Continúa el procesamiento...
            $producto = [
                'idpro' => $resultados[0]['idpro'],
                'nompro' => $resultados[0]['nompro'],
                'descripcion' => $resultados[0]['descripcion'],
                'cantidad' => $resultados[0]['cantidad'],
                'idval' => $resultados[0]['idval'],
                'valorunitario' => $resultados[0]['valorunitario'],
                'fechiniofer' => $resultados[0]['fechiniofer'],
                'fechfinofer' => $resultados[0]['fechfinofer'],
                'precio' => $resultados[0]['precio'],
                'pordescu' => $resultados[0]['pordescu'],
                'imagenes' => [], // Inicializa como un arreglo vacío
                'caracteristicas' => [] // Inicializa como un arreglo vacío
            ];

            // Recorre los resultados
            foreach ($resultados as $fila) {
                if ($fila['imagenes']) { // Verifica si existen imágenes
                    $producto['imagenes'] = json_decode('[' . $fila['imagenes'] . ']', true); // Convierte el JSON a un array
                }

                if ($fila['caracteristicas']) { // Verifica si existen características
                    $producto['caracteristicas'] = json_decode('[' . $fila['caracteristicas'] . ']', true); // Convierte el JSON a un array
                }
            }

            return $producto;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener los datos del producto. Inténtalo más tarde.";
            return null;
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo $e->getMessage();
            return null;
        }
    }
    public function deleteProducto()
{
    $sqlUpdate = "UPDATE producto SET estado = 'inactivo' WHERE idpro = :idpro";
    $sqlSelectImages = "SELECT imgpro FROM imagen WHERE idpro = :idpro";
    $sqlDeleteImagesDB = "DELETE FROM imagen WHERE idpro = :idpro";

    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        // 1. Cambiar el estado del producto a "inactivo"
        $stmt = $conexion->prepare($sqlUpdate);
        $idpro = $this->getIdpro();
        $stmt->bindParam(':idpro', $idpro, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // 2. Obtener imágenes asociadas al producto
            $stmt = $conexion->prepare($sqlSelectImages);
            $stmt->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $stmt->execute();
            $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN); // Obtener solo los nombres de archivo con ruta

            // 3. Eliminar archivos de imagen del directorio
            foreach ($imagenes as $imagen) {
                $rutaImagen = 'C:/xampp/htdocs/SHOOP/' . $imagen; // Ajustar ruta base del servidor
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen); // Eliminar archivo físico
                }
            }

            // 4. Eliminar registros de imágenes en la base de datos
            $stmt = $conexion->prepare($sqlDeleteImagesDB);
            $stmt->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }

        return false;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        return false;
    }
}

    public function getProductosSugeridos($idusu = null)
    {
        $res = [];
        $sql = "(
    SELECT DISTINCT 
        p.idpro, 
        p.nompro, 
        p.estado, 
        p.tipro, 
        p.valorunitario, 
        p.precio, 
        p.pordescu, 
        i.imgpro, 
        p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento
    FROM producto AS p
    LEFT JOIN imagen AS i ON p.idpro = i.idpro
    LEFT JOIN carrito AS c ON c.idusu = COALESCE(:idusu, 0)
    LEFT JOIN detallecarrito AS dc ON dc.idcar = c.idcar AND dc.idpro = p.idpro
    LEFT JOIN favoritos AS f ON f.idusu = COALESCE(:idusu, 0)
    LEFT JOIN detallefavoritos AS df ON df.idfav = f.idfav AND df.idpro = p.idpro
    LEFT JOIN busquedas AS b ON (COALESCE(:idusu, 0) > 0 AND b.idusu = :idusu AND p.nompro LIKE CONCAT('%', b.termino_busqueda, '%')) 
    WHERE p.estado = 'activo'
    AND (
        p.idval = (SELECT idval FROM producto WHERE idpro = :idpro) 
        OR EXISTS (SELECT 1 FROM detallecarrito AS dc WHERE dc.idpro = p.idpro AND dc.idcar = c.idcar)
        OR EXISTS (SELECT 1 FROM detallefavoritos AS df WHERE df.idpro = p.idpro AND df.idfav = f.idfav)
        OR EXISTS (SELECT 1 FROM busquedas AS b WHERE b.idusu = :idusu AND p.nompro LIKE CONCAT('%', b.termino_busqueda, '%'))
    )
    GROUP BY p.idpro
    LIMIT 10
)
UNION ALL
(
    SELECT DISTINCT 
        p.idpro, 
        p.nompro, 
        p.estado, 
        p.tipro, 
        p.valorunitario, 
        p.precio, 
        p.pordescu, 
        i.imgpro, 
        p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento
    FROM producto AS p
    LEFT JOIN imagen AS i ON p.idpro = i.idpro
    WHERE p.estado = 'activo'
    ORDER BY RAND()
    LIMIT 10
)
ORDER BY RAND()
LIMIT 16;";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpro = $this->getIdpro();
            $result->bindValue(':idpro', $idpro);
            $result->bindValue(':idusu', $idusu, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos sugeridos. Inténtalo más tarde";
        }
        return $res;
    }
    public function getProductosPorCategoria($idpro)
    {
        $res = [];
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.precio, p.pordescu, i.imgpro, p.precio - (p.precio * (p.pordescu / 100)) AS valor_con_descuento, p.idval FROM producto AS p LEFT JOIN imagen AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' AND p.idpro <> :idpro AND ( p.idval = (SELECT idval FROM producto WHERE idpro = :idpro) OR p.nompro LIKE CONCAT('%', (SELECT nompro FROM producto WHERE idpro = :idpro), '%') OR p.nompro REGEXP (SELECT REPLACE(nompro, ' ', '|') FROM producto WHERE idpro = :idpro)) GROUP BY p.idpro ORDER BY p.productvend DESC, p.precio ASC LIMIT 10;
";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);

            $result->bindValue(':idpro', $idpro, PDO::PARAM_INT);

            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos por categoría y nombre. Inténtalo más tarde";
        }

        return $res;
    }

    public function actualizarCantidadVendida($idpro, $cantidadVendida)
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            // Consulta para actualizar la cantidad de productos vendidos
            $sql = "UPDATE producto SET productvend = productvend + :cantidadVendida WHERE idpro = :idpro";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':cantidadVendida', $cantidadVendida, PDO::PARAM_INT);
            $stmt->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            throw new Exception("Error al actualizar la cantidad de productos vendidos.");
        }
    }
}
