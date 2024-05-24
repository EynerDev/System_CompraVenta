<?php

    class Moneda extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_moneda_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_MONEDA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_moneda_id($mon_id){
            $conectar = parent::conexion();
            $sql = "SP_L_MONEDA_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $mon_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_moneda($mon_id){
            $conectar = parent::conexion();
            $sql = "SP_D_MONEDA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $mon_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_moneda($suc_id, $mon_name){
            $conectar = parent::conexion();
            $sql = "SP_I_MONEDA_01 ?,? ";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2,$mon_name);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_moneda($mon_id, $suc_id, $mon_name){
            $conectar = parent::conexion();
            $sql = "SP_U_MONEDA_01 ?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $mon_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $mon_name);
            $sql_query->execute();

            
            
        }

    }

?>