<?php
class conectar{
    protected $dbh;

    protected function conexion(){
        try{
            $conectar = $this->dbh = new PDO("sqlsrv:Server=localhost;Database=CompraVenta","Eyner","");
            return $conectar;

        }catch(Exception $e){
            print("Error al hacer la conecion".$e->getMessage());
            die();

        }

    }

}

?>