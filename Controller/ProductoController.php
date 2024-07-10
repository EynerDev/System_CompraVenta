<?php
// TODO: Llamando clases
require_once("../Config/conn.php");
require_once("../Models/ProductoModel.php");

// TODO: Inicializando clase Producto
$producto = new Producto();

switch ($_GET["op"]) {
    case "guardaryeditar":
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
        $prod_img = isset($_POST["prod_img"]) ? $_POST["prod_img"] : null;

        $prod_img = null;
        $prod_img_type = null;

        if (isset($_FILES["prod_img"]) && $_FILES["prod_img"]["error"] == 0) {
            $prod_img = file_get_contents($_FILES["prod_img"]["tmp_name"]);
            $prod_img_type = $_FILES["prod_img"]["type"];
        }


        if (empty($prod_id)) {
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

    // TODO: Listado de registros formato JSON para datatable JS
    case "listar":
        $datos = $producto->get_producto_sucursal_id($_POST["suc_id"]);
        $data  = array();
        foreach ($datos as $row) {
            $sub_array = array();
            if ($row["PROD_IMG"] != ''){
                $sub_array[] =
                "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>".
                        "<img src='../../assets/productos/".$row["PROD_IMG"]."' alt='' class='avatar-xs rounded-circle'>".
                    "</div>".
                "</div>";
            }else{
                $sub_array[] =
                "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>".
                        "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>".
                    "</div>".
                "</div>";
            }
            $sub_array[] = $row["CAT_NAME"];
            $sub_array[] = $row["PROD_NAME"];
            $sub_array[] = $row["UNID_NAME"];
            $sub_array[] = $row["MON_NAME"];
            $sub_array[] = $row["PROD_PCOMPRA"];
            $sub_array[] = $row["PROD_PVENTA"];
            $sub_array[] = $row["PROD_STOCK"];
            $sub_array[] = $row["CREATED_AT"];
            $sub_array[] = '<button type="button" onClick="editar(' . $row["PROD_ID"] . ')" id="' . $row["PROD_ID"] . '" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["PROD_ID"] . ')" id="' . $row["PROD_ID"] . '" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>';
            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    // TODO: Mostrar información de un registro por su id
    case "mostrar":
        $datos = $producto->get_producto_id($_POST["prod_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
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
                if($row["PROD_IMG"] != ''){
                    $output["PROD_IMG"] = '<img src="../../assets/productos/'.$row["PROD_IMG"].'" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="'.$row["PROD_IMG"].'" />';
                }else{
                    $output["PROD_IMG"] = '<img src="../../assets/productos/error_404.jpeg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="" />';

                }
            }
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar estado de registro a 0
    case "eliminar":
        $producto->delete_producto($_POST["prod_id"]);
        break;

    case "combo":
        // Obtener los datos de la empresa
        $datos = $producto->get_producto_cat_id($_POST["cat_id"]);
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected value=''>Seleccionar Producto</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PROD_ID"] . "'>" . $row["PROD_NAME"] . "</option>";
            }
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron categorias</option>";
        }
        break;
}
?>
