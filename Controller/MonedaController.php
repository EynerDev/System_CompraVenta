<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/MonedaModel.php");
// TODO:Inicializando clase Moneda
    $moneda = new MonedaModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["mon_id"])){
                $moneda->insert_moneda($_POST["suc_id"],$_POST["mon_name"]);
            }else{
                $moneda->update_moneda($_POST["mon_id"],$_POST["suc_id"],$_POST["mon_name"]);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $moneda->get_moneda_sucursal_id($_POST["suc_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["mon_name"];
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
            $datos = $moneda->get_moneda_id($_POST["mon_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["mon_id"] = $row["mon_id"];
                    $output["suc_id"] = $row["suc_id"];
                    $output["mon_name"] = $row["mon_name"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $moneda->delete_moneda($_POST["mon_id"]);
            break;

    }




?>