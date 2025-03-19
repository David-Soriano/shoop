<?php
class Mdev
{
    private $iddevo;
    private $idped;
    private $idpro;
    private $motivo;
    private $fechasolicitud;
    private $estado;
    private $fechaprocesamiento;
    private $montoreembolso;

    public function getIddevo(){
        return $this->iddevo;
    }
    public function setIddevo($iddevo){
        $this->iddevo = $iddevo;
    }
    public function getIdped(){
        return $this->idped;
    }
    public function setIdped($idped){
        $this->idped = $idped;
    }
    public function getIdpro(){
        return $this->idpro;
    }
    public function setIdpro($idpro){
        $this->idpro = $idpro;
    }
    public function getMotivo(){
        return $this->motivo;
    }
    public function setMotivo($motivo){
        $this->motivo = $motivo;
    }
    public function getFechasolicitud(){
        return $this->fechasolicitud;
    }
    public function setFechasolicitud($fechasolicitud){
        $this->fechasolicitud = $fechasolicitud;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function getFechaprocesamiento(){
        return $this->fechaprocesamiento;
    }
    public function setFechaprocesamiento($fechaprocesamiento){
        $this->fechaprocesamiento = $fechaprocesamiento;
    }
    public function getMontoreembolso(){
        return $this->montoreembolso;
    }
    public function setMontoreembolso($montoreembolso){
        $this->montoreembolso = $montoreembolso;
    }


    public function saveDev() {
        $sql = "INSERT INTO devolucionreembolso (idped, idpro, motivo, estado, montoreembolso) 
                VALUES (:idped, :idpro, :motivo, 'pendiente', :montoreembolso)";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
    
            $idped = $this->getIdped();
            $idpro = $this->getIdpro();
            $motivo = $this->getMotivo();
            $monto = $this->getMontoreembolso();
    
            $result->bindParam(':idped', $idped, PDO::PARAM_INT);
            $result->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $result->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            $result->bindParam(':montoreembolso', $monto, PDO::PARAM_STR);
    
            $result->execute();
    
            if ($result->rowCount() > 0) {
                return true;
            }
    
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al guardar la solicitud. Inténtalo más tarde";
            return false;
        }
    }

    public function getDevs($idprov){
        $sql = "SELECT 
    pr.idprov, 
    pxp.idpro, 
    pxp.idprodprv, 
    p.nompro, 
    p.precio, 
    p.pordescu, 
    dp.iddet, 
    dp.idped, 
    dp.cantidad, 
    ped.idusu, 
    ped.total, 
    ped.fecha, 
    ped.estped, 
    i.imgpro, 
    i.nomimg,
    dr.iddevo, 
    dr.idped AS idped_devo, 
    dr.idpro AS idpro_devo, 
    dr.motivo, 
    dr.fechasolicitud, 
    dr.estado, 
    dr.fechaprocesamiento, 
    dr.montoreembolso
FROM proveedor pr 
INNER JOIN prodxprov pxp ON pr.idprov = pxp.idprov 
INNER JOIN producto p ON pxp.idpro = p.idpro 
INNER JOIN detalle_pedido dp ON p.idpro = dp.idpro 
INNER JOIN pedido ped ON dp.idped = ped.idped 
LEFT JOIN (
    SELECT idpro, imgpro, nomimg 
    FROM imagen 
    WHERE (idpro, ordimg) IN (
        SELECT idpro, MIN(ordimg) 
        FROM imagen 
        GROUP BY idpro
    )
) i ON p.idpro = i.idpro
LEFT JOIN devolucionreembolso dr ON ped.idped = dr.idped
WHERE pr.idprov = :idprov
  AND dr.iddevo IS NOT NULL  -- Solo traer los pedidos que tienen devolución/reembolso
ORDER BY ped.fecha DESC;
";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(':idprov', $idprov);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al ver los reembolsos. Inténtalo más tarde";
        }
        return $res;
    }
    
}
