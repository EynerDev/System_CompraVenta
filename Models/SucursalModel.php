<?php

    class sucursal extends conectar{
        // TODO: Listar registros por empresa id
        public function get_sucursal_empresa_id($emp_id){
            $conectar = parent::conexion();
            $sql = "SP_L_SUCURSAL_01 ?";
            $sql_query = $conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // TODO: Listar registros por id 
        public function get_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_SUCURSAL_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_sucursal($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_D_SUCURSAL_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_sucursal($emp_id, $suc_name){
            $conectar = parent::conexion();
            $sql = "SP_I_SUCURSAL_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->bindValue(2, $suc_name);
            $sql_query->execute();
            
        }
        // TODO: Actualizar registros  
        public function update_sucursal( $suc_name, $suc_id){
            $conectar = parent::conexion();
            $sql = "SP_U_SUCURSAL_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_name);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->execute();

            
            
        }

    }

?>