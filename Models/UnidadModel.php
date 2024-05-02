<?php

    class unidad_medida extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_unidad_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_UNIDAD_DE_MEDIDA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);

        }
        // TODO: Listar registros por id 
        public function get_unidad_id($uni_id){
            $conectar = parent::conexion();
            $sql = "SP_L_UNIDAD_DE_MEDIDA_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $uni_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_unidad($uni_id){
            $conectar = parent::conexion();
            $sql = "SP_D_UNIDAD_DE_MEDIDA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $uni_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_unidad($suc_id, $unid_name){
            $conectar = parent::conexion();
            $sql = "SP_I_UNIDAD_DE_MEDIDA_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $unid_name);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_unidad($uni_id, $suc_id, $unid_name){
            $conectar = parent::conexion();
            $sql = "SP_U_UNIDAD_DE_MEDIDA_01 ?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $uni_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $unid_name);
            $sql_query->execute();

            
            
        }

    }

?>