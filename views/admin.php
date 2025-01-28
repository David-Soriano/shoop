<?php require_once "../model/logoutprv.php";
if ($_SESSION['idpef'] != 2)
    header("Location: ../home.php") ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Portal de IT</title>
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
        if ($pg)
            $rut = getPagAdm($pg);
        else {
            $rut = null; ?>
            <div class="row">
                <section class="tickets col">
                    <h2>PQRs</h2>
                    <section>
                        <div class="ticket">
                            <div class="messages-section">
                                <div class="messages">
                                    <div class="message-box">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80"
                                            alt="profile image">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="name">Stephanie</div>
                                                <div class="star-checkbox">
                                                    <input type="checkbox" id="star-1">
                                                    <label for="star-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-star">
                                                            <polygon
                                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                            <p class="message-line">
                                                I got your first assignment. It was quite good. 🥳 We can continue with the
                                                next assignment.
                                            </p>
                                            <p class="message-line time">
                                                Dec, 12
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-box">
                                        <img src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80"
                                            alt="profile image">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="name">Mark</div>
                                                <div class="star-checkbox">
                                                    <input type="checkbox" id="star-2">
                                                    <label for="star-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-star">
                                                            <polygon
                                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                            <p class="message-line">
                                                Hey, can tell me about progress of project? I'm waiting for your response.
                                            </p>
                                            <p class="message-line time">
                                                Dec, 12
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-box">
                                        <img src="https://images.unsplash.com/photo-1543965170-4c01a586684e?ixid=MXwxMjA3fDB8MHxzZWFyY2h8NDZ8fG1hbnxlbnwwfDB8MHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                                            alt="profile image">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="name">David</div>
                                                <div class="star-checkbox">
                                                    <input type="checkbox" id="star-3">
                                                    <label for="star-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-star">
                                                            <polygon
                                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                            <p class="message-line">
                                                Awesome! 🤩 I like it. We can schedule a meeting for the next one.
                                            </p>
                                            <p class="message-line time">
                                                Dec, 12
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-box">
                                        <img src="https://images.unsplash.com/photo-1533993192821-2cce3a8267d1?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MTl8fHdvbWFuJTIwbW9kZXJufGVufDB8fDB8&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                                            alt="profile image">
                                        <div class="message-content">
                                            <div class="message-header">
                                                <div class="name">Jessica</div>
                                                <div class="star-checkbox">
                                                    <input type="checkbox" id="star-4">
                                                    <label for="star-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-star">
                                                            <polygon
                                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                            <p class="message-line">
                                                I am really impressed! Can't wait to see the final result.
                                            </p>
                                            <p class="message-line time">
                                                Dec, 11
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>Sin PQRs por ahora</p>
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

    </div>
    <?php include "vwFooter.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/script2.js"></script>
    <script src="../JS/script3.js"></script>
</body>

</html>