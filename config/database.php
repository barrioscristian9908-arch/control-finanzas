<?php
    class db{
        private $host = "localhost";
        private $dbname = "control_finanzas";
        private $user = "root";
        private $password = "";

        public function conexion(){
            try{
                $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
                return $PDO;
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    }
?>