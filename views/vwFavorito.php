<?php require_once("controller/cfav.php"); ?>
<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp">
        <?php if(!$dtFavoritos){?>
        <div class="col bx-items-carr-comp">
            <div class="col-6">
                <?php echo $isLoggedIn ? "<h4>Aquí veras tus favoritos</h4>" : "<h4>Inicia sesión para guardar tus favoritos</h4>" ?>
                <p>Encuentra productos y coleccionalos</p>
            </div>
            <div class="col-4">
                <img src="IMG/favoritos.svg" alt="favoritos">
            </div>
        </div>
        <?php } else{?>
        <div class="p-3 bx-tusped-gen-n2">
            <h2 class="text-center fw-bold">Tus Favoritos</h2>

            <div class="my-3">
                <?php foreach ($dtFavoritos as $dtf) { ?>
                    <div class="card-body bx_tusped">
                        <div class="row bx_tusped-dtp">
                            <div class="col-2 bx_tusped-img"><img src="<?= $dtf['imgpro'] ?>" alt="<?= $dtf['nompro'] ?>">
                            </div>
                            <div class="col">
                                <div class="bx_tusped-inf-nompro">
                                    <p class="bx_tusped-nompro"><?= $dtf['nompro'] ?></p>
                                    <p class="bx_tusped-nompro">$<?= $dtf['precio'] ?></p>
                                </div>
                            </div>
                            <div class="col">
                                <p class="bx_tusped-tienda"><?= $dtf['pordescu'] ?></p>
                            </div>
                            <div class="col bx_tusped-opcs"><a href="home.php?pg=28&idpro=<?= $dtf['idpro'] ?>"
                                    class="bx_tusped-btn-sg-ev">Ver Producto</a></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php }?>
    </div>
</div>