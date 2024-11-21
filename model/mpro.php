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
    //Traer todos los productos a la pagina inicial
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
    //Productos en oferta limitado
    public function getInfOfertas()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
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
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
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
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' 
            GROUP BY p.idpro
            ORDER BY p.productvend DESC
            LIMIT 4";
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
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, i.imgpro, 
            p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento 
            FROM producto AS p 
            LEFT JOIN imagen AS i ON p.idpro = i.idpro 
            WHERE p.estado = 'activo' 
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
            $sql = "SELECT p.idpro, p.nompro, p.valorunitario, p.pordescu, i.imgpro,
       p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento FROM producto AS p LEFT JOIN (SELECT idpro, imgpro FROM imagen WHERE ordimg = (SELECT MIN(ordimg) FROM imagen WHERE idpro = imagen.idpro)) AS i ON p.idpro = i.idpro WHERE p.idpro IN ($idsProductos) AND p.estado = 'activo' ORDER BY FIELD(p.idpro, $idsProductos) DESC;"; // Mantener el orden de los productos

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
        $sql = "SELECT p.idpro, p.nompro, p.estado, p.tipro, p.valorunitario, p.pordescu, p.feccreat, i.imgpro, p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento, CASE WHEN DATEDIFF(NOW(), p.feccreat) <= 20 THEN 1 ELSE 0 END AS es_nuevo FROM producto AS p LEFT JOIN (SELECT idpro, imgpro FROM imagen ORDER BY ordimg ASC) AS i ON p.idpro = i.idpro WHERE p.estado = 'activo' AND DATEDIFF(NOW(), p.feccreat) <= 20 GROUP BY p.idpro ORDER BY p.feccreat DESC;";
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
        $sql = "SELECT p.idpro, p.nompro, p.precio, p.cantidad, p.tipro, p.valorunitario, p.feccreat, p.estado, p.pordescu, p.idval, v.nomval AS categoria, i.imgpro, p.valorunitario - (p.valorunitario * (p.pordescu / 100)) AS valor_con_descuento FROM producto p JOIN valor v ON p.idval = v.idval JOIN dominio d ON v.iddom = d.iddom LEFT JOIN (SELECT idpro, imgpro FROM imagen ORDER BY ordimg ASC) AS i ON p.idpro = i.idpro WHERE d.nomdom = 'Categorías' AND v.nomval = :categoria GROUP BY p.idpro";

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
        return $conexion->lastInsertId(); // Retorna el ID del producto recién insertado
    }
    private function insertImagenes($conexion, $idProducto, $imagenes)
    {
        $sql = "INSERT INTO imagen(imgpro, nomimg, tipimg, idpro, ordimg) 
                VALUES (:imgpro, :nomimg, :tipimg, :idpro, :ordimg)";
        $stmt = $conexion->prepare($sql);

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
                WHERE pr.idprov = :idprov
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
                WHERE pr.idprov = :idprov";
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
    function updateallPrd($imagenes, $caracteristicas, $idpro)
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $conexion->beginTransaction(); // Inicia la transacción

            // Actualiza el producto
            $productoActualizado = $this->updateProducto($idpro, $conexion);

            if ($productoActualizado) {
                // Actualiza las imágenes y características asociadas
                $this->updateImagen($conexion, $idpro, $imagenes);
                $this->updateCaracteristicas($conexion, $idpro, $caracteristicas);
            }

            $conexion->commit(); // Confirma la transacción si todo sale bien
            return $idpro; // Retorna el ID del producto actualizado
        } catch (PDOException $e) {
            $conexion->rollBack(); // Reversa los cambios en caso de error
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al actualizar el producto. Inténtalo más tarde.";
            return null;
        }
    }

    function updateProducto($idpro, $conexion)
    {
        $sql = "UPDATE producto 
            SET nompro = :nompro, descripcion = :descripcion, cantidad = :cantidad, idval = :idval,
                valorunitario = :valorunitario, fechfinofer = :fechfinofer, precio = :precio, pordescu = :pordescu
            WHERE idpro = :idpro";
        try {
            $result = $conexion->prepare($sql);
            $result->bindParam(':nompro', $this->getNompro());
            $result->bindParam(':descripcion', $this->getDescripcion());
            $result->bindParam(':cantidad', $this->getCantidad());
            $result->bindParam(':idval', $this->getIdval());
            $result->bindParam(':valorunitario', $this->getValorunitario());
            $result->bindParam(':fechfinofer', $this->getFechfinofer());
            $result->bindParam(':precio', $this->getPrecio());
            $result->bindParam(':pordescu', $this->getPordescu());
            $result->bindValue(':idpro', $idpro);
            $result->execute();
            return $result->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            throw $e;
        }
    }

    function updateImagen($conexion, $idpro, $imagenes)
    {
        $sql = "UPDATE imagen 
            SET imgpro = :imgpro, nomimg = :nomimg, tipimg = :tipimg, ordimg = :ordimg
            WHERE idpro = :idpro AND ordimg = :ordimg";
        try {
            $result = $conexion->prepare($sql);
            foreach ($imagenes as $index => $imagen) {
                $result->bindValue(':idpro', $idpro);
                $result->bindValue(':imgpro', $imagen['imgpro']);
                $result->bindValue(':nomimg', $imagen['nomimg']);
                $result->bindValue(':tipimg', $imagen['tipimg']);
                $result->bindValue(':ordimg', $index + 1); // Orden de la imagen
                $result->execute();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            throw $e;
        }
    }

    function updateCaracteristicas($conexion, $idpro, $caracteristicas)
    {
        $sql = "UPDATE caracteristica 
            SET descripcioncr = :descripcion cr
            WHERE idpro = :idpro";
        try {
            $result = $conexion->prepare($sql);
            foreach ($caracteristicas as $descripcion) {
                $result->bindValue(':idpro', $idpro);
                $result->bindValue(':descripcioncr', htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'));
                $result->execute();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            throw $e;
        }
    }

    function getProductoById($idpro)
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = "SELECT 
                    p.idpro, p.nompro, p.descripcion, p.cantidad, p.idval, 
                    p.valorunitario, p.fechfinofer, p.precio, p.pordescu,
                    i.idimag, i.imgpro, i.nomimg, i.tipimg, i.ordimg,
                    c.idcar, c.descripcioncr AS descripcion_caracteristica
                FROM producto p
                LEFT JOIN imagen i ON p.idpro = i.idpro
                LEFT JOIN caracteristica c ON p.idpro = c.idpro
                WHERE p.idpro = :idpro";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idpro', $idpro, PDO::PARAM_INT);
            $stmt->execute();

            // Obtiene todos los resultados
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                throw new Exception("No se encontró el producto con el ID proporcionado.");
            }

            // Organiza los datos en un formato estructurado
            $producto = [
                'idpro' => $resultados[0]['idpro'],
                'nompro' => $resultados[0]['nompro'],
                'descripcion' => $resultados[0]['descripcion'],
                'cantidad' => $resultados[0]['cantidad'],
                'idval' => $resultados[0]['idval'],
                'valorunitario' => $resultados[0]['valorunitario'],
                'fechfinofer' => $resultados[0]['fechfinofer'],
                'precio' => $resultados[0]['precio'],
                'pordescu' => $resultados[0]['pordescu'],
                'imagenes' => [],
                'caracteristicas' => []
            ];

            foreach ($resultados as $fila) {
                // Agregar imágenes si existen
                if ($fila['idimag']) {
                    $producto['imagenes'][] = [
                        'idimag' => $fila['idimag'],
                        'imgpro' => $fila['imgpro'],
                        'nomimg' => $fila['nomimg'],
                        'tipimg' => $fila['tipimg'],
                        'ordimg' => $fila['ordimg']
                    ];
                }

                // Agregar características si existen
                if ($fila['idcar']) {
                    $producto['caracteristicas'][] = [
                        'idcar' => $fila['idcar'],
                        'descripcioncr' => $fila['descripcioncr']
                    ];
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
}
