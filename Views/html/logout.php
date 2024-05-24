<?php

    require_once("../../Config/conn.php");

    // Verificar si la variable de sesión requerida está establecida
    if (isset($_SESSION["COM_ID"])) {
        // Realizar la redirección
        header("Location: " . conectar::baseUrl() . "?c=" . $_SESSION["COM_ID"]);
        print($_SESSION["COM_ID"]);
        
        // Destruir la sesión
        session_destroy();
        
        // Finalizar la ejecución del script
        exit();
    } else {
        // Manejar el caso en que la variable de sesión no esté establecida
        echo "La variable de sesión COM_ID no está establecida.";
        exit();
    }


?>