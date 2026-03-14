<?php

require_once "../config/database.php";
require_once "../controllers/MonitoringController.php";

header("Content-Type: application/json");

$database = new Database();
$db = $database->connect();

$controller = new MonitoringController($db);

$result = $controller->getDashboard();

echo json_encode($result);
