<?php

class Compra {
    private $idcom;
    private $tiproduct;
    private $cantidad;
    private $preciocom;
    private $iddell;
    private $idubi;
    private $idusu;
    private $idped;

    // Métodos "set" para asignar valores a las propiedades
    public function setIdcom($idcom) {
        $this->idcom = $idcom;
    }

    public function setTiproduct($tiproduct) {
        $this->tiproduct = $tiproduct;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setPreciocom($preciocom) {
        $this->preciocom = $preciocom;
    }

    public function setIddell($iddell) {
        $this->iddell = $iddell;
    }

    public function setIdubi($idubi) {
        $this->idubi = $idubi;
    }

    public function setIdusu($idusu) {
        $this->idusu = $idusu;
    }

    public function setIdped($idped) {
        $this->idped = $idped;
    }

    // Métodos "get" para obtener los valores de las propiedades
    public function getIdcom() {
        return $this->idcom;
    }

    public function getTiproduct() {
        return $this->tiproduct;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPreciocom() {
        return $this->preciocom;
    }

    public function getIddell() {
        return $this->iddell;
    }

    public function getIdubi() {
        return $this->idubi;
    }

    public function getIdusu() {
        return $this->idusu;
    }

    public function getIdped() {
        return $this->idped;
    }

    // Método para obtener las compras del usuario
    public function getComPar() {
        $res = [];
        $sql = "SELECT 
            c.idcom AS CompraID,
            c.tiproduct AS TipoProducto,
            c.cantidad AS CantidadCompra,
            c.preciocom AS PrecioCompra,
            c.iddell AS DetalleCompraID,
            c.idubi AS UbicacionID,
            u.idusu AS UsuarioID,
            u.nomusu AS NombreUsuario,
            u.apeusu AS ApellidoUsuario,
            u.docusu AS DocumentoUsuario,
            u.emausu AS EmailUsuario,
            u.celusu AS CelularUsuario,
            u.dirrecusu AS DireccionUsuario,
            u.tipdoc AS TipoDocumento,
            p.idped AS PedidoID,
            p.total AS TotalPedido,
            p.fecha AS FechaPedido,
            pr.nompro AS NombreProducto,
            pr.precio AS PrecioProducto
        FROM 
            compra c
        LEFT JOIN 
            usuario u ON c.idusu = u.idusu
        LEFT JOIN 
            pedido p ON c.idped = p.idped
        LEFT JOIN 
            detallecompra d ON c.iddell = d.iddell
        LEFT JOIN 
            producto pr ON d.idpro = pr.idpro
        WHERE 
            c.idusu = :idusu"; 

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
}

