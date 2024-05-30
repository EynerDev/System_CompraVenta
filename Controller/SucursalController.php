<?php
// TODO:llamando clases
    require("../Config/conn.php");
    require("../Models/SucursalModel.php");
// TODO:Inicializando clase Sucursal
    $sucursal = new Sucursal();

    switch($_GET["op"]){
    // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $suc_name = isset($_POST["suc_name"]) ? $_POST["suc_name"] : null;
        $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null;
        
        if ($emp_id && $suc_name) {
            if (empty($suc_id)){
                $sucursal->insert_sucursal($emp_id, $suc_name);
                echo json_encode([
                    'success' => true,
                    'message' => 'Sucursal creada exitosamente'
                ]);
            } else {
                $sucursal->update_sucursal($suc_id, $suc_name);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Registro actualizado exitosamente.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Datos incompletos.']);
        }
        break;

        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $sucursal->get_sucursal_empresa_id($_POST["emp_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["SUC_NAME"];
                $sub_array[] = $row["CREATED_AT"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["SUC_ID"].')" id="'.$row["SUC_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["SUC_ID"].')" id="'.$row["SUC_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>';
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
            $datos = $sucursal->get_sucursal_id($_POST["suc_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["SUC_ID"]=$row["SUC_ID"];
                    $output["EMP_ID"]=$row["EMP_ID"];
                    $output["SUC_NAME"] = $row["SUC_NAME"];

                }
                echo json_encode($output);
            }
            break;
        // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $suc = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;

        if ($suc === $_SESSION["SUC_ID"]) {
            echo json_encode(['success' => false, 'message' => 'No puedes eliminar la Sucursal', 'icon' => 'error']);
        } else {
            $sucursal->delete_sucursal($suc);
            echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente.', 'icon' => 'success']);
            
        }
        break;


        case "combo":
            var_dump($_POST["emp_id"]);
            $valor = (int)$_POST["emp_id"];
            echo gettype($valor);
            $datos=$sucursal->get_sucursal_empresa_id($valor);   
                if (is_array($datos) && count($datos) > 0) {
                $html = "<option selected>Seleccionar Sucursal</option>";
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row["SUC_ID"] . "'>" . $row["SUC_NAME"] . "</option>";
                }
                echo $html;
                }
                break;
            



        }
?>