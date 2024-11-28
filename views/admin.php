<?php require_once "../model/logoutprv.php"; 
if($_SESSION['idpef'] != 2) header("Location: ../home.php")?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de IT</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <h1>Hola <?= $_SESSION['nomusu'] ?>,</h1>
        <p>Bienvenid<?php if ($_SESSION['genusu'] == 'M') {
            echo "o";
        } else
            echo "a" ?> al Portal de Administración</p>
        </header>

        <nav>
            <ul>
                <li><a href="#">Hardware</a></li>
                <li><a href="#">Software</a></li>
                <li><a href="#">Office</a></li>
                <li><a href="#">Peripherals</a></li>
                <li><a href="#">Security Requests</a></li>
                <li><a href="#">Benefits</a></li>
            </ul>
        </nav>

        <section class="tickets">
            <h2>Mis Tickets</h2>
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

        <section class="knowledge">
            <h2>Centro de Conocimiento</h2>
            <ul>
                <li><a href="#">¿Dónde solicito la verificación de empleado?</a></li>
                <li><a href="#">¿Cómo configurar el correo en mi dispositivo móvil?</a></li>
                <li><a href="#">Accediendo a información de pagos</a></li>
                <li><a href="#">Guía de instalación de aplicaciones de escritorio</a></li>
            </ul>
        </section>

        <section class="contact">
            <h2>Contáctanos</h2>
            <p>Llame al Service Desk para ayudar con tus solicitudes IT, dudas y problemas.</p>
            <p>Teléfono: 800-444-4444</p>
            <p>Email: helpdesk@company.com</p>
            <button>Chat With Us</button>
        </section>

        <footer>
            <p>NEWROCKET © 2024</p>
        </footer>
    </body>

    </html>

    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            /* Fondo blanco para todo el cuerpo */
            color: #333;
        }

        /* Header */
        header {
            text-align: center;
            padding: 40px 20px;
            background: rgb(225, 75, 47);
            background: linear-gradient(112deg, rgba(225, 75, 47, 1) 0%, rgba(233, 105, 74, 1) 23%, rgba(240, 134, 100, 1) 64%, rgba(248, 164, 127, 1) 84%, rgba(255, 255, 255, 1) 100%);
            color: #fff;
        }

        header h1 {
            font-size: 2.5rem;
        }

        header p {
            font-size: 1rem;
            margin-top: 10px;
        }

        /* Logo */
        .logo img {
            max-width: 150px;
        }

        /* Navbar */
        nav {
            background-color: #fff;
            padding: 15px 0;
            text-align: center;
        }

        nav ul {
            list-style: none;
        }

        nav ul li {
            display: inline-block;
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #ff2e5b;
            color: #fff;
        }

        /* Sección de Tickets */
        .tickets {
            margin: 30px 20px;
        }

        .tickets h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .ticket {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .ticket h3 {
            font-size: 1.25rem;
            display: inline-block;
        }

        .ticket span {
            font-size: 1rem;
            color: #ff2e5b;
            font-weight: bold;
            margin-left: 10px;
        }

        .ticket p {
            font-size: 0.875rem;
            color: #777;
        }

        /* Sección de Centro de Conocimiento */
        .knowledge {
            margin: 30px 20px;
        }

        .knowledge h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .knowledge ul {
            list-style: none;
        }

        .knowledge ul li {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .knowledge ul li a {
            text-decoration: none;
            color: #00b1c7;
            font-weight: bold;
        }

        .knowledge ul li a:hover {
            color: #ff2e5b;
        }

        /* Sección de Contacto */
        .contact {
            margin: 30px 20px;
        }

        .contact h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .contact p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .contact button {
            padding: 10px 20px;
            background-color: #00b1c7;
            color: #fff;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .contact button:hover {
            background-color: #ff2e5b;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            color: #333;
        }
    </style>