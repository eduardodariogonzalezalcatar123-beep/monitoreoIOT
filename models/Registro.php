<?php

class Registro {

    private $conn;
    private $table = "registros";

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($sensor,$valor,$estado,$desviacion,$severidad){

        $query = "INSERT INTO registros
                (id_sensor,valor,fecha,estado_calculado,desviacion,nivel_severidad)
                VALUES
                (:sensor,:valor,NOW(),:estado,:desviacion,:severidad)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sensor",$sensor);
        $stmt->bindParam(":valor",$valor);
        $stmt->bindParam(":estado",$estado);
        $stmt->bindParam(":desviacion",$desviacion);
        $stmt->bindParam(":severidad",$severidad);

        return $stmt->execute();
    }
}