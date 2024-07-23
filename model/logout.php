<?php
session_start();
if(session_status() != 2 || $_SESSION['aut'] != "Msjh$5%khdfHSÑjsdh:-."){
    session_destroy();
    header("localhost: index.php");
    exit();
}