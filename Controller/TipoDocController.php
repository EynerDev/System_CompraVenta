<?php
// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir el archivo de configuración para la conexión a la base de datos
require_once("../Models/TipodocModel.php"); // Incluir el archivo del modelo TipodocModel.php que contiene la clase Tipodoc

// TODO: Inicializando clase Tipodoc
$tipoDoc = new Tipodoc(); // Crear una instancia de la clase Tipodoc para manejar operaciones relacionadas con tipos de documento

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    // TODO: Obtener datos para un combo (select) de tipos de documentos
    case "combo":
        // Obtener los datos de tipos de documentos desde el modelo
        $datos = $tipoDoc->get_tipodoc_id();   
        if (is_array($datos) && count($datos) > 0) {
            // Crear las opciones HTML para el select
            $html = "<option selected>Seleccionar Tipo Documento</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["TIPO_DOC_ID"] . "'>" . $row["DESCRIPTION"] . "</option>";
            }
            echo $html; // Enviar el HTML generado
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron tipos de documento</option>";
        }
        break;
}
?>
