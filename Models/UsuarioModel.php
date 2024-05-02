<?php

    class usuario extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_usuario_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_USUARIO_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_usuario_id($user_id){
            $conectar = parent::conexion();
            $sql = "SP_L_USUARIO_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $user_id);
            $sql_query->execute();
            return $sql_query->fecthAll(PDO::FECTH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_usuario($user_id){
            $conectar = parent::conexion();
            $sql = "SP_D_USUARIO_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $user_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_usuario($suc_id,$user_email, $user_name, 
                                        $user_role_id, $user_ape, $user_typedoc, 
                                        $user_document,$user_number,
                                        $user_password){
            $conectar = parent::conexion();
            $sql = "SP_I_USUARIO_01 ?,?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $user_email);
            $sql_query->bindValue(3, $user_name);
            $sql_query->bindValue(4, $user_role_id);
            $sql_query->bindValue(5, $user_ape);
            $sql_query->bindValue(6, $user_typedoc);
            $sql_query->bindValue(7, $user_document);
            $sql_query->bindValue(8, $user_number);
            $sql_query->bindValue(9, $user_password);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_usuario($user_id,$suc_id,$user_email,$user_name,
                                        $user_role_id, $user_ape, $user_typedoc, 
                                        $user_document,$user_number,
                                        $user_password){
            $conectar = parent::conexion();
            $sql = "SP_U_USUARIO_01 ?,?,?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $user_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $user_email);
            $sql_query->bindValue(4, $user_name);
            $sql_query->bindValue(5, $user_role_id);
            $sql_query->bindValue(6, $user_ape);
            $sql_query->bindValue(7, $user_typedoc);
            $sql_query->bindValue(8, $user_document);
            $sql_query->bindValue(9, $user_number);
            $sql_query->bindValue(10, $user_password);
            $sql_query->execute();

            
            
        }

    }

?>