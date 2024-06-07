<?php

// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/CategoriaModel.php");

// TODO: Inicializando clase Categoria
$categoria = new Categoria();

switch($_GET["op"]){
    // TODO: Guardar y editar, guardar cuando el id en vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $cat_name = isset($_POST["cat_name"]) ? $_POST["cat_name"] : null;
        $cat_id = isset($_POST["cat_id"]) ? $_POST["cat_id"] : null;
        
        if ($suc_id && $cat_name) {
            if (empty($cat_id)){
                $categoria->insert_categoria($suc_id, $cat_name);
                echo json_encode([
                    'success' => true,
                    'message' => 'Categoria creada exitosamente'
                ]);
            } else {
                $categoria->update_categoria($cat_id, $suc_id, $cat_name);
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
        $datos = $categoria->get_categoria_suc_id($_POST["suc_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["CAT_NAME"];
            $sub_array[] = $row["CREATED_AT"];
            $sub_array[] = '<button type="button" onClick="editar('.$row["CAT_ID"].')" id="'.$row["CAT_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["CAT_ID"].')" id="'.$row["CAT_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
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
        $datos = $categoria->get_categoria_id($_POST["cat_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["CAT_NAME"] = $row["CAT_NAME"];
            }
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar estado de registro a 0
    case "eliminar":
        $categoria->delete_categoria($_POST["cat_id"]);
        echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente.']);
        break;
    case "combo":
        // Obtener los datos de la empresa
        $datos = $categoria->get_categoria_suc_id($_POST["suc_id"]);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected>Seleccionar Tipo Documento</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["CAT_ID"] . "'>" . $row["CAT_NAME"] . "</option>";
            }
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron categorias</option>";
        }
        break;
}
?>
