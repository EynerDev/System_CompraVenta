<?php
session_start();
class conectar {

    protected function conexion() {
        
        $host = 'eyner';  // Nombre del servidor
        $instance = 'sqlexpress';  // Nombre de la instancia
        $db = 'CompraVenta';  // nombre de tu base de datos
        $user = 'sa';  // Usuario de SQL Server
        $pass = '2672';  // Contraseña de SQL Server
        $charset = 'utf8';

        $dsn = "sqlsrv:Server=$host\\$instance;Database=$db";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            echo "Conexión exitosa.";
            return $pdo;
        } catch (PDOException $e) {
            echo 'Conexión fallida: ' . $e->getMessage() . ' Código de error: ' . $e->getCode();
        }

    }

    public function baseUrl(){
        return "http://localhost/Compra_venta/";
    }
}
?>