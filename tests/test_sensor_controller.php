<?php

$base_url = "http://localhost/api/sensors.php";


$data_create = [
    "id_esclavo" => 1,
    "tipo" => "temperatura",
    "nombre" => "sensor_prueba",
    "limite_min" => 20,
    "limite_max" => 30
];


$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "POST",
        "content" => json_encode($data_create)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($base_url, false, $context);

echo "CREAR SENSOR:\n";
echo $result . "\n\n";



$result = file_get_contents($base_url);

echo "LISTAR SENSORES:\n";
echo $result . "\n\n";



$data_update = [
    "id_sensor" => 1,
    "limite_min" => 40,
    "limite_max" => 70
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "PUT",
        "content" => json_encode($data_update)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($base_url, false, $context);

echo "ACTUALIZAR LIMITES:\n";
echo $result . "\n";
