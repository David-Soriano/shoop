<?php
session_start();

if (session_status() != PHP_SESSION_ACTIVE || !isset($_SESSION['aut']) || $_SESSION['aut'] != "Msjh$5%khdfHSÑjsdh:-.") {
    session_destroy();
    header("Location: ../index.php");
    exit();
}