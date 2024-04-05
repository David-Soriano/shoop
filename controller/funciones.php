<?php
function insertMenu($op = 2)
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

function insertMenu2()
{
    include ("views/vwMenu2-2.php");
    include ("views/vwMenu3-3.php");
    include ("views/vwMenu6.php");
    // include ("views/vwMenu4.php");

    // if ($op == 1) {
    //     include ("views/vwMenu3.php");
    //     include ("views/vwMenu5.php");
    // } else {
    //     include ("views/vwMenu6.php");
    // }
}