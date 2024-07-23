<?php
// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir el archivo de configuración para la conexión a la base de datos
require_once("../Models/UsuarioModel.php"); // Incluir el archivo del modelo UsuarioModel.php que contiene la clase Usuario

// TODO: Inicializando clase Usuario
$usuario = new Usuario(); // Crear una instancia de la clase Usuario para manejar operaciones relacionadas con usuarios

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    // TODO: Guardar y editar, guardar cuando el id está vacío y actualizar cuando id tiene un valor
    case "guardaryeditar":
        // Obtener datos de la solicitud POST
        $suc_id = isset($_POST["suc_id"]) ? $_POST["suc_id"] : null;
        $user_email = isset($_POST["user_email"]) ? $_POST["user_email"] : null;
        $user_name = isset($_POST["user_name"]) ? $_POST["user_name"] : null;
        $user_role_id = isset($_POST["user_role_id"]) ? $_POST["user_role_id"] : null;
        $user_ape = isset($_POST["user_ape"]) ? $_POST["user_ape"] : null;
        $user_typedoc = isset($_POST["user_typedoc"]) ? $_POST["user_typedoc"] : null;
        $user_document = isset($_POST["user_document"]) ? $_POST["user_document"] : null;
        $user_number = isset($_POST["user_number"]) ? $_POST["user_number"] : null;
        $user_password = isset($_POST["user_password"]) ? $_POST["user_password"] : null;
        $user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : null;
        
        // Verificar que todos los datos necesarios estén presentes
        if ($suc_id && $user_email && $user_name && $user_role_id && $user_ape && $user_typedoc && $user_document && $user_number && $user_password){
            if (empty($user_id)){
                // Si el ID del usuario está vacío, insertar un nuevo registro
                $usuario->insert_usuario(
                    $suc_id,
                    $user_email,
                    $user_name,
                    $user_role_id, 
                    $user_ape, 
                    $user_typedoc, 
                    $user_document, 
                    $user_number, 
                    $user_password
                );
                echo json_encode([
                    'success' => true,
                    'message' => "Usuario creado exitosamente",
                    'icon' => 'success',
                ]);
            } else {
                // Si el ID del usuario no está vacío, actualizar el registro existente
                $usuario->update_usuario(
                    $user_id,
                    $suc_id,
                    $user_email,
                    $user_name,
                    $user_role_id, 
                    $user_ape, 
                    $user_typedoc, 
                    $user_document, 
                    $user_number, 
                    $user_password
                );
                echo json_encode([
                    'success' => true,
                    'message' => "Usuario actualizado exitosamente",
                    'icon' => 'success',
                ]);
            }
        } else {
            // Responder con un mensaje de error si los datos están incompletos
            echo json_encode([
                'success' => false,
                'message' => "Se encuentran campos vacíos",
                'icon' => 'error',
            ]);
        }    
        break;

    // TODO: Listado de registros formato JSON para DataTables JS
    case "listar":
        // Obtener datos de la base de datos
        $datos = $usuario->get_usuario_sucursal_id($_POST["suc_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach($datos as $row){
            $sub_array = array();
            $sub_array[] = $row["NOMBRE"];
            $sub_array[] = $row["APELLIDO"];
            $sub_array[] = $row["TIPO_DE_DOCUMENTO"];
            $sub_array[] = $row["DOCUMENTO"];
            $sub_array[] = $row["ROL"];
            $sub_array[] = $row["CORREO"];
            $sub_array[] = $row["NUMERO"];
            $sub_array[] = $row["CREATED_AT"];
            // Botones de acción para editar y eliminar
            $sub_array[] = '<button type="button" onClick="editar('.$row["USER_ID"].')" id="'.$row["USER_ID"].'" class="btn btn-soft-warning btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-edit-line label-icon label-icon align-middle"></i> </button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$row["USER_ID"].')" id="'.$row["USER_ID"].'" class="btn btn-soft-danger btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-delete-bin-5-line label-icon "></i> </button>'; 
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

    // TODO: Mostrar información de un registro por su ID
    case "mostrar":
        $datos = $usuario->get_usuario_id($_POST["user_id"]);
        if(is_array($datos) == TRUE and count($datos) > 0){
            foreach($datos as $row){
                $output["USER_ID"] = $row["USER_ID"];
                $output["SUC_ID"] = $row["SUC_ID"];
                $output["USER_NAME"] = $row["USER_NAME"];
                $output["USER_APE"] = $row["USER_APE"];
                $output["USER_TYPEDOC"] = $row["USER_TYPEDOC"];
                $output["USER_DOCUMENT"] = $row["USER_DOCUMENT"];
                $output["USER_ROLE_ID"] = $row["USER_ROLE_ID"];
                $output["USER_EMAIL"] = $row["USER_EMAIL"];
                $output["USER_NUMBER"] = $row["USER_NUMBER"];
                $output["USER_PASSWORD"] = $row["USER_PASSWORD"];
            }
            echo json_encode($output);
        }
        break;

    // TODO: Cambiar estado de registro a 0 (Eliminar)
    case "eliminar":
        $usuario->delete_usuario($_POST["user_id"]);
        echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente.']);
        break;

    // TODO: Actualizar contraseña del usuario
    case "password":
        $usuario->update_contrasena($_POST["user_id"], $_POST["user_password"]);
        echo json_encode(['success' => true, 'message' => 'Contraseña actualizada exitosamente.']);
        break;
}
?>
