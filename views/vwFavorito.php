<?php require_once("controller/cfav.php"); ?>
<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp">
    <?php if (empty($dtFavoritos)) { ?>
            <div class="col bx-items-carr-comp">
                <div class="col-6 bx-items-carr-comp_favo">
                    <?php echo $isLoggedIn ? "<h4>Aquí veras tus favoritos</h4>" : "<h4>Inicia sesión para guardar tus favoritos</h4>" ?>
                    <p>Encuentra productos y coleccionalos</p>
                </div>
                <div class="col-4 bx-items-carr-comp_favo">
                    <img src="IMG/favoritos.svg" alt="favoritos">
                </div>
            </div>
        <?php } else { ?>
            <div class="p-3 bx-tusped-gen-n2">
                <h2 class="text-center fw-bold">Tus Favoritos</h2>

                <div class="my-3">
                    <?php foreach ($dtFavoritos as $dtf) { ?>
                        <div class="card-body bx_tusped bx-favor">
                            <a href="home.php?pg=001&idpro=<?= $dtf['idpro'] ?>" class="row bx_tusped-dtp bx-favor-dtp">
                                <div class="col-2 bx_tusped-img">
                                    <img src="<?= $dtf['imgpro'] ?>" alt="<?= $dtf['nompro'] ?>">
                                </div>
                                <div class="col">
                                    <div class="bx_tusped-inf-nompro bx-favor-inf-nompro">
                                        <div>
                                            <p class="bx_tusped-nompro bx-favor-nompro"><?= $dtf['nompro'] ?></p>
                                            <?php if ($dtf['pordescu'] > 0) { ?>
                                                <del
                                                    class="bx-favor-del">$<?php echo number_format($dtf['precio'], 0, ",", "."); ?></del>
                                            <?php } ?>
                                            <p class="bx_tusped-nompro">
                                                $<?= number_format($dtf['valor_con_descuento'], 0, ",", "."); ?></p>
                                        </div>
                                        <p class="bx-favor-prd-vend"><?= $dtf['productvend'] ?> Vendidos</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="bx-favor-nomv"><?= $dtf['nomval'] ?></p>
                                    <?php if ($dtf['pordescu'] > 0) { ?>
                                        <p class="bx_tusped-tienda bx-favor-descu"><?= $dtf['pordescu'] ?>% OFF</p>
                                    <?php } ?>
                                </div>
                            </a>
                            <div class="col bx_tusped-opcs bx-favor-opc"><button class="bx-favor-elim"
                                    id="btn-eli-fav" data-idusu="<?= $_SESSION['idusu'] ?>" data-idpro="<?= $dtf['idpro'] ?>">Eliminar</button></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php insertText("Productos hechos para ti", $dtProdsSuge, 2)?>
</div>