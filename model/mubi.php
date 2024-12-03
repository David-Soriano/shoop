<?php 
class Mubi{
    private $idubi;
    private $nomubi;
    private $depubi;

    public function getIdubi(){
        return $this->idubi;
    }
    public function setIdubi($idubi){
        $this->idubi = $idubi;
    }
    public function getNomubi(){
        return $this->nomubi;
    }
    public function setNomubi($nomubi){
        $this->nomubi = $nomubi;
    }
    public function getDepubi(){
        return $this->depubi;
    }
    public function setDepubi($depubi){
        $this->depubi = $depubi;
    }

    public function getAll()
    {
        $res = NULL;
        $sql = "SELECT d.idubi AS cd, d.nomubi AS nd, m.idubi AS cm, m.nomubi AS nm FROM ubicacion AS m LEFT JOIN ubicacion AS d ON m.depenubi = d.idubi";
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);
        $result->execute();
        $res = $result->fetchall(PDO::FETCH_ASSOC);
        return $res;
    }
    public function getDep($depenubi){
        $resultado = NULL;
        $sql = "SELECT * FROM ubicacion WHERE depenubi=:depenubi";
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);
        $result->bindParam(":depenubi", $depenubi);
        $result->execute();
        $resultado = $result->fetchall(PDO::FETCH_ASSOC);
        return $resultado;
    }
}