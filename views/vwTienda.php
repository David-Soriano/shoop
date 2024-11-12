<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
    <div class="carousel-indicators">
        <?php
        $i = 0;
        foreach($dtSliders as $dtsl) {
            $activeClass = $i === 0 ? 'active' : '';
            echo "<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$i' class='$activeClass' aria-current='true' aria-label='Slide ".($i+1)."'></button>";
            $i++;
        }
        ?>
    </div>
    <div class="carousel-inner">
        <?php
        $i = 0;
        foreach($dtSliders as $dtsl) {
            $activeClass = $i === 0 ? 'active' : '';
            echo "<div class='carousel-item $activeClass'>";
            echo "<img src='" . $dtsl['imgpro'] . "' class='d-block w-100' alt='...'>";
            echo "</div>";
            $i++;
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class="row bx-artc-prc">
    <section class="col-sm-10 col">
        <div class="row d-flex gap-5 justify-content-center">
            <?php foreach ($productos as $producto): ?>
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
                            <p id="val-sindes">$<del><?php echo number_format($producto['valorunitario'], 0, ',', '.'); ?></del>
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
            <?php endforeach; ?>


        </div>
    </section>
</div>