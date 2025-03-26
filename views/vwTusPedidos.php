<?php
include_once("controller/cped.php"); ?>
<div class="container my-5 bx-tusped-gen">
    <div class="p-3 bx-tusped-gen-n2">
        <h2 class="text-center fw-bold">Tus Pedidos</h2>

        <div class="my-3">
            <?php if (!empty($dtpedido)) {
                foreach ($dtpedido as $dtpd) {
                    $fecha = new DateTime($dtpd['fecha']);
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
                    $hora = $fecha->format('H:i:s'); // Hora en formato 24h 
            ?>
                    <div class="card-body bx_tusped">
                        <div class="row bx_tusped-fech">
                            <p><?php echo "$dia de $mes de $año, $hora"; ?></p>
                        </div>
                        <div class="row bx_tusped-dtp">
                            <div class="col-2 bx_tusped-img"><img src="<?= $dtpd['imgpro'] ?>" alt="<?= $dtpd['nompro'] ?>">
                            </div>
                            <div class="col bx-dt-pr-ped">
                                <p class="bx_tusped-est-ped" <?php if ($dtpd['estped'] == "Cancelado") {
                                                                    echo "style='color:red;'";
                                                                } ?>><?= $dtpd['estped'] ?></p>
                                <!-- <p class="bx_tusped-ult-acc">Ultima Acción</p> -->
                                <div class="bx_tusped-inf-nompro">
                                    <p class="bx_tusped-nompro"><?= $dtpd['nompro'] ?></p>
                                    <p class="bx_tusped-nompro"><?= $dtpd['cantidad'] ?> Unidad</p>
                                </div>
                            </div>
                            <div class="col">
                                <p class="bx_tusped-tienda"><?= $dtpd['nomprov'] ?></p>
                            </div>
                            <div class="col bx_tusped-opcs"><a href="home.php?pg=28&idped=<?= $dtpd['idped'] ?>" class="bx_tusped-btn-sg-ev">Seguir
                                    Envío</a></div>
                        </div>
                    </div>
            <?php }
            } else{?>
                <div class="row bx-msj-null">
                    <div class="col">
                        <img src="IMG/Pedidos.svg" alt="">
                        <p>No a realizado ningún pedido</p>
                    </div>
                </div>
                
                <?php insertText("Productos hechos para ti", $dtProdsSuge, 2);
             } ?>

        </div>

    </div>
</div>