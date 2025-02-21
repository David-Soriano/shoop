<?php

class Compra
{
    private $idcom;
    private $tiproduct;
    private $cantidad;
    private $preciocom;
    private $iddell;
    private $idubi;
    private $idusu;
    private $idped;
    private $subtotal;
    private $total;
    private $idpro;
    private $direccomp;
    private $iva;


    // Métodos "set" para asignar valores a las propiedades
    public function setIdcom($idcom)
    {
        $this->idcom = $idcom;
    }

    public function setTiproduct($tiproduct)
    {
        $this->tiproduct = $tiproduct;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function setPreciocom($preciocom)
    {
        $this->preciocom = $preciocom;
    }

    public function setIddell($iddell)
    {
        $this->iddell = $iddell;
    }

    public function setIdubi($idubi)
    {
        $this->idubi = $idubi;
    }

    public function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }

    public function setIdped($idped)
    {
        $this->idped = $idped;
    }

    // Métodos "get" para obtener los valores de las propiedades
    public function getIdcom()
    {
        return $this->idcom;
    }

    public function getTiproduct()
    {
        return $this->tiproduct;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPreciocom()
    {
        return $this->preciocom;
    }

    public function getIddell()
    {
        return $this->iddell;
    }

    public function getIdubi()
    {
        return $this->idubi;
    }

    public function getIdusu()
    {
        return $this->idusu;
    }

    public function getIdped()
    {
        return $this->idped;
    }
    
    // Getter y Setter para subtotal
    public function getSubtotal() {
        return $this->subtotal;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    // Getter y Setter para total
    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    // Getter y Setter para idpro
    public function getIdpro() {
        return $this->idpro;
    }

    public function setIdpro($idpro) {
        $this->idpro = $idpro;
    }

    // Getter y Setter para direccomp
    public function getDireccomp() {
        return $this->direccomp;
    }

    public function setDireccomp($direccomp) {
        $this->direccomp = $direccomp;
    }
    public function getIva(){
        return $this->iva;
    }
    public function setIva($iva){
        $this->iva = $iva;
    }
    // Método para obtener las compras del usuario
    public function getComPar()
    {
        $res = [];
        $sql = "SELECT c.idcom, c.tiproduct, c.cantidad, c.preciocom, c.idubi, c.idusu, c.idped, c.fechareg, u.nomusu, u.apeusu, u.docusu, u.emausu, u.celusu, u.dirrecusu, u.tipdoc, d.subtotal, d.iva, d.idpro, d.direccomp, pr.nompro, pr.precio , i.imgpro, i.nomimg FROM compra c LEFT JOIN usuario u ON c.idusu = u.idusu LEFT JOIN pedido p ON c.idped = p.idped LEFT JOIN detallecompra d ON c.idcom = d.idcom LEFT JOIN producto pr ON d.idpro = pr.idpro LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON pr.idpro = i.idpro WHERE c.idusu = :idusu";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $idusu = $this->getIdusu(); // Obtener el ID del usuario
            $result->bindValue(':idusu', $idusu, PDO::PARAM_INT);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener las compras. Inténtalo más tarde.";
        }
        return $res;
    }
    function saveCompra()
{
    $sql = "INSERT INTO compra(tiproduct, cantidad, preciocom, idubi, idusu, idped, fechareg) 
            VALUES (:tiproduct , :cantidad , :preciocom , :idubi , :idusu, :idped, NOW());";

    try {
        $modelo = new Conexion();
        $conexion = $modelo->getConexion();
        $result = $conexion->prepare($sql);

        $tiproduct = $this->getTiproduct();
        $result->bindParam(':tiproduct', $tiproduct);

        $cantidad = $this->getCantidad();
        $result->bindParam(':cantidad', $cantidad);

        $preciocom = $this->getPreciocom();
        $result->bindParam(':preciocom', $preciocom);

        $idubi = $this->getIdubi();
        $result->bindParam(':idubi', $idubi);

        $idusu = $this->getIdusu();
        $result->bindParam(':idusu', $idusu);

        $idped = $this->getIdped();
        $result->bindParam(':idped', $idped);

        // Ejecutar la consulta
        $result->execute();

        // Obtener el ID de la última inserción
        $idcom = $conexion->lastInsertId();

        return $idcom; // Retorna el ID de la compra recién insertada

    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
        echo "Error. Intentalo más tarde";
        return false; // Retornar falso en caso de error
    }
}

    function saveDetalleCompra()
    {
        $sql = "INSERT INTO detallecompra(subtotal, iva, total, idpro, direccomp, idcom) 
            VALUES (:subtotal, :iva, :total, :idpro, :direccomp, :idcom);";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);

            // Obtenemos los valores con sus respectivos getters
            $subtotal = $this->getSubtotal(); 
            $result->bindParam(':subtotal', $subtotal);

            $iva = $this->getIva(); 
            $result->bindParam(':iva', $iva);

            $total = $this->getTotal(); 
            $result->bindParam(':total', $total);

            $idpro = $this->getIdpro();
            $result->bindParam(':idpro', $idpro);

            $direccomp = $this->getDireccomp(); 
            $result->bindParam(':direccomp', $direccomp);

            $idcom = $this->getIdcom();
            $result->bindParam(':idcom', $idcom);

            $result->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error. Intentalo más tarde.";
        }
    }

    function getCompras($idusu)
    {
        $res = NULL;
        $sql = "SELECT u.idusu, c.idcom, c.tiproduct, c.fechareg, c.preciocom, c.cantidad, c.idubi, dc.iddell, dc.idpro, pr.nompro, pr.precio AS precio_producto, pr.tipro, pr.valorunitario, pr.descripcion, i.imgpro, i.nomimg, pv.nomprov, pd.idped, pd.estped FROM usuario u JOIN compra c ON u.idusu = c.idusu JOIN detallecompra dc ON c.idcom = dc.idcom JOIN producto pr ON dc.idpro = pr.idpro LEFT JOIN ( SELECT idpro, imgpro, nomimg FROM imagen WHERE (idpro, ordimg) IN ( SELECT idpro, MIN(ordimg) FROM imagen GROUP BY idpro ) ) i ON pr.idpro = i.idpro LEFT JOIN proveedor pv ON pv.idusu = u.idusu INNER JOIN pedido pd ON c.idped = pd.idped WHERE u.idusu = :idusu ORDER BY c.fechareg DESC;";

        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
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

