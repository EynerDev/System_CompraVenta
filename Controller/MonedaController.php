<?php
// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir el archivo de conexión a la base de datos
require_once("../Models/MonedaModel.php"); // Incluir el archivo del modelo MonedaModel.php que contiene la clase Moneda

// TODO: Inicializando clase Moneda
$moneda = new Moneda(); // Crear una instancia de la clase Moneda para manejar operaciones relacionadas con monedas

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    
    // TODO: Guardar y editar, guardar cuando el id en vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null; // ID de la sucursal
        $mon_name = isset($_POST["mon_name"]) ? $_POST["mon_name"] : null; // Nombre de la moneda
        $mon_id = isset($_POST["mon_id"]) ? $_POST["mon_id"] : null; // ID de la moneda
        
        // Verificar que los datos necesarios estén presentes
        if ($suc_id && $mon_name) {
            if (empty($mon_id)){
                // Si mon_id está vacío, insertar una nueva moneda
                $moneda->insert_moneda($suc_id, $mon_name);
                echo json_encode([
                    'success' => true,
                    'message' => 'Moneda creada exitosamente'
                ]);
            } else {
                // Si mon_id tiene un valor, actualizar la moneda existente
                $moneda->update_moneda($mon_id, $suc_id, $mon_name);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Registro actualizado exitosamente.'
                ]);
            }
        } else {
            // Si los datos están incompletos
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos.'
            ]);
        }
        break;

    // TODO: Listado de registros formato JSON para datatable JS
    case "listar":
        // Obtener datos de la base de datos para la sucursal especificada
        $datos = $moneda->get_moneda_sucursal_id($_POST["suc_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["MON_NAME"]; // Nombre de la moneda
            $sub_array[] = $row["CREATED_AT"]; // Fecha de creación
            // Botones para editar y eliminar el registro
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

    // TODO: Mostrar información de un registro por su ID
    case "mostrar":
        $datos = $moneda->get_moneda_id($_POST["mon_id"]);
        if(is_array($datos) == TRUE && count($datos) > 0){
            foreach($datos as $row){
                $output["SUC_ID"] = $row["SUC_ID"]; // ID de la sucursal
                $output["MON_NAME"] = $row["MON_NAME"]; // Nombre de la moneda
            }
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar estado de registro a 0 (Eliminar)
    case "eliminar":
        $moneda->delete_moneda($_POST["mon_id"]); // Eliminar la moneda con el ID especificado
        echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente.']);
        break;

    // TODO: Generar opciones para un combo (select) basado en el ID de la sucursal
    case "combo":
        // Obtener los datos de monedas para la sucursal especificada
        $datos = $moneda->get_moneda_sucursal_id($_POST["suc_id"]);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected value=''>Seleccionar Moneda</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["MON_ID"] . "'>" . $row["MON_NAME"] . "</option>";
            }
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron monedas</option>";
        }
        break;
}
?>
