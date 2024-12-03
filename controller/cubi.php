<?php
include "../model/mubi.php";

$mubi = new Mubi();
$dat = $mubi->getAll();
$dtDtp = $mubi->getDep(0);