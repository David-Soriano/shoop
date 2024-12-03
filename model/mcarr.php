<?php
// Modelo ajustado

class CarritoModel {
    private $idusu; // ID del usuario
    private $conexion; // Conexión a la base de datos

    public function __construct($idusu, $conexion) {
        $this->idusu = $idusu;
        $this->conexion = $conexion;
    }

    public function getIdusu() {
        return $this->idusu;
    }

    public function obtenerCarrito() {
        $sql = "
            SELECT 
                c.idcar AS id_carrito,
                c.idusu AS id_usuario,
                p.idpro AS id_producto,
                p.nompro AS nombre_producto,
                p.precio AS precio_producto,
                p.descripcion AS descripcion_producto,
                dc.cantidad AS cantidad_producto,
                (dc.cantidad * p.precio) AS subtotal
            FROM carrito c
            JOIN detallecarrito dc ON c.idcar = dc.idcar
            JOIN producto p ON dc.idpro = p.idpro
            WHERE c.idusu = :idusu
            ORDER BY c.fecha_creacion DESC;
        ";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idusu', $this->getIdusu());
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return [];
        }
    }

    public function agregarProducto($productId) {
        try {
            $sqlCarrito = "SELECT idcar FROM carrito WHERE idusu = ?";
            $stmtCarrito = $this->conexion->prepare($sqlCarrito);
            $stmtCarrito->execute([$this->getIdusu()]);
            $carrito = $stmtCarrito->fetch(PDO::FETCH_ASSOC);

            if (!$carrito) {
                $sqlNuevoCarrito = "INSERT INTO carrito (idusu, fecha_creacion) VALUES (?, NOW())";
                $stmtNuevoCarrito = $this->conexion->prepare($sqlNuevoCarrito);
                $stmtNuevoCarrito->execute([$this->getIdusu()]);
                $carritoId = $this->conexion->lastInsertId();
            } else {
                $carritoId = $carrito['idcar'];
            }

            $sqlDetalle = "SELECT iddetcar FROM detallecarrito WHERE idcar = ? AND idpro = ?";
            $stmtDetalle = $this->conexion->prepare($sqlDetalle);
            $stmtDetalle->execute([$carritoId, $productId]);
            $detalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC);

            if ($detalle) {
                $sqlActualizar = "UPDATE detallecarrito SET cantidad = cantidad + 1 WHERE iddetcar = ?";
                $stmtActualizar = $this->conexion->prepare($sqlActualizar);
                return $stmtActualizar->execute([$detalle['iddetcar']]);
            } else {
                $sqlInsertar = "INSERT INTO detallecarrito (idcar, idpro, cantidad) VALUES (?, ?, 1)";
                $stmtInsertar = $this->conexion->prepare($sqlInsertar);
                return $stmtInsertar->execute([$carritoId, $productId]);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }
}
