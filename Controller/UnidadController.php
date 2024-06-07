<?php
// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/UnidadModel.php");

// TODO: Inicializando clase Unidad
$unidad = new Unidad();

switch($_GET["op"]){
    // TODO: Guardar y editar, guardar cuando el id en vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $unid_name = isset($_POST["unid_name"]) ? $_POST["unid_name"] : null;
        $uni_id = isset($_POST["uni_id"]) ? $_POST["uni_id"] : null;
        
        if ($suc_id && $unid_name) {
            if (empty($uni_id)){
                $unidad->insert_unidad($suc_id, $unid_name);
                echo json_encode([
                    'success' => true,
                    'message' => 'Registro creado exitosamente'
                ]);
            } else {
                $unidad->update_unidad($uni_id, $suc_id, $unid_name);
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
        // Obtener datos de la base de datos
        $datos = $unidad->get_unidad_sucursal_id($_POST["suc_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["UNID_NAME"];
            $sub_array[] = $row["CREATED_AT"];
            $sub_array[] = '<button type="button" onClick="editar('.$row["UNI_ID"].')" id="'.$row["UNI_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["UNI_ID"].')" id="'.$row["UNI_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
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
        $datos = $unidad->get_unidad_id($_POST["uni_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $output["UNI_ID"] = $row["UNI_ID"];
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["UNID_NAME"] = $row["UNID_NAME"];
            }
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar estado de registro a 0
    case "eliminar":
        $unidad->delete_unidad($_POST["uni_id"]);
        echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente.']);
        break;
    case "combo":
        // Obtener los datos de la empresa
        $datos = $unidad->get_unidad_sucursal_id($_POST["suc_id"]);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected>Seleccionar Unidad</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["UNI_ID"] . "'>" . $row["UNID_NAME"] . "</option>";
            }
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron unidades</option>";
        }
        break;
}
?>
