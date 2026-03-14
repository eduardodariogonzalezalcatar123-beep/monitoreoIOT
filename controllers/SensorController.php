<?php

require_once __DIR__ . '/../models/Sensor.php';

class SensorController {

    private $sensor;

    public function __construct($db)
    {
        $this->sensor = new Sensor($db);
    }

    public function getSensors()
    {
        return $this->sensor->getAll();
    }

    public function getSensor($id)
    {
        return $this->sensor->getById($id);
    }

    public function createSensor($data)
    {
        return $this->sensor->create($data);
    }

    public function updateLimits($data)
    {
        return $this->sensor->updateLimits(
            $data["id_sensor"],
            $data["limite_min"],
            $data["limite_max"]
        );
    }
}
