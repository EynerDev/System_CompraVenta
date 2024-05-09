<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/RolModel.php");
// TODO:Inicializando clase Rol
    $rol = new RolModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["role_id"])){
                $rol->insert_rol($_POST["suc_id"],$_POST["role_name"]);
            }else{
                $rol->update_rol($_POST["role_id"],$_POST["suc_id"],$_POST["role_name"]);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $rol->get_rol_sucursal_id($_POST["suc_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["role_name"];
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
            $datos = $rol->get_rol_id($_POST["role_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["role_id"] = $row["role_id"];
                    $output["suc_id"] = $row["suc_id"];
                    $output["role_name"] = $row["role_name"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $rol->delete_rol($_POST["role_id"]);
            break;

    }




?>