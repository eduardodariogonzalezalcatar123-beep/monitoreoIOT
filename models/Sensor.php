<?php

class Sensor {

    private $conn;
    private $table = "sensores";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getById($id){

        $query = "SELECT * FROM ".$this->table." WHERE id_sensor = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id",$id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateLastReading($id,$valor){

        $query = "UPDATE sensores 
                  SET ultima_lectura = :valor,
                      ultima_fecha = NOW()
                  WHERE id_sensor = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":valor",$valor);
        $stmt->bindParam(":id",$id);

        return $stmt->execute();
    }
}