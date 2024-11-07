<div class="row bx-cont-inf d-flex justify-content-center">
    <section class="col-6 section">
        <div class="row bx-fot-art">
            <div class="col-2">
                <div class="row bx-min-fot min-img">
                    <?php if (!empty($dtImgpro)) {
                        foreach ($dtImgpro as $dtImg => $img) { ?>
                            <div class="col" onmouseover="changeMainImage('<?= $img['imgpro'] ?>')">
                                <img class="thumbnail" src="<?= $img['imgpro'] ?>" alt="Imagen del producto <?= $dtImg + 1 ?>">
                            </div>
                        <?php }
                    } else { ?>
                        <p>No hay imágenes disponibles para este producto.</p>
                    <?php } ?>
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
                    <div class="col-10 bx-art-pr image-zoom-container">
                        <img id="mainImage" src="<?= $dtinf['imgpro'] ?>" alt="<?= $dtinf['nompro'] ?>">
                    </div>
                <?php }
            } ?>
        </div>
    </section>
    <aside class="aside col-6 bx-txt-prd bx-compu">
        <div class="row bx-opc-det-prd">
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

                            if (!empty($dtCarprd)) {
                                $contador = 0; // Inicializar un contador
                                foreach ($dtCarprd as $dtcar) {
                                    if ($contador >= 5)
                                        break; // Detener el bucle después de 5 elementos
                                    ?>
                                    <ul>
                                        <li><?= $dtcar['descripcion'] ?></li>
                                    </ul>
                                    <?php
                                    $contador++; // Incrementar el contador
                                }
                            } else { ?>
                                <p><b>No se incluyeron características</b></p>
                            <?php } ?>

                            <a href="#bx-des-prd">Ver más detalles</a>
                        </section>

                    </div>
                    <div class="col-5 bx-btns-comp">
                        <p>Stock disponible: <span><?= $dtinf['cantidad']; ?></span></p>
                        <p>Cantidad: <input type="number" id="cantidad" data-max="<?= $dtinf['cantidad']; ?>" value="1"></p>

                        <button id="btn-buy"><a href="<?php echo $isLoggedIn ? "home.php?pg=9" : "views/vwLogin.php"; ?>">Lo
                                quiero </a></button>
                        <button id="btn-add-carr" title="Añadir al carrito"><i class="bi bi-cart2"></i></button>
                        <div class="col">
                            <h6>Información de la Tienda</h6>
                            <div class="col">

                                <h6><?= $dtinf['nomprov']; ?></h6>
                            </div>
                            <p><?= $dtinf['desprv']; ?></p>
                            <div>
                                <p>Consulta nuestros <a href="">Terminos y Condiciones</a></p>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
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
                    <div class="col-10 bx-btns-comp">
                        <p>Stock disponible: <span><?= $dtinf['cantidad']; ?></span></p>
                        <p>Cantidad: <span>1</span></p>
                        <button id="btn-buy"><a href="<?php echo $isLoggedIn ? "home.php?pg=9" : "views/vwLogin.php"; ?>">Lo
                                quiero </a></button>
                        <button id="btn-add-carr" title="Añadir al carrito"><i class="bi bi-cart2"></i></button>
                        <div class="col">
                            <h6>Información de la Tienda</h6>
                            <div class="col">
                                <h6>Nombre Tienda</h6>
                            </div>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae nam sequi qui sunt
                                quidem vel delectus similique</p>
                            <div>
                                <p>Consulta nuestros <a href="">Terminos y Condiciones</a></p>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </aside>
    <hr>
</div>