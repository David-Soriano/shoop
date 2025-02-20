<div class="row bx-mr-prd-gene">
<h5><span id="title-mrart"><?php
    echo $title; ?></span></h5>
    <section class="section col d-flex align-items-center bx-mr-prd" id="product-section">
            <?php if (!empty($data)) {
                foreach ($data as $dt) { ?>
                    <a href="<?php if(session_status() === PHP_SESSION_NONE){
                        echo 'index.php?pg=001&idpro=' . $dt['idpro']; 
                    } else{
                        echo 'home.php?pg=001&idpro=' . $dt['idpro'];
                    }?>" class="col-3">
                        <div class="row">
                            <div class="col bx-mr-prd_img">
                                <img src="<?= $dt['imgpro']; ?>" alt="<?= $dt['nompro']; ?>">
                            </div>
                            <div class="col bx-mr-prd_descrip">
                                <p class="bx-mr-prd_nompro"><?= $dt['nompro']; ?></p>
                                <?php if ($dt['pordescu'] > 0) { ?>
                                    <p><del class="bx-mr-prd_del">$<?php echo number_format($dt['precio'], 0, ",", "."); ?></del></p>
                                <?php } ?>
                                <p><span class="bx-mr-prd_precio">$<?=  number_format($dt['valor_con_descuento'], 2, ",", "."); ?></span> <span class="bx-mr-prd_pordesc"><?php if ($dt['pordescu'] > 0)echo $dt['pordescu'] . "% OFF";?></span></p>
                            </div>
                        </div>
                    </a>
                <?php }
            } ?>
    </section>
</div>