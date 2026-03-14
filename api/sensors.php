<?php

require_once "../config/database.php";
require_once "../controllers/SensorController.php";

header("Content-Type: application/json");

$database = new Database();
$db = $database->connect();

$controller = new SensorController($db);

$method = $_SERVER["REQUEST_METHOD"];

$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    case "GET":
        echo json_encode($controller->getSensors());
        break;

    case "POST":
        echo json_encode($controller->createSensor($data));
        break;

    case "PUT":
        echo json_encode($controller->updateLimits($data));
        break;
}
