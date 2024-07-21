<?php

// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir la conexión a la base de datos
require_once("../Models/CategoriaModel.php"); // Incluir el modelo de categoría

// TODO: Inicializando clase Categoria
$categoria = new Categoria(); // Crear una instancia de la clase Categoria

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    // TODO: Guardar y editar, guardar cuando el id está vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        // Obtener los valores enviados a través del formulario POST
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $cat_name = isset($_POST["cat_name"]) ? $_POST["cat_name"] : null;
        $cat_id = isset($_POST["cat_id"]) ? $_POST["cat_id"] : null;
        
        // Verificar que los campos obligatorios no estén vacíos
        if ($suc_id && $cat_name) {
            if (empty($cat_id)){
                // Si cat_id está vacío, se trata de una nueva categoría
                $categoria->insert_categoria($suc_id, $cat_name);
                echo json_encode([
                    'success' => true,
                    'message' => 'Categoria creada exitosamente'
                ]);
            } else {
                // Si cat_id tiene un valor, se actualiza la categoría existente
                $categoria->update_categoria($cat_id, $suc_id, $cat_name);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Registro actualizado exitosamente.'
                ]);
            }
        } else {
            // Respuesta de error si los datos están incompletos
            echo json_encode([
                'success' => false, 
                'message' => 'Datos incompletos.']);
        }
        break;

    // TODO: Listado de registros en formato JSON para DataTables JS
    case "listar":
        // Obtener datos de la base de datos según el suc_id
        $datos = $categoria->get_categoria_suc_id($_POST["suc_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["CAT_NAME"]; // Nombre de la categoría
            $sub_array[] = $row["CREATED_AT"]; // Fecha de creación
            $sub_array[] = '<button type="button" onClick="editar('.$row["CAT_ID"].')" id="'.$row["CAT_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>'; // Botón de editar
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["CAT_ID"].')" id="'.$row["CAT_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; // Botón de eliminar
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
        // Obtener la información de la categoría por cat_id
        $datos = $categoria->get_categoria_id($_POST["cat_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $output["SUC_ID"] = $row["SUC_ID"]; // ID de la sucursal
                $output["CAT_NAME"] = $row["CAT_NAME"]; // Nombre de la categoría
            }
            // Enviar la respuesta JSON
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar el estado del registro a 0 (eliminación lógica)
    case "eliminar":
        // Cambiar el estado de la categoría a eliminada
        $categoria->delete_categoria($_POST["cat_id"]);
        // Enviar la respuesta JSON de éxito
        echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente.']);
        break;
        
    // TODO: Generar un combo de categorías para una sucursal
    case "combo":
        // Obtener los datos de la categoría según el suc_id
        $datos = $categoria->get_categoria_suc_id($_POST["suc_id"]);   
        if (is_array($datos) && count($datos) > 0) {
            // Generar las opciones para el select
            $html = "<option selected value=''>Seleccionar Categoria</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["CAT_ID"] . "'>" . $row["CAT_NAME"] . "</option>";
            }
            // Enviar las opciones como respuesta
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron categorias</option>";
        }
        break;

    // TODO: Listar categorías y su stock total
    case "listar_stock_categorias":
        // Obtener el total de stock por categoría
        $datos = $categoria->get_categoria_total_stock($_POST["suc_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            // Generar la lista HTML con las categorías y sus stocks
            foreach($datos as $row){
            ?>  
                <li class="py-1">
                    <a href="#" class="text-muted"><?php echo $row["CAT_NAME"] ?><span class="float-end">(<?php echo $row["STOCK_TOTAL"] ?>)</span></a>
                </li>
            <?php
            }
        }
        break; 
}
?>
