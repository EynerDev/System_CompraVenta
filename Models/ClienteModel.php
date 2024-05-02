<?php

    class cliente extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_cliente_empresa_id($emp_id){
            $conectar = parent::conexion();
            $sql = "SP_L_CLIENTE_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_cliente_id($cli_id){
            $conectar = parent::conexion();
            $sql = "SP_L_CLIENTE_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cli_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_cliente($cli_id){
            $conectar = parent::conexion();
            $sql = "SP_D_CLIENTE_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cli_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_cliente($emp_id, $tipo_doc_id, $cli_doc, $cli_name, $cli_number, $cli_direcc, $cli_email){
            $conectar = parent::conexion();
            $sql = "SP_I_CLIENTE_01 ?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->bindValue(2, $tipo_doc_id);
            $sql_query->bindValue(3, $cli_doc);
            $sql_query->bindValue(4, $cli_name);
            $sql_query->bindValue(5, $cli_number);
            $sql_query->bindValue(6, $cli_direcc);
            $sql_query->bindValue(7, $cli_email);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_cliente($cli_id,$emp_id, $tipo_doc_id, $cli_doc, $cli_name, $cli_number, $cli_direcc, $cli_email){
            $conectar = parent::conexion();
            $sql = "SP_U_CLIENTE_01 ?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cli_id);
            $sql_query->bindValue(2, $emp_id);
            $sql_query->bindValue(3, $tipo_doc_id);
            $sql_query->bindValue(4, $cli_doc);
            $sql_query->bindValue(5, $cli_name);
            $sql_query->bindValue(6, $cli_number);
            $sql_query->bindValue(7, $cli_direcc);
            $sql_query->bindValue(8, $cli_email);
            $sql_query->execute();

            
            
        }

    }

?>