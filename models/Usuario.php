<?php
require_once __DIR__.'/Orm.php';
final class Usuario extends Orm{
    private  $id;
    private  $usuario;
    private  $token;
    private  $nombre;
    private  $foto;
    private  $descripcion;
    private  $fechaCreacion;
    private  $activo;
    private  $correo;
    private  $clave;
    private  $sal;
    private  $rol;


    public function __construct(PDO $connecion){
        parent::__construct("Usuario",$connecion);
    }

    public function getId(){ return $this->id; }
    public function getUsuario(){ return $this->usuario; }
    public function getNombre(){ return $this->nombre; }
    public function getClaveEncript(){ return $this->clave; }
    public function getSal(){ return $this->sal; }
    public function getCorreo(){ return $this->correo; }
    public function getRol(){ return $this->rol; }
    public function getToken(){ return $this->token; }


    public function datosUsuarioDB(
         $id,
         $usuario,
         $token,
         $nombre,
         $foto,
         $descripcion,
         $fechaCreacion,
         $activo,
         $correo,
         $clave,
         $sal,
         $rol
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


    public function datosRegistro(string $nombre,string $correo,string $usuario,string $clave):void
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->sal = password_hash(random_bytes(16), PASSWORD_DEFAULT);
        $this->clave = password_hash($clave . $this->sal, PASSWORD_DEFAULT);
    }
    // public function datosLogin(string $usuario,string $clave):void
    // {
    //     $this->usuario = $usuario;
    //     $this->clave = $clave;
    // }
    
       // Getter mágico
    //public function __get($name) {
    //    return isset($this->data[$name]) ? $this->data[$name] : null;
    //}

    public function getByUsuAndEmail(string $usuario,string $correo){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE nomUsuario =:usuario OR correo =:correo AND eliminado = '0'";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":usuario", $usuario);
            $stm->bindValue(":correo", $correo);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener registro getByUsuAndEmail: " . $e->getMessage();
            error_log("Error al obtener registro getByUsuAndEmail: " . $e->getMessage()) ;
        } 
    }

    public function getByUsu(string $usuario){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE nomUsuario =:usuario";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":usuario", $usuario);
            $stm->execute();
            return $stm->fetch();
        }catch (PDOException $e) {
            echo "Error al obtener registro getByUsu: " . $e->getMessage();
            error_log("Error al obtener registro getByUsu: " . $e->getMessage());
        } 
    }

}