<?php
// TODO: Llamando clases
require_once("../config/conn.php"); // Incluir la conexión a la base de datos
require_once("../Models/CompaniaModel.php"); // Incluir el modelo de compañía

// TODO: Inicializando clase Compania
$compania = new Compania(); // Crear una instancia de la clase CompaniaModel

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch ($_GET["op"]) {
    // TODO: Guardar y editar, guardar cuando el id está vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        if (empty($_POST["com_id"])) {
            // Si com_id está vacío, se trata de una nueva compañía
            $compania->insert_compania($_POST["com_name"]);
        } else {
            // Si com_id tiene un valor, se actualiza la compañía existente
            $compania->update_compania($_POST["com_id"], $_POST["com_name"]);
        }
        break;

    // TODO: Listado de registros en formato JSON para DataTables JS
    case "listar":
        // Obtener datos de la base de datos
        $datos = $compania->get_compania();
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["com_name"]; // Nombre de la compañía
            $sub_array[] = "Eliminar"; // Botón de eliminar (no implementado)
            $sub_array[] = "Editar"; // Botón de editar (no implementado)
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
        // Obtener la información de la compañía por com_id
        $datos = $compania->get_compania_id($_POST["com_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["com_id"] = $row["com_id"]; // ID de la compañía
                $output["com_name"] = $row["com_name"]; // Nombre de la compañía
            }
            // Enviar la respuesta JSON
            echo json_encode($output);
        }
        break;

    // TODO: Eliminar o cambiar estado de registro a 0
    case "eliminar":
        // Cambiar el estado de la compañía a eliminado
        $compania->delete_compania($_POST["com_id"]);
        // Respuesta de éxito no enviada porque el bloque echo está vacío
        break;
}
?>
