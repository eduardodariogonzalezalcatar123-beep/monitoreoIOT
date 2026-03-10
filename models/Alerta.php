<?php

class Alerta {

    private $conn;
    private $table = "alertas";

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($sensor,$tipo,$valor){

        $query = "INSERT INTO alertas
                  (id_sensor,tipo_alerta,valor,fecha)
                  VALUES
                  (:sensor,:tipo,:valor,NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sensor",$sensor);
        $stmt->bindParam(":tipo",$tipo);
        $stmt->bindParam(":valor",$valor);

        return $stmt->execute();
    }
}