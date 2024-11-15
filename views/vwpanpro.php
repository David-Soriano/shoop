<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../CSS/stylepancon.css">
  <title>Panel de control</title>
</head>

<body>
  <header>
    <a href="#"><img src="../IMG/LogoAnimado.gif" alt=""></a>
    <div>
      <h2>Panel de Control</h2>
    </div>
    <div>
      <i class="bi bi-person-circle"></i>
    </div>
  </header>
  <main>
    <div class="container-fluid">
      <div class="row bx-prc">
        <div class="bx-slider col-2">
          <h5>Ordenes</h5>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=003">Listado de Pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=004">Detalle de Pedidos</a>
            </li>
          </ul>
          <h5>Inventario</h5>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=001">Almacén</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=002">Añadir Nuevos Articulos</a>
            </li>
          </ul>
        </div>
        <div class="bx-apartados col-9">
          <?php
          $vw = isset($_GET["vw"]) ? $_GET["vw"] : NULL;
          $excluirVistas = array("001", "002", "003", "004");
          if (!in_array($vw, $excluirVistas)) {
            include("vwDefPan.php");
          }
          ?>

          <?php
          if ($vw == "001") {
            require_once("../views/vwTable.php");
          } else if ($vw == "002") {
            require_once("../views/vwven.php");
          } else if ($vw == "003") {
            require_once("../views/vwListPed.php");
          } else if ($vw == "004") {
            require_once("../views/vwDetPed.php");
          }
          ?>
        </div>
      </div>
    </div>
  </main>
  <?php include("vwFooter.php") ?>

  <!-- Bootstrap scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="../JS/script2.js"></script>
</body>

</html>