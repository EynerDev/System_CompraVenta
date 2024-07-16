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
        
        $datos = $venta->insert_venta_detalle($venta_id, $prod_id, $prod_pventa, $det_venta_cant);
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
                $sub_array[]= $row["PROD_PVENTA"];
                $sub_array[]= $row["DET_VENTA_CANT"];
                $sub_array[]= $row["DET_TOTAL"];
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
            $output["VENTA_SUB_TOTAL"] = $row["VENTA_SUB_TOTAL"];
            $output["VENTA_IVA"] = $row["VENTA_IVA"];
            $output["VENTA_TOTAL"] = $row["VENTA_TOTAL"];
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
            $_POST["venta_coment"]

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
            $output["VENTA_SUB_TOTAL"] = $row["VENTA_SUB_TOTAL"];
            $output["VENTA_IVA"] = $row["VENTA_IVA"];
            $output["VENTA_TOTAL"] = $row["VENTA_TOTAL"];
            $output["VENTA_COMENT"] = $row["VENTA_COMENT"];
            $output["USER_ID"] = $row["USER_ID"];
            $output["CREATED_AT"] = $row["CREATED_AT"];
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
                    <td scope=""><?php echo $row["PROD_PVENTA"]?></td>
                    <td scope=""><?php echo $row["DET_VENTA_CANT"]?></td>
                    <td scope="text_end"><?php echo $row["DET_TOTAL"]?></td>
            
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
                $sub_array[]= $row["CLI_NAME"];
                $sub_array[]= $row["CLI_DOC"];
                $sub_array[]= $row["PAGO_NAME"];
                $sub_array[]= $row["MON_NAME"];
                $sub_array[]= $row["VENTA_SUB_TOTAL"];
                $sub_array[]= $row["VENTA_IVA"];
                $sub_array[]= $row["VENTA_TOTAL"];
                $sub_array[]= $row["USER_NAME"]." ".$row["USER_APE"];
                $sub_array[] = '<button type="button" onClick="redirigirAVistaVenta('.$row["VENTA_ID"].')" id="'.$row["VENTA_ID"].'" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-file-line label-icon align-middle fs-16 me-2"></i> VER PDF</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["VENTA_ID"].')" id="'.$row["VENTA_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
                $sub_array[] = '<button type="button" onClick="verDetalle('.$row["VENTA_ID"].')" id="'.$row["VENTA_ID"].'" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-eye-line label-icon align-middle fs-16 me-2"></i> Ver detalle</button>'; 
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
}   
?>
