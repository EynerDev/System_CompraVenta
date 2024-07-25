<?php
    // Inicia la sesión (debería estar antes de cualquier salida al navegador)
    session_start();
    require_once __DIR__ . '../../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    class Conectar {
        protected function conexion() {
            // Variables de entorno para la conexión
            $host = $_ENV['DB_HOST']; 
            $db = $_ENV['DB'];  // Nombre de tu base de datos
            $user = $_ENV['DB_USER'];  // Usuario de SQL Server
            $pass = $_ENV['DB_PASS'];  // Contraseña de SQL Server

            try {
                // Intenta conectar a la base de datos
                //Cadena de conexion a azure DB
                $pdo = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);

                // $pdo = new PDO("sqlsrv:Server=$host;Database=$db", $user, $pass);
                 echo "Conexión exitosa.";// Esto debería estar en otra parte, no en la conexión misma
                return $pdo;
            } catch (PDOException $e) {
                // Maneja los errores de conexión
                echo 'Conexión fallida: ' . $e->getMessage() . ' Código de error: ' . $e->getCode();
                return null; // Devuelve null en caso de error
            }
        }

        public static function baseUrl(){
            //Ruta entorno de desarrollo
            // return "http://localhost/System_CompraVenta/";

            //Ruta entorno de produccion(AZURE)
            return "https://compraventa-eynerdev.azurewebsites.net/";

        }
    }
?>
