<?php
include "model/mpro.php";

$mpro = new Mpro();

$productos = $mpro->getAll();