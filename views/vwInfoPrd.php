<div class="container d-flex justify-content-center align-items-center flex-column bx-inituser">
    <?PHP 
    include_once "controller/crev.php";
    include "views/vwPrdPart.php";
    // echo urlPrd("views/vwPrdPart.php", "index.php?pg=9", "index.php?pg=1015");
    insertText("Algunos Productos Similares", $dtProdSugeCatego, 1);
    require_once ("vwCarPrd.php");
    require_once ("vwDesPrd.php");
    mostrarReviews($idpro)?>

</div>
