<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/UnidadModel.php");
// TODO:Inicializando clase Unidad
    $unidad = new UnidadModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["uni_id"])){
                $unidad->insert_unidad($_POST["suc_id"],$_POST["unid_name"]);
            }else{
                $unidad->update_unidad($_POST["uni_id"],$_POST["suc_id"],$_POST["unid_name"]);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $unidad->get_unidad_sucursal_id($_POST["suc_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["unid_name"];
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
            $datos = $unidad->get_unidad_id($_POST["uni_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["uni_id"] = $row["uni_id"];
                    $output["suc_id"] = $row["suc_id"];
                    $output["unid_name"] = $row["unid_name"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $unidad->delete_unidad($_POST["uni_id"]);
            break;

    }




?>