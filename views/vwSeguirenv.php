<?php include_once("controller/cped.php");
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
                                <h4 class="fw-bold"><?= $dts['nompro']; ?></h4>
                                <p class="bx-seg-env_catg"><?= $dts['cantidad']; ?> Unidad</p>
                            </div>
                        </div>
                        <?php if ($dts['estped'] == "Recibido") {
                            $fecha = "2025-03-26 09:55:02";
                            $fecha_formateada = date("d F", strtotime($fecha));

                            // Convertir el mes a español
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

                            $fecha_formateada = str_replace(array_keys($meses), array_values($meses), $fecha_formateada);

                            // Agregar "de" correctamente
                            echo "<p>Recibiste la compra el día " . str_replace(" ", " de ", $fecha_formateada) . "</p>";

                        }
                }
                // Array con los estados posibles
                $estados = ["Aprobado", "Enviado", "En Tránsito", "En Reparto", "Recibido"];
                ?>
                    <div class="d-flex align-items-center mt-5 bx-dot">
                        <?php foreach ($estados as $estado) {

                            if ($dts['estped'] != "Pendiente Reembolso" and $dts['estped'] != "Devuelto") {
                                if ($dts['estped'] != "Cancelado") {
                                    $activeClass = ($dts['estped'] == $estado) ? 'dot-active' : '';
                                    if ($dts['estped'] == 'Pendiente Reembolso') {
                                        echo "<p>El pedido esta pendiente de reembolso</p>";
                                        break;
                                    } else {
                                        ?>
                                        <div class="me-3 text-center">
                                            <span class="dot <?= $activeClass; ?>"></span>
                                            <p class="small"><?= $estado; ?></p>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<p>El pedido fue CANCELADO</p>";
                                    break;
                                }
                            } else {
                                echo "<p>El pedido esta en proceso de reembolso o ya se a devuelto</p>";
                                break;
                            }
                        } ?>
                    </div>
                </div>
                <?php foreach ($dtSegEnv as $dts) { ?>
                    <div class="col bx-seg-env_img">
                        <img src="<?= $dts['imgpro']; ?>" alt="<?= $dts['nomimg']; ?>" class="img-thumbnail img-sg-env">
                        <p class="bx-seg-env_catg"><?= $dts['nomval']; ?></p>
                    </div>
                    <?php $estado = $dts['estped'];
                    $idpro = $dts['idpro'];
                } ?>
                <div class="d-flex justify-content-between align-items-center mt-5 mt-sm-3">
                    <a href="#" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">Detalles</a>
                    <?php //foreach ($dtSegEnv as $dts) {
                    
                        if ($estado != "En Tránsito" && $estado != "En Reparto" && $estado != "Recibido" && $estado != "Pendiente Reembolso" && $estado != "Devuelto" && $estado != "Cancelado") { ?>
                        <a href="#" class="btn btn-link" id="btn-can-ped" data-idped="<?= $dts['idped'] ?>"
                        data-idprov="<?= $dts['idprov'] ?>">Cancelar pedido</a>
                    <?php }
                        if ($dts['estped'] == "En Reparto") { ?>
                        <a href="#" class="btn btn-outline-success" id="btn-rec-ped" data-idped="<?= $dts['idped'] ?>"
                            data-idprov="<?= $dts['idprov'] ?>">Recibido</a>
                    <?php }
                        if ($estado == "Recibido") { ?>
                        <a href="home.php?pg=38&idped=<?= $idped ?>">Devolver</a>
                        <a href="home.php?pg=37&idpro=<?= $idpro ?>" class="btn btn-outline-success">Calificar</a>
                    <?php }
                        //} ?>
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
                        $fechaMostrada = false; // Variable para evitar repetir la fecha
                        $totalCompra = 0; // Acumulador del total de la compra
                    
                        foreach ($dtSegEnv as $dts) {
                            if (!$fechaMostrada) {
                                // Mostrar la fecha solo una vez
                                $fecha = new DateTime($dts['fecha']);
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
                                $dia = $fecha->format('j');
                                $mes = $meses[$fecha->format('F')];
                                $año = $fecha->format('Y');
                                $hora = $fecha->format('H:i:s');
                                echo "<p>$dia de $mes de $año, $hora</p>";
                                $fechaMostrada = true; // Para que no vuelva a mostrarse
                            }

                            // Acumular el total
                            $totalCompra += $dts['precio_final'];
                            ?>

                            <div class="row">
                                <div class="col">
                                    <p>Producto: <strong><?= $dts['nompro']; ?></strong></p>
                                    <p>Precio: <strong>$<?= number_format($dts['precio_final'], 2); ?></strong></p>
                                    <p>Descuento: <strong
                                            class="vl-green">$<?= number_format($dts['valor_descuento'], 2); ?></strong></p>
                                    <p>Envío: <strong class="vl-green">Gratis</strong></p>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="row">
                            <div class="col">
                                <p>Pago:</p>
                            </div>
                            <div class="col">
                                <p><?= $dts['npago']; ?></p>
                                <p><?= $dts['mpago']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>Total Compra:</strong></p>
                            </div>
                            <div class="col">
                                <p><strong>$<?= number_format($totalCompra, 2); ?></strong></p>
                            </div>
                        </div>
                    <?php } ?>
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
            $cantp = $dtsd['total_productos'];
            if ($dtsd['estped'] == "Recibido") { ?>
                <div class="row bx-seg-env-minf">
                    <div class="col bx-seg-dt bx-seg-env-minf_help bx-seg-env-minf_inf-comp">
                        <h4>Información de la Compra</h4>
                        <div class="row">
                            <div class="col-1 bx-seg-env-minf_inf-comp-ico"><i class="bi bi-receipt"></i></div>
                            <div class="col-11 bx-seg-env-minf_inf-comp-des">
                                <p><?= $dtsd['nompro'] ?></p><a href="views/vwFactura.php?idped=<?= $dtsd['idped'] ?>">Descargar
                                    Factura</a>
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

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><span><?= $cantp ?></span> Producto(s) En Tu Compra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach ($dtSegEnv as $dt) { ?>
                    <a href="home.php?pg=001&idpro=<?= $dt['idpro'] ?>" class="bx-dtp">
                        <div class="row">
                            <div class="col-2 bx-dtp-image">
                                <img src="<?= $dt['imgpro'] ?>" alt="<?= $dt['nompro'] ?>">
                            </div>
                            <div class="col">
                                <p class="p-dtp-nmp"><?= $dt['nompro'] ?></p>
                                <p class="p-dtp-und"><?= $dt['cantidad'] ?> Unidad</p>
                            </div>
                            <div class="col-1">
                                <i class="bi bi-chevron-compact-right"></i>
                            </div>
                        </div>
                    </a>
                <?php } ?>

            </div>
        </div>
    </div>