<?php
class Musu
{
    private $idusu;
    private $nomusu;
    private $apeusu;
    private $docusu;
    private $emausu;
    private $celusu;
    private $genusu;
    private $dirrecusu;
    private $tipdoc;
    private $idval;
    private $idubi;
    private $feccreate;
    private $fecupdate;
    private $fotpef;
    private $idpef;
    private $pasusu;
    private $estusu;
    function getIdusu()
    {
        return $this->idusu;
    }
    function getNomusu()
    {
        return $this->nomusu;
    }
    function getApeusu()
    {
        return $this->apeusu;
    }
    function getDocusu()
    {
        return $this->docusu;
    }
    function getEmausu()
    {
        return $this->emausu;
    }
    function getCelusu()
    {
        return $this->celusu;
    }
    function getGenusu()
    {
        return $this->genusu;
    }
    function getDirrecusu()
    {
        return $this->dirrecusu;
    }
    function getTipdoc()
    {
        return $this->tipdoc;
    }
    function getIdval()
    {
        return $this->idval;
    }
    function getIdubi()
    {
        return $this->idubi;
    }
    function getFeccreate()
    {
        return $this->feccreate;
    }
    function getFecupdate()
    {
        return $this->fecupdate;
    }
    function getFotpef()
    {
        return $this->fotpef;
    }
    function getIdpef()
    {
        return $this->idpef;
    }
    function getPasusu()
    {
        return $this->pasusu;
    }
    function getEstusu()
    {
        return $this->estusu;
    }
    function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }
    function setNomusu($nomusu)
    {
        $this->nomusu = $nomusu;
    }
    function setApeusu($apeusu)
    {
        $this->apeusu = $apeusu;
    }
    function setDocusu($docusu)
    {
        $this->docusu = $docusu;
    }
    function setEmausu($emausu)
    {
        $this->emausu = $emausu;
    }
    function setCelusu($celusu)
    {
        $this->celusu = $celusu;
    }
    function setGenusu($genusu)
    {
        $this->genusu = $genusu;
    }
    function setDirrecusu($dirrecusu)
    {
        $this->dirrecusu = $dirrecusu;
    }
    function setTipdoc($tipdoc)
    {
        $this->tipdoc = $tipdoc;
    }
    function setIdval($idval)
    {
        $this->idval = $idval;
    }
    function setIdubi($idubi)
    {
        $this->idubi = $idubi;
    }
    function setFeccreate($feccreate)
    {
        $this->feccreate = $feccreate;
    }
    function setFecupdate($fecupdate)
    {
        $this->fecupdate = $fecupdate;
    }
    function setFotpef($fotpef)
    {
        $this->fotpef = $fotpef;
    }
    function setIdpef($idpef)
    {
        $this->idpef = $idpef;
    }
    function setPasusu($pasusu)
    {
        $this->pasusu = $pasusu;
    }
    function setEstusu($estusu)
    {
        $this->estusu = $estusu;
    }
    function getAll()
    {
        $res = NULL;
        $sql = "SELECT idusu, nomusu, apeusu, docusu, emausu, celusu, genusu, dirrecusu, tipdoc, idval, idubi, feccreate, fecupdate, fotpef, idpef, pasusu FROM usuario;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getOne()
    {
        $res = NULL;
        $sql = "SELECT idusu, nomusu, apeusu, docusu, emausu, celusu, genusu, dirrecusu, tipdoc, idval, idubi, feccreate, fecupdate, fotpef, idpef, pasusu FROM usuario WHERE idusu = :idusu;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idusu = $this->getIdusu();
            $result->bindParam(':idusu', $idusu, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function saveUsu()
    {
        $sql = "INSERT INTO usuario(nomusu, apeusu, tipdoc, docusu, emausu, celusu, genusu, idubi, dirrecusu, idpef, pasusu) 
        VALUES (:nomusu, :apeusu, :tipdoc, :docusu, :emausu, :celusu, :genusu, :idubi, :dirrecusu, :idpef, :pasusu)";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);

            $nomusu = $this->getNomusu();
            $apeusu = $this->getApeusu();
            $tipdoc = $this->getTipdoc();
            $docusu = $this->getDocusu();
            $emausu = $this->getEmausu();
            $celusu = $this->getCelusu();
            $genusu = $this->getGenusu();
            $idubi = $this->getIdubi();
            $dirrecusu = $this->getDirrecusu();
            $idpef = $this->getIdpef();
            $pasusu = $this->getPasusu();

            $result->bindParam(':nomusu', $nomusu, PDO::PARAM_STR);
            $result->bindParam(':apeusu', $apeusu, PDO::PARAM_STR);
            $result->bindParam(':tipdoc', $tipdoc, PDO::PARAM_STR);
            $result->bindParam(':docusu', $docusu, PDO::PARAM_STR);
            $result->bindParam(':emausu', $emausu, PDO::PARAM_STR);
            $result->bindParam(':celusu', $celusu, PDO::PARAM_STR);
            $result->bindParam(':genusu', $genusu, PDO::PARAM_STR);
            $result->bindParam(':idubi', $idubi, PDO::PARAM_INT);
            $result->bindParam(':dirrecusu', $dirrecusu, PDO::PARAM_STR);
            $result->bindParam(':idpef', $idpef, PDO::PARAM_INT);
            $result->bindParam(':pasusu', $pasusu, PDO::PARAM_STR);

            $result->execute();

            // Obtener el ID del usuario recién insertado
            $lastId = $conexion->lastInsertId();

            // Consultar el idpef del usuario recién insertado
            $query = $conexion->prepare("SELECT idpef FROM usuario WHERE idusu = :lastId");
            $query->bindParam(':lastId', $lastId, PDO::PARAM_INT);
            $query->execute();

            $data = $query->fetch(PDO::FETCH_ASSOC);

            return $data ? $data['idpef'] : null;

        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al registrar. Inténtalo más tarde";
            return null;
        }
    }


    function verificarCorreo($emausu)
    {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        // Consulta para verificar si el correo ya existe
        $sql = "SELECT COUNT(*) FROM usuario WHERE emausu = :emausu";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':emausu', $emausu);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0; // Retorna true si el correo ya existe
    }
    public function getUsers($limit, $offset)
    {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $query = 'SELECT u.idusu, u.nomusu, u.apeusu, u.docusu, u.emausu, u.celusu, u.genusu, u.dirrecusu, u.tipdoc, u.idubi, u.idpef, u.estusu, p.nompef FROM usuario AS u INNER JOIN perfil AS p ON p.idpef = u.idpef LIMIT :limit OFFSET :offset;'; // Ajusta según tus columnas
        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalUsers()
    {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $query = "SELECT COUNT(*) AS total FROM usuario u LEFT JOIN perfil p ON p.idpef = u.idpef"; // Ajusta el nombre de tu tabla
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }
}