<?php

$url = "http://localhost/api/sensors.php";

$result = file_get_contents($url);

echo "LISTA DE SENSORES\n";
echo $result . "\n";
