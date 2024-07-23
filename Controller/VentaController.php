<?php

// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/VentaModel.php");

// TODO: Inicializando clase Venta
$venta = new Venta();

switch($_GET["op"]){
    case "registrar":
        $datos = $venta->insert_venta_x_id($_POST["suc_id"],$_POST["user_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $output["VENTA_ID"] = $row["VENTA_ID"];
            }
            echo json_encode($output);
        }
        break;
case "detalle":
    $prod_pventa = isset($_POST["prod_pventa"]) ? $_POST["prod_pventa"] : null;
    $venta_id = isset($_POST["venta_id"]) ? $_POST["venta_id"] : null;
    $det_venta_cant = isset($_POST["det_venta_cant"]) ? $_POST["det_venta_cant"] : null;
    $prod_id = isset($_POST["prod_id"]) ? $_POST["prod_id"] : null;

    // Obtener el stock actual y forzar el tipo de dato a entero
    $stock_actual = (int)$venta->get_stock_actual($prod_id);

    // Forzar el tipo de la cantidad de venta a entero
    $det_venta_cant = (int)$det_venta_cant;

    // Verificar si la cantidad de venta es mayor que el stock actual
    if ($det_venta_cant > $stock_actual) {
        echo json_encode([
            "success" => false,
            "message" => "No hay stock suficiente"
        ]);
    } else {
        // Insertar detalle de venta
        $datos = $venta->insert_venta_detalle($venta_id, $prod_id, $prod_pventa, $det_venta_cant);

        echo json_encode([
            "success" => true,
            "message" => "Detalle de venta agregado con éxito."
        ]);
    }
    break;

    case "listar_detalle":
        $datos = $venta->get_venta_detalle($_POST["venta_id"]);
        $data  = array();
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
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
                $sub_array[]= $row["CAT_NAME"];
                $sub_array[]= $row["PROD_NAME"];
                $sub_array[]= $row["UNID_NAME"];
                $sub_array[]= $row["PRECIO_PRODUCTO"];
                $sub_array[]= $row["DET_VENTA_CANT"];
                $sub_array[]= $row["TOTAL"];
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["DET_VENTA_ID"].','.$row["VENTA_ID"].')" id="'.$row["DET_VENTA_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
                $data[] = $sub_array;

            }
        }
        $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
        break;
    case "eliminar":
        $venta->delete_detalle_venta($_POST["det_venta_id"]);
        break; 
    case "calculo":
        $datos = $venta->get_venta_calculo($_POST["venta_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
            $output["SUB_TOTAL"] = $row["SUB_TOTAL"];
            $output["IVA"] = $row["IVA"];
            $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;   
    case "guardar":
        $datos = $venta->update_venta(
            $_POST["venta_id"],
            $_POST["pago_id"],
            $_POST["cli_id"],
            $_POST["cli_tipo_doc_id"],
            $_POST["cli_doc"],
            $_POST["cli_direcc"],
            $_POST["cli_email"],
            $_POST["cli_number"],
            $_POST["mon_id"],
            $_POST["venta_coment"],
            $_POST["doc_id"]

        );
        $venta->update_stock_venta($_POST["venta_id"]);
        break;
    case "listar_pdf":

        $datos = $venta->get_venta_pdf($_POST["venta_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
            $output["VENTA_ID"] = $row["VENTA_ID"];
            $output["SUC_ID"] = $row["SUC_ID"];
            $output["PAGO_ID"] = $row["PAGO_ID"];
            $output["CLI_ID"] = $row["CLI_ID"];
            $output["CLI_DOC"] = $row["CLI_DOC"];
            $output["CLI_DIRECC"] = $row["CLI_DIRECC"];
            $output["CLI_EMAIL"] = $row["CLI_EMAIL"];
            $output["MON_ID"] = $row["MON_ID"];
            $output["CLI_NUMBER"] = $row["CLI_NUMBER"];
            $output["SUB_TOTAL"] = $row["SUB_TOTAL"];
            $output["IVA"] = $row["IVA"];
            $output["TOTAL"] = $row["TOTAL"];
            $output["VENTA_COMENT"] = $row["VENTA_COMENT"];
            $output["USER_ID"] = $row["USER_ID"];
            $output["FECHA_VENTA"] = $row["FECHA_VENTA"];
            $output["ACTIVE"] = $row["ACTIVE"];
            $output["SUC_NAME"] = $row["SUC_NAME"];
            $output["EMP_EMAIL"] = $row["EMP_EMAIL"];
            $output["EMP_WEBSITE"] = $row["EMP_WEBSITE"];
            $output["EMP_TEL"] = $row["EMP_TEL"];
            $output["EMP_DIRC"] = $row["EMP_DIRC"];
            $output["EMP_NAME"] = $row["EMP_NAME"];
            $output["EMP_RUT"] = $row["EMP_RUT"];
            $output["COM_NAME"] = $row["COM_NAME"];
            $output["USER_NUMBER"] = $row["USER_NUMBER"];
            $output["USER_DOCUMENT"] = $row["USER_DOCUMENT"];
            $output["USER_NAME"] = $row["USER_NAME"];
            $output["USER_APE"] = $row["USER_APE"];
            $output["USER_ROLE_ID"] = $row["USER_ROLE_ID"];
            $output["USER_EMAIL"] = $row["USER_EMAIL"];
            $output["MON_NAME"] = $row["MON_NAME"];
            $output["PAGO_NAME"] = $row["PAGO_NAME"];
            $output["CLI_NAME"] = $row["CLI_NAME"];
            }
            echo json_encode($output);
        }
        break;
    case "listar_detalle_pdf":
        $datos = $venta->get_venta_detalle($_POST["venta_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
            ?>
                <tr>
                    <td scope="">
                    <?php 
                        if ($row["PROD_IMG"] != ''){
                            ?>
                                <?php 
                                    echo "<div class='d-flex align-items-center'>" .
                                        "<div class='flex-shrink-0 me-2'>".
                                            "<img src='../../assets/productos/".$row["PROD_IMG"]."' alt='' class='avatar-xs rounded-circle'>".
                                        "</div>".
                                    "</div>";
                                ?>
                            <?php 
                        }else{
                            ?>
                                <?php 
                                    echo "<div class='d-flex align-items-center'>" .
                                        "<div class='flex-shrink-0 me-2'>".
                                            "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>".
                                        "</div>".
                                    "</div>";
                                ?>
                            <?php 
                        }
                
                    ?>
                    </td>
                    <td scope=""><?php echo $row["CAT_NAME"]?></td>
                    <td scope=""><?php echo $row["PROD_NAME"]?></td>
                    <td scope="row"><?php echo $row["UNID_NAME"]?></td>
                    <td scope=""><?php echo $row["PRECIO_PRODUCTO"]?></td>
                    <td scope=""><?php echo $row["DET_VENTA_CANT"]?></td>
                    <td scope="text_end"><?php echo $row["TOTAL"]?></td>
            
                </tr>
              
            <?php
            }
            echo json_encode($datos);
        }
        break; 
    case "listar_venta":
        $datos = $venta->get_list_venta($_POST["suc_id"]);
        $data  = array();
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[]= "C-".$row["VENTA_ID"];
                $sub_array[]= $row["DOC_NAME"];
                $sub_array[]= $row["CLI_NAME"];
                $sub_array[]= $row["CLI_DOC"];
                $sub_array[]= $row["PAGO_NAME"];
                $sub_array[]= $row["MON_NAME"];
                $sub_array[]= $row["SUB_TOTAL"];
                $sub_array[]= $row["IVA"];
                $sub_array[]= $row["TOTAL"];
                $sub_array[]= $row["USER_NAME"]." ".$row["USER_APE"];
                $sub_array[]= $row["FECHA_VENTA"];
                $sub_array[] = '<button type="button" onClick="redirigirAVistaVenta('.$row["VENTA_ID"].')" id="'.$row["VENTA_ID"].'" class="btn btn-soft-secondary btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-file-list-3-line label-icom"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["VENTA_ID"].')" id="'.$row["VENTA_ID"].'" class="btn btn-soft-danger btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-delete-bin-5-line label-icon "></i></button>'; 
                $sub_array[] = '<button type="button" onClick="verDetalle('.$row["VENTA_ID"].')" id="'.$row["VENTA_ID"].'" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-eye-line label-icon"></i></button>'; 
                $data[] = $sub_array;
    
            }
        }
        $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
        break;
    case "listar_top_productos":
            $datos = $venta->get_venta_top_productos($_POST["suc_id"]);
                if(is_array($datos) == TRUE and count($datos) > 0){
                    foreach($datos as $row){
                    ?>
                        <tr>
                            <td scope="">
                                <div class="d-flex align-items-center">
                                    <?php 
                                        if ($row["PROD_IMG"] != ''){
                                            ?>
                                                <?php 
                                                    echo "<div class='avatar-sm bg-light rounded p-1 me-2'>".
                                                            "<img src='../../assets/productos/".$row["PROD_IMG"]."' alt='' class='avatar-xs rounded-circle'>".
                                                        "</div>"
                                                
                                                ?>
                                            <?php 
                                        }else{
                                            ?>
                                                <?php 
                                                    echo"<div class='avatar-sm bg-light rounded p-1 me-2'>".
                                                            "<img src='../../assets/productos/error_404.jpeg' alt='' class='avatar-xs rounded-circle'>".
                                                        "</div>"
                                                    
                                                ?>
                                            <?php 
                                        }
                                
                                    ?>
                                    <div>
                                        <h5 class="fs-14 my-1"><?php echo $row["PROD_NAME"]?></a></h5>
                                        <span class="text-muted"><?php echo $row["CAT_NAME"]?></span>
                                    </div>
                                </div> 
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal"><?php echo $row["CANT"]?></h5>
                                <span class="text-muted">Cantidad</span>
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal"><?php echo $row["PRECIO_PRODUCTO"]?></h5>
                                <span class="text-muted">Price</span>
                            </td>
                                                                    
                            <td>
                                <h5 class="fs-14 my-1 fw-normal"><?php echo $row["PROD_STOCK"]?></h5>
                                <span class="text-muted">Stock</span>
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal"><?php echo $row["UNID_NAME"]?></h5>
                                <span class="text-muted">Unidad</span>
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal"><?php echo $row["MON_NAME"]?></h5>
                                <span class="text-muted">Moneda</span>
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal">$<?php echo $row["TOTAL"]?></h5>
                                <span class="text-muted">Total</span>
                            </td>
                            
                    
                        </tr>
                      
                    <?php
                    }
                    echo json_encode($datos);
                }
        break; 
    case "ventabarras":
        $datos = $venta->get_venta_grafico_barra($_POST["suc_id"]);
        $data = array();
        foreach ($datos as $row) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;
    case "eliminar_venta":
        $venta->delete_venta($_POST["venta_id"]);
        break;
}   
?>
