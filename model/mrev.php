<?php
class Mrev
{
    private $idrev;
    private $idpro;
    private $idusu;
    private $rating;
    private $comentario;
    private $fecha;

    // Métodos "get" para obtener los valores de las propiedades
    public function getIdrev()
    {
        return $this->idrev;
    }
    public function getIdpro()
    {
        return $this->idpro;
    }
    public function getIdusu()
    {
        return $this->idusu;
    }
    public function getRating()
    {
        return $this->rating;
    }  
    public function getComentario()
    {
        return $this->comentario;
    }
    public function getFecha()
    {
        return $this->fecha;
    }

    // Métodos "set" para establecer los valores de las propiedades
    public function setIdrev($idrev)
    {
        $this->idrev = $idrev;
    }
    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }
    public function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }


    public function agregarReview()
{
    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        // Obtener valores
        $idpro = $this->getIdpro();
        $idusu = $this->getIdusu();
        $rating = $this->getRating();
        $comentario = $this->getComentario();

        // Verificar si el usuario ha comprado el producto
        $sql = "SELECT COUNT(*) FROM compra AS c 
                INNER JOIN detallecompra AS dc ON dc.idcom = c.idcom 
                WHERE c.idusu = :idusu AND dc.idpro = :idpro";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idusu', $idusu, PDO::PARAM_INT);
        $stmt->bindParam(':idpro', $idpro, PDO::PARAM_INT);
        $stmt->execute();

        $compras = $stmt->fetchColumn();

        if ($compras > 0) {
            // Insertar la review
            $sql2 = "INSERT INTO review (idpro, idusu, rating, comentario) 
                     VALUES (:idpro, :idusu, :rating, :comentario)";
            $stmt2 = $conexion->prepare($sql2);
            $stmt2->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $stmt2->bindParam(':idusu', $idusu, PDO::PARAM_INT);
            $stmt2->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt2->bindParam(':comentario', $comentario, PDO::PARAM_STR);
            $stmt2->execute();

            if ($stmt2->rowCount() > 0) {
                return true;
            } else {
                error_log("Error al insertar review", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            }
        }
    } catch (Exception $e) {
        error_log("Error en agregarReview: " . $e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
    }

    return false;
}


    public function obtenerReviews()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $sql = "SELECT r.*, u.nombre FROM review r JOIN usuario u ON r.idusu = u.idusu WHERE r.idpro = :idpro ORDER BY r.fecha DESC";
            $stmt = $conexion->prepare($sql);
            $idpro = $this->getIdpro();
            $stmt->bindParam(':idpro', $idpro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log( $e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }
}