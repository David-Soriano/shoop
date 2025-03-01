<?php
class Mprov
{
    private $idprov;
    private $nomprov;
    private $dirrecprov;
    private $urlt;
    private $estado;
    private $nit;
    private $idubi;
    private $idusu;
    private $desprv;
    private $saldo;

    // Getter y Setter para idprov
    public function getIdprov()
    {
        return $this->idprov;
    }
    public function setIdprov($idprov)
    {
        $this->idprov = $idprov;
    }

    // Getter y Setter para nomprov
    public function getNomprov()
    {
        return $this->nomprov;
    }
    public function setNomprov($nomprov)
    {
        $this->nomprov = $nomprov;
    }

    // Getter y Setter para dirrecprov
    public function getDirrecprov()
    {
        return $this->dirrecprov;
    }
    public function setDirrecprov($dirrecprov)
    {
        $this->dirrecprov = $dirrecprov;
    }

    // Getter y Setter para url
    public function getUrlt()
    {
        return $this->urlt;
    }
    public function setUrlt($urlt)
    {
        $this->urlt = $urlt;
    }

    // Getter y Setter para estado
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    // Getter y Setter para nit
    public function getNit()
    {
        return $this->nit;
    }
    public function setNit($nit)
    {
        $this->nit = $nit;
    }

    // Getter y Setter para idubi
    public function getIdubi()
    {
        return $this->idubi;
    }
    public function setIdubi($idubi)
    {
        $this->idubi = $idubi;
    }

