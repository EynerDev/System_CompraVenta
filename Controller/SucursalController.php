<?php
// TODO: Llamando clases
require("../Config/conn.php"); // Incluir el archivo de configuración para la conexión a la base de datos
require("../Models/SucursalModel.php"); // Incluir el archivo del modelo SucursalModel.php que contiene la clase Sucursal

// TODO: Inicializando clase Sucursal
$sucursal = new Sucursal(); // Crear una instancia de la clase Sucursal para manejar operaciones relacionadas con sucursales

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]) {

    // TODO: Guardar y editar sucursales
    case "guardaryeditar":
        // Obtener datos de la solicitud POST
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $suc_name = isset($_POST["suc_name"]) ? $_POST["suc_name"] : null;
        $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null;

        // Verificar si los datos necesarios están presentes
        if ($emp_id && $suc_name) {
            // Si el ID de sucursal está vacío, se inserta una nueva sucursal
            if (empty($suc_id)){
                $sucursal->insert_sucursal($emp_id, $suc_name);
                echo json_encode([
                    'success' => true,
                    'message' => 'Sucursal creada exitosamente'
                ]);
            } else {
                // Si el ID está presente, se actualiza la sucursal existente
                $sucursal->update_sucursal($suc_id, $suc_name);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Registro actualizado exitosamente.'
                ]);
            }
        } else {
            // Si faltan datos, se envía un mensaje de error
            echo json_encode([
                'success' => false, 
                'message' => 'Datos incompletos.'
            ]);
        }
        break;

    // TODO: Listado de sucursales en formato JSON para DataTables JS
    case "listar":
        // Obtener datos de sucursales desde el modelo
        $datos = $sucursal->get_sucursal_empresa_id($_POST["emp_id"]);
        $data  = array();
        foreach($datos as $row){
            $sub_array = array();
            // Agregar información de la sucursal al array
            $sub_array[] = $row["SUC_NAME"];
            $sub_array[] = $row["CREATED_AT"];
            // Botones para editar y eliminar sucursal
            $sub_array[] = '<button type="button" onClick="editar('.$row["SUC_ID"].')" id="'.$row["SUC_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["SUC_ID"].')" id="'.$row["SUC_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>';
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

    // TODO: Mostrar información de una sucursal por su ID
    case "mostrar":
        // Obtener información de la sucursal por ID
        $datos = $sucursal->get_sucursal_id($_POST["suc_id"]);
        if (is_array($datos) == TRUE && count($datos) > 0){
            foreach($datos as $row){
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["EMP_ID"] = $row["EMP_ID"];
                $output["SUC_NAME"] = $row["SUC_NAME"];
            }
            echo json_encode($output);
        }
        break;

    // TODO: Eliminar sucursal
    case "eliminar":
        $suc = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;

        // Verificar si la sucursal que se quiere eliminar es la actual en sesión
        if ($suc === $_SESSION["SUC_ID"]) {
            echo json_encode(['success' => false, 'message' => 'No puedes eliminar la Sucursal', 'icon' => 'error']);
        } else {
            // Eliminar la sucursal
            $sucursal->delete_sucursal($suc);
            echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente.', 'icon' => 'success']);
        }
        break;

    // TODO: Obtener sucursales para un combo (select) basado en la empresa
    case "combo":
        // Verificar el tipo de valor recibido para emp_id
        var_dump($_POST["emp_id"]);
        $valor = (int)$_POST["emp_id"];
        echo gettype($valor);

        // Obtener los datos de sucursales para la empresa especificada
        $datos = $sucursal->get_sucursal_empresa_id($valor);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected>Seleccionar Sucursal</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["SUC_ID"] . "'>" . $row["SUC_NAME"] . "</option>";
            }
            echo $html; // Enviar el HTML generado
        }
        break;
}
?>
