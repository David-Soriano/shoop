<?php
// Modelo ajustado

class CarritoModel
{
    private $idusu; // ID del usuario
    private $conexion; // Conexión a la base de datos

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function getIdusu()
    {
        return $this->idusu;
    }

    public function obtenerCarrito($idUsuario)
    {
        try {
            $res = "";
            $sql = "SELECT 
                    c.idcar, 
                    c.idusu, 
                    dc.iddetcar, 
                    dc.idcar, 
                    dc.idpro, 
                    dc.cantidad, 
                    dc.precar, 
                    p.nompro, 
                    p.precio, 
                    p.pordescu, 
                    (p.precio - (p.precio * (p.pordescu / 100))) AS precio_final, 
                    (p.precio * (p.pordescu / 100)) AS valor_descuento,
                    i.imgpro, 
                    i.nomimg 
                FROM carrito AS c
                INNER JOIN detallecarrito AS dc ON dc.idcar = c.idcar
                INNER JOIN producto AS p ON dc.idpro = p.idpro
                LEFT JOIN (
                    SELECT idpro, imgpro, nomimg 
                    FROM imagen 
                    WHERE (idpro, ordimg) IN (
                        SELECT idpro, MIN(ordimg) 
                        FROM imagen 
                        GROUP BY idpro
                    )
                ) i ON p.idpro = i.idpro
                WHERE c.idusu = :idusu";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idusu', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los productos en el carrito
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return []; // En caso de error, retorna un array vacío
        }
        return $res;
    }


