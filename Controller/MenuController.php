<?php
// TODO: Llamando clases
require("../Config/conn.php"); // Incluir el archivo de conexión a la base de datos
require("../Models/MenuModel.php"); // Incluir el archivo del modelo MenuModel.php que contiene la clase Menu

// TODO: Inicializando clase Menu
$menu = new Menu(); // Crear una instancia de la clase Menu para manejar operaciones relacionadas con el menú

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    
    // Caso para listar registros de menú en formato JSON para DataTables
    case "listar":
        // Obtener datos de la base de datos para el rol especificado
        $datos = $menu->get_menu_role_id($_POST["role_id"]);
        $data = array();

        // Recorrer los datos y preparar el array para DataTables
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["MEN_NAME"]; // Nombre del menú
            // Crear botones para habilitar o inhabilitar, según el estado actual del permiso
            if($row["MEND_PERMISO"] == "SI"){
                $sub_array[] = '<button type="button" onClick="inhabilitar('.$row["MEND_ID"].')" id="'.$row["MEND_ID"].'" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>'.$row["MEND_PERMISO"].'</button>';
            } else {
                $sub_array[] = '<button type="button" onClick="habilitar('.$row["MEND_ID"].')" id="'.$row["MEND_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class="ri-close-line label-icon align-middle fs-16 me-2"></i>'.$row["MEND_PERMISO"].'</button>';
            }
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

    // Caso para habilitar un menú basado en su ID
    case "habilitar":
        $menu->update_menu_habilitar($_POST["mend_id"]);
        break;

    // Caso para inhabilitar un menú basado en su ID
    case "inhabilitar":
        $menu->update_menu_inhabilitar($_POST["mend_id"]);
        break;

    // Caso para insertar un nuevo menú basado en el ID de rol
    case "insert":
        $menu->insert_menu_role_id($_POST["role_id"]);
        break;
}
?>
