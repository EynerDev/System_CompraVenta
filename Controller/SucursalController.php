<?php
// TODO:llamando clases
    require("../Config/conn.php");
    require("../Models/SucursalModel.php");
// TODO:Inicializando clase Sucursal
    $sucursal = new Sucursal();

    switch($_GET["op"]){
    // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["suc_id"])){
                $sucursal->insert_sucursal($_POST["emp_id"],$_POST["suc_name"]);
            }else{
                $sucursal->update_sucursal($_POST["suc_id"],$_POST["emp_id"],$_POST["suc_name"]);
            }
            break;

        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $sucursal->get_sucursal_empresa_id($_POST["emp_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["suc_id"];
                $sub_array = $row["suc_name"];
                $sub_array = $row["emp_id"];
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
            $datos = $sucursal->get_sucursal_id($_POST["suc_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["suc_id"] = $row["suc_id"];
                    $output["emp_id"] = $row["emp_id"];
                    $output["suc_name"] = $row["suc_name"];
                }
                echo json_encode($output);
            }
            break;
        // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $sucursal->delete_sucursal($_POST["suc_id"]);
            break;

        case "combo":
            var_dump($_POST["emp_id"]);
            $valor = (int)$_POST["emp_id"];
            echo gettype($valor);
            $datos=$sucursal->get_sucursal_empresa_id($valor);   
                if (is_array($datos) && count($datos) > 0) {
                $html = "<option selected>Seleccionar Sucursal</option>";
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row["SUC_ID"] . "'>" . $row["SUC_NAME"] . "</option>";
                }
                echo $html;
                }
                break;
            



        }
?>