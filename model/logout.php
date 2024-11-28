<?php
ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict'); 
session_start();

// Cargar las variables de entorno
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Validar la sesión usando la variable de entorno
if (session_status() !== PHP_SESSION_ACTIVE || !isset($_SESSION['aut']) || $_SESSION['aut'] !== $_ENV['SESSION_SECRET']) {
    session_destroy();
    header("Location: index.php");
    exit();
}
