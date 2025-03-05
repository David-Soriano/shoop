<?php
class Pedido
{
    private $idped;
    private $idusu;
    private $total;
    private $fecha;
    private $estped;

    private $idcom;
    private $tiproduct;
    private $cantidad;
    private $preciocom;
    private $idubi;
    private $fechareg;

    // Variables privadas (Atributos)
    private $subtotal;
    private $idpro;
    private $direccomp;

    // Getter y Setter para Subtotal
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    // Getter y Setter para Idpro
    public function getIdpro()
    {
        return $this->idpro;
    }

    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }

    // Getter y Setter para Direccomp
    public function getDireccomp()
    {
        return $this->direccomp;
    }

    public function setDireccomp($direccomp)
    {
        $this->direccomp = $direccomp;
    }
    // Método getter y setter para idped
    public function getIdped()
    {
        return $this->idped;
    }

    public function setIdped($idped)
    {
        $this->idped = $idped;
    }

    // Método getter y setter para idusu
    public function getIdusu()
    {
        return $this->idusu;
    }

    public function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }

    // Método getter y setter para total
    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    // Método getter y setter para fecha
    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    // Método getter y setter para estped
    public function getEstped()
    {
        return $this->estped;
    }

    public function setEstped($estped)
    {
        $this->estped = $estped;
    }

    // Getter y Setter para idcom
    public function getIdcom()
    {
        return $this->idcom;
    }

    public function setIdcom($idcom)
    {
        $this->idcom = $idcom;
    }

    // Getter y Setter para tiproduct
    public function getTiproduct()
    {
        return $this->tiproduct;
    }

    public function setTiproduct($tiproduct)
    {
        $this->tiproduct = $tiproduct;
    }

    // Getter y Setter para cantidad
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    // Getter y Setter para preciocom
    public function getPreciocom()
    {
        return $this->preciocom;
    }

    public function setPreciocom($preciocom)
    {
        $this->preciocom = $preciocom;
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

    // Getter y Setter para fechareg
    public function getFechareg()
    {
        return $this->fechareg;
    }

    public function setFechareg($fechareg)
    {
        $this->fechareg = $fechareg;
    }
    function getOne()
    {
        $res = NULL;
        $sql = "SELECT p.idped, p.idusu, p.total, p.fecha, p.estped, dp.idpro, dp.cantidad, dp.idubi, dp.direccion, pr.nompro, pr.valorunitario, v.nomval FROM pedido AS p INNER JOIN detalle_pedido AS dp ON p.idped = dp.idped INNER JOIN producto AS pr ON dp.idpro = pr.idpro INNER JOIN valor AS v ON pr.idval = v.idval WHERE p.idped = :idped";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idped = $this->getIdped();
            $result->bindValue(':idped', $idped);
            $result->execute();
            $res = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getPedPar()
    {
        $res = NULL;
        $sql = "SELECT u.idusu, p.idped, p.fecha, p.total, p.estped, dp.iddet, dp.idpro, dp.cantidad, dp.precio AS precio_pedido, pr.nompro, pr.precio AS precio_producto, pr.tipro, pr.valorunitario, pr.descripcion, i.imgpro, i.nomimg, pv.nomprov FROM usuario u JOIN pedido p ON u.idusu = p.idusu JOIN detalle_pedido dp ON p.idped = dp.idped JOIN producto pr ON dp.idpro = pr.idpro LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON pr.idpro = i.idpro LEFT JOIN proveedor pv ON pv.idusu = u.idusu WHERE u.idusu = :idusu AND p.estped <> 'Recibido' ORDER BY p.fecha DESC; ";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idusu = $this->getIdusu();
            $result->bindValue(':idusu', $idusu);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function seguirEnvio($idped)
    {
        $res = NULL;
        $sql = "SELECT p.idped, p.idusu, p.total, p.fecha, p.estped, dp.iddet, dp.idped, dp.idpro, dp.cantidad, dp.precio AS precio_pedido, dp.mpago, dp.npago, pr.idpro, pr.nompro, pr.precio AS precio_producto, pr.pordescu, pr.idval, v.nomval, i.imgpro, i.nomimg, (pr.precio * (pr.pordescu / 100)) AS valor_descuento, (pr.precio - (pr.precio * (pr.pordescu / 100))) AS precio_final, pv.idprov, pv.nomprov, pv.desprv FROM pedido p INNER JOIN detalle_pedido dp ON p.idped = dp.idped INNER JOIN producto pr ON pr.idpro = dp.idpro INNER JOIN valor v ON v.idval = pr.idval INNER JOIN prodxprov AS pxp ON pxp.idpro = pr.idpro INNER JOIN proveedor AS pv ON pxp.idprov = pv.idprov LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON pr.idpro = i.idpro WHERE p.idped = :idped;";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(':idped', $idped);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getPedidos($idprov)
    {
        $res = NULL;
        $sql = "SELECT pr.idprov, pxp.idpro, pxp.idprodprv, p.nompro, p.precio, p.pordescu, dp.iddet, dp.idped, dp.cantidad, ped.idusu, ped.total, ped.fecha, ped.estped, i.imgpro, i.nomimg FROM proveedor pr INNER JOIN prodxprov pxp ON pr.idprov = pxp.idprov INNER JOIN producto p ON pxp.idpro = p.idpro INNER JOIN detalle_pedido dp ON p.idpro = dp.idpro INNER JOIN pedido ped ON dp.idped = ped.idped LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON p.idpro = i.idpro WHERE pr.idprov = :idprov ORDER BY ped.fecha DESC;";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(':idprov', $idprov);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getTotalPed()
    {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $query = "SELECT COUNT(*) AS total FROM pedido u"; // Ajusta el nombre de tu tabla
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }
    function updatePedido($estped)
    {
        $sql = "UPDATE pedido SET estped = :estped WHERE idped = :idped;";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idped = $this->getIdped();
            // $estped = $this->getEstped();
            $result->bindValue(':idped', $idped);
            $result->bindValue(':estped', $estped);
            $result->execute();

            // Verificamos si la actualización afectó alguna fila
            if ($result->rowCount() > 0) {
                return true;  // Si se actualizó correctamente
            } else {
                return false; // Si no se actualizó
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo más tarde";
            return false;
        }
    }
    function getDatosUsuario(){
        $res = NULL;
        $sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.emausu, u.dirrecusu, u.celusu, p.idped, p.idusu, p.total, dp.iddet, dp.idpro, dp.cantidad, pr.nompro FROM usuario AS u INNER JOIN pedido AS p  ON p.idusu = u.idusu INNER JOIN detalle_pedido  AS dp ON p.idped = dp.idped INNER JOIN producto AS pr ON dp.idpro = pr.idpro WHERE p.idped = :idped;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idped = $this->getIdped();
            $result->bindValue(':idped', $idped);
            $result->execute();
            $res = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
}
?>