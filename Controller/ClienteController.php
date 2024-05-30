<?php
// TODO:llamando clases
    require_once ("../Config/conn.php");
    require_once("../Models/ClienteModel.php");
// TODO:Inicializando clase Cliente
    $cliente = new Cliente();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
    
            $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null;
            $tipo_doc_id = isset($_POST["tipo_doc_id"]) ? $_POST["tipo_doc_id"] : null;
            $cli_doc = isset($_POST["cli_doc"]) ? $_POST["cli_doc"] : null;
            $cli_name = isset($_POST["cli_name"]) ? $_POST["cli_name"] : null;
            $cli_number = isset($_POST["cli_number"]) ? $_POST["cli_number"] : null;
            $cli_direcc = isset($_POST["cli_direcc"]) ? $_POST["cli_direcc"] : null;
            $cli_email = isset($_POST["cli_email"]) ? $_POST["cli_email"] : null;
            $cli_id = isset($_POST["cli_id"]) ? $_POST["cli_id"] : null;
            
            if ($emp_id  && $tipo_doc_id && $cli_doc  && $cli_name && $cli_number && $cli_direcc && $cli_email) {
                if (empty($cli_id)){
                    $cliente->insert_cliente($emp_id, $tipo_doc_id, $cli_doc, $cli_name, $cli_number, $cli_direcc, $cli_email);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Cliente creado exitosamente',
                        'icon' => 'success'
                    ]);
                } else {
                    $cliente->update_cliente($cli_id, $emp_id, $tipo_doc_id, $cli_doc, $cli_name, $cli_number, $cli_direcc, $cli_email);
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Registro actualizado exitosamente.',
                        'icon' => 'success'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Datos incompletos.',
                    'icon' => 'error'
                ]);
            }
            break;

        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $cliente->get_cliente_empresa_id($_POST["emp_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["CLI_NAME"];
                $sub_array[] = $row["CLI_DOC"];
                $sub_array[] = $row["CLI_NUMBER"];
                $sub_array[] = $row["CLI_EMAIL"];
                $sub_array[] = $row["CREATED_AT"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["CLI_ID"].')" id="'.$row["CLI_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["CLI_ID"].')" id="'.$row["CLI_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
                $data[] = $sub_array;

                
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);

            break;
        // TODO: Mostrar informacion de un registro por su id
        case "mostrar":
            $datos = $cliente->get_cliente_id($_POST["cli_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["CLI_ID"] = $row["CLI_ID"];
                    $output["EMP_ID"] = $row["EMP_ID"];
                    $output["CLI_NAME"] = $row["CLI_NAME"];
                    $output["TIPO_DOC_ID"] = $row["TIPO_DOC_ID"];
                    $output["CLI_DOC"] = $row["CLI_DOC"];
                    $output["CLI_NUMBER"] = $row["CLI_NUMBER"];
                    $output["CLI_DIRECC"] = $row["CLI_DIRECC"];
                    $output["CLI_EMAIL"] = $row["CLI_EMAIL"];
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