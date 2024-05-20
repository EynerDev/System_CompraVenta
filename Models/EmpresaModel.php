<?php

    class Empresa extends conectar{
        // TODO: Listar registros por compañia id
        public function get_empresa_compania_id($com_id) {
            $conectar = parent::conexion();
            $sql = "SP_L_EMPRESA_01 ?";
            $sql_query = $conectar->prepare($sql);
            $sql_query->bindValue(1, $com_id, PDO::PARAM_INT);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // TODO: Listar registros por id 
        public function get_empresa_id($emp_id){
            $conectar = parent::conexion();
            $sql = "SP_L_EMPRESA_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_empresa($emp_id){
            $conectar = parent::conexion();
            $sql = "SP_D_EMPRESA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_empresa($com_id, $emp_name, $emp_rut){
            $conectar = parent::conexion();
            $sql = "SP_I_EMPRESA_01 ?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $com_id);
            $sql_query->bindValue(2, $emp_name);
            $sql_query->bindValue(3, $emp_rut);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_empresa($emp_id, $com_id, $emp_name, $emp_rut){
            $conectar = parent::conexion();
            $sql = "SP_U_EMPRESA_01 ?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->bindValue(2, $com_id);
            $sql_query->bindValue(3, $emp_name);
            $sql_query->bindValue(4, $emp_rut);
            $sql_query->execute();

            
            
        }

    }

?>