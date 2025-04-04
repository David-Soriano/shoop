<?php
class Mpag
{
    private $idpag;
    private $nompag;
    private $rutpag;
    private $mospag;
    private $lugpag;
    private $icopag;
    private $idpef;
    //Menú
    private $idsbm;
    private $nombre;
    private $url;
    private $url2;
    private $idmen;
    private $lugmen;
    private $actpag;
    private $estpagn;

    public function getIdpag()
    {
        return $this->idpag;
    }
    public function getNompag()
    {
        return $this->nompag;
    }
    public function getRutpag()
    {
        return $this->rutpag;
    }
    public function getMospag()
    {
        return $this->mospag;
    }
    public function getIcopag()
    {
        return $this->icopag;
    }
    public function getIdsbm()
    {
        return $this->idsbm;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function getUrl2()
    {
        return $this->url2;
    }
    public function getIdmen()
    {
        return $this->idmen;
    }
    public function getLugmen()
    {
        return $this->lugmen;
    }
    public function getActpag()
    {
        return $this->actpag;
    }
    public function getEstpagn()
    {
        return $this->estpagn;
    }
    public function getLugpag()
    {
        return $this->lugpag;
    }
    public function getIdpef()
    {
        return $this->idpef;
    }

    public function setLugpag($lugpag)
    {
        $this->lugpag = $lugpag;
    }
    public function setIdpag($idpag)
    {
        $this->idpag = $idpag;
    }
    public function setNompag($nompag)
    {
        $this->nompag = $nompag;
    }
    public function setRutpag($rutpag)
    {
        $this->rutpag = $rutpag;
    }
    public function setMospag($mospag)
    {
        $this->mospag = $mospag;
    }
    public function setIcopag($icopag)
    {
        $this->icopag = $icopag;
    }
    public function setIdsbm($idsbm)
    {
        $this->idsbm = $idsbm;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function setUrl2($url2)
    {
        $this->url2 = $url2;
    }
    public function setIdmen($idmen)
    {
        $this->idmen = $idmen;
    }
    public function setLugmen($lugmen)
    {
        $this->lugmen = $lugmen;
    }
    public function setActpag($actpag)
    {
        $this->actpag = $actpag;
    }
    public function setEstpagn($estpagn)
    {
        $this->estpagn = $estpagn;
    }
    public function setIdpef($idpef)
    {
        $this->idpef = $idpef;
    }
    //Traer todas las paginas de la base de datos
    function getAll()
    {
        $res = NULL;
        $sql = "SELECT idpag, nompag, rutpag, mospag, icopag FROM pagina;";
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
    function getOnePage()
    {
        $res = NULL;
        $sql = "SELECT idpag, nompag, rutpag, mospag, icopag, lugpag, estpagn, actpag FROM pagina WHERE idpag = :idpag;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idpag', $this->idpag, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    //Traer una pagina en especifico de la base de datos
    function getOne($idpag, $idpef, $lugpag)
    {
        $res = NULL;
        $lugpag = $lugpag ?: null;
        $sql = "SELECT p.idpef, p.nompef, p.pagini, pxp.idperpf, pg.idpag, pg.nompag, pg.rutpag, pg.mospag, pg.icopag, pg.lugpag FROM pagxperfil AS pxp INNER JOIN perfil AS p ON pxp.idpef = p.idpef INNER JOIN pagina AS pg ON pxp.idpag = pg.idpag WHERE pxp.idpef = :idpef AND ((pg.idpag = :idpag AND (pg.lugpag = :lugpag OR :lugpag IS NULL))) AND (pg.estpagn = 'Activo' AND pg.actpag = 1) LIMIT 1;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result->bindParam(':idpef', $idpef, PDO::PARAM_INT);
            $result->bindParam(':lugpag', $lugpag, PDO::PARAM_INT);


            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    //Traer el menu de la barra de navegacion
    function getMenu($isLoged)
    {
        $res = NULL;
        try {
            $sql = "SELECT idmen, nombre, url, ordmen, estmen, url2, submen, lugmen 
                FROM menu 
                WHERE lugmen = 0 AND (estmen = :status OR estmen IS NULL);";

            $status = $isLoged ? 1 : 0;

            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            $result->execute();
            $menuItems = $result->fetchAll(PDO::FETCH_ASSOC);

            // Obtener submenús para cada ítem del menú principal
            foreach ($menuItems as $key => $menuItem) {
                if ($menuItem['submen'] != 0) {
                    $menuItems[$key]['submenus'] = $this->getSubMen($menuItem['idmen']);
                } else {
                    $menuItems[$key]['submenus'] = []; // No tiene submenús
                }
            }

            $res = $menuItems;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error en getMenu. Intentalo más tarde";
        }
        return $res;
    }
    //Traer el menu de las opciones del perfil de usuario
    function getMenuPerf($isLoged)
    {
        $res = NULL;
        $sql = "SELECT idmen, nombre, url, ordmen, estmen, url2, submen, lugmen, isUser
                    FROM menu 
                    WHERE estmen = :status AND lugmen = :status ORDER BY ordmen;";
        try {
            $status = $isLoged ? 1 : 0;

            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error en MenuPerf. Intentalo mas tarde";
        }
        return $res;
    }
    //Traer submenús 
    function getSubMen($idmen)
    {
        $res = NULL;
        $sql = "SELECT s.idsbm, s.nombre, s.url, s.url2, s.idmen 
                FROM submenu AS s 
                INNER JOIN menu AS m ON s.idmen = m.idmen 
                WHERE s.idmen = :idmen;";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idmen', $idmen, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, "C:/xampp/htdocs/SHOOP/errors/error_log.log");
            echo "Error. Intentalo mas tarde";
        }
        return $res;
    }
    function getMenHeader($lugmen)
    {
        $res = NULL;
        $sql = "SELECT idmen, nombre, url, ordmen, estmen, url2, submen, lugmen, icomen
                FROM menu 
                WHERE lugmen = :lugmen;";
        try {

            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':lugmen', $lugmen);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error en Menu Header. Intentalo mas tarde";
        }
        return $res;
    }
    //metodos adicionales para las operaciones de la clase
    function savePag()
    {
        $res = NULL;
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        try {
            $nompag = $this->getNompag();
            $rutpag = $this->getRutpag();
            $icopag = $this->getIcopag();
            $lugpag = $this->getLugpag();

            // 🚀 1. Verificar si la página ya existe y está inactiva
            $sqlCheck = "SELECT idpag FROM pagina WHERE nompag = :nompag AND estpagn = 'Inactivo'";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bindParam(':nompag', $nompag, PDO::PARAM_STR);
            $stmtCheck->execute();
            $paginaInactiva = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($paginaInactiva) {
                // 🚀 2. Si existe y está inactiva, activarla nuevamente
                $idpag = $paginaInactiva['idpag'];
                $sqlUpdate = "UPDATE pagina SET estpagn = 'Activo' WHERE idpag = :idpag";
                $stmtUpdate = $conexion->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':idpag', $idpag, PDO::PARAM_INT);
                $res = $stmtUpdate->execute();
            } else {
                // 🚀 3. Si no existe, proceder con la inserción normal
                $sqlInsert = "INSERT INTO pagina (nompag, rutpag, icopag, lugpag) VALUES (:nompag, :rutpag, :icopag, :lugpag)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $stmtInsert->bindParam(':nompag', $nompag, PDO::PARAM_STR);
                $stmtInsert->bindParam(':rutpag', $rutpag, PDO::PARAM_STR);
                $stmtInsert->bindParam(':icopag', $icopag, PDO::PARAM_STR);
                $stmtInsert->bindParam(':lugpag', $lugpag, PDO::PARAM_INT);
                $res = $stmtInsert->execute();
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo json_encode(["success" => false, "error" => "Error al guardar la página"]);
            return false;
        }

        return $res;
    }

    function ediPag()
    {
        //implementar la logica de guardado en la base de datos
        $res = NULL;
        $sql = "UPDATE pagina SET actpag=:actpag WHERE idpag = :idpag";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $actpag = $this->getActpag();
            $result->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result->bindParam(':actpag', $actpag, PDO::PARAM_INT);
            $res = $result->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al actualizar la página";
        }
        return $res;
    }
    function delPag()
    {
        $res = NULL;
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();

        try {
            $idpag = $this->getIdpag();

            // Eliminar relacion en la tabla `pagxperfil`
            $sql1 = "DELETE FROM pagxperfil WHERE idpag = :idpag";
            $result1 = $conexion->prepare($sql1);
            $result1->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $result1->execute();

            $sql2 = "UPDATE pagina SET estpagn = 'Inactivo' WHERE idpag = :idpag";
            $result2 = $conexion->prepare($sql2);
            $result2->bindParam(':idpag', $idpag, PDO::PARAM_INT);
            $res = $result2->execute();

        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo json_encode(["success" => false, "error" => "Error al eliminar la página"]);
            return false;
        }

        return $res;
    }

    public function getPagxPer()
    {
        $res = [];

        $sql = "SELECT p.idpag, p.nompag, pe.idpef, 
                   IF(pp.idpag IS NOT NULL, 1, 0) AS tiene_permiso 
            FROM pagina p
            CROSS JOIN perfil pe
            LEFT JOIN pagxperfil pp 
            ON p.idpag = pp.idpag AND pe.idpef = pp.idpef
            ORDER BY pe.idpef, p.idpag";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return ["error" => "Error al obtener páginas", "message" => $e->getMessage()];
        }

        return $res;
    }


    public function getTotalPages()
    {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $query = "SELECT COUNT(*) AS total FROM pagina p LEFT JOIN pagxperfil pxp ON p.idpag = pxp.idpag LEFT JOIN perfil pe ON pxp.idpef = pe.idpef WHERE p.estpagn = 'Activo'"; // Ajusta el nombre de tu tabla
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    public function getPages($limit, $offset)
    {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $query = 'SELECT p.idpag AS "ID Página", p.nompag AS "Nombre Página", p.rutpag AS "Ruta Página", p.mospag AS "Mostrar Página", p.icopag AS "Ícono", p.lugpag AS "Lugar Página", p.actpag AS "Ver Pagina", pe.idpef AS "ID Perfil", pe.nompef AS "Perfil", pe.pagini AS "Página Inicial"  FROM pagina p LEFT JOIN pagxperfil pxp ON p.idpag = pxp.idpag LEFT JOIN perfil pe ON pxp.idpef = pe.idpef WHERE p.estpagn = "Activo" LIMIT :limit OFFSET :offset '; // Ajusta según tus columnas
        $stmt = $conexion->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}