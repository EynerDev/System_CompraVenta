<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/ProductoModel.php");
// TODO:Inicializando clase Producto
    $producto = new ProductoModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["prod_id"])){
                $producto->insert_producto(
                    $_POST["suc_id"],
                    $_POST["cat_id"],
                    $_POST["prod_name"],
                    $_POST["prod_description"],
                    $_POST["unid_id"],
                    $_POST["mon_id"],
                    $_POST["prod_pcompra"],
                    $_POST["prod_pventa"],
                    $_POST["prod_stock"],
                    $_POST["prod_fecha_en"],
                    $_POST["prod_img"],
                );
                    
            }else{
                $producto->update_producto(
                $_POST["prod_id"],
                $_POST["suc_id"],
                $_POST["cat_id"],
                $_POST["prod_name"],
                $_POST["prod_description"],
                $_POST["unid_id"],
                $_POST["mon_id"],
                $_POST["prod_pcompra"],
                $_POST["prod_pventa"],
                $_POST["prod_stock"],
                $_POST["prod_fecha_en"],
                $_POST["prod_img"],);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $producto->get_producto_sucursal_id($_POST["suc_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["prod_name"];
                $sub_array = $row["prod_description"];
                $sub_array = $row["unid_id"];
                $sub_array = $row["prod_pcompra"];
                $sub_array = $row["prod_pventa"];
                $sub_array = $row["prod_stock"];
                $sub_array = $row["prod_fecha_en"];
                $sub_array = $row["prod_img"];
                $sub_array = "Eliminar";
                $sub_array = "Editar";
                $data[] = $sub_array;

                $results = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($results);
            }

            break;
            // TODO: Mostrar informacion de un registro por su id
        case "mostrar":
            $datos = $producto->get_producto_id($_POST["prod_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["prod_id"] = $row["prod_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["prod_name"] = $row["prod_name"];
                    $output["prod_description"] = $row["prod_description"];
                    $output["prod_pcompra"] = $row["prod_pcompra"];
                    $output["prod_pventa"] = $row["prod_pventa"];
                    $output["prod_stock"] = $row["prod_stock"];
                    $output["prod_fecha_en"] = $row["prod_fecha_en"];
                    $output["prod_img"] = $row["prod_img"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $producto->delete_producto($_POST["prod_id"]);
            break;

    }




?>