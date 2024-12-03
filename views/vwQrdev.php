<?php
require_once 'QRController.php';

// Instancia del controlador
$controller = new QRController();
$qrContent = $controller->getQRContent();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Código QR</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <link rel="stylesheet" href="Styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">Shoop</div>
        </div>
    </header>
    <main>
        <div class="container">
            <h1>Nombre Producto</h1>
            <p>Acércate al punto de recolección y muestra este QR.</p>
            <canvas id="qrcode"></canvas>
            <button class="btn">Volver</button>
        </div>
    </main>
    <footer>
        <p>© Adso</p>
    </footer>
    <script>
        // Generar QR dinámicamente
        document.addEventListener("DOMContentLoaded", function () {
            const qrContent = "<?php echo $qrContent; ?>"; // Contenido del QR desde el controlador
            const qrCodeCanvas = document.getElementById("qrcode");

            QRCode.toCanvas(qrCodeCanvas, qrContent, {
                width: 200, 
                margin: 2,
                color: {
                    dark: "#000000",
                    light: "#ffffff"
                },
            });
        });
    </script>
</body>
</html>
