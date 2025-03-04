<?php require_once "../model/logoutprv.php";
if ($_SESSION['idpef'] != 2)
    header("Location: ../home.php") ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Portal de Administración</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../CSS/admin.css">
    </head>

    <body>
    <?php include "../model/conexion.php";
include "../controller/cadmin.php"; ?>
    <header>
        <div class="row bx-opc-in">
            <div class="col">
                <a href="../views/admin.php">SHOOP S.A</a>
            </div>
            <div class="col">
                <div class="btn-group btn-pf-adm">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?= $_SESSION['nomusu'] ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="vwExit.php">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row bx-wel">
            <div class="col">
                <h1>Hola <?= $_SESSION['nomusu'] ?>,</h1>
                <p>Bienvenid<?php if ($_SESSION['genusu'] == 'M') {
                    echo "o";
                } else if ($_SESSION['genusu'] == 'M') {
                    echo "a";
                } else
                    echo "@" ?> al Portal de Administración</p>
                    </div>
                </div>
            </header>

            <nav class="nav">
                <ul>
            <?php if ($dtImg) {
                    foreach ($dtImg as $dt) { ?>
                    <li>
                        <a href="admin.php?pg=<?= $dt['urlimg'] ?>">
                            <div class="col">
                                <img src="../<?= $dt['imgpro'] ?>" alt="<?= $dt['nomimg'] ?>">
                                <h6><?= $dt['nomimg'] ?></h6>
                            </div>
                        </a>
                    </li>
                <?php }
                } ?>
        </ul>
    </nav>

    <div class="container">
        <?php $pg = isset($_GET['pg']) ? $_GET['pg'] : NULL;
        if ($pg) {
            $rut = getPagAdm($pg);
            if (!$rut) {
                echo "<div class='bx-404'><img src='../IMG/404.svg' alt='404'>
        <p class='msj-404'>Estamos trabajando para volver a estar en línea.</p></div>";
            }
        } else {
            $rut = null; ?>
            <div class="row">
                <section class="tickets col">
                    <h2>PQRs</h2>
                    <section>
                        <div class="ticket">
                            <div class="messages-section">
                                <div class="messages">
                                    <?php if (isset($dtPqr) && $dtPqr) {
                                        foreach ($dtPqr as $dt) { ?>
                                            <a href="#" class="message-box" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                data-id="<?= $dt['idpqr'] ?>" data-nombre="<?= htmlspecialchars($dt['nomusu']) ?>"
                                                data-tipo="<?= htmlspecialchars($dt['tippqr']) ?>"
                                                data-mensaje="<?= htmlspecialchars($dt['mensaje']) ?>"
                                                data-emausu="<?= $dt['emausu'] ?>">
                                                <div class="avatar">
                                                    <?= strtoupper(substr($dt['nomusu'], 0, 1)) ?>
                                                </div>
                                                <div class="message-content">
                                                    <div class="message-header">
                                                        <div class="name"><?= $dt['nomusu'] ?></div>
                                                    </div>
                                                    <p class="message-line">
                                                        <?= strlen($dt['mensaje']) > 20 ? substr($dt['mensaje'], 0, 20) . '...' : $dt['mensaje']; ?>
                                                    </p>
                                                </div>
                                            </a>
                                        <?php }
                                    } else { ?>
                                        <p>Sin PQRs por ahora</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
                <section class="tickets col">
                    <h2>Por Definir</h2>
                    <section>
                        <div class="ticket">
                            <!-- <h3>Apple iPad 7” <span>OPEN</span></h3> -->
                            <p>Pronto estaremos con nuevas funciones</p>
                        </div>
                    </section>
                </section>
                <section class="tickets col">
                    <h2>Por Definir</h2>
                    <section>
                        <div class="ticket">
                            <!-- <h3>Apple iPad 7” <span>OPEN</span></h3> -->
                            <p>Pronto estaremos con nuevas funciones</p>
                        </div>
                    </section>
                </section>
                <!-- <section class="knowledge col">
                <h2>Centro de Conocimiento</h2>
                <ul>
                    <li><a href="#">¿Dónde solicito la verificación de empleado?</a></li>
                    <li><a href="#">¿Cómo configurar el correo en mi dispositivo móvil?</a></li>
                    <li><a href="#">Accediendo a información de pagos</a></li>
                    <li><a href="#">Guía de instalación de aplicaciones de escritorio</a></li>
                </ul>
            </section>

            <section class="contact col">
                <h2>Contáctanos</h2>
                <p>Llame al Service Desk para ayudar con tus solicitudes IT, dudas y problemas.</p>
                <p>Teléfono: 800-444-4444</p>
                <p>Email: helpdesk@company.com</p>
                <button>Chat With Us</button>
            </section> -->
            </div>
        <?php }
        if ($rut) {
            $pg = '../' . $rut[0]['rutpag'];
            include $pg;
        } ?>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <span id="pqrTipo"></span> de <span id="pqrNombre"></span>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-res-pqr" action="../controller/cpqr.php" method="POST">
                            <div class="mb-3">
                                <h6>Mensaje recibido:</h6>
                                <p class="msj-rcb" id="pqrMensajetx" name="pqrMensaje"></p>
                                <input type="hidden" name="pqrMensaje" id="pqrMensaje">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Tu respuesta:</label>
                                <textarea class="form-control" id="message-text" name="respuesta"
                                    placeholder="Escribe la respuesta aquí..."></textarea>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="nomusu" id="pqrNombretx">
                                <input type="hidden" name="acc" value="res">
                                <input type="hidden" name="idpqr" id="idpqr">
                                <input type="hidden" name="emausu" id="emausu">
                                <button type="submit" class="btn btn-primary">Responder</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php include "vwFooter.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/script2.js"></script>
    <script src="../JS/script3.js"></script>
</body>

</html>