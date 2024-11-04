<?php
class Producto {
    public $idpro;
    public $nompro;
    public $precio;
    public $descripcion;
    public $estado;
    public $imgpro;
    public function __construct($idpro, $nompro, $precio, $descripcion, $estado, $imgpro) {
        $this->idpro = $idpro;
        $this->nompro = $nompro;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->imgpro = $imgpro;
    }
    // Getters
    public function getIdpro()
    {
        return $this->idpro;
    }

    public function getNompro()
    {
        return $this->nompro;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getImgpro()
    {
        return $this->imgpro;
    }

    // Setters
    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }

    public function setNompro($nompro)
    {
        $this->nompro = $nompro;
    }

    public function setPrecio($precio)
    {
        if ($precio < 0) {
            throw new Exception("El precio no puede ser negativo.");
        }
        $this->precio = $precio;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado)
    {
        $estadosValidos = ['activo', 'inactivo'];
        if (!in_array($estado, $estadosValidos)) {
            throw new Exception("Estado no válido.");
        }
        $this->estado = $estado;
    }

    public function setImgpro($imgpro)
    {
        $this->imgpro = $imgpro;
    }
}
