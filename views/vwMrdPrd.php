<div class="bx-pr-art-sg">
    <h5><span id="title-mrart"><?php require_once("controller/cpro.php");
    echo $title; ?></span></h5>
    <div class="row bx-art-sg">
        <button class="btn-direct" id="btn-left"><i class="bi bi-chevron-compact-left"></i></button>
        <section class="section col d-flex align-items-center bx-mr-prd" id="product-section">
            <?php if (!empty($data)) {
                foreach ($data as $dt) { ?>
                    <a class="col-2 ">
                        <div class="row">
                            <div class="col">
                                <img src="<?= $dt['imgpro']; ?>" alt="<?= $dt['nompro']; ?>">
                            </div>
                            <div class="col">
                                <p><?= $dt['nompro']; ?></p>
                                <?php if ($dt['pordescu'] > 0) { ?>
                                    <p><del>$<?php echo number_format($dt['precio'], 0, ",", "."); ?></del> <span><?= $dt['pordescu']?>%</span></p>

                                <?php } ?>

                                <p>$<?=  number_format($dt['valor_con_descuento'], 2, ",", "."); ; ?></p>
                            </div>
                        </div>
                    </a>
                <?php }
            } ?>
        </section>
        <button class="btn-direct" id="btn-right"><i class="bi bi-chevron-compact-right"></i></button>
    </div>
</div>