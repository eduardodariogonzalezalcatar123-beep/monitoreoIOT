<?php

class MonitoringService {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDashboard()
    {

        $query = "
        SELECT
            m.nombre AS master,
            e.nombre AS esclavo,
            e.ubicacion,
            s.id_sensor,
            s.nombre AS sensor,
            s.tipo,
            s.ultima_lectura,
            s.estado_actual,
            s.ultima_fecha
        FROM sensores s
        JOIN esp32_esclavo e ON s.id_esclavo = e.id_esclavo
        JOIN esp32_master m ON e.id_master = m.id_master
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
