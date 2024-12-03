<section class="bx-artc-prc">
    <div class="row ">
        <div class="col tit-new">
            <h4>Descubre lo último desde el primer vistazo</h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <section class="bx-apart">
                <div class="row d-flex gap-5 justify-content-center">
                    <?php if ($productosNuevos) {
                        foreach ($productosNuevos as $producto): ?>
                            <!-- Código del producto -->
                            <a href="<?php echo $isLoggedIn ? "home.php?pg=001&idpro=" . $producto['idpro'] : "index.php?pg=001&idpro=" . $producto['idpro']; ?>"
                                class="col-lg-2 col-md-3 col-sm-5 col-4 bx-item">

                                <div class="col img-artc">
                                    <img src="<?php echo $producto['imgpro']; ?>"
                                        alt="<?php echo htmlspecialchars($producto['nompro']); ?>"
                                        title="<?php echo htmlspecialchars($producto['nompro']); ?>">
                                </div>
                                <div class="col inf-artc">
                                    <h6><?php echo htmlspecialchars($producto['nompro']); ?></h6>
                                    <?php if ($producto['valor_con_descuento'] > 0) { ?>
                                        <p id="val-sindes">
                                            $<del><?php echo number_format($producto['valorunitario'], 0, ',', '.'); ?></del>
                                        </p>
                                    <?php } ?>
                                    <div class="inf-tot-prc">
                                        <p id="prc-fin">
                                            <?php
                                            // Verificar si el valor con descuento es válido y mayor que 0
                                            $valorConDescuento = $producto['valor_con_descuento'] > 0 ? $producto['valor_con_descuento'] : $producto['valorunitario'];
                                            echo "$" . number_format($valorConDescuento, 0, ',', '.');
                                            ?>
                                        </p>
                                        <?php if ($producto['valor_con_descuento'] > 0) { ?>
                                            <p id="inf-val-des"><?php echo $producto['pordescu']; ?>%</p>
                                        <?php } ?>

                                    </div>
                                </div>
                            </a>
                        <?php endforeach;
                    } else { ?>
                        <p>Pronto añadiremos productos nuevos. ¡Vuelve Pronto!</p>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</section>