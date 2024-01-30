<?php
require_once __DIR__.'/Orm.php';
final class Usuario extends Orm{
    private int $id;
    private string $usuario;
    private string $token;
    private string $nombre;
    private string $foto;
    private string $descripcion;
    private string $fechaCreacion;
    private bool $activo;
    private string $correo;
    private string $clave;
    private string $sal;
    private string $rol;


    public function __construct(PDO $connecion){
        parent::__construct("Usuario",$connecion);
    }

    public function datosUsuario(
        int $id,
        string $usuario,
        string $token,
        string $nombre,
        string $foto,
        string $descripcion,
        string $fechaCreacion,
        bool $activo,
        string $correo,
        string $clave,
        string $sal,
        string $rol
    ) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->token = $token;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->descripcion = $descripcion;
        $this->fechaCreacion = $fechaCreacion;
        $this->activo = $activo;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->sal = $sal;
        $this->rol = $rol;
    }

    // public function getId(): int {
    //     return $this->id;
    // }


    public function datosRegistro(string $usuario,string $nombre,string $correo,string $clave):void
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->sal = password_hash(random_bytes(16), PASSWORD_DEFAULT);
        $this->clave = password_hash($clave . $this->sal, PASSWORD_DEFAULT);
    }
    public function datosLogin(string $usuario,string $clave):void
    {
        $this->usuario = $usuario;
        $this->clave = $clave;
    }
    
       // Getter mágico
    //public function __get($name) {
    //    return isset($this->data[$name]) ? $this->data[$name] : null;
    //}

    public function getByUsuAndEmail(string $usuario,string $correo){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE usuario =:usuario OR correo =:correo";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":usuario", $usuario);
            $stm->bindValue(":correo", $correo);
            $stm->execute();
            return $stm->fetch();
        }catch (PDOException $e) {
            echo "Error al obtener registro getByUsuAndEmail: " . $e->getMessage();
        } 
    }

    public function getByUsu(string $usuario){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE usuario =:usuario";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":usuario", $usuario);
            $stm->execute();
            return $stm->fetch();
        }catch (PDOException $e) {
            echo "Error al obtener registro getByUsu: " . $e->getMessage();
        } 
    }


}