<?php
// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/TipodocModel.php");

// TODO: Inicializando clase Moneda
$tipoDoc = new Tipodoc();

switch($_GET["op"]){
        case "combo":
                // Obtener los datos de la empresa
                $datos = $tipoDoc->get_tipodoc_id();   
                if (is_array($datos) && count($datos) > 0) {
                    $html = "<option selected>Seleccionar Tipo Documento</option>";
                    foreach ($datos as $row) {
                        $html .= "<option value='" . $row["TIPO_DOC_ID"] . "'>" . $row["DESCRIPTION"] . "</option>";
                    }
                    echo $html;
                } else {
                    // Manejar el caso donde no se encuentran datos
                    echo "<option selected>No se encontraron empresas</option>";
                }
                break;
}   
?>
