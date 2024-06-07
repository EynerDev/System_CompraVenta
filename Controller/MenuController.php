<?php
// TODO:llamando clases
    require("../Config/conn.php");
    require("../Models/MenuModel.php");
// TODO:Inicializando clase Menu
    $menu = new Menu();

    switch($_GET["op"]){
    
        // TODO: Listado de registros formato JSON para datatable JS
        case "listar":
            // Obtener datos de la base de datos
            $datos = $menu->get_menu_role_id($_POST["role_id"]);
            $data = array();

            // Recorrer los datos y preparar el array para DataTables
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["MEN_NAME"];
                if($row["MEND_PERMISO"] == "SI"){
                    $sub_array[] = '<button type="button" onClick="inhabilitar('.$row["MEND_ID"].')"  id="'.$row["MEND_ID"].'" class="btn btn-success btn-label waves-effect waves-light"><i class=" ri-check-double-line label-icon align-middle fs-16 me-2"></i>'.$row["MEND_PERMISO"].'</button>';
                }else{
                    $sub_array[] = '<button type="button" onClick="habilitar('.$row["MEND_ID"].')"  id="'.$row["MEND_ID"].'" class="btn btn-danger btn-label waves-effect waves-light"><i class=" ri-close-line label-icon align-middle fs-16 me-2"></i>'.$row["MEND_PERMISO"].'</button>';

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
        // TODO: Mostrar informacion de un registro por su id
        case "habilitar":
            $menu->update_menu_habilitar($_POST["mend_id"]);
            break;
        case "inhabilitar":
            $menu->update_menu_inhabilitar($_POST["mend_id"]);
            break;
        }
?>