<?php include_once(__DIR__ . "/../controller/ccarr.php"); ?>
<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp" <?php if (!$isLoggedIn)
        echo "style='display: flex; justify-content: center;'"; ?>>
        <div class="col-8 bx-items-carr-comp">
            <?php if ($isLoggedIn) { ?>
                <?php if (!empty($dtCarrito)) { ?>
                    <?php foreach ($dtCarrito as $producto) { ?>
                        <div class="card-body">
                            <div class="row product producto-carrito" data-idpro="<?= $producto['idpro'] ?>"
                                data-nombre="<?= $producto['nompro'] ?>" data-cantidad="<?= $producto['cantidad'] ?>"
                                data-precio="<?= $producto['precio_final'] ?>"
                                data-imagen="<?= $producto['imgpro'] ?>">
                                <div class="col-2 bx_tusped-img">
                                    <a href="home.php?pg=001&idpro=<?= $producto['idpro'] ?>"><img
                                            src="<?php echo htmlspecialchars($producto['imgpro'] ?? 'default-image.png'); ?>"
                                            alt="<?php echo htmlspecialchars($producto['precio_final']); ?>"></a>
                                </div>
                                <div class="col product-details">
                                    <a href="" class="bx-a-car">
                                        <h6><?php echo htmlspecialchars($producto['nompro']); ?></h6>
                                        <?php if ($producto['pordescu'] > 0) { ?>
                                            <del>$<?= number_format($producto['precio'], 0, ",", "."); ?></del>
                                        <?php } ?>
                                        <p class="product-details_prec-fin">
                                            <?php echo "$" . number_format($producto['precio_final'], 2); ?>
                                        </p>
                                        <?php if ($producto['pordescu'] > 0) { ?>
                                            <p class="vl-green"><?= $producto['pordescu'] ?>% OFF</p>
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="col-2 product-actions_opt">
                                    <div class="col">
                                        <p>Cantidad: <span><?= $producto['cantidad'] ?></span></p>
                                    </div>
                                </div>
                                <div class="col">
                                    <p>Total</p>
                                    <p><span class="total">$
                                            <?= number_format($producto['cantidad'] * $producto['precio_final'], 0, ",", "."); ?></span>
                                    </p>
                                </div>
                                <div class="col-1 product-actions">
                                    <div class="row product-actions_opt">
                                        <div class="col">
                                            <a href="#" title="Eliminar" class="btn-eli-pcar" data-idpro="<?= $producto['idpro'] ?>"><i class="bi bi-x"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                <?php } else { ?>
                    <div class="col-4 bx-car-comp-imgnn">
                        <img src="IMG/carroVacio.svg" alt="">
                    </div>
                    <div class="col-6 bx-car-comp-imgnn">
                        <h4>Mi estimado(a), el carro esta vacío</h4>
                    </div>
                    <button><a href='home.php'>Encontrar Articulos</a></button>
                <?php } ?>

                <!-- Resumen del carrito -->
            </div>
            <?php if ($isLoggedIn) {
                if (!empty($dtCarrito)) { ?>
                    <div class="col bx-seg-dt bx-seg-env-minf_det-com bx-res-com-cr">
                        <div>
                            <h4>Resumen de Compra</h4>
                        </div>
                        <div class="bx-seg-dt_fech">
                            <?php
                            $total = 0;
                            foreach ($dtValoresCarrito as $dts) { ?>
                                <div class="row">
                                    <div class="col">
                                        <p>Producto:</p>
                                        <p>Descuento:</p>
                                        <p>Envío:</p>
                                    </div>
                                    <div class="col">
                                        <p>$<?= number_format($dts['precio'], 2, ",", ".") ?></p>
                                        <p class="vl-green">- $<?= number_format($dts['descuento_unitario'], 2, ",", ".") ?></p>
                                        <p class="vl-green">Gratis</p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <?php if (!empty($dtTotCarrito) && is_array($dtTotCarrito)) { ?>
                                    <div class="col">
                                        <p>Subtotal:</p>
                                        <p>Descuento:</p>
                                        <p>Total:</p>
                                    </div>
                                    <div class="col">
                                        <p>$<?= number_format($dtTotCarrito['total_productos'], 2, ",", ".") ?></p>
                                        <p class="vl-green">- $<?= number_format($dtTotCarrito['total_descuento'], 2, ",", ".") ?></p>
                                        <p class="tot-carr">$<?= number_format($dtTotCarrito['total_pagar'], 2, ",", ".") ?></p>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="footer">
                            <form id="formPago" action="controller/resPago.php" method="POST">
                                <input type="hidden" name="productos" id="productos">
                                <button type="submit" class="continue-button">Continuar</button>
                            </form>

                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    <?php } else { ?>
        <div class="col-4">
            <img src="IMG/carroVacio.svg" alt="">
        </div>
        <div class="col-6">
            <h4>Inicia sesión para ver tu carrito</h4>

            <p>Agrega productos y los veras aquí</p>
        </div>
        <button><a href='views/vwLogin.php'>Iniciar Sesión</a></button>
    <?php } ?>
</div>