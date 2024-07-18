<?php

// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/DocumentoModel.php");

// TODO: Inicializando clase Pago
$pago = new Documento();

switch($_GET["op"]){
    case "combo":
        // Obtener los datos de la empresa
        $datos = $pago->get_documento($_POST["doc_tipo"]);   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected value=''>Seleccionar Tipo Documento</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["DOC_ID"] . "'>" . $row["DOC_NAME"] . "</option>";
            }
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron documento</option>";
        }
        break;
}
?>
