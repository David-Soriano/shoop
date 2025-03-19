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
    
}
