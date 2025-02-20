<?php

function insertText ($title, $data, $include){
    if($include == 1) include ("views/vwMrdPrd.php");
    elseif($include == 2) include ("views/vwMorePrdGen.php");
}

function urlPrd($ruta, $url1 = "#", $url2 = "#"){
    include ($ruta);
}