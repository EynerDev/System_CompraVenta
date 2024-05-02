<?php

    class categoria extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_categoria_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_CATEGORIA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_categoria_id($cat_id){
            $conectar = parent::conexion();
            $sql = "SP_L_CATEGORIA_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cat_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_categoria($cat_id){
            $conectar = parent::conexion();
            $sql = "SP_D_CATEGORIA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cat_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_categoria($suc_id, $cat_name){
            $conectar = parent::conexion();
            $sql = "SP_I_CATEGORIA_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $cat_name);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_categoria($cat_id, $suc_id, $cat_name){
            $conectar = parent::conexion();
            $sql = "SP_U_CATEGORIA_01 ?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cat_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $cat_name);
            $sql_query->execute();

            
            
        }

    }

?>