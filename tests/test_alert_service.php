<?php

require_once "config/database.php";
require_once "services/AlertService.php";

$db = new Database();
$conn = $db->connect();

$alertService = new AlertService($conn);

/*
Prueba de lectura de sensor
*/

$id_sensor = 1;
$valor = 100;

$resultado = $alertService->processReading($id_sensor,$valor);

print_r($resultado);