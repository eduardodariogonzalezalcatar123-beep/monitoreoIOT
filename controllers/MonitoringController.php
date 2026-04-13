<?php

require_once __DIR__ . '/../services/MonitoringService.php';

class MonitoringController {

    private $monitoringService;

    public function __construct($db)
    {
        $this->monitoringService = new MonitoringService($db);
    }

    public function getDashboard()
    {
        return $this->monitoringService->getDashboard();
    }

    public function getHistory(){
        return $this->monitoringService->getHistory();
    }
}
