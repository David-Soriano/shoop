<div class="row bx-cont-inf d-flex justify-content-center">
    <section class="col-6 section">
        <div class="row bx-fot-art">
            <div class="col-2">
                <div class="row bx-min-fot min-img">
                    <div class="col">
                        <img src="IMG/Articulo 5.webp" alt="">
                    </div>
                    <div class="col">
                        <img src="IMG/min-art5.webp" alt="">
                    </div>
                    <div class="col">
                        <img src="IMG/min1-art5.webp" alt="">
                    </div>
                    <div class="col">
                        <img src="IMG/min2-art5.webp" alt="">
                    </div>
                </div>
            </div>
            <aside class="aside col-6 bx-mobile">
                <div class="row">
                    <?php if (isset($dtInfPrd)) {
                        foreach ($dtInfPrd as $dtinf) { ?>
                            <div class="col bx-car-prd">
                                <p><?php if ($dtinf['es_nuevo']) { ?>Nuevo | <?php }
                                                                            echo $dtinf['productvend']; ?> vendidos</p>
                                <h3><?= $dtinf['nompro']; ?></h3>
                            </div>
                    <?php }
                    } ?>
                </div>
            </aside>
            <?php if (isset($dtInfPrd)) {
                foreach ($dtInfPrd as $dtinf) { ?>
                    <div class="col-10 bx-art-pr">
                        <img src="<?= $dtinf['imgpro'] ?>" alt="<?= $dtinf['nompro'] ?>">
                    </div>
            <?php }
            } ?>
        </div>
    </section>
    <aside class="aside col-6 bx-txt-prd bx-compu">
        <div class="row">
            <?php if (isset($dtInfPrd)) {
                foreach ($dtInfPrd as $dtinf) { ?>
                    <div class="col-7 bx-car-prd">
                        <div class="bx-compu">
                            <section>
                                <p><?php if ($dtinf['es_nuevo']) { ?>Nuevo | <?php }
                                                                            echo $dtinf['productvend']; ?> vendidos</p>
                                <h3><?= $dtinf['nompro']; ?></h3>
                            </section>
                        </div>
                        <?php if ($dtinf['valor_con_descuento'] > 0) { ?>
                            <del>$<?php echo number_format($dtinf['valorunitario'], 0, ",", "."); ?></del>
                        <?php } ?>
                        <h4><?php $valorConDescuento = $dtinf['valor_con_descuento'] > 0 ? $dtinf['valor_con_descuento'] : $dtinf['valorunitario'];
                            echo "$" . number_format($valorConDescuento, 0, ",", "."); ?>
                            <?php if ($dtinf['pordescu']) { ?>
                                <span><?= $dtinf['pordescu']; ?>% OFF</span>
                            <?php } ?>
                        </h4>
                        <p><span>Envío Gratis</span></p>
                        <section class="bx-carprd">
                            <p>
                                Características principales:
                            </p>
                            <?php
                            // Verificar si $dtCarprd no está vacío
                            if (!empty($dtCarprd)) {
                                foreach ($dtCarprd as $dtcar) { ?>
                                    <ul>
                                        <li><?= $dtcar['descripcion'] ?></li>
                                    </ul>
                                <?php }
                            } else { ?>
                                <p><b>No se incluyeron características</b></p>
                            <?php } ?>
                            <a href="#bx-des-prd">Ver más detalles</a>
                        </section>

                    </div>
            <?php }
            } ?>
            <div class="col-5 bx-btns-comp">
                <p>Stock disponible: <span>10</span></p>
                <p>Cantidad: <span>1</span></p>
                <button id="btn-buy"><a href="<?php echo $isLoggedIn ? "home.php?pg=9" : "views/vwLogin.php"; ?>">Lo
                        quiero </a></button>
                <button id="btn-add-carr" title="Añadir al carrito"><i class="bi bi-cart2"></i></button>
                <div class="col">
                    <h6>Información de la Tienda</h6>
                    <div class="col">
                        <div class="icon-shop"></div>
                        <h6>Nombre Tienda</h6>
                    </div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae nam sequi qui sunt
                        quidem vel delectus similique</p>
                    <div>
                        <p>Consulta nuestros <a href="">Terminos y Condiciones</a></p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <aside class="aside col-6 bx-txt-prd bx-mobile">
        <div class="row">
            <?php if (isset($dtInfPrd)) {
                foreach ($dtInfPrd as $dtinf) { ?>
                    <div class="col-10 bx-car-prd">
                        <?php if ($dtinf['valor_con_descuento'] > 0) { ?>
                            <del>$<?php echo number_format($dtinf['valorunitario'], 0, ",", "."); ?></del>
                        <?php } ?>
                        <h4><?php $valorConDescuento = $dtinf['valor_con_descuento'] > 0 ? $dtinf['valor_con_descuento'] : $dtinf['valorunitario'];
                            echo "$" . number_format($valorConDescuento, 0, ",", "."); ?>
                            <?php if ($dtinf['pordescu']) { ?>
                                <span><?= $dtinf['pordescu']; ?>% OFF</span>
                            <?php } ?>
                        </h4>
                        <p><span>Envío Gratis</span></p>
                    </div>
            <?php }
            } ?>
            <div class="col-10 bx-btns-comp">
                <p>Stock disponible: <span>10</span></p>
                <p>Cantidad: <span>1</span></p>
                <button id="btn-buy"><a href="<?php echo $isLoggedIn ? "home.php?pg=9" : "views/vwLogin.php"; ?>">Lo
                        quiero </a></button>
                <button id="btn-add-carr" title="Añadir al carrito"><i class="bi bi-cart2"></i></button>
                <div class="col">
                    <h6>Información de la Tienda</h6>
                    <div class="col">
                        <div class="icon-shop"></div>
                        <h6>Nombre Tienda</h6>
                    </div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae nam sequi qui sunt
                        quidem vel delectus similique</p>
                    <div>
                        <p>Consulta nuestros <a href="">Terminos y Condiciones</a></p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
<hr>
</div>