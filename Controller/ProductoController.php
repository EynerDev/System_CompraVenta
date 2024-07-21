<?php

// TODO: Llamando clases
require_once("../Config/conn.php"); // Incluir el archivo de configuración para la conexión a la base de datos
require_once("../Models/ProductoModel.php"); // Incluir el archivo del modelo ProductoModel.php que contiene la clase Producto

// TODO: Inicializando clase Producto
$producto = new Producto(); // Crear una instancia de la clase Producto para manejar operaciones relacionadas con productos

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch ($_GET["op"]) {
    
    // TODO: Guardar y editar productos
    case "guardaryeditar":
        // Obtener datos del formulario POST
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $cat_id = isset($_POST["cat_id"]) ? $_POST["cat_id"] : null;
        $prod_name = isset($_POST["prod_name"]) ? $_POST["prod_name"] : null;
        $prod_descrip = isset($_POST["prod_descrip"]) ? $_POST["prod_descrip"] : null;
        $unid_id = isset($_POST["unid_id"]) ? $_POST["unid_id"] : null;
        $mon_id = isset($_POST["mon_id"]) ? $_POST["mon_id"] : null;
        $prod_pcompra = isset($_POST["prod_pcompra"]) ? $_POST["prod_pcompra"] : null;
        $prod_pventa = isset($_POST["prod_pventa"]) ? $_POST["prod_pventa"] : null;
        $prod_stock = isset($_POST["prod_stock"]) ? $_POST["prod_stock"] : null;
        $prod_fecha_en = isset($_POST["prod_fecha_en"]) ? $_POST["prod_fecha_en"] : null;
        $prod_id = isset($_POST["prod_id"]) ? $_POST["prod_id"] : null;
        $prod_img = isset($_FILES["prod_img"]) && $_FILES["prod_img"]["error"] == 0 ? file_get_contents($_FILES["prod_img"]["tmp_name"]) : null;
        $prod_img_type = isset($_FILES["prod_img"]) ? $_FILES["prod_img"]["type"] : null;

        // Verificar si es una operación de inserción o actualización
        if (empty($prod_id)) {
            // Insertar un nuevo producto
            $producto->insert_producto(
                $suc_id,
                $cat_id,
                $prod_name,
                $prod_descrip,
                $unid_id,
                $mon_id,
                $prod_pcompra,
                $prod_pventa,
                $prod_stock,
                $prod_fecha_en,
                $prod_img,
                $prod_img_type
            );
            echo json_encode([
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'icon' => 'success'
            ]);
        } else {
            // Actualizar un producto existente
            $producto->update_producto(
                $prod_id,
                $suc_id,
                $cat_id,
                $prod_name,
                $prod_descrip,
                $unid_id,
                $mon_id,
                $prod_pcompra,
                $prod_pventa,
                $prod_stock,
                $prod_fecha_en,
                $prod_img,
                $prod_img_type
            );
            echo json_encode([
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'icon' => 'success'
            ]);
        }
        break;

    // TODO: Listado de registros formato JSON para DataTables JS
    case "listar":
        // Obtener datos de productos desde el modelo
        $datos = $producto->get_producto_sucursal_id($_POST["suc_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            // Verificar si la imagen del producto está disponible
            if ($row["PROD_IMG"] != ''){
                $sub_array[] =
                "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>".
                        "<img src='../../assets/productos/".$row["PROD_IMG"]."' alt='' class='avatar-xs rounded-circle'>".
                    "</div>".
                "</div>";
            } else {
                $sub_array[] =
                "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>".
                        "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>".
                    "</div>".
                "</div>";
            }
            // Añadir otros datos del producto al array
            $sub_array[] = $row["CAT_NAME"];
            $sub_array[] = $row["PROD_NAME"];
            $sub_array[] = $row["UNID_NAME"];
            $sub_array[] = $row["MON_NAME"];
            $sub_array[] = $row["PROD_PCOMPRA"];
            $sub_array[] = $row["PROD_PVENTA"];
            $sub_array[] = $row["PROD_STOCK"];
            $sub_array[] = $row["CREATED_AT"];
            // Botones para editar y eliminar el producto
            $sub_array[] = '<button type="button" onClick="editar(' . $row["PROD_ID"] . ')" id="' . $row["PROD_ID"] . '" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["PROD_ID"] . ')" id="' . $row["PROD_ID"] . '" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>';
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

    // TODO: Mostrar información de un producto por su ID
    case "mostrar":
        // Obtener información del producto por ID
        $datos = $producto->get_producto_id($_POST["prod_id"]);
        if (is_array($datos) == true && count($datos) > 0) {
            foreach ($datos as $row) {
                $output["PROD_ID"] = $row["PROD_ID"];
                $output["CAT_ID"] = $row["CAT_ID"];
                $output["CAT_NAME"] = $row["CAT_NAME"];
                $output["PROD_NAME"] = $row["PROD_NAME"];
                $output["PROD_DESCRIP"] = $row["PROD_DESCRIP"];
                $output["UNID_ID"] = $row["UNID_ID"];
                $output["UNID_NAME"] = $row["UNID_NAME"];
                $output["MON_ID"] = $row["MON_ID"];
                $output["MON_NAME"] = $row["MON_NAME"];
                $output["PROD_PCOMPRA"] = $row["PROD_PCOMPRA"];
                $output["PROD_PVENTA"] = $row["PROD_PVENTA"];
                $output["PROD_STOCK"] = $row["PROD_STOCK"];
                // Mostrar la imagen del producto si está disponible
                if ($row["PROD_IMG"] != ''){
                    $output["PROD_IMG"] = '<img src="../../assets/productos/'.$row["PROD_IMG"].'" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="'.$row["PROD_IMG"].'" />';
                } else {
                    $output["PROD_IMG"] = '<img src="../../assets/productos/error_404.jpeg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="" />';
                }
            }
            echo json_encode($output);
        }
        break;

    // TODO: Eliminar un producto
    case "eliminar":
        // Eliminar el producto por ID
        $producto->delete_producto($_POST["prod_id"]);
        echo json_encode([
            'success' => true,
            'message' => 'Producto eliminado exitosamente',
            'icon' => 'success'
        ]);
        break;

    // TODO: Obtener productos para un combo (select) basado en la categoría
    case "combo":
        // Obtener los datos de productos para la categoría especificada
        $datos = $producto->get_producto_cat_id($_POST["cat_id"]);
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected value=''>Seleccionar Producto</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PROD_ID"] . "'>" . $row["PROD_NAME"] . "</option>";
            }
            echo $html; // Enviar el HTML generado
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron productos</option>";
        }
        break;
}
?>
