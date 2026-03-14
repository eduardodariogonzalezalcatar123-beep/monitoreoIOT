<?php

require_once __DIR__."/../models/Sensor.php";
require_once __DIR__."/../models/Registro.php";
require_once __DIR__."/../models/Alerta.php";

class AlertService {

    private $sensorModel;
    private $registroModel;
    private $alertaModel;

    public function __construct($db)
    {
        $this->sensorModel   = new Sensor($db);
        $this->registroModel = new Registro($db);
        $this->alertaModel   = new Alerta($db);
    }

    public function processReading($id_sensor, $valor)
    {
        $sensor = $this->sensorModel->getById($id_sensor);

        if(!$sensor){
            return [
                "status" => "error",
                "message" => "Sensor no encontrado"
            ];
        }

        $limite_min = $sensor["limite_min"];
        $limite_max = $sensor["limite_max"];

        $resultado = $this->evaluateReading($valor, $limite_min, $limite_max);

        // guardar registro
        $this->registroModel->create(
            $id_sensor,
            $valor,
            $resultado["estado"],
            $resultado["desviacion"],
            $resultado["severidad"]
        );

        // actualizar ultima lectura
        $this->sensorModel->updateLastReading(
    $id_sensor,
    $valor,
    $resultado["estado"]
);


        // generar alerta si aplica
        if($resultado["estado"] !== "normal"){
            $this->alertaModel->create(
                $id_sensor,
                $resultado["estado"],
                $valor
            );
        }

        return [
            "status" => "ok",
            "estado" => $resultado["estado"],
            "severidad" => $resultado["severidad"]
        ];
    }


    private function evaluateReading($valor, $min, $max)
    {

        $rango = $max - $min;

        // zona preventiva (20% antes del limite)
        $zona_preventiva = $rango * 0.2;

        $estado = "normal";
        $desviacion = 0;
        $severidad = 0;

        if($valor < $min){

            $estado = "critico_bajo";
            $desviacion = $min - $valor;

        }
        elseif($valor > $max){

            $estado = "critico_alto";
            $desviacion = $valor - $max;

        }
        elseif($valor <= ($min + $zona_preventiva)){

            $estado = "preventivo_bajo";

        }
        elseif($valor >= ($max - $zona_preventiva)){

            $estado = "preventivo_alto";

        }

        // cálculo de severidad
        if($estado !== "normal"){
            $severidad = min(100, ($desviacion / $rango) * 100);
        }

        return [
            "estado" => $estado,
            "desviacion" => $desviacion,
            "severidad" => $severidad
        ];
    }
}