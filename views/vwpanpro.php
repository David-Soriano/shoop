<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/stylepancon.css">
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <title>Panel de control</title>
</head>

<body>
  <div class="div">
    <div class="sidebar">
      <button type="button" class="btn btn-danger"><a href="../home.php">Volver</a></button>
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
          <a class="nav-link text-black" href="vwpanpro.php?vw=001">Lista de Inventarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-black" href="vwpanpro.php?vw=002">Añadir Nuevos Articulos</a>
        </li>
      </ul>
    </div>
  </div>
  <!-- Content -->

</body>

</html>
<!-- Bootstrap scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$vw = isset($_GET["vw"]) ? $_GET["vw"] : NULL;
$excluirVistas = array("001", "002", "003", "004");
if (!in_array($vw, $excluirVistas)) {
  include ("vwDefPan.php");
}
?>

<?php
if ($vw == "001") {
  require_once ("../views/vwTable.php");
} else if ($vw == "002") {
  require_once ("../views/vwven.php");
} else if ($vw == "003") {
  require_once ("../views/vwlispro.php");
} else if ($vw == "004") {
  require_once ("../views/vwDetPed.php");
}
?>