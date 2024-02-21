<?php
require_once __DIR__.'/Orm.php';
final class Diario extends Orm{

    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('Diario',$connecion);
    }

    // Método mágico __set
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

    public function obtenerTodosDiarios() {
        try {
            $resultados = $this->getAll();
            $diarios = [];
            foreach ($resultados as $fila) {
                $diario = new Diario($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $diario->setAtributos($nombre,$valor);
                }
                $diarios[] = $diario;
            }
            return $diarios;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosDiarios: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosDiarios:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnDiario($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $diario = new Diario($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $diario->setAtributos($nombre,$valor);
                }
                return $diario;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnDiario: " . $e->getMessage();
            error_log("Error al obtener obtenerUnDiario:" . $e->getMessage()) ;
            return [];
        }
    }

    public function creaDiario($idUsuario,$titulo,$descripcion,$visible){
        $dato=[
            'idUsuario' => $idUsuario,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'visible' => $visible
        ];
        try {
           return $this->insert($dato);

        } catch (PDOException $e) {
            echo "Error al registrarUsuario: " . $e->getMessage();
            error_log("Error al obtener guardaToken:" . $e->getMessage()) ;
            return false;
        }
    }

    
}