<?php
require_once './ORM.php';

final class Puntaje extends Orm{
 
    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('Puntaje',$connecion);
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

    public function obtenerTodosPuntaje() {
        try {
            $resultados = $this->getAll();
            $puntajes = [];
            foreach ($resultados as $fila) {
                $puntaje = new Puntaje($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $puntaje->setAtributos($nombre,$valor);
                }
                $puntajes[] = $puntaje;
            }
            return $puntajes;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosPuntaje: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosPuntaje:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnPuntaje($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $puntaje = new Puntaje($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $puntaje->setAtributos($nombre,$valor);
                }
                return $puntaje;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnPuntaje: " . $e->getMessage();
            error_log("Error al obtener obtenerUnPuntaje:" . $e->getMessage()) ;
            return [];
        }
    }

    public function promedioPuntaje($idDiario){
        try {
            $query = "SELECT ROUND(AVG(puntajeDato),1) AS promedioPuntuacion FROM {$this->tabla} WHERE idDiario = {$idDiario}";
            $stm = $this->connection->prepare($query);
            $stm->execute();
            return $stm->fetch();
        } catch (PDOException $e) {
            echo "Error al promedioPuntaje: " . $e->getMessage();
            error_log("Error al obtener promedioPuntaje:" . $e->getMessage()) ;
            return false;
        }
    }
    public function editaPuntaje($idCapitulo,$titulo,$imagen,$parrafo){
        $dato=[
            'tituloCapitulo' => $titulo,
            'imagenCapitulo' => $imagen,
            'parrafoCapitulo' => $parrafo
        ];
        try {
           return $this->upDateById($idCapitulo,$dato);

        } catch (PDOException $e) {
            echo "Error al editaCapitulo: " . $e->getMessage();
            error_log("Error al obtener editaCapitulo:" . $e->getMessage()) ;
            return false;
        }
    }
}