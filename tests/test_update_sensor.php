<?php

$url = "http://localhost/api/sensors.php";

$data = [
    "id_sensor" => 2,
    "limite_min" => 55,
    "limite_max" => 35
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "PUT",
        "content" => json_encode($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo "ACTUALIZAR SENSOR\n";
echo $result . "\n";
