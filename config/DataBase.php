<?php 
class DataBase {
    private string $host = 'localhost';
    private string $db_nombre = 'pag_sims';
    private string $usuario = 'root';
    private string $password = '';
    private $connection;

    public function __construct() {
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
