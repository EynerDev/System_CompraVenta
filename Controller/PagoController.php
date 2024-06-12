<?php

// TODO: Llamando clases
require_once ("../Config/conn.php");
require_once("../Models/PagosModel.php");

// TODO: Inicializando clase Pago
$pago = new Pagos();

switch($_GET["op"]){
    case "combo":
        // Obtener los datos de la empresa
        $datos = $pago->get_pago();   
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option selected value=''>Seleccionar Pago</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PAGO_ID"] . "'>" . $row["PAGO_NAME"] . "</option>";
            }
            echo $html;
        } else {
            // Manejar el caso donde no se encuentran datos
            echo "<option selected>No se encontraron pagos</option>";
        }
        break;
}
?>
