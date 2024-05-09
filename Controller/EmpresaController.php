<?php
// TODO:llamando clases
    require_once ("..config/conn.php");
    require_once("..Models/EmpresaModel.php");
// TODO:Inicializando clase Empresa
    $empresa = new EmpresaModel();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":
            if (empty($_POST["emp_id"])){
                $empresa->insert_empresa($_POST["com_id"],$_POST["emp_name"], $_POSt["emp_rut"]);
            }else{
                $empresa->update_empresa($_POST["emp_id"],$_POST["com_id"],$_POST["emp_name"], $_POST["emp_rut"]);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $empresa->get_empresa_compania_id($_POST["com_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array = $row["emp_id"];
                $sub_array = $row["emp_name"];
                $sub_array = $row["emp_rut"];
                $sub_array = $row["com_id"];
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
            $datos = $empresa->get_empresa_id($_POST["emp_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["emp_id"] = $row["emp_id"];
                    $output["com_id"] = $row["com_id"];
                    $output["emp_name"] = $row["emp_name"];
                    $output["emp_rut"] = $row["emp_rut"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $empresa->delete_empresa($_POST["emp_id"]);
            break;

        case "combo":
            $datos = $empresa->get_empresa_compania_id($_POST["com_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                $html="";
                $html.="<option>Seleccionar Empresa</option>";
                foreach($datos as $row){
                    $html.="<option value='".$row["EMP_ID"]."'>".$row["EMP_NAME"]."</option>";
                }
                echo $html;
            }



        }
?>