<?php include "../model/logoutprv.php";
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", "C:/xampp\htdocs/SHOOP/errors/error_log.log"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../CSS/stylepancon.css">
  <link rel="shortcut icon" href="../IMG/lg_vendedores.png" type="image/x-icon">
  <title>Vendedores</title>
</head>

<body>
  <?php
  require_once("../controller/cpancon.php");
  require_once("../controller/cpagprv.php");

  if (!$idProveedor) {
    header("Location:vwRegPrv.php");
    exit();
  }

  $dtProvData = getDtProv($_SESSION['idprov']);
  $dtProv = $dtProvData[0]; ?>
  <header>
    <div class="row bx-opc-in">
      <div class="col">
        <a href="../views/admin.php">SHOOP S.A</a>
      </div>
      <div class="col">
        <div class="btn-group btn-pf-adm">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <?= $dtProv['nomprov'] ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="vwpanpro.php?vw=36">Perfil</a></li>
            <li><a class="dropdown-item" href="vwExit.php">Cerrar Sesión</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row bx-wel">
      <div class="col">
        <h1>Hola <?= $dtProv['nomprov'] ?>,</h1>
        <?php if (isset($_REQUEST['isn']) && $_REQUEST['isn'] == 1) { ?>
          <h6>Estas de vuelta</h6>
        <?php } ?>
        <p>Bienvenid<?php if ($_SESSION['genusu'] == 'M') {
          echo "o";
        } else if ($_SESSION['genusu'] == 'M') {
          echo "a";
        } else
          echo "@" ?> al Portal de Vendedores</p>
          </div>
          <p>Saldo: $<?= number_format($saldo['saldo'], 2, ",", "."); ?></p>
    </div>
  </header>
  <main>
    <div class="container-fluid">
      <div class="row bx-prc">
        <div class="bx-slider col-2">
          <h5>Ordenes</h5>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=25">Listado de Pedidos</a>
            </li>
          </ul>
          <h5>Inventario</h5>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=23">Almacén</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=24">Añadir Nuevos Articulos</a>
            </li>
          </ul>
          <h5>PQRs</h5>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-black" href="vwpanpro.php?vw=27">PQRs</a>
            </li>
          </ul>
        </div>
        <div class="bx-apartados col-9">
          <?php
          $vw = isset($_GET["vw"]) ? $_GET["vw"] : NULL;

          if ($vw)
            $rut = getRutPrv($vw);
          else
            $rut = getRutPrv(26);
          if ($rut) {
            $pg = "../" . $rut[0]['rutpag'];
            include $pg;
          } else
            include("../views/vwDefPan.php");
          ?>
        </div>
      </div>
    </div>
  </main>
  <?php include("vwFooter.php") ?>

  <!-- Bootstrap scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../JS/script2.js"></script>
</body>

</html>