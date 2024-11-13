<?php
class Pedido {
    private $idped;
    private $idusu;
    private $total;
    private $fecha;
    private $estped;

    // Método getter y setter para idped
    public function getIdped() {
        return $this->idped;
    }

    public function setIdped($idped) {
        $this->idped = $idped;
    }

    // Método getter y setter para idusu
    public function getIdusu() {
        return $this->idusu;
    }

    public function setIdusu($idusu) {
        $this->idusu = $idusu;
    }

    // Método getter y setter para total
    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    // Método getter y setter para fecha
    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    // Método getter y setter para estped
    public function getEstped() {
        return $this->estped;
    }

    public function setEstped($estped) {
        $this->estped = $estped;
    }
    function getPedPar()
    {
        $res = NULL;
        $sql = "SELECT u.idusu, p.idped, p.fecha, p.total, p.estped, dp.iddet, dp.idpro, dp.cantidad, dp.precio AS precio_pedido, pr.nompro, pr.precio AS precio_producto, pr.tipro, pr.valorunitario, pr.descripcion, i.imgpro, i.nomimg FROM usuario u JOIN pedido p ON u.idusu = p.idusu JOIN detalle_pedido dp ON p.idped = dp.idped JOIN producto pr ON dp.idpro = pr.idpro LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro)) i ON pr.idpro = i.idpro WHERE u.idusu = :idusu ORDER BY p.fecha DESC; ";
   
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idusu=$this->getIdusu();
            $result->bindValue(':idusu', $idusu);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }

}
?>