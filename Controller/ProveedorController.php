<?php
// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir el archivo de configuración para la conexión a la base de datos
require_once("../Models/ProveedorModel.php"); // Incluir el archivo del modelo ProveedorModel.php que contiene la clase Proveedor

// TODO: Inicializando clase Proveedor
$proveedor = new Proveedor(); // Crear una instancia de la clase Proveedor para manejar operaciones relacionadas con proveedores

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]) {

    // TODO: Guardar y editar proveedores
    case "guardaryeditar":
        // Obtener datos del formulario POST
        $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null;
        $prov_rut = isset($_POST["prov_rut"]) ? $_POST["prov_rut"] : null;
        $prov_name = isset($_POST["prov_name"]) ? $_POST["prov_name"] : null;
        $prov_number = isset($_POST["prov_number"]) ? $_POST["prov_number"] : null;
        $prov_dirc = isset($_POST["prov_dirc"]) ? $_POST["prov_dirc"] : null;
        $prov_email = isset($_POST["prov_email"]) ? $_POST["prov_email"] : null;
        $prov_id = isset($_POST["prov_id"]) ? $_POST["prov_id"] : null;
        
        // Verificar que todos los campos requeridos estén presentes
        if ($emp_id && $prov_rut && $prov_name && $prov_number && $prov_dirc && $prov_email) {
            if (empty($prov_id)){
                // Insertar nuevo proveedor
                $proveedor->insert_proveedor($emp_id, $prov_name, $prov_rut, $prov_number, $prov_dirc, $prov_email);
                echo json_encode([
                    'success' => true,
                    'message' => 'Proveedor creado exitosamente',
                    'icon' => 'success'
                ]);
            } else {
                // Actualizar proveedor existente
                $proveedor->update_proveedor($prov_id, $emp_id, $prov_name, $prov_rut, $prov_number, $prov_dirc, $prov_email);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Registro actualizado exitosamente.',
                    'icon' => 'success'
                ]);
            }
        } else {
            // Datos incompletos
            echo json_encode([
                'success' => false, 
                'message' => 'Datos incompletos.',
                'icon' => 'error'
            ]);
        }
        break;

    // TODO: Listado de proveedores en formato JSON para DataTables JS
    case "listar":
        // Obtener datos de proveedores desde el modelo
        $datos = $proveedor->get_proveedor_empresa_id($_POST["emp_id"]);
        $data  = array();
        foreach($datos as $row){
            $sub_array = array();
            // Agregar información del proveedor al array
            $sub_array[] = $row["PROV_NAME"];
            $sub_array[] = $row["PROV_RUT"];
            $sub_array[] = $row["PROV_NUMBER"];
            $sub_array[] = $row["PROV_EMAIL"];
            $sub_array[] = $row["CREATED_AT"];
            // Botones para editar y eliminar el proveedor
            $sub_array[] = '<button type="button" onClick="editar('.$row["PROV_ID"].')" id="'.$row["PROV_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["PROV_ID"].')" id="'.$row["PROV_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
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

    // TODO: Mostrar información de un proveedor por su ID
    case "mostrar":
        // Obtener información del proveedor por ID
        $datos = $proveedor->get_proveedor_id($_POST["prov_id"]);
        if (is_array($datos) == TRUE && count($datos) > 0){
            foreach($datos as $row){
                $output["PROV_ID"] = $row["PROV_ID"];
                $output["EMP_ID"] = $row["EMP_ID"];
                $output["PROV_NAME"] = $row["PROV_NAME"];
                $output["PROV_RUT"] = $row["PROV_RUT"];
                $output["PROV_DIRC"] = $row["PROV_DIRC"];
                $output["PROV_NUMBER"] = $row["PROV_NUMBER"];
                $output["PROV_EMAIL"] = $row["PROV_EMAIL"];
            }
            echo json_encode($output);
        }
        break;

    // TODO: Eliminar proveedor
    case "eliminar":
        // Eliminar proveedor por ID
        $proveedor->delete_proveedor($_POST["prov_id"]);
        echo json_encode([
            'success' => true,
            'message' => 'Proveedor eliminado exitosamente',
            'icon' => 'success'
        ]);
        break;

    // TODO: Obtener proveedores para un combo (select) basado en la empresa
    case "combo":
        // Obtener los datos de proveedores para la empresa especificada
        $datos = $proveedor->get_proveedor_empresa_id($_POST["emp_id"]);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected value=''>Seleccionar proveedor</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PROV_ID"] . "'>" . $row["PROV_NAME"] . "</option>";
            }
            echo $html; // Enviar el HTML generado
        } else {
            // Manejar el caso donde no se encuentran proveedores
            echo "<option selected>No se encontraron proveedores</option>";
        }
        break;
}
?>
