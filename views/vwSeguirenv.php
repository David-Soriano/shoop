<?php include_once("controller/cped.php");
$idped = isset($_REQUEST['idped']) ? $_REQUEST['idped'] : NULL;
$dtSegEnv = segEnv($idped);

?>
<div class="container my-5 bx-tusped-gen">
    <div class="p-4 bx-tusped-gen-n2">

        <div class="mb-4 bx-seg-env row">
            <div class="col-8 bx-seg-env_estados"><?php if ($dtSegEnv) {
                foreach ($dtSegEnv as $dts) { ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold"><?= $dts['nompro']; ?></h4>
                                <p class="bx-seg-env_catg"><?= $dts['cantidad']; ?> Unidad</p>
                            </div>
                        </div>
                        <?php if ($dts['estped'] == "Recibido") {
                            echo "<p>Recibiste la compra el día 1 de Enero</p>";
                        }
                }
                // Array con los estados posibles
                $estados = ["Aprobado", "Enviado", "En Tránsito", "En Reparto", "Recibido"];
                ?>
                    <div class="d-flex align-items-center mt-2">
                        <?php foreach ($estados as $estado) {
                            if ($dts['estped'] != "Cancelado") {
                                $activeClass = ($dts['estped'] == $estado) ? 'dot-active' : '';
                                ?>
                                <div class="me-3 text-center">
                                    <span class="dot <?= $activeClass; ?>"></span>
                                    <p class="small"><?= $estado; ?></p>
                                </div>
                            <?php } else {
                                echo "<p>El pedido fue CANCELADO</p>";
                                break;
                            }
                        } ?>
                    </div>
                </div>
                <div class="col bx-seg-env_img">
                    <img src="<?= $dts['imgpro']; ?>" alt="<?= $dts['nomimg']; ?>" class="img-thumbnail img-sg-env">
                    <p class="bx-seg-env_catg"><?= $dts['nomval']; ?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="#" class="btn btn-outline-danger">Detalles</a>
                    <?php foreach ($dtSegEnv as $dts) {
                        if ($dts['estped'] != "Recibido" && $dts['estped'] != "Cancelado") { ?>
                            <?php if ($dts['estped'] != "En Tránsito" && $dts['estped'] != "En Reparto" && $dts['estped'] != "Recibido") { ?>
                                <a href="#" class="btn btn-link">Cancelar pedido</a>
                            <?php } ?>
                            <?php if ($dts['estped'] == "En Reparto") { ?>
                                <a href="#" class="btn btn-outline-success" id="btn-rec-ped" data-idped="<?=$dts['idped']?>">Recibido</a>
                            <?php } ?>
                        <?php }
                    } ?>

                </div>
            <?php } ?>
        </div>
        <div class="row bx-seg-env-minf">
            <div class="col bx-seg-dt bx-seg-env-minf_det-com">
                <div>
                    <h4>Detalles de Compra</h4>
                </div>
                <div class="bx-seg-dt_fech">
                    <?php if ($dtSegEnv) {
                        foreach ($dtSegEnv as $dtsd) {
                            $fecha = new DateTime($dtsd['fecha']);
                            $meses = [
                                "January" => "enero",
                                "February" => "febrero",
                                "March" => "marzo",
                                "April" => "abril",
                                "May" => "mayo",
                                "June" => "junio",
                                "July" => "julio",
                                "August" => "agosto",
                                "September" => "septiembre",
                                "October" => "octubre",
                                "November" => "noviembre",
                                "December" => "diciembre"
                            ];

                            $dia = $fecha->format('j'); // Día sin ceros iniciales
                            $mes = $meses[$fecha->format('F')]; // Nombre del mes en español
                            $año = $fecha->format('Y'); // Año
                            $hora = $fecha->format('H:i:s'); // Hora en formato 24h ?>
                            <p><?php echo "$dia de $mes de $año, $hora"; ?></p>

                            <div class="row">
                                <div class="col">
                                    <p>Producto:</p>
                                    <p>Descuento:</p>
                                    <p>Envío:</p>
                                </div>
                                <div class="col">
                                    <p>$<?= $dts['total']; ?></p>
                                    <p class="vl-green">$<?= $dts['valor_descuento']; ?></p>
                                    <p class="vl-green">Gratis</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>Pago:</p>
                                </div>
                                <div class="col">
                                    <p>
                                        <?= $dts['npago']; ?>
                                    </p>
                                    <p><?= $dts['mpago']; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>Total:</p>
                                </div>
                                <div class="col">
                                    <p>$<?= $dts['total']; ?></p>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="col bx-seg-dt bx-seg-env-minf_help">
                <h4>Ayuda con la Compra</h4>
                <div class="row">
                    <ul>
                        <li><a href="">Opinar sobre el producto</a></li>
                        <li><a href="">Tengo un problema con el pedido</a></li>
                        <li><a href="">Quiero devolver el pedido</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php foreach ($dtSegEnv as $dtsd) {
            if ($dtsd['estped'] == "Recibido") { ?>
                <div class="row bx-seg-env-minf">
                    <div class="col bx-seg-dt bx-seg-env-minf_help bx-seg-env-minf_inf-comp">
                        <h4>Información de la Compra</h4>
                        <div class="row">
                            <div class="col-1 bx-seg-env-minf_inf-comp-ico"><i class="bi bi-receipt"></i></div>
                            <div class="col-11 bx-seg-env-minf_inf-comp-des">
                                <p><?= $dtsd['nompro'] ?></p><a href="#">Descargar Factura</a>
                            </div>
                        </div>
                    </div>

                    <div class="col bx-seg-dt bx-seg-env-minf_help bx-seg-env-minf_Tienda">
                        <h4>Información de la Tienda</h4>
                        <div>
                            <p><?= $dtsd['nomprov'] ?></p>
                            <p class="bx-seg-dt_fech"><?= $dtsd['desprv'] ?></p>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
</div>