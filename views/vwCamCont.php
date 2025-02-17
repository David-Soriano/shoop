<?php
require_once '../model/conexion.php';

if (isset($_GET['token'])) {

    $model = new Conexion();
    $db = $model->getConexion();

    $token = $_GET['token'];
    $query = "SELECT idusu FROM usuario WHERE token_recuperacion = :token AND token_expira > NOW()";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si se encuentra el usuario
    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $idUsuario = $usuario['idusu'];
    } else {
        echo "El token no es válido o ha expirado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styleLogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Nueva Contraseña</title>
</head>

<body>
    <div class="section">
        <div class="container">
            <div class="container bx-rec-con">
                <div class="row d-flex justify-content-center">
                    <div class="rec-con col-5" id="bx-rec-corr">
                        <h3>Recuperar Contraseña</h3>
                        <form id="cambiar-form" class="d-flex flex-column">
                            <input type="hidden" id="idUsuario" value="<?php echo $idUsuario; ?>">
                            <label for="ncontrasena">Contraseña Nueva</label>
                            <input type="password" name="contrasena" id="ncontrasena" required>
                            <label for="ncontrasena2">Confirma Contraseña</label>
                            <input type="password" name="contrasena2" id="ncontrasena2" required>
                            <input type="submit" class="inp-link" value="Confirmar">
                        </form>
                        <p id="mensaje"></p>
                        <a href="vwLogin.php"><input type="button" value="Iniciar Sesión" class="inp-link" id="btn-vol1"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    document.getElementById("cambiar-form").addEventListener("submit", function (event) {
        event.preventDefault();
        let idUsuario = document.getElementById("idUsuario").value;
        let contrasena = document.getElementById("ncontrasena").value;
        let contrasena2 = document.getElementById("ncontrasena2").value;

        if (contrasena !== contrasena2) {
            document.getElementById("mensaje").innerText = "Las contraseñas no coinciden.";
            return;
        }

        fetch('../controller/recuperarController.php', {
            method: "POST",
            body: new URLSearchParams({ idUsuario: idUsuario, contrasena: contrasena }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById("mensaje").innerText = data.message;
            })
            .catch(error => console.error('Error:', error));
    });
</script>