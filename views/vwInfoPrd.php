<div class="container d-flex justify-content-center align-items-center flex-column bx-inituser">
    <?PHP 
    include "views/vwPrdPart.php";
    // echo urlPrd("views/vwPrdPart.php", "index.php?pg=9", "index.php?pg=1015");
    insertText("Algunos Productos Similares", $dtProdSugeCatego, 1) ?>
    <?PHP require_once ("vwCarPrd.php")?>
    <?PHP require_once ("vwDesPrd.php")?>
</div>
