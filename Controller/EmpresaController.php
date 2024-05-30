<?php
// TODO:llamando clases
    require("../Config/conn.php");
    require("../Models/EmpresaModel.php");
// TODO:Inicializando clase Empresa
    $empresa = new Empresa();

    switch($_GET["op"]){
    // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            $com_id = isset($_POST["com_id"]) ? $_POST["com_id"] : null;
            $emp_name = isset($_POST["emp_name"]) ? $_POST["emp_name"] : null;
            $emp_rut = isset($_POST["emp_rut"]) ? $_POST["emp_rut"] : null; 
            $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null; 

            if ($com_id && $emp_name && $emp_rut) {
                if (empty($emp_id)){
                    $empresa->insert_empresa($com_id, $emp_name, $emp_rut);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Registro Agregado Exitosamente'
                    ]);
                } else {
                    $empresa->update_empresa($emp_id, $com_id, $emp_name, $emp_rut);
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Registro actualizado exitosamente.'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Datos incompletos.'
                ]);
            }
            break;

        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":
            // Obtener datos de la base de datos
            $datos = $empresa->get_empresa_compania_id($_POST["com_id"]);
            $data = array();

            // Recorrer los datos y preparar el array para DataTables
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["EMP_NAME"];
                $sub_array[] = $row["EMP_RUT"];
                $sub_array[] = $row["CREATED_AT"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["EMP_ID"].')" id="'.$row["EMP_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["EMP_ID"].')" id="'.$row["EMP_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
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
            $datos = $empresa->get_empresa_id($_POST["emp_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["EMP_ID"] = $row["EMP_ID"];
                    $output["COM_ID"] = $row["COM_ID"];
                    $output["EMP_NAME"] = $row["EMP_NAME"];
                    $output["EMP_RUT"] = $row["EMP_RUT"];
                }
                echo json_encode($output);
            }
            break;
        // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $empresa->delete_empresa($_POST["emp_id"]);
            break;

            case "combo":
                // Asegúrate de que com_id esté presente en $_POST
                if (isset($_POST["com_id"])) {
                    
                    // Convertir com_id a entero
                    $valor = (int)$_POST["com_id"];
                    
                    // Obtener los datos de la empresa
                    $datos = $empresa->get_empresa_compania_id($valor);   
                    if (is_array($datos) && count($datos) > 0) {
                        $html = "<option selected>Seleccionar Empresa</option>";
                        foreach ($datos as $row) {
                            $html .= "<option value='" . $row["EMP_ID"] . "'>" . $row["EMP_NAME"] . "</option>";
                        }
                        echo $html;
                    } else {
                        // Manejar el caso donde no se encuentran datos
                        echo "<option selected>No se encontraron empresas</option>";
                    }
                } else {
                    // Manejar el caso donde com_id no está presente en la solicitud POST
                    echo "Error: com_id no está definido.";
                }
                break;
            



        }
?>