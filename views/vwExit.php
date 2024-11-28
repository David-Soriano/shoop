<?php ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict'); 
session_start();
session_destroy();
echo "<script type='text/javascript'>window.location='../index.php';</script>";
exit();