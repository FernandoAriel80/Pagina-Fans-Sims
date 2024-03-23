<?php
require_once __DIR__.'/Orm.php';
final class Usuario extends Orm{
    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('Usuario',$connecion);
    }

    public function setAtributos($nombre, $valor) {
        $this->atributos[$nombre] = $valor;
    }

    // Método mágico __get
    public function __get($nombre) {
        if (array_key_exists($nombre, $this->atributos)) {
            return $this->atributos[$nombre];
        }
        return null;
    }

    public function obtenerTodosUsuarios() {
        try {
            $resultados = $this->getAll();
            $usuarios = [];
            foreach ($resultados as $fila) {
                $usuario = new Usuario($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $usuario->setAtributos($nombre,$valor);
                }
                $usuarios[] = $usuario;
            }
            return $usuarios;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosUsuarios: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosUsuarios:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnUsuario($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $usuario = new Usuario($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $usuario->setAtributos($nombre,$valor);
                }
                return $usuario;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnUsuario: " . $e->getMessage();
            error_log("Error al obtener obtenerUnUsuario:" . $e->getMessage()) ;
            return [];
        }
    }

    public function registrarUsuario(string $usuario,string $nombre,string $correo,string $clave,string $sal){
        $dato=[
            'nomUsuario' => $usuario,
            'nombre' => $nombre,
            'correo' => $correo,
            'clave' => $clave,
            'sal' => $sal
        ];
    
        try {
            $resultado = $this->insert($dato);
            if (!empty($resultado)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al registrarUsuario: " . $e->getMessage();
            error_log("Error al obtener registrarUsuario:" . $e->getMessage()) ;
            return false;
        }
    }

    function guardaToken(string $token){
        $dato=[
            'token' => $token,
        ];
        try {
            $resultado = $this->upDateById($this->atributos['idUsuario'],$dato);
            if (!empty($resultado)) {
                return true;
            } else {
                return false;
            }  
        } catch (PDOException $e) {
            echo "Error al guardaToken: " . $e->getMessage();
            error_log("Error al obtener guardaToken:" . $e->getMessage()) ;
            return false;
        }
    }

    public function getByUsuAndEmailAndNom(string $usuario,string $correo,string $nombre){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE nomUsuario =:usuario OR correo =:correo OR nombre =:nombre";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":usuario", $usuario);
            $stm->bindValue(":correo", $correo);
            $stm->bindValue(":nombre", $nombre);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener registro getByUsuAndEmailAndNom: " . $e->getMessage();
            error_log("Error al obtener registro getByUsuAndEmailAndNom: " . $e->getMessage()) ;
        } 
    }

    public function getNombreExistente(string $usuario,string $nombre){
        try{
            $query = "SELECT * FROM {$this->tabla} WHERE nombre =:nombre AND nombre !=:usuario";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":usuario", $usuario);
            $stm->bindValue(":nombre", $nombre);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener registro getNombreExistente: " . $e->getMessage();
            error_log("Error al obtener registro getNombreExistente: " . $e->getMessage()) ;
        } 
    }

    public function editaPerfil($idPerfil,$nombre,$foto){
        $dato=[
            'nombre' => $nombre,
            'foto' => $foto,
        ];
        try {
           return $this->upDateById($idPerfil,$dato);

        } catch (PDOException $e) {
            echo "Error al editaPerfil: " . $e->getMessage();
            error_log("Error al obtener editaPerfil:" . $e->getMessage()) ;
            return false;
        }
    }

    
}