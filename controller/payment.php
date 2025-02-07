<?php
include 'config.php';
session_start();

// Recibir y decodificar productos
$productosJson = $_REQUEST['product'] ?? '';
$ubicacionJson = $_REQUEST['ubicacion'] ?? '';
// $productos = json_decode($productosJson, true);
// $ubicacion = json_decode($ubicacionJson, true);
// Validaciones básicas
if (!isset($_POST['amount'], $_POST['descripcion'])) {
    die("Error: Falta información de pago.");
}

$amount = number_format((float) $_POST['amount'], 2, '.', ''); // Asegurar formato decimal correcto
$descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8');
$referenceCode = uniqid('order_');

// Generar firma de PayU
$signatureString = PAYU_API_KEY . "~" . PAYU_MERCHANT_ID . "~" . $referenceCode . "~" . $amount . "~" . PAYU_CURRENCY;
$signature = md5($signatureString);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Pago...</title>
</head>

<body>
    <h2>Redirigiendo al portal de pagos...</h2>
    <form id="payu-form" method="POST" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu">
        <input type="hidden" name="merchantId" value="<?= PAYU_MERCHANT_ID; ?>">
        <input type="hidden" name="accountId" value="<?= PAYU_ACCOUNT_ID; ?>">
        <input type="hidden" name="description" value="<?= $descripcion ?>">
        <input type="hidden" name="referenceCode" value="<?= $referenceCode; ?>">
        <input type="hidden" name="amount" value="<?= $amount; ?>">
        <input name="tax" type="hidden" value="0">
        <input name="taxReturnBase" type="hidden" value="0">
        <input type="hidden" name="currency" value="<?= PAYU_CURRENCY; ?>">
        <input type="hidden" name="signature" value="<?= $signature; ?>">
        <input type="hidden" name="test" value="<?= PAYU_TEST_MODE; ?>">
        <input name="buyerEmail" type="hidden" value="<?= $_SESSION['emausu'] ?>">
        <input type="hidden" name="responseUrl" value="<?= PAYU_RESPONSE_URL; ?>">
        <input type="hidden" name="confirmationUrl" value="<?= PAYU_CONFIRMATION_URL; ?>">
        <input type="hidden" name="extra1" value='<?= htmlspecialchars($productosJson, ENT_QUOTES, 'UTF-8'); ?>'>
        <input type="hidden" name="extra2" value='<?= htmlspecialchars($ubicacionJson, ENT_QUOTES, 'UTF-8'); ?>'>
    </form>

    <script>
        setTimeout(function () {
            document.getElementById("payu-form").submit();
        }, 2000); // Retraso de 2 segundos antes del envío
    </script>
</body>

</html>