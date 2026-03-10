<?php

class Database {

    private $host = "mysql";
    private $db_name = "monitoreo";
    private $username = "api_user";
    private $password = "api_pass";

    public function connect(){

        try {

            $conn = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->db_name,
                $this->username,
                $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch(PDOException $e){

            echo "Error: ".$e->getMessage();
        }
    }
}