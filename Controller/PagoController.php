<?php

// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir el archivo de configuración de conexión a la base de datos
require_once("../Models/PagosModel.php"); // Incluir el archivo del modelo PagosModel.php que contiene la clase Pagos

// TODO: Inicializando clase Pago
$pago = new Pagos(); // Crear una instancia de la clase Pagos para manejar operaciones relacionadas con pagos

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    
    // TODO: Generar opciones para un combo (select) basado en los datos de pagos
    case "combo":
        // Obtener los datos de pagos desde el modelo
        $datos = $pago->get_pago();   
        
        // Verificar si se obtuvieron datos
        if (is_array($datos) && count($datos) > 0) {
            // Construir el HTML para el <select> con las opciones de pagos
            $html = "<option selected value=''>Seleccionar Pago</option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row["PAGO_ID"] . "'>" . $row["PAGO_NAME"] . "</option>";
            }
            echo $html; // Enviar el HTML generado
        } else {
            // Manejar el caso donde no se encontraron datos de pagos
            echo "<option selected>No se encontraron pagos</option>";
        }
        break;
}
?>
