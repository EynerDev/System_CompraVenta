<?php
// TODO: Llamando clases
require_once("../Config/conn.php"); // Incluir la conexión a la base de datos
require_once("../Models/ClienteModel.php"); // Incluir el modelo de cliente

// TODO: Inicializando clase Cliente
$cliente = new Cliente(); // Crear una instancia de la clase Cliente

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch ($_GET["op"]) {
    // TODO: Guardar y editar, guardar cuando el id está vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        // Obtener los valores enviados a través del formulario POST
        $emp_id = isset($_POST["emp_id"]) ? $_POST["emp_id"] : null;
        $tipo_doc_id = isset($_POST["tipo_doc_id"]) ? $_POST["tipo_doc_id"] : null;
        $cli_doc = isset($_POST["cli_doc"]) ? $_POST["cli_doc"] : null;
        $cli_name = isset($_POST["cli_name"]) ? $_POST["cli_name"] : null;
        $cli_number = isset($_POST["cli_number"]) ? $_POST["cli_number"] : null;
        $cli_direcc = isset($_POST["cli_direcc"]) ? $_POST["cli_direcc"] : null;
        $cli_email = isset($_POST["cli_email"]) ? $_POST["cli_email"] : null;
        $cli_id = isset($_POST["cli_id"]) ? $_POST["cli_id"] : null;

        // Verificar que los campos obligatorios no estén vacíos
        if ($emp_id && $tipo_doc_id && $cli_doc && $cli_name && $cli_number && $cli_direcc && $cli_email) {
            if (empty($cli_id)) {
                // Si cli_id está vacío, se trata de un nuevo cliente
                $cliente->insert_cliente($emp_id, $tipo_doc_id, $cli_doc, $cli_name, $cli_number, $cli_direcc, $cli_email);
                echo json_encode([
                    'success' => true,
                    'message' => 'Cliente creado exitosamente',
                    'icon' => 'success'
                ]);
            } else {
                // Si cli_id tiene un valor, se actualiza el cliente existente
                $cliente->update_cliente($cli_id, $emp_id, $tipo_doc_id, $cli_doc, $cli_name, $cli_number, $cli_direcc, $cli_email);
                echo json_encode([
                    'success' => true,
                    'message' => 'Registro actualizado exitosamente.',
                    'icon' => 'success'
                ]);
            }
        } else {
            // Respuesta de error si los datos están incompletos
            echo json_encode([
                'success' => false,
                'message' => 'Datos incompletos.',
                'icon' => 'error'
            ]);
        }
        break;

    // TODO: Listado de registros en formato JSON para DataTables JS
    case "listar":
        // Obtener datos de la base de datos según el emp_id
        $datos = $cliente->get_cliente_empresa_id($_POST["emp_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["CLI_NAME"]; // Nombre del cliente
            $sub_array[] = $row["CLI_DOC"]; // Documento del cliente
            $sub_array[] = $row["CLI_NUMBER"]; // Número de contacto del cliente
            $sub_array[] = $row["CLI_EMAIL"]; // Correo electrónico del cliente
            $sub_array[] = $row["CREATED_AT"]; // Fecha de creación
            $sub_array[] = '<button type="button" onClick="editar(' . $row["CLI_ID"] . ')" id="' . $row["CLI_ID"] . '" class="btn btn-soft-warning btn-icon waves-effect waves-light layout-rightside-btn"><i class=" ri-edit-line label-icon align-middle"></i></button>'; // Botón de editar
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["CLI_ID"] . ')" id="' . $row["CLI_ID"] . '" class="btn btn-soft-danger btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-delete-bin-5-line label-icon"></i></button>'; // Botón de eliminar
            $data[] = $sub_array; // Añadir el subarray al array principal
        }

        // Preparar la estructura final de la respuesta para DataTables
        $results = array(
            "sEcho" => 1, // Información del número de veces que se envía una solicitud
            "iTotalRecords" => count($data), // Total de registros
            "iTotalDisplayRecords" => count($data), // Total de registros a mostrar
            "aaData" => $data // Datos
        );

        // Enviar la respuesta JSON
        echo json_encode($results);
        break;

    // TODO: Mostrar información de un registro por su id
    case "mostrar":
        // Obtener la información del cliente por cli_id
        $datos = $cliente->get_cliente_id($_POST["cli_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["CLI_ID"] = $row["CLI_ID"]; // ID del cliente
                $output["EMP_ID"] = $row["EMP_ID"]; // ID de la empresa
                $output["CLI_NAME"] = $row["CLI_NAME"]; // Nombre del cliente
                $output["DESCRIPTION"] = $row["DESCRIPTION"]; // Descripción del cliente
                $output["TIPO_DOC_ID"] = $row["TIPO_DOC_ID"]; // ID del tipo de documento
                $output["CLI_DOC"] = $row["CLI_DOC"]; // Documento del cliente
                $output["CLI_NUMBER"] = $row["CLI_NUMBER"]; // Número de contacto del cliente
                $output["CLI_DIRECC"] = $row["CLI_DIRECC"]; // Dirección del cliente
                $output["CLI_EMAIL"] = $row["CLI_EMAIL"]; // Correo electrónico del cliente
            }
            // Enviar la respuesta JSON
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar el estado del registro a 0 (eliminación lógica)
    case "eliminar":
        // Cambiar el estado del cliente a eliminado
        $cliente->delete_cliente($_POST["cli_id"]);
        // Respuesta de éxito no enviada porque el bloque echo está vacío
        break;

    // TODO: Generar un combo de clientes para una empresa
    case "combo":
        // Obtener los datos de los clientes según el emp_id
        $datos = $cliente->get_cliente_empresa_id($_POST["emp_id"]);
        if (is_array($datos) && count($datos) > 0) {
            // Generar las opciones para el select
            $html = "<option selected value=''>Seleccionar Cliente</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["CLI_ID"] . "'>" . $row["CLI_NAME"] . "</option>";
            }
            // Enviar las opciones como respuesta
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron clientes</option>";
        }
        break;
}
?>
