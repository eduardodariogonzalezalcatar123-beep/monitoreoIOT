<?php

class Sensor {

    private $conn;
    private $table = "sensores";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM sensores";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM sensores WHERE id_sensor = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO sensores
        (id_esclavo, tipo, nombre, limite_min, limite_max)
        VALUES
        (:id_esclavo, :tipo, :nombre, :limite_min, :limite_max)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_esclavo", $data["id_esclavo"]);
        $stmt->bindParam(":tipo", $data["tipo"]);
        $stmt->bindParam(":nombre", $data["nombre"]);
        $stmt->bindParam(":limite_min", $data["limite_min"]);
        $stmt->bindParam(":limite_max", $data["limite_max"]);

        return $stmt->execute();
    }

    public function updateLimits($id, $min, $max)
    {
        $query = "UPDATE sensores
                  SET limite_min = :min,
                      limite_max = :max
                  WHERE id_sensor = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":min", $min);
        $stmt->bindParam(":max", $max);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
    public function updateLastReading($id_sensor, $valor, $estado)
{
    $query = "UPDATE sensores
              SET ultima_lectura = ?,
                  ultima_fecha = NOW(),
                  estado_actual = ?
              WHERE id_sensor = ?";

    $stmt = $this->conn->prepare($query);

    return $stmt->execute([
        $valor,
        $estado,
        $id_sensor
    ]);
}

}
