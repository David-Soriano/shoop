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
        <link rel="stylesheet" href="../CSS/admin.css">
    </head>

    <body>
    <?php include "../model/conexion.php";
include "../controller/cadmin.php"; ?>
    <header>
        <div class="row">
            <div class="col">
                <img src="logo.png" alt="Logo">
            </div>
            <div class="col">
                <a href="#"><?= $_SESSION['nomusu'] ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1>Hola <?= $_SESSION['nomusu'] ?>,</h1>
                <p>Bienvenid<?php if ($_SESSION['genusu'] == 'M') {
                    echo "o";
                } else
                    echo "a" ?> al Portal de Administración</p>
                </div>
            </div>
        </header>

        <nav>
            <ul>
            <?php if ($dtImg) {
                    foreach ($dtImg as $dt) { ?>
                    <li>
                        <a href="#">
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
        <div class="row">
            <section class="tickets col">
                <h2>Mis Tickets</h2>
                <section>
                    <div class="ticket">
                        <h3>Apple iPad 7” <span>OPEN</span></h3>
                        <p>Ticket #RE00138305 - 45 mins ago</p>
                    </div>
                    <div class="ticket">
                        <h3>iPhone XR <span>APPROVED</span></h3>
                        <p>Ticket #RE00138305 - 2 days ago</p>
                    </div>
                    <div class="ticket">
                        <h3>Mi laptop no enciende <span>ON HOLD</span></h3>
                        <p>Ticket #RE00138305 - 45 mins ago</p>
                    </div>
                    <div class="ticket">
                        <h3>Macbook Pro 15” <span>APPROVED</span></h3>
                        <p>Ticket #RE00138305 - 45 mins ago</p>
                    </div>
                </section>
            </section>

            <section class="knowledge col">
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
            </section>
        </div>

    </div>
    <footer>
        <p>NEWROCKET © 2024</p>
    </footer>
</body>

</html>