    // Getter y Setter para idusu
    public function getIdusu()
    {
        return $this->idusu;
    }
    public function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }

    // Getter y Setter para desprv
    public function getDesprv()
    {
        return $this->desprv;
    }
    public function setDesprv($desprv)
    {
        $this->desprv = $desprv;
    }
    public function getSaldo()
    {
        return $this->saldo;
    }
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }
    public function saveProv()
    {
        $res = NULL;
        $sql = "INSERT INTO proveedor(nomprov, idusu, dirrecprov, idubi, urlt, nit, desprv ) 
                VALUES (:nomprov, :idusu, :dirrecprov, :idubi, :urlt, :nit, :desprv)";

        try {
            // Establecer la conexión con la base de datos
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);

            // Obtener los datos del proveedor
            $nomprov = $this->getNomprov();
            $idusu = $this->getIdusu();
            $dirrecprov = $this->getDirrecprov();
            $idubi = $this->getIdubi();
            $url = $this->getUrlt();
            $nit = $this->getNit();
            $desprv = $this->getDesprv();

            error_log("Datos enviados a la consulta: " . print_r([
                'nomprov' => $nomprov,
                'idusu' => $idusu,
                'dirrecprov' => $dirrecprov,
                'idubi' => $idubi,
                'urlt' => $url,
                'nit' => $nit,
                'desprv' => $desprv,
            ], true), 3, 'C:/xampp/htdocs/SHOOP/errors/debug_log.log');

            // Vincular los parámetros
            $result->bindParam(':nomprov', $nomprov, PDO::PARAM_STR);
            $result->bindParam(':idusu', $idusu, PDO::PARAM_INT);
            $result->bindParam(':dirrecprov', $dirrecprov, PDO::PARAM_STR);
            $result->bindParam(':idubi', $idubi, PDO::PARAM_INT);
            $result->bindParam(':urlt', $url, PDO::PARAM_STR);
            $result->bindParam(':nit', $nit, PDO::PARAM_STR);
            $result->bindParam(':desprv', $desprv, PDO::PARAM_STR);

            // Ejecutar la consulta
            $result->execute();
            $res = $conexion->lastInsertId();  // Devuelve idprov

        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al registrar proveedor. Inténtalo más tarde.";
        }

        return $res;
    }

    public function existeProveedor($idusu)
    {
        $idprov = null; // Variable para almacenar el id del proveedor
        $sql = "SELECT idprov FROM proveedor WHERE idusu = :idusu LIMIT 1"; // Obtenemos el id del proveedor

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idusu', $idusu, PDO::PARAM_INT);
            $result->execute();

            // Obtener el idprov del proveedor, si existe
            if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $idprov = $row['idprov']; // Asignamos el idprov encontrado
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al verificar proveedor. Inténtalo más tarde.";
        }

        return $idprov; // Devolvemos el idprov (o null si no se encontró)
    }

    public function insertProdxProv($idProveedor, $idProducto)
    {
        try {
            $res = "";
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $sql = "INSERT INTO prodxprov(idpro, idprov) VALUES (:idpro, :idprov)";
            $stmt = $conexion->prepare($sql);

            $stmt->bindValue(':idpro', $idProducto, PDO::PARAM_INT);
            $stmt->bindValue(':idprov', $idProveedor, PDO::PARAM_INT);

            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al insertar prodxprv. Inténtalo más tarde.";
        }
        return $res;
    }
    public function traerSaldo($idprov)
    {
        try {
            $res = "";
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $sql = "SELECT saldo FROM proveedor WHERE idprov = :idprov";
            $stmt = $conexion->prepare($sql);

            $stmt->bindValue(':idprov', $idprov, PDO::PARAM_INT);

            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al insertar prodxprv. Inténtalo más tarde.";
        }
        return $res;
    }
    public function getOneProv()
    {
        try {
            $res = "";
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $sql = "SELECT * FROM proveedor WHERE idprov = :idprov";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idprov', $this->getIdprov(), PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al insertar prodxprv. Inténtalo más tarde.";
        }
        return $res;
    }
    public function updateProv()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = "UPDATE proveedor SET nomprov = :nomprov, desprv = :desprv WHERE idprov = :idprov";
            $stmt = $conexion->prepare($sql);

            // Obtener valores del objeto
            $nomprov = $this->getNomprov();
            $desprv = $this->getDesprv();
            $idprov = $this->getIdprov();

            // Asignar valores a la consulta preparada
            $stmt->bindValue(':idprov', $idprov, PDO::PARAM_INT);
            $stmt->bindValue(':nomprov', $nomprov, PDO::PARAM_STR);
            $stmt->bindValue(':desprv', $desprv, PDO::PARAM_STR);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return "Error al actualizar el proveedor. Inténtalo más tarde.";
        }
    }

    public function updateProvDtg()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = "UPDATE proveedor SET urlt = :urlt, nit = :nit WHERE idprov = :idprov";
            $stmt = $conexion->prepare($sql);

            // Obtener valores del objeto
            $urlt = $this->getUrlt();
            $nit = $this->getNit();
            $idprov = $this->getIdprov();

            // Asignar valores a la consulta preparada
            $stmt->bindValue(':idprov', $idprov, PDO::PARAM_INT);
            $stmt->bindValue(':urlt', $urlt, PDO::PARAM_STR);
            $stmt->bindValue(':nit', $nit, PDO::PARAM_STR);
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return "Error al actualizar el proveedor. Inténtalo más tarde.";
        }
    }
    public function updateProvDir()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = "UPDATE proveedor SET dirrecprov	 = :dirrecprov	,idubi = :idubi WHERE idprov = :idprov";
            $stmt = $conexion->prepare($sql);

            // Obtener valores del objeto
            $dirrecprov = $this->getDirrecprov();
            $idubi = $this->getIdubi();
            $idprov = $this->getIdprov();

            // Asignar valores a la consulta preparada
            $stmt->bindValue(':idprov', $idprov, PDO::PARAM_INT);
            $stmt->bindValue(':dirrecprov', $dirrecprov, PDO::PARAM_STR);
            $stmt->bindValue(':idubi', $idubi, PDO::PARAM_INT);
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return "Error al actualizar el proveedor. Inténtalo más tarde.";
        }
    }
    public function inactivarPrv()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = 'UPDATE proveedor SET estprv = "inactivo" WHERE idprov = :idprov';
            $stmt = $conexion->prepare($sql);

            // Obtener valores del objeto
            $idprov = $this->getIdprov();

            // Asignar valores a la consulta preparada
            $stmt->bindValue(':idprov', $idprov, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return "Error al actualizar el proveedor. Inténtalo más tarde.";
        }
    }
    public function activarPrv()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            $sql = 'UPDATE proveedor SET estprv = "activo" WHERE idusu = :idusu';
            $stmt = $conexion->prepare($sql);

            // Obtener valores del objeto
            $idusu = $this->getIdusu();

            // Asignar valores a la consulta preparada
            $stmt->bindValue(':idusu', $idusu, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return "Error al actualizar el proveedor. Inténtalo más tarde.";
        }
    }
    public function eliminarPrv()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();

            // Verificar si el proveedor tiene pedidos asociados
            $sqlCheck = 'SELECT COUNT(*) FROM pedido WHERE idprov = :idprov';
            $stmtCheck = $conexion->prepare($sqlCheck);
            $idprov = $this->getIdprov();
            $stmtCheck->bindValue(':idprov', $idprov, PDO::PARAM_INT);
            $stmtCheck->execute();
            $tienePedidos = $stmtCheck->fetchColumn(); // Obtiene el número de pedidos

            if ($tienePedidos > 0) {
                return false; // Indica que no se puede eliminar porque tiene pedidos
            }

            // Si no tiene pedidos, proceder con la eliminación
            $sqlDelete = 'DELETE FROM proveedor WHERE idprov = :idprov';
            $stmtDelete = $conexion->prepare($sqlDelete);
            $stmtDelete->bindValue(':idprov', $idprov, PDO::PARAM_INT);

            return $stmtDelete->execute() && $stmtDelete->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false; // Indica error en la ejecución
        }
    }
}
