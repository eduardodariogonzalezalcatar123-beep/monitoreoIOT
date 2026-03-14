<?php

require_once "../config/database.php";
require_once "../controllers/DataController.php";

header("Content-Type: application/json");

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode([
        "status" => "error",
        "message" => "No se recibieron datos"
    ]);
    exit;
}

$controller = new DataController($db);

$result = $controller->receiveData($data);

echo json_encode($result);
