<?php

// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/CompraModel.php");

// TODO: Inicializando clase Compra
$compra = new Compra();

switch($_GET["op"]){
    case "registrar":
        $datos = $compra->insert_compra_x_id($_POST["suc_id"],$_POST["user_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $output["COMPRA_ID"] = $row["COMPRA_ID"];
            }
            echo json_encode($output);
        }
        break;
    case "detalle":
        $datos = $compra->insert_compra_detalle($_POST["compra_id"],$_POST["prod_id"], $_POST["prod_pcompra"], $_POST["det_cant"]);
        break;
    case "listar_detalle":
        $datos = $compra->get_compra_detalle($_POST["compra_id"]);
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
                $sub_array[]= $row["DET_CANT"];
                $sub_array[]= $row["TOTAL"];
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["DET_ID"].','.$row["COMPRA_ID"].')" id="'.$row["DET_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
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
        $compra->delete_detalle_compra($_POST["det_id"]);
        break; 
    case "calculo":
        $datos = $compra->get_compra_calculo($_POST["compra_id"]);
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
        $datos = $compra->update_compra(
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

        $datos = $compra->get_compra_pdf($_POST["compra_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
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
            echo json_encode($output);
        }
        break;
    case "listar_detalle_pdf":
        $datos = $compra->get_compra_detalle($_POST["compra_id"]);
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
                    <td scope=""><?php echo $row["DET_CANT"]?></td>
                    <td scope="text_end"><?php echo $row["TOTAL"]?></td>
            
                </tr>
              
            <?php
            }
            echo json_encode($datos);
        }
        break; 
    case "listar_compra":

        $datos = $compra->get_list_compra($_POST["suc_id"]);
        $data  = array();
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[]= "C-".$row["COMPRA_ID"];
                $sub_array[]= $row["PROV_NAME"];
                $sub_array[]= $row["DOC_NAME"];
                $sub_array[]= $row["PROV_RUT"];
                $sub_array[]= $row["PAGO_NAME"];
                $sub_array[]= $row["MON_NAME"];
                $sub_array[]= $row["SUB_TOTAL"];
                $sub_array[]= $row["IVA"];
                $sub_array[]= $row["TOTAL"];
                $sub_array[]= $row["USER_NAME"]." ".$row["USER_APE"];
                $sub_array[]= $row["FECHA_COMPRA"];
                $sub_array[] = '<button type="button" onClick="redirigirAVistaCompra('.$row["COMPRA_ID"].')" id="'.$row["COMPRA_ID"].'" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-file-line label-icon align-middle fs-16 me-2"></i> VER PDF</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["COMPRA_ID"].')" id="'.$row["COMPRA_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
                $sub_array[] = '<button type="button" onClick="verDetalle('.$row["COMPRA_ID"].')" id="'.$row["COMPRA_ID"].'" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-eye-line label-icon align-middle fs-16 me-2"></i> Ver detalle</button>'; 
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
        $datos = $compra->get_compra_top_productos($_POST["suc_id"]);
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
                                    <h5 class="fs-14 my-1"><a href="apps-ecommerce-product-details.html" class="text-reset"><?php echo $row["PROD_NAME"]?></a></h5>
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
}   
?>