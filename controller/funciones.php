<?php
function insertMenu($op = 2, $link1 = "#", $link2 = "#", $link3 = "#", $link4 = "#", $link5 = "#", $link6 = "#", $link7 = "#")
{
    include ("views/vwMenu1.php");
    include ("views/vwMenu2.php");
    include ("views/vwMenu4.php");

    if ($op == 1) {
        include ("views/vwMenu3.php");
        include ("views/vwMenu5.php");
    } else {
        include ("views/vwMenu6.php");
    }
}

function insertText ($title){
    include ("views/vwMrdPrd.php");
}

function urlPrd($ruta, $url1 = "#", $url2 = "#"){
    include ($ruta);
}