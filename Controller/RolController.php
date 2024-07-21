<?php
// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir el archivo de configuración para la conexión a la base de datos
require_once("../Models/RolModel.php"); // Incluir el archivo del modelo RolModel.php que contiene la clase Rol

// TODO: Inicializando clase Rol
$rol = new Rol(); // Crear una instancia de la clase Rol para manejar operaciones relacionadas con roles

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]) {

    // TODO: Guardar y editar roles
    case "guardaryeditar":
        // Verificar si se está creando o actualizando un rol basado en la existencia del ID
        if (empty($_POST["role_id"])){
            // Insertar nuevo rol
            $rol->insert_rol($_POST["suc_id"], $_POST["role_name"]);
            echo json_encode([
                "success" => true,
                "message" => "Rol guardado con éxito",
                'icon' => 'success',
            ]);
        } else {
            // Actualizar rol existente
            $rol->update_rol($_POST["role_id"], $_POST["suc_id"], $_POST["role_name"]);
            echo json_encode([
                "success" => true,
                "message" => "Rol actualizado con éxito",
                'icon' => 'success',
            ]);
        }
        break;

    // TODO: Listado de roles en formato JSON para DataTables JS
    case "listar":
        // Obtener datos de roles desde el modelo
        $datos = $rol->get_rol_sucursal_id($_POST["suc_id"]);
        $data  = array();
        foreach($datos as $row){
            $sub_array = array();
            // Agregar información del rol al array
            $sub_array[] = $row["ROLE_NAME"];
            $sub_array[] = $row["CREATED_AT"];
            // Botones para gestionar permisos, editar y eliminar el rol
            $sub_array[] = '<button type="button" onClick="permisos('.$row["ROLE_ID"].')" id="'.$row["ROLE_ID"].'" class="btn btn-primary btn-label waves-effect waves-light"><i class="ri-user-line label-icon align-middle fs-16 me-2"></i> Permisos</button>';
            $sub_array[] = '<button type="button" onClick="editar('.$row["ROLE_ID"].')" id="'.$row["ROLE_ID"].'" class="btn btn-warning btn-label waves-effect waves-light"><i class="ri-edit-box-fill label-icon align-middle fs-16 me-2"></i> Editar</button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["ROLE_ID"].')" id="'.$row["ROLE_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> Eliminar</button>'; 
            $data[] = $sub_array;
        }

        // Preparar la estructura final de la respuesta para DataTables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        // Enviar la respuesta JSON
        echo json_encode($results);
        break;

    // TODO: Mostrar información de un rol por su ID
    case "mostrar":
        // Obtener información del rol por ID
        $datos = $rol->get_rol_id($_POST["role_id"]);
        if (is_array($datos) == TRUE && count($datos) > 0){
            foreach($datos as $row){
                $output["ROLE_ID"] = $row["ROLE_ID"];
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["ROLE_NAME"] = $row["ROLE_NAME"];
            }
            echo json_encode($output);
        }
        break;

    // TODO: Eliminar rol
    case "eliminar":
        // Eliminar rol por ID
        $rol->delete_rol($_POST["role_id"]);
        echo json_encode([
            'success' => true,
            'message' => 'Rol eliminado exitosamente',
            'icon' => 'success'
        ]);
        break;

    // TODO: Obtener roles para un combo (select) basado en la sucursal
    case "combo":
        // Obtener los datos de roles para la sucursal especificada
        $datos = $rol->get_rol_sucursal_id($_POST["suc_id"]);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected>Seleccionar Rol</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["ROLE_ID"] . "'>" . $row["ROLE_NAME"] . "</option>";
            }
            echo $html; // Enviar el HTML generado
        } else {
            // Manejar el caso donde no se encuentran roles
            echo "<option selected>No se encontraron roles</option>";
        }
        break;
}
?>
