<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/CompaniaModel.php");
// TODO:Inicializando clase Compania
    $compania = new CompaniaModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["com_id"])){
                $compania->insert_compania($_POST["com_name"]);
            }else{
                $compania->update_compania($_POST["com_id"],$_POST["com_name"]);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $compania->get_compania();
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["com_name"];
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
            $datos = $compania->get_compania_id($_POST["com_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["com_id"] = $row["com_id"];
                    $output["com_name"] = $row["com_name"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Eliminar o Cambiar estado de registro a 0
        case "eliminar":
            $compania->delete_compania($_POST["com_id"]);
            break;

    }




?>