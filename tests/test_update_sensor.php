<?php

$url = "http://localhost/api/sensors.php";

$data = [
    "id_sensor" => 1,
    "limite_min" => 60,
    "limite_max" => 30
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
