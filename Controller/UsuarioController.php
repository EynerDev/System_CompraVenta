<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/UsuarioModel.php");
// TODO:Inicializando clase Usuario
    $usuario = new UsuarioModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["user_id"])){
                $usuario->insert_usuario(
                    $_POST["suc_id"],
                    $_POST["user_email"],
                    $_POST["user_name"],
                    $_POST["user_role_id"], 
                    $_POST["user_ape"], 
                    $_POST["user_typedoc"], 
                    $_POST["user_document"], 
                    $_POST["user_number"], 
                    $_POST["user_password"], 
                );
            }else{
                $usuario->update_usuario(
                    $_POST["user_id"],
                    $_POST["suc_id"],
                    $_POST["user_email"],
                    $_POST["user_name"],
                    $_POST["user_role_id"], 
                    $_POST["user_ape"], 
                    $_POST["user_typedoc"], 
                    $_POST["user_document"], 
                    $_POST["user_number"], 
                    $_POST["user_password"],
                );
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $usuario->get_usuario_sucursal_id($_POST["suc_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["user_name"];
                $sub_array = $row["user_ape"];
                $sub_array = $row["user_typedoc"];
                $sub_array = $row["user_document"];
                $sub_array = $row["user_role_id"];
                $sub_array = $row["user_email"];
                $sub_array = $row["user_number"];
                $sub_array = $row["user_password"];
                $sub_array = "Eliminar";
                $sub_array = "Editar";
                $data[] = $sub_array;

                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
            }

            break;
            // TODO: Mostrar informacion de un registro por su id
        case "mostrar":
            $datos = $usuario->get_usuario_id($_POST["user_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["user_id"] = $row["user_id"];
                    $output["suc_id"] = $row["suc_id"];
                    $output["user_name"] = $row["user_name"];
                    $output["user_ape"] = $row["user_ape"];
                    $output["user_typedoc"] = $row["user_typedoc"];
                    $output["user_document"] = $row["user_document"];
                    $output["user_role_id"] = $row["user_role_id"];
                    $output["user_email"] = $row["user_email"];
                    $output["user_number"] = $row["user_number"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $usuario->delete_usuario($_POST["user_id"]);
            break;

    }




?>