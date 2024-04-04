<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../CSS/styleConfig.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cuentas y Configuración - G.I.L Technology</title>

</head>
<body>
    <div class="logo">
        <img src="../IMG/Logo.png" alt="">
    </div>
  <div class="container">
    <h1>Cuentas y Configuración - G.I.L Technology</h1>
    
    <div class="account-section">
      <h2>Mi Cuenta</h2>
      <p>Aquí puedes gestionar tu cuenta y configurar tus preferencias.</p>
      
      <h3>Información de la Cuenta</h3>
      <p>Nombre de Usuario: juan1234</p>
      <p>Correo Electrónico: juandedios@gmail.com</p>
      
      <h3>Cambiar Contraseña</h3>
      <form class="settings-form">
        <label for="current-password">Contraseña Actual:</label>
        <input type="password" id="current-password" name="current-password" required>
        <label for="new-password">Nueva Contraseña:</label>
        <input type="password" id="new-password" name="new-password" required>
        <label for="confirm-password">Confirmar Nueva Contraseña:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        <input type="submit" value="Guardar Cambios">
      </form>
    </div>
  </div>
</body>
</html>
