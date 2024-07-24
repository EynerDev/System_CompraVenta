<?php

    class Usuario extends Conectar{
        // TODO: Listar registros por sucursal id
        public function get_usuario_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_USUARIO_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_usuario_id($user_id){
            $conectar = parent::conexion();
            $sql = "SP_L_USUARIO_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $user_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
            
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
        public function update_contrasena($user_id, $user_password){
            $conectar = parent::conexion();
            $sql = "SP_U_USUARIO_02 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $user_id);
            $sql_query->bindValue(2, $user_password);
            $sql_query->execute();

        }

        //TODO: Acceso al sistema
        public function Login(){
            $conectar = parent::conexion();
            if(isset($_POST["enviar"])){
                $sucursal = $_POST["suc_id"];
                $correo = $_POST["email"];
                $password = $_POST["password"];
        
                if(empty($correo) || empty($sucursal) || empty($password)){
                    // Mostrar mensaje de error o redirigir con un mensaje de error
                    echo "
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Todos los campos son obligatorios.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    return; // Salir de la función para evitar ejecución posterior
                }
        
                // Realizar la consulta a la base de datos
                $sql = "SP_LOGIN_USUARIO ?,?,?"; // Usar CALL para procedimientos almacenados
                $sql_query = $conectar->prepare($sql);
                $sql_query->bindValue(1, $sucursal);
                $sql_query->bindValue(2, $correo);
                $sql_query->bindValue(3, $password);
                $sql_query->execute();
                $resultado = $sql_query->fetch(PDO::FETCH_ASSOC);
        
                if(is_array($resultado) && count($resultado) > 0){
                    session_start(); // Asegúrate de que la sesión esté iniciada
                    $_SESSION["USER_ID"] = $resultado["USER_ID"];
                    $_SESSION["SUC_ID"] = $resultado["SUC_ID"];
                    $_SESSION["USER_NAME"] = $resultado["USER_NAME"];
                    $_SESSION["USER_APE"] = $resultado["USER_APE"];
                    $_SESSION["USER_EMAIL"] = $resultado["USER_EMAIL"];
                    $_SESSION["USER_ROLE_ID"] = $resultado["USER_ROLE_ID"];
                    $_SESSION["ROLE_NAME"] = $resultado["ROLE_NAME"];
                    $_SESSION["COM_ID"] = $resultado["COM_ID"];
                    $_SESSION["EMP_ID"] = $resultado["EMP_ID"];
                    
                    header("Location:".Conectar::baseUrl()."Views/home/");
                    exit();
                } else {
                    // Mostrar mensaje de error o redirigir con un mensaje de error
                    echo "
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Usuario o contraseña incorrectos.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            }
        }
        

    }

?>