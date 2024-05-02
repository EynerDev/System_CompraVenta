<?php

    class rol extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_rol_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_ROL_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_rol_id($role_id){
            $conectar = parent::conexion();
            $sql = "SP_L_ROL_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $role_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_rol($role_id){
            $conectar = parent::conexion();
            $sql = "SP_D_ROL_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $role_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_rol($suc_id, $role_name){
            $conectar = parent::conexion();
            $sql = "SP_I_ROL_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $role_name);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_rol($role_id, $suc_id, $role_name){
            $conectar = parent::conexion();
            $sql = "SP_U_ROL_01 ?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $role_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $role_name);
            $sql_query->execute();

            
            
        }

    }

?>