<?php

    class compania extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_compania_sucursal_id(){
            $conectar = parent::conexion();
            $sql = "SP_L_COMPANIA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_compania_id($com_id){
            $conectar = parent::conexion();
            $sql = "SP_L_COMPANIA_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $com_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_compania($com_id){
            $conectar = parent::conexion();
            $sql = "SP_D_COMPANIA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $com_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_compania($com_name){
            $conectar = parent::conexion();
            $sql = "SP_I_COMPANIA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1,$com_name);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_compania($com_id, $com_name){
            $conectar = parent::conexion();
            $sql = "SP_U_COMPANIA_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $com_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $com_name);
            $sql_query->execute();

            
            
        }

    }

?>