    public function agregarProducto($idUsuario, $idpro, $cantidad, $precio)
    {
        try {
            $this->conexion->beginTransaction(); // Iniciar transacción

            // 1️⃣ Verificar si el usuario ya tiene un carrito
            $sqlCarrito = "SELECT idcar FROM carrito WHERE idusu = :idusu";
            $stmtCarrito = $this->conexion->prepare($sqlCarrito);
            $stmtCarrito->bindParam(':idusu', $idUsuario, PDO::PARAM_INT);
            $stmtCarrito->execute();
            $carrito = $stmtCarrito->fetch(PDO::FETCH_ASSOC);

            if (!$carrito) {
                // 2️⃣ Si no tiene carrito, crearlo
                $sqlCrearCarrito = "INSERT INTO carrito (idusu) VALUES (:idusu)";
                $stmtCrearCarrito = $this->conexion->prepare($sqlCrearCarrito);
                $stmtCrearCarrito->bindParam(':idusu', $idUsuario, PDO::PARAM_INT);
                $stmtCrearCarrito->execute();

                // Obtener el idcar recién insertado
                $idCarrito = $this->conexion->lastInsertId();
            } else {
                // Si ya existe el carrito, obtener su idcar
                $idCarrito = $carrito['idcar'];
            }

            // 3️⃣ Verificar si el producto ya está en el carrito
            $sqlVerificar = "SELECT iddetcar FROM detallecarrito WHERE idcar = :idcar AND idpro = :idpro";
            $stmtVerificar = $this->conexion->prepare($sqlVerificar);
            $stmtVerificar->bindParam(':idcar', $idCarrito, PDO::PARAM_INT);
            $stmtVerificar->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $stmtVerificar->execute();
            $detalleCarrito = $stmtVerificar->fetch(PDO::FETCH_ASSOC);

            if (!$detalleCarrito) {
                // Si el producto no está en el carrito, insertarlo
                $sqlDetalle = "INSERT INTO detallecarrito (idcar, idpro, cantidad, precar) 
                               VALUES (:idcar, :idpro, :cantidad, :precar)";
                $stmtDetalle = $this->conexion->prepare($sqlDetalle);
                $stmtDetalle->bindParam(':idcar', $idCarrito, PDO::PARAM_INT);
                $stmtDetalle->bindParam(':idpro', $idpro, PDO::PARAM_INT);
                $stmtDetalle->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmtDetalle->bindParam(':precar', $precio, PDO::PARAM_STR);
                $stmtDetalle->execute();
            } 
            $this->conexion->commit(); // Confirmar la transacción

            return true;
        } catch (Exception $e) {
            $this->conexion->rollBack(); // Revertir si hay error
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }
    public function eliminarProducto($idUsuario, $idpro)
    {
        try {
            $this->conexion->beginTransaction(); // Iniciar transacción

            // 1️⃣ Obtener el ID del carrito del usuario
            $sqlCarrito = "SELECT idcar FROM carrito WHERE idusu = :idusu";
            $stmtCarrito = $this->conexion->prepare($sqlCarrito);
            $stmtCarrito->bindParam(':idusu', $idUsuario, PDO::PARAM_INT);
            $stmtCarrito->execute();
            $carrito = $stmtCarrito->fetch(PDO::FETCH_ASSOC);

            if (!$carrito) {
                throw new Exception("El usuario no tiene un carrito.");
            }

            $idCarrito = $carrito['idcar'];

            // 2️⃣ Eliminar el producto del detallecarrito
            $sqlEliminar = "DELETE FROM detallecarrito WHERE idcar = :idcar AND idpro = :idpro";
            $stmtEliminar = $this->conexion->prepare($sqlEliminar);
            $stmtEliminar->bindParam(':idcar', $idCarrito, PDO::PARAM_INT);
            $stmtEliminar->bindParam(':idpro', $idpro, PDO::PARAM_INT);
            $stmtEliminar->execute();

            $this->conexion->commit(); // Confirmar la transacción

            return true;
        } catch (Exception $e) {
            $this->conexion->rollBack(); // Revertir si hay error
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }
    public function limpiarCarrito($idUsuario)
    {
        try {
            // Obtener el ID del carrito del usuario
            $sqlCarrito = "SELECT idcar FROM carrito WHERE idusu = :idusu";
            $stmtCarrito = $this->conexion->prepare($sqlCarrito);
            $stmtCarrito->bindParam(':idusu', $idUsuario, PDO::PARAM_INT);
            $stmtCarrito->execute();
            $carrito = $stmtCarrito->fetch(PDO::FETCH_ASSOC);

            if ($carrito) {
                $idCarrito = $carrito['idcar'];

                // Eliminar los productos del detalle del carrito
                $sqlEliminar = "DELETE FROM detallecarrito WHERE idcar = :idcar";
                $stmtEliminar = $this->conexion->prepare($sqlEliminar);
                $stmtEliminar->bindParam(':idcar', $idCarrito, PDO::PARAM_INT);
                $stmtEliminar->execute();
            }

            return true;
        } catch (Exception $e) {
            error_log("Error al limpiar el carrito: " . $e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return false;
        }
    }


    public function obtenerDetalleProductosFactura($idusu)
    {
        $res = "";
        $sql = "SELECT 
                    dc.idpro, 
                    p.nompro, 
                    dc.cantidad, 
                    p.precio, 
                    p.pordescu,
                    (p.precio * (p.pordescu / 100)) AS descuento_unitario,
                    (dc.cantidad * (p.precio * (p.pordescu / 100))) AS descuento_total,
                    (p.precio - (p.precio * (p.pordescu / 100))) AS precio_final_unitario,
                    (dc.cantidad * (p.precio - (p.precio * (p.pordescu / 100)))) AS precio_final_total
                FROM carrito AS c
                INNER JOIN detallecarrito AS dc ON dc.idcar = c.idcar
                INNER JOIN producto AS p ON dc.idpro = p.idpro
                WHERE c.idusu = :idusu";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(":idusu", $idusu);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        }
        return $res;
    }

    // 🔹 2️⃣ Obtener totales para la factura
    public function obtenerTotalesFactura($idusu)
    {
        $res = "";
        $sql = "SELECT 
                    SUM(dc.cantidad * p.precio) AS total_productos,  
                    SUM(dc.cantidad * (p.precio * (p.pordescu / 100))) AS total_descuento,
                    SUM(dc.cantidad * (p.precio - (p.precio * (p.pordescu / 100)))) AS total_pagar
                FROM carrito AS c
                INNER JOIN detallecarrito AS dc ON dc.idcar = c.idcar
                INNER JOIN producto AS p ON dc.idpro = p.idpro
                WHERE c.idusu = :idusu";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(":idusu", $idusu);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        }
        return $res;
    }

}
