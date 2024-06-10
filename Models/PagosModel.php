<?php

    class Pagos extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_pago(){
            $conectar = parent::conexion();
            $sql = "SP_LISTAR_PAGO";
            $sql_query=$conectar->prepare($sql);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
    }

?>