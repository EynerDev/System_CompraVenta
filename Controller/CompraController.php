<?php

// TODO: Llamando clases
require_once("../Config/conn.php"); // Incluir la conexión a la base de datos
require_once("../Models/CompraModel.php"); // Incluir el modelo de compra

// TODO: Inicializando clase Compra
$compra = new Compra(); // Crear una instancia de la clase Compra

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch ($_GET["op"]) {
    case "registrar":
        // Registrar una nueva compra
        $datos = $compra->insert_compra_x_id($_POST["suc_id"], $_POST["user_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["COMPRA_ID"] = $row["COMPRA_ID"]; // ID de la compra
            }
            echo json_encode($output); // Enviar respuesta JSON
        }
        break;

    case "detalle":
        // Registrar detalle de la compra
        $compra->insert_compra_detalle($_POST["compra_id"], $_POST["prod_id"], $_POST["prod_pcompra"], $_POST["det_cant"]);
        break;

    case "listar_detalle":
        // Listar detalles de una compra específica
        $datos = $compra->get_compra_detalle($_POST["compra_id"]);
        $data = array();
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                // Mostrar imagen del producto si existe, de lo contrario mostrar imagen por defecto
                if ($row["PROD_IMG"] != '') {
                    $sub_array[] =
                        "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>" .
                        "<img src='../../assets/productos/" . $row["PROD_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                        "</div>" .
                        "</div>";
                } else {
                    $sub_array[] =
                        "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>" .
                        "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>" .
                        "</div>" .
                        "</div>";
                }
                // Añadir datos al array
                $sub_array[] = $row["CAT_NAME"];
                $sub_array[] = $row["PROD_NAME"];
                $sub_array[] = $row["UNID_NAME"];
                $sub_array[] = $row["PRECIO_PRODUCTO"];
                $sub_array[] = $row["DET_CANT"];
                $sub_array[] = $row["TOTAL"];
                $sub_array[] = '<button type="button" onClick="eliminar(' . $row["DET_ID"] . ',' . $row["COMPRA_ID"] . ')" id="' . $row["DET_ID"] . '" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>';
                $data[] = $sub_array;
            }
        }
        // Preparar y enviar respuesta JSON
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "eliminar":
        // Eliminar un detalle de compra
        $compra->delete_detalle_compra($_POST["det_id"]);
        break;

    case "calculo":
        // Calcular el total de la compra, incluyendo IVA
        $datos = $compra->get_compra_calculo($_POST["compra_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["SUB_TOTAL"] = $row["SUB_TOTAL"];
                $output["IVA"] = $row["IVA"];
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output); // Enviar respuesta JSON
        }
        break;

    case "guardar":
        // Guardar los cambios en la compra y actualizar el stock
        $compra->update_compra(
            $_POST["compra_id"],
            $_POST["pago_id"],
            $_POST["prov_id"],
            $_POST["prov_rut"],
            $_POST["prov_dirc"],
            $_POST["prov_email"],
            $_POST["mon_id"],
            $_POST["prov_number"],
            $_POST["prov_coment"],
            $_POST["doc_id"]
        );
        $compra->update_stock_compra($_POST["compra_id"]);
        break;

    case "listar_pdf":
        // Obtener datos de la compra para generar PDF
        $datos = $compra->get_compra_pdf($_POST["compra_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["COMPRA_ID"] = $row["COMPRA_ID"];
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["PAGO_ID"] = $row["PAGO_ID"];
                $output["PROV_ID"] = $row["PROV_ID"];
                $output["PROV_RUT"] = $row["PROV_RUT"];
                $output["PROV_DIRC"] = $row["PROV_DIRC"];
                $output["PROV_EMAIL"] = $row["PROV_EMAIL"];
                $output["MON_ID"] = $row["MON_ID"];
                $output["PROV_NUMBER"] = $row["PROV_NUMBER"];
                $output["SUB_TOTAL"] = $row["SUB_TOTAL"];
                $output["IVA"] = $row["IVA"];
                $output["TOTAL"] = $row["TOTAL"];
                $output["COMPRA_COMENT"] = $row["COMPRA_COMENT"];
                $output["EMP_EMAIL"] = $row["EMP_EMAIL"];
                $output["SUC_NAME"] = $row["SUC_NAME"];
                $output["EMP_TEL"] = $row["EMP_TEL"];
                $output["EMP_NAME"] = $row["EMP_NAME"];
                $output["EMP_RUT"] = $row["EMP_RUT"];
                $output["EMP_WEBSITE"] = $row["EMP_WEBSITE"];
                $output["FECHA_COMPRA"] = $row["FECHA_COMPRA"];
                $output["COM_NAME"] = $row["COM_NAME"];
                $output["USER_ID"] = $row["USER_ID"];
                $output["USER_NAME"] = $row["USER_NAME"];
                $output["MON_NAME"] = $row["MON_NAME"];
                $output["PAGO_NAME"] = $row["PAGO_NAME"];
                $output["USER_APE"] = $row["USER_APE"];
                $output["USER_EMAIL"] = $row["USER_EMAIL"];
                $output["PAGO_NAME"] = $row["PAGO_NAME"];
                $output["PAGO_NAME"] = $row["PAGO_NAME"];
                $output["PROV_NAME"] = $row["PROV_NAME"];
                $output["EMP_DIRC"] = $row["EMP_DIRC"];
            }
            echo json_encode($output); // Enviar respuesta JSON
        }
        break;

    case "listar_detalle_pdf":
        // Listar los detalles de la compra para el PDF
        $datos = $compra->get_compra_detalle($_POST["compra_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                ?>
                <tr>
                    <td scope="">
                        <?php
                        if ($row["PROD_IMG"] != '') {
                            // Mostrar imagen del producto si existe
                            echo "<div class='d-flex align-items-center'>" .
                                "<div class='flex-shrink-0 me-2'>" .
                                "<img src='../../assets/productos/" . $row["PROD_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                                "</div>" .
                                "</div>";
                        } else {
                            // Mostrar imagen por defecto si no existe imagen del producto
                            echo "<div class='d-flex align-items-center'>" .
                                "<div class='flex-shrink-0 me-2'>" .
                                "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>" .
                                "</div>" .
                                "</div>";
                        }
                        ?>
                    </td>
                    <td scope=""><?php echo $row["CAT_NAME"] ?></td>
                    <td scope=""><?php echo $row["PROD_NAME"] ?></td>
                    <td scope="row"><?php echo $row["UNID_NAME"] ?></td>
                    <td scope=""><?php echo $row["PRECIO_PRODUCTO"] ?></td>
                    <td scope=""><?php echo $row["DET_CANT"] ?></td>
                    <td scope="text_end"><?php echo $row["TOTAL"] ?></td>
                </tr>
                <?php
            }
            echo json_encode($datos); // Enviar respuesta JSON
        }
        break;

    case "listar_compra":
        // Listar todas las compras de una sucursal
        $datos = $compra->get_list_compra($_POST["suc_id"]);
        $data = array();
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                $sub_array = array();
                // Añadir datos de compra al array
                $sub_array[] = "C-" . $row["COMPRA_ID"];
                $sub_array[] = $row["PROV_NAME"];
                $sub_array[] = $row["DOC_NAME"];
                $sub_array[] = $row["PROV_RUT"];
                $sub_array[] = $row["PAGO_NAME"];
                $sub_array[] = $row["MON_NAME"];
                $sub_array[] = $row["SUB_TOTAL"];
                $sub_array[] = $row["IVA"];
                $sub_array[] = $row["TOTAL"];
                $sub_array[] = $row["USER_NAME"] . " " . $row["USER_APE"];
                $sub_array[] = $row["FECHA_COMPRA"];
                // Añadir botones de acciones
                $sub_array[] = '<button type="button" onClick="redirigirAVistaCompra(' . $row["COMPRA_ID"] . ')" id="' . $row["COMPRA_ID"] . '" class="btn btn-soft-secondary btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-file-list-3-line label-icom"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar(' . $row["COMPRA_ID"] . ')" id="' . $row["COMPRA_ID"] . '" class="btn btn-soft-danger btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-delete-bin-5-line label-icon "></i></button>';
                $sub_array[] = '<button type="button" onClick="verDetalle(' . $row["COMPRA_ID"] . ')" id="' . $row["COMPRA_ID"] . '" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-eye-line label-icon"></i></button>';
                $data[] = $sub_array;
            }
        }
        // Preparar y enviar respuesta JSON
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "listar_top_productos":
        // Listar los productos más comprados
        $datos = $compra->get_compra_top_productos($_POST["suc_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                ?>
                <tr>
                    <td scope="">
                        <div class="d-flex align-items-center">
                            <?php
                            if ($row["PROD_IMG"] != '') {
                                // Mostrar imagen del producto si existe
                                echo "<div class='avatar-sm bg-light rounded p-1 me-2'>" .
                                    "<img src='../../assets/productos/" . $row["PROD_IMG"] . "' alt='' class='avatar-xs rounded-circle'>" .
                                    "</div>";
                            } else {
                                // Mostrar imagen por defecto si no existe imagen del producto
                                echo "<div class='avatar-sm bg-light rounded p-1 me-2'>" .
                                    "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>" .
                                    "</div>";
                            }
                            ?>
                            <div>
                                <h5 class="fs-14 my-1"><?php echo $row["PROD_NAME"] ?></a></h5>
                                <span class="text-muted"><?php echo $row["CAT_NAME"] ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-14 my-1 fw-normal"><?php echo $row["CANT"] ?></h5>
                        <span class="text-muted">Cantidad</span>
                    </td>
                    <td>
                        <h5 class="fs-14 my-1 fw-normal"><?php echo $row["PRECIO_PRODUCTO"] ?></h5>
                        <span class="text-muted">Price</span>
                    </td>

                    <td>
                        <h5 class="fs-14 my-1 fw-normal"><?php echo $row["PROD_STOCK"] ?></h5>
                        <span class="text-muted">Stock</span>
                    </td>
                    <td>
                        <h5 class="fs-14 my-1 fw-normal"><?php echo $row["UNID_NAME"] ?></h5>
                        <span class="text-muted">Unidad</span>
                    </td>
                    <td>
                        <h5 class="fs-14 my-1 fw-normal"><?php echo $row["MON_NAME"] ?></h5>
                        <span class="text-muted">Moneda</span>
                    </td>
                    <td>
                        <h5 class="fs-14 my-1 fw-normal">$<?php echo $row["TOTAL"] ?></h5>
                        <span class="text-muted">Total</span>
                    </td>
                </tr>
                <?php
            }
            echo json_encode($datos); // Enviar respuesta JSON
        }
        break;

    case "listar_top_compras":
        // Listar las compras más grandes
        $datos = $compra->get_list_compra_top($_POST["suc_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                ?>
                <tr>
                    <td>
                        <a href="" class="fw-medium link-primary">#-C<?php echo $row["COMPRA_ID"] ?></a>
                    </td>
                    <td>
                        <div class="flex-grow-1"><?php echo $row["USER_NAME"] . " " . $row["USER_APE"] ?></div>
                    </td>
                    <td><?php echo $row["PROV_NAME"] ?></td>
                    <td>
                        <span class="text-success"><?php echo $row["MON_NAME"] ?></span>
                    </td>
                    <td><?php echo $row["SUB_TOTAL"] ?></td>
                    <td>
                        <span class=""><?php echo $row["IVA"] ?></span>
                    </td>
                    <td>
                        <span class=""><?php echo $row["TOTAL"] ?></span>
                    </td>
                </tr>
                <?php
            }
            echo json_encode($datos); // Enviar respuesta JSON
        }
        break;
    case "listar_top_compras_ventas":
        // Listar las compras más grandes
        $datos = $compra->get_list_compra_venta($_POST["suc_id"]);
        if (is_array($datos) == TRUE and count($datos) > 0) {
            foreach ($datos as $row) {
                ?>
                <div class="acitivity-item d-flex">
                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                            <?php 
                                if($row["REGISTRO_DOC"] == 'Compra'){
                                    ?>
                                        <div class="avatar-title bg-soft-success text-success rounded-circle">
                                        <i class="ri-shopping-cart-2-line"></i>
                                        </div>
                                    <?php
                                }else{
                                    ?>
                                        <div class="avatar-title bg-soft-danger text-success rounded-circle">
                                        <i class=" ri-line-chart-line"></i>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 lh-base"><?php echo $row["REGISTRO_DOC"]?>-<?php echo $row["DOC_NAME"]?></h6>
                            <p class="text-muted mb-1"><?php echo $row["PROV_NAME"]?></p>
                            <small class="mb-0 text-muted"><?php echo $row["FECHA_COMPRA"]?></small>
                        </div>
                    </div>
                    
                    <?php
            }
        }
        break;
    case "dountcompra":
        $datos = $compra->get_consumo_compra_cat($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;
    case "comprabarras":
        $datos = $compra->get_compra_grafico_barra($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;
    case "eliminar_compra":
        $compra->delete_compra($_POST["compra_id"]);
        break;

    
}
?>
