<?php 
require_once './vendor/autoload.php'; // Asegúrate de cargar el autoloader de Composer

// Cargar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();
 
class DataBase {
    private string $host;
    private string $db_nombre;
    private string $usuario;
    private string $password;
    private $connection;

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->db_nombre = $_ENV['DB_NAME'];
        $this->usuario = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];

        $dsn = 'mysql:host='.$this->host.';dbname='.$this->db_nombre;
        $options = [ 
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
           
        try {
            $this->connection = new PDO($dsn, $this->usuario, $this->password, $options);
            $this->connection->exec("SET CHARACTER SET UTF8");
        } catch(PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
            error_log('Error de conexión: ' . $e->getMessage());
        }
    }

    public function conectar() {
        return $this->connection;
    }

    public function desconectar() {
        $this->connection = null;
    }

//     public function ejecutarConsulta($sql) {
//         $stmt = $this->connection->prepare($sql);
//         $stmt->execute();
//         return $stmt;
//     }
 }
