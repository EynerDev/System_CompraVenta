<?php
// TODO: Llamando clases
require("../Config/conn.php"); // Incluir el archivo de conexión a la base de datos
require("../Models/EmpresaModel.php"); // Incluir el archivo del modelo EmpresaModel.php que contiene la clase Empresa

// TODO: Inicializando clase Empresa
$empresa = new Empresa(); // Crear una instancia de la clase Empresa para manejar operaciones relacionadas con empresas

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    // Caso para guardar y editar registros de empresas
    case "guardaryeditar":
        // Obtener los datos del formulario, con valores por defecto si no están presentes
        $com_id = isset($_POST["com_id"]) ? $_POST["com_id"] : null;
        $emp_name = isset($_POST["emp_name"]) ? $_POST["emp_name"] : null;
        $emp_rut = isset($_POST["emp_rut"]) ? $_POST["emp_rut"] : null; 
        $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null; 

        // Verificar que todos los datos necesarios estén presentes
        if ($com_id && $emp_name && $emp_rut) {
            // Si emp_id está vacío, insertar un nuevo registro; de lo contrario, actualizar el registro existente
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
            // Responder con un mensaje de error si los datos están incompletos
            echo json_encode([
                'success' => false, 
                'message' => 'Datos incompletos.'
            ]);
        }
        break;

    // Caso para listar registros de empresas en formato JSON para DataTables
    case "listar":
        // Obtener datos de la base de datos para la compañía especificada
        $datos = $empresa->get_empresa_compania_id($_POST["com_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["EMP_NAME"];
            $sub_array[] = $row["EMP_RUT"];
            $sub_array[] = $row["CREATED_AT"];
            // Botones para editar y eliminar, con llamadas a funciones JavaScript
            $sub_array[] = '<button type="button" onClick="editar('.$row["EMP_ID"].')" id="'.$row["EMP_ID"].'" class="btn btn-soft-warning btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-edit-line label-icon label-icon align-middle"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["EMP_ID"].')" id="'.$row["EMP_ID"].'" class="btn btn-soft-danger btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-delete-bin-5-line label-icon "></i></button>'; 
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

    // Caso para mostrar la información de un registro específico por su ID
    case "mostrar":
        $datos = $empresa->get_empresa_id($_POST["emp_id"]);
        if(is_array($datos) && count($datos) > 0){
            foreach($datos as $row){
                $output["EMP_ID"] = $row["EMP_ID"];
                $output["COM_ID"] = $row["COM_ID"];
                $output["EMP_NAME"] = $row["EMP_NAME"];
                $output["EMP_RUT"] = $row["EMP_RUT"];
            }
            // Enviar la información del registro en formato JSON
            echo json_encode($output);
        }
        break;

    // Caso para eliminar un registro cambiando su estado a 0 (lógico)
    case "eliminar":
        $empresa->delete_empresa($_POST["emp_id"]);
        break;

    // Caso para obtener un menú desplegable de empresas según el ID de la compañía
    case "combo":
        // Asegúrate de que com_id esté presente en $_POST
        if (isset($_POST["com_id"])) {
            
            // Convertir com_id a entero
            $valor = (int)$_POST["com_id"];
                
            // Obtener los datos de las empresas para la compañía especificada
            $datos = $empresa->get_empresa_compania_id($valor);   
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option selected>Seleccionar Empresa</option>";
                foreach ($datos as $row) {
                    // Construir las opciones del menú desplegable
                    $html .= "<option value='" . $row["EMP_ID"] . "'>" . $row["EMP_NAME"] . "</option>";
                }
                // Enviar el HTML del menú desplegable
                echo $html;
            } else {
                // Manejar el caso donde no se encuentran empresas
                echo "<option selected>No se encontraron empresas</option>";
            }
        } else {
            // Manejar el caso donde com_id no está presente en la solicitud POST
            echo "Error: com_id no está definido.";
        }
        break;
}
?>
