<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp">
        <div class="col bx-items-carr-comp">
            <div class="col-6">
                <?php echo $isLoggedIn ? "<h4>Aquí podrás realizar tus pagos</h4>" : "<h4>Inicia sesión para realizar pago</h4>"; ?>
                <p></p>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Datos de Pago</title>
        <link rel="stylesheet" href="CSS/stylePagos.css">
    </head>
    <body>
        <div class="container mt-5">
            <!-- Dirección de Entrega -->
            <div class="border p-3 mb-4" style="background-color: #f9f9f9; border-radius: 8px;">
                <h5 class="mb-3"><strong>Dirección De Entrega</strong></h5>
                <p class="mb-1"><strong>Dariana Marcela De La Cruz Ortega (+57) 3014667845</strong></p>
                <p class="text-muted">Carrera 4este #11-00, Conjunto los pinos, Torre 16 apartamento 503, Chía, Cundinamarca.</p>
                <button class="btn btn-link text-primary p-0" style="font-size: 14px;">Cambiar</button>
            </div>

            <!-- Tabla de productos -->
            <h2 class="text-center">Resumen de Pago</h2>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0; // Inicializar total
                    if (!empty($idusu)) {
                        foreach ($idusu as $idpro): 
                            $subtotal = $idpro->precio * $idpro->cantidad;
                            $total += $subtotal;
                    ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($idpro->imagen) ?>" alt="<?= htmlspecialchars($idpro->nombre) ?>" width="50"></td>
                        <td><?= htmlspecialchars($idpro->nombre) ?></td>
                        <td><?= $idpro->cantidad ?></td>
                        <td><?= number_format($idpro->precio, 2) ?></td>
                        <td><?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php 
                        endforeach;
                    } else {
                        echo '<tr><td colspan="5" class="text-center"></td></tr>';
                    }
                    ?>
                </tbody>
            </table>

            <!-- Opciones adicionales -->
            <div class="border p-3 mt-4" style="background-color: #f9f9f9; border-radius: 8px;">
                <div class="mb-3">
                    <label for="mensajeVendedor" class="form-label"><strong>Mensaje:</strong></label>
                    <input type="text" id="mensajeVendedor" class="form-control" placeholder="(Opcional) Dejar un mensaje al vendedor">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p><strong>Opción de Envío:</strong> Estándar Rápido (Recibir antes del 4 - 16 de diciembre)</p>
                </div>
            </div>

            <!-- Resumen total -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h4>Total a pagar: <?= number_format($total, 2) ?> COP</h4>
                <button class="btn btn-success">Realizar Pago</button>
            </div>

            <!-- Métodos de pago -->
            <div class="payment-method mt-4">
                <p>Medios de pago <a href="#">Términos y Condiciones</a></p>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary">PSE</button>
                    <button class="btn btn-outline-primary">Efecty</button>
                    <button class="btn btn-outline-primary">Tarjeta de Crédito</button>
                    <button class="btn btn-outline-primary">Tarjeta de Débito</button>
                </div>
            </div>
        </div>
      </div>
      </div>
    </div>
    </body>
    </html>
</div>
