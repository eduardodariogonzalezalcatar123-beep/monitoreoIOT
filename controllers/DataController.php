<?php

require_once __DIR__ . '/../services/AlertService.php';

class DataController {

    private $alertService;

    public function __construct($db)
    {
        $this->alertService = new AlertService($db);
    }

    public function receiveData($data)
    {

        if (!isset($data["sensores"])) {
            return [
                "status" => "error",
                "message" => "No sensors provided"
            ];
        }

        $results = [];

        foreach ($data["sensores"] as $sensor) {

            if(!isset($sensor["id_sensor"]) || !isset($sensor["valor"])){
                continue;
            }

            $id_sensor = $sensor["id_sensor"];
            $valor = $sensor["valor"];

            $result = $this->alertService->processReading($id_sensor, $valor);

            $results[] = $result;
        }

        return [
            "status" => "ok",
            "processed" => count($results),
            "results" => $results
        ];
    }
}
