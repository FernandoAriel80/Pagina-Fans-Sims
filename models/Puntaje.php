<?php
require_once __DIR__.'/Orm.php';
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

}