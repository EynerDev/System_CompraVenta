<?php
 // Configurar la cabecera para JSON
    header('Content-Type: application/json');
// TODO:llamando clases
    require_once ("../Config/conn.php");
    require_once("../Models/MonedaModel.php");
// TODO:Inicializando clase Moneda
    $moneda = new Moneda();

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

            // Obtener datos de la base de datos
            $datos = $moneda->get_moneda_sucursal_id($_POST["suc_id"]);
            $data = array();
                
                // Recorrer los datos y preparar el array para DataTables
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["MON_ID"]; // Nombre de la categoría
                $sub_array[] = $row["MON_NAME"]; // Nombre de la categoría
                $sub_array[] = $row["CREATED_AT"]; // Nombre de la categoría
                $sub_array[] = '<button type="button" onClick="editar('.$row["MON_ID"].')" id="'.$row["MON_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["MON_ID"].')" id="'.$row["MON_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
                $data[] = $sub_array;
            }
                
                // Preparar la estructura final de la respuesta para DataTables
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
                
                // Enviar la respuesta JSON
            echo json_encode($results);
            break;
                
            
            // TODO: Mostrar informacion de un registro por su id
        case "mostrar":
            $datos = $moneda->get_moneda_id($_POST["mon_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["MON_ID"] = $row["MON_ID"];
                    $output["SUC_ID"] = $row["SUC_ID"];
                    $output["MON_NAME"] = $row["MON_NAME"];
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