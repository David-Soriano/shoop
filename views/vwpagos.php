<?php
include 'controller/config.php';
$carrito = $_SESSION['respag'] ?? [];
$ubicacion = [
    'idubi' => $_SESSION['idubi'],
    'direccion' => $_SESSION['dirrecusu']
];
?>
<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp">
        <div class="col bx-items-carr-comp bx-pagos">
            <div class="col-6">
                <div class="container mt-5">
                    <!-- Dirección de Entrega -->
                    <div class="border p-3 mb-4" style="background-color: #f9f9f9; border-radius: 8px;">
                        <h5 class="mb-3"><strong>Dirección De Entrega</strong></h5>
                        <?php if ($_SESSION['dirrecusu']) { ?>
                            <p class="mb-1"><strong><?= $_SESSION['nomusu'] ?>     <?= $_SESSION['apeusu'] ?> TEL:
                                    <?= $_SESSION['celusu'] ?></strong></p>
                            <p class="text-muted"><?= $_SESSION['departamento'] ?> - <?= $_SESSION['ciudad'] ?></p>
                            <p class="text-muted"><?= $_SESSION['dirrecusu'] ?></p>
                            <button><a href="home.php?pg=15">Cambiar</a></button>
                        <?php } else { ?>
                            <button class="btn btn-link text-primary" style="font-size: 14px;">Añadir Dirección</button>
                        <?php } ?>

                    </div>

                    <!-- Tabla de productos -->
                    <h2 class="text-center">Resumen de Pago</h2>
                    <div class="table-responsive">
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
                                $total = 0;
                                $descripciones = [];
                                ?>

                                <?php foreach ($carrito as $item) { ?>
                                    <tr>
                                        <td><img src="<?= $item['imagen']; ?>" alt="<?= $item['nombre']; ?>"
                                                style="width: 50px;"></td>
                                        <td><?= $item['nombre']; ?></td>
                                        <td><?= $item['cantidad']; ?></td>
                                        <td>$<?= number_format($item['precio'], 0, ",", "."); ?></td>
                                        <td>$<?= number_format($item['cantidad'] * $item['precio'], 0, ",", "."); ?></td>
                                    </tr>

                                    <?php
                                    $total += $item['cantidad'] * $item['precio'];
                                    $descripciones[] = $item['nombre'];
                                    ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>


                    <!-- Opciones adicionales -->
                    <div class="border p-3 mt-4" style="background-color: #f9f9f9; border-radius: 8px;">
                        <div class="mb-3">
                            <label for="mensajeVendedor" class="form-label"><strong>Mensaje:</strong></label>
                            <input type="text" id="mensajeVendedor" class="form-control"
                                placeholder="(Opcional) Dejar un mensaje al vendedor">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p><strong>Opción de Envío:</strong> Estándar Rápido (Recibir antes del 4 - 16 de diciembre)
                            </p>
                        </div>
                    </div>
                    <?php
                    $descrip = implode(", ", $descripciones); // Convertir la lista de nombres en una cadena
                    ?>

                    <!-- Resumen total -->
                    <div class="bx-res-tot-pag">
                        <h4>Total a pagar:
                            <span>$<?= number_format($total, 0, ",", "."); ?></span> COP
                        </h4>
                        <form method="POST" class="form-pago" action="controller/payment.php">
                            <input type="hidden" name="amount" value="<?= $total; ?>">
                            <input type="hidden" name="descripcion" value="Artículo: <?= $descrip ?>">
                            <input type="hidden" name="product"
                                value="<?= htmlspecialchars(json_encode($carrito, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="ubicacion"
                                value="<?= htmlspecialchars(json_encode($ubicacion, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" class="btn btn-success btn-pago">Realizar Pago</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>