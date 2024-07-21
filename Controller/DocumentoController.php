<?php

// TODO: Llamando clases
require_once ("../Config/conn.php"); // Incluir archivo de conexión a la base de datos
require_once("../Models/DocumentoModel.php"); // Incluir el modelo DocumentoModel.php que contiene la clase Documento

// TODO: Inicializando clase Documento
$pago = new Documento(); // Crear una instancia de la clase Documento para manejar operaciones relacionadas con documentos

// Switch para manejar diferentes operaciones basadas en el parámetro 'op' de la solicitud GET
switch($_GET["op"]){
    // Caso para manejar la solicitud de un menú desplegable de documentos
    case "combo":
        // Obtener los datos de documentos según el tipo especificado en la solicitud POST
        $datos = $pago->get_documento($_POST["doc_tipo"]);   
        
        // Verificar si la consulta devuelve un array y contiene elementos
        if (is_array($datos) && count($datos) > 0) {
            // Inicializar el HTML del menú desplegable con una opción predeterminada
            $html = "<option selected value=''>Seleccionar Tipo Documento</option>";
            
            // Iterar sobre los datos obtenidos para construir las opciones del menú desplegable
            foreach ($datos as $row) {
                // Agregar una opción para cada tipo de documento con su ID y nombre
                $html .= "<option value='" . $row["DOC_ID"] . "'>" . $row["DOC_NAME"] . "</option>";
            }
            // Imprimir el HTML del menú desplegable
            echo $html;
        } else {
            // Si no se encuentran documentos, mostrar una opción predeterminada indicando que no se encontraron documentos
            echo "<option selected>No se encontraron documento</option>";
        }
        break;
}
?>
