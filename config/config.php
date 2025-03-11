<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USER', 'davidscicua314@gmail.com');
define('MAIL_PASS', 'eajy mxph noiy wliy'); // Considera usar variables de entorno para mayor seguridad
define('MAIL_PORT', 587);
define('MAIL_FROM_NAME', 'Juan David Soriano');

define('MAIL_FROM', MAIL_USER);


