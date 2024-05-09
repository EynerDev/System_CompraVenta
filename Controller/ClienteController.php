<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/ClienteModel.php");
// TODO:Inicializando clase Cliente
    $cliente = new ClienteModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["cli_id"])){
                $cliente->insert_cliente(
                    $_POST["emp_id"],
                    $_POST["tipo_doc_id"],
                    $_POST["cli_doc"],
                    $_POST["cli_name"],
                    $_POST["cli_number"],
                    $_POST["cli_direcc"], 
                    $_POST["cli_email"]);
            }else{
                $cliente->update_cliente(
                    $_POST["cli_id"],
                    $_POST["emp_id"],
                    $_POST["tipo_doc_id"],
                    $_POST["cli_doc"],
                    $_POST["cli_name"],
                    $_POST["cli_number"],
                    $_POST["cli_direcc"], 
                    $_POST["cli_email"]);
            }
            break;

        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $cliente->get_cliente_sucursal_id($_POST["emp_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["cli_name"];
                $sub_array = $row["tipo_doc_id"];
                $sub_array = $row["cli_doc"];
                $sub_array = $row["cli_number"];
                $sub_array = $row["cli_direcc"];
                $sub_array = $row["cli_email"];
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
            $datos = $cliente->get_cliente_id($_POST["cli_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["cli_id"] = $row["cli_id"];
                    $output["emp_id"] = $row["emp_id"];
                    $output["cli_name"] = $row["cli_name"];
                    $output["tipo_doc_id"] = $row["tipo_doc_id"];
                    $output["cli_doc"] = $row["cli_doc"];
                    $output["cli_number"] = $row["cli_number"];
                    $output["cli_direcc"] = $row["cli_direcc"];
                    $output["cli_email"] = $row["cli_email"];
                }
                echo json_encode($output);
            }
            break;
        // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $cliente->delete_cliente($_POST["cli_id"]);
            break;

    }




?>