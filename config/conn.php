<?php
    // Inicia la sesión (debería estar antes de cualquier salida al navegador)
    session_start();
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    class Conectar {
        protected function conexion() {
            // Variables de entorno para la conexión
            $host = $_ENV['DB_HOST'];
            $instance = $_ENV['DB_INSTANCE'];  // Nombre de la instancia
            $db = $_ENV['DB'];  // Nombre de tu base de datos
            $user = $_ENV['DB_USER'];  // Usuario de SQL Server
            $pass = $_ENV['DB_PASS'];  // Contraseña de SQL Server
            $charset = $_ENV['DB_CHARSET'];

            // Cadena de conexión PDO para SQL Server
            $dsn = "sqlsrv:Server=$host\\$instance;Database=$db";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                // Intenta conectar a la base de datos
                $pdo = new PDO($dsn, $user, $pass, $options);
                // echo "Conexión exitosa."; // Esto debería estar en otra parte, no en la conexión misma
                return $pdo;
            } catch (PDOException $e) {
                // Maneja los errores de conexión
                echo 'Conexión fallida: ' . $e->getMessage() . ' Código de error: ' . $e->getCode();
                return null; // Devuelve null en caso de error
            }
        }

        public static function baseUrl(){
            return "http://localhost/Compra_venta/";
        }
    }
?>
