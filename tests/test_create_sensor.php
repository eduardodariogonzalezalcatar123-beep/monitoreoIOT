<?php

$url = "http://localhost/api/sensors.php";

$data = [
    "id_esclavo" => 1,
    "tipo" => "temperatura",
    "nombre" => "sensor_test",
    "limite_min" => 20,
    "limite_max" => 30
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "POST",
        "content" => json_encode($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo "CREAR SENSOR\n";
echo $result . "\n";
