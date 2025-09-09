<?php
echo "IP del servidor: " . $_SERVER['REMOTE_ADDR'] . "\n";
echo "IP según ifconfig: ";
system('curl -s ifconfig.me');
echo "\n";
echo "Headers HTTP:\n";
foreach($_SERVER as $key => $value) {
    if(strpos($key, 'HTTP_') === 0 || strpos($key, 'REMOTE_') === 0) {
        echo "$key: $value\n";
    }
}
?>