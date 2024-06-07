<?php
// TODO:llamando clases
    require_once ("../Config/conn.php");
    require_once("../Models/RolModel.php");
// TODO:Inicializando clase Rol
    $rol = new Rol();

    switch($_GET["op"]){
        // TODO:Guardar y editar, guardar cuando el id en vacio y actualizar cuando id tiene un valor
        case "guardaryeditar":

            if (empty($_POST["role_id"])){
                $rol->insert_rol($_POST["suc_id"],$_POST["role_name"]);
                echo json_encode([
                    "success"=>true,
                    "message"=>"Rol guardado con éxito",
                    'icon' => 'success',
                ]);
            }else{
                $rol->update_rol($_POST["role_id"],$_POST["suc_id"],$_POST["role_name"]);
                echo json_encode([
                    "success"=>true,
                    "message"=>"Rol actualizado con éxito",
                    'icon' => 'success',
                ]);
            }
            break;

            // TODO: Listado de registros formato JSON para datatable JS
        case "listar":

            $datos = $rol->get_rol_sucursal_id($_POST["suc_id"]);
            $data  = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["ROLE_NAME"];
                $sub_array[] = $row["CREATED_AT"];
                $sub_array[] = '<button type="button" onClick="permisos('.$row["ROLE_ID"].')" id="'.$row["ROLE_ID"].'" class="btn btn-primary btn-label waves-effect waves-light"><i class="ri-user-line label-icon align-middle fs-16 me-2"></i> Permisos</button>';
                $sub_array[] = '<button type="button" onClick="editar('.$row["ROLE_ID"].')" id="'.$row["ROLE_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["ROLE_ID"].')" id="'.$row["ROLE_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
                $data[] = $sub_array;

                
            };
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);

            break;
            // TODO: Mostrar informacion de un registro por su id
        case "mostrar":
            $datos = $rol->get_rol_id($_POST["role_id"]);
            if(is_array($datos)==TRUE and count($datos)>0){
                foreach($datos as $row){
                    $output["ROLE_ID"] = $row["ROLE_ID"];
                    $output["SUC_ID"] = $row["SUC_ID"];
                    $output["ROLE_NAME"] = $row["ROLE_NAME"];
                }
                echo json_encode($output);
            }
            break;
            // TODO: Cambiar estado de registro a 0
        case "eliminar":
            $rol->delete_rol($_POST["role_id"]);
            break;

        case "combo":
            // Obtener los datos de la empresa
            $datos = $rol->get_rol_sucursal_id($_POST["suc_id"]);   
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option selected>Seleccionar Rol</option>";
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row["ROLE_ID"] . "'>" . $row["ROLE_NAME"] . "</option>";
                }
                echo $html;
            } else {
                // Manejar el caso donde no se encuentran datos
                echo "<option selected>No se encontraron categorias</option>";
            }
            break;

    }




?>