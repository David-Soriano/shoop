<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USER', 'toshoop2024@gmail.com');
define('MAIL_PASS', 'xahguccxsmlyhrka'); // Considera usar variables de entorno para mayor seguridad
define('MAIL_PORT', 587);
define('MAIL_FROM_NAME', 'Soporte SHOOP');

define('MAIL_FROM', MAIL_USER);


