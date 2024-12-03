<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Devolución</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Sh<span>∞</span>p</div>
        <nav>
            <a href="#">Categoría</a>
            <a href="#">Nosotros</a>
            <a href="#">Ayuda/PQR</a>
            <a href="#">Productos</a>
            <a href="#">Vender</a>
        </nav>
    </header>

    <main>
        <div class="confirmation-box">
            <h1><?= htmlspecialchars($productDetails['name']); ?></h1>
            <p>
                <?= htmlspecialchars($productDetails['status']); ?><br>
                <?= htmlspecialchars($productDetails['refundMessage']); ?>
            </p>
            <div class="check-icon">✔️</div>
            <button onclick="window.history.back();">Volver</button>
        </div>
    </main>

    <footer>ADSO</footer>
</body>
</html>
