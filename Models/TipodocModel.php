<?php

    class tipodoc extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_tipodoc_sucursal_id(){
            $conectar = parent::conexion();
            $sql = "SP_L_TIPODOC_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_tipodoc_id($tipo_doc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_TIPODOC_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $tipo_doc_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_tipodoc($tipo_doc_id){
            $conectar = parent::conexion();
            $sql = "SP_D_TIPODOC_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $tipo_doc_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_tipodoc($description){
            $conectar = parent::conexion();
            $sql = "SP_I_TIPODOC_01 ? ";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $description);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_tipodoc($tipo_doc_id, $description){
            $conectar = parent::conexion();
            $sql = "SP_U_TIPODOC_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $tipo_doc_id);
            $sql_query->bindValue(2, $description);
            $sql_query->execute();

            
            
        }

    }

?>