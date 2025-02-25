<?php
class Mpqr
{
    private $idpqr;
    private $fechacrea;
    private $emausu;
    private $tippqr;
    private $idprov;
    private $idusu;
    private $asunto;
    private $mensaje;
    private $estado;
    private $fechpqr;
    private $nomusu;
    private $idrespuesta;
    private $respuesta;
    private $fecha_respuesta;
    //Getter y Setter para idpqr
    public function getIdpqr()
    {
        return $this->idpqr;
    }
    public function setIdpqr($idpqr)
    {
        $this->idpqr = $idpqr;
    }
    //Getter y Setter para fechacrea
    public function getFechacrea()
    {
        return $this->fechacrea;
    }
    public function setFechacrea($fechacrea)
    {
        $this->fechacrea = $fechacrea;
    }
    //Getter y Setter para emausu
    public function getEmausu()
    {
        return $this->emausu;
    }
    public function setEmausu($emausu)
    {
        $this->emausu = $emausu;
    }
    //Getter y Setter para tiopqr
    public function getTippqr()
    {
        return $this->tippqr;
    }
    public function setTippqr($tippqr)
    {
        $this->tippqr = $tippqr;
    }
    //Getter y Setter para idprov
    public function getIdprov()
    {
        return $this->idprov;
    }
    public function setIdprov($idprov)
    {
        $this->idprov = $idprov;
    }
    //Getter y Setter para idusu
    public function getIdusu()
    {
        return $this->idusu;
    }
    public function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }
    //Getter y Setter para asunto
    public function getAsunto()
    {
        return $this->asunto;
    }
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
    }
    //Getter y Setter para mensaje
    public function getMensaje()
    {
        return $this->mensaje;
    }
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }
    //Getter y Setter para estado
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    //Getter y Setter para fechpqr
    public function getFechpqr()
    {
        return $this->fechpqr;
    }
    public function setFechpqr($fechpqr)
    {
        $this->fechpqr = $fechpqr;
    }
    //Getter y Setter para nomusu
    public function getNomusu()
    {
        return $this->nomusu;
    }
    public function setNomusu($nomusu)
    {
        $this->nomusu = $nomusu;
    }
    //Getter y Setter para idrespuesta
    public function getIdrespuesta()
    {
        return $this->idrespuesta;
    }
    public function setIdrespuesta($idrespuesta)
    {
        $this->idrespuesta = $idrespuesta;
    }
    //Getter y Setter para respuesta
    public function getRespuesta()
    {
        return $this->respuesta;
    }
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;
    }
    //Getter y Setter para fecha_respuesta
    public function getFecha_respuesta()
    {
        return $this->fecha_respuesta;
    }
    public function setFecha_respuesta($fecha_respuesta)
    {
        $this->fecha_respuesta = $fecha_respuesta;
    }
    //Funciones básicas
    public function savePqr()
    {
        $res = false;
        $sql = "INSERT INTO pqr (emausu, tippqr, mensaje, nomusu, idusu, idprov) 
                VALUES (:emausu, :tippqr, :mensaje, :nomusu, :idusu, :idprov);";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $nomusu = $this->getNomusu();
            $emausu = $this->getEmausu();
            $tippqr = $this->getTippqr();
            $mensaje = $this->getMensaje();
            $idusu = $this->getIdusu();
            $idprov = $this->getIdprov();
            $result->bindParam(':emausu', $emausu, PDO::PARAM_STR);
            $result->bindParam(':tippqr', $tippqr, PDO::PARAM_STR);
            $result->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
            $result->bindParam(':nomusu', $nomusu, PDO::PARAM_STR);
            $result->bindParam(':idusu', $idusu, PDO::PARAM_INT);
            $result->bindParam(':idprov', $idprov, PDO::PARAM_INT);

            if ($result->execute()) {
                $res = $conexion->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false; // Indica que la operación falló
        } finally {
            $conexion = null; // Cierra la conexión
        }

        return $res;
    }
    public function getAllPqr()
    {
        $res = [];
        $sql = "SELECT idpqr, fechacrea, emausu, tippqr, idusu, mensaje, nomusu FROM pqr WHERE estado = 'Pendiente'";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC); // Cambiado a fetchAll para traer todas las filas
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error. Inténtalo más tarde";
        }

        return $res;
    }

    public function guardarRespuesta()
    {
        $res = "";
        $sql = "INSERT INTO respuestas_pqr (idpqr, respuesta) VALUES (:idpqr, :respuesta)";
        $sql2 = "UPDATE pqr SET estado = :estado WHERE idpqr = :idpqr";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $stmt = $conexion->prepare($sql);
            $idpqr = $this->getIdpqr();
            $respuesta = $this->getRespuesta();
            $stmt->bindParam(":idpqr", $idpqr, PDO::PARAM_INT);
            $stmt->bindParam(":respuesta", $respuesta, PDO::PARAM_STR);
            if($stmt->execute()){
                $result = $conexion->prepare($sql2);
                $estado = "Resuelto";
                $result->bindParam(":estado", $estado, PDO::PARAM_STR);
                $result->bindParam(":idpqr", $idpqr, PDO::PARAM_INT);
                if($result->execute()){
                    $res = true;
                }else{
                    $res = false;
                }
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
        return $res;
    }

}