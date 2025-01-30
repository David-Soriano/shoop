<?php
$logFile = 'shoop/errors/debug_log.log';
$mensaje = date('Y-m-d H:i:s') . " - Error en PayU: " . json_encode($_POST) . "\n";
file_put_contents($logFile, $mensaje, FILE_APPEND);
echo "OK";
?>