<?php

    class proveedor extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_proveedor_empresa_id($emp_id){
            $conectar = parent::conexion();
            $sql = "SP_L_PROVEEDOR_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_proveedor_id($prov_id){
            $conectar = parent::conexion();
            $sql = "SP_L_PROVEEDOR_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $prov_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_proveedor($prov_id){
            $conectar = parent::conexion();
            $sql = "SP_D_PROVEEDOR_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $prov_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_proveedor($emp_id,$prov_name, $prov_rut, $prov_number, $prov_dirc, $prov_email){
            $conectar = parent::conexion();
            $sql = "SP_I_PROVEEDOR_01 ?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $emp_id);
            $sql_query->bindValue(2, $prov_name);
            $sql_query->bindValue(3, $prov_rut);
            $sql_query->bindValue(4, $prov_number);
            $sql_query->bindValue(5, $prov_dirc);
            $sql_query->bindValue(6, $prov_email);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_proveedor($prov_id,$emp_id, $prov_rut, $prov_name, $prov_number, $prov_dirc, $prov_email){
            $conectar = parent::conexion();
            $sql = "SP_U_PROVEEDOR_01 ?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $prov_id);
            $sql_query->bindValue(2, $emp_id);
            $sql_query->bindValue(3, $prov_name);
            $sql_query->bindValue(4, $prov_rut);
            $sql_query->bindValue(5, $prov_number);
            $sql_query->bindValue(6, $prov_dirc);
            $sql_query->bindValue(7, $prov_email);
            $sql_query->execute();

            
            
        }

    }

?>