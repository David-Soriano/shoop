<?php
include_once("controller/cped.php");
$idped = isset($_REQUEST['idped']) ? $_REQUEST['idped'] : NULL;
$dtSegEnv = segEnv($idped);
?>
<div class="container my-5 bx-tusped-gen">
    <div class="p-4 bx-tusped-gen-n2">

        <div class="mb-4 bx-seg-env row">
            <div class="col-8 bx-seg-env_estados"><?php if ($dtSegEnv) {
                foreach ($dtSegEnv as $dts) { ?>
                        <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 8%;">
                            <div>
                                <h5>Proceso de Devolución</h5>
                                <h4 class="fw-bold"><?= $dts['nompro']; ?></h4>
                                <p class="bx-seg-env_catg"><?= $dts['cantidad']; ?> Unidad</p>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <?php foreach ($dtSegEnv as $dts) { ?>
                    <div class="col bx-seg-env_img">
                        <img src="<?= $dts['imgpro']; ?>" alt="<?= $dts['nomimg']; ?>" class="img-thumbnail img-sg-env">
                        <p class="bx-seg-env_catg"><?= $dts['nomval']; ?></p>
                    </div>
                    <?php
                    $idpro = $dts['idpro'];
                } ?>
                <form method="post" class="form-dev my-5" action="controller/cdev.php">
                    <h3>Solicitar Devolución</h3>

                    <input type="hidden" name="idped" value="<?= $dts['idped'] ?>">
                    <input type="hidden" name="idpro" value="<?= $idpro ?>">
                    <input type="hidden" name="monto" value="<?=$dts['precio_pedido']?>">

                    <label>Motivo de la devolución:</label>
                    <textarea name="motivo" required class="form-control" placeholder="Escribe las razones por las cuales quiere devolver el producto"></textarea>

                    <label>Monto a reembolsar:</label>
                    <p>$<?php echo number_format($dts['precio_pedido'], 2, ',', '.') ?></p>

                    <button type="submit">Solicitar devolución</button>
                </form>

            <?php } ?>
        </div>
    </div>
</div>