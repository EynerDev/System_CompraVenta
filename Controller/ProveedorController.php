<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/ProveedorModel.php");
// TODO:Inicializando clase Proveedor
    $proveedor = new ProveedorModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["prov_id"])){
                $proveedor->insert_proveedor(
                    $_POST["emp_id"],
                    $_POST["prov_name"],
                    $_POST["prov_rut"],
                    $_POST["prov_number"],
                    $_POST["prov_dirc"], 
                    $_POST["prov_email"]);
            }else{
                $proveedor->update_proveedor(
                    $_POST["prov_id"],
                    $_POST["emp_id"],
                    $_POST["prov_name"],
                    $_POST["prov_rut"],
                    $_POST["prov_number"],
                    $_POST["prov_dirc"], 
                    $_POST["prov_email"]);
            }
            break;

        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $proveedor->get_proveedor_sucursal_id($_POST["emp_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["prov_name"];
                $sub_array = $row["prov_rut"];
                $sub_array = $row["prov_number"];
                $sub_array = $row["prov_dirc"];
                $sub_array = $row["prov_email"];
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
            $datos = $proveedor->get_proveedor_id($_POST["prov_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["prov_id"] = $row["prov_id"];
                    $output["emp_id"] = $row["emp_id"];
                    $output["prov_name"] = $row["prov_name"];
                    $output["prov_rut"] = $row["prov_rut"];
                    $output["prov_number"] = $row["prov_number"];
                    $output["prov_dirc"] = $row["prov_dirc"];
                    $output["prov_email"] = $row["prov_email"];
                }
                echo json_encode($output);
            }
            break;
        // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $proveedor->delete_proveedor($_POST["prov_id"]);
            break;

    }




?>