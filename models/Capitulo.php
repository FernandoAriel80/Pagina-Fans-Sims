<?php
require_once __DIR__.'/Orm.php';
final class Capitulo extends Orm{
    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('Capitulo',$connecion);
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

    public function obtenerTodosCapitulos() {
        try {
            $resultados = $this->getAll();
            $capitulos = [];
            foreach ($resultados as $fila) {
                $capitulo = new Capitulo($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $capitulo->setAtributos($nombre,$valor);
                }
                $capitulos[] = $capitulo;
            }
            return $capitulos;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosCapitulos: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosCapitulos:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnCapitulo($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $capitulo = new Capitulo($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $capitulo->setAtributos($nombre,$valor);
                }
                return $capitulo;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnCapitulo: " . $e->getMessage();
            error_log("Error al obtener obtenerUnCapitulo:" . $e->getMessage()) ;
            return [];
        }
    }

    public function creaCapitulo($idDiario,$titulo,$imagen,$parrafo){
        $dato=[
            'idDiario' => $idDiario,
            'titulo' => $titulo,
            'imagen' => $imagen,
            'parrafo' => $parrafo
        ];
        try {
           return $this->insert($dato);

        } catch (PDOException $e) {
            echo "Error al creaCapitulo: " . $e->getMessage();
            error_log("Error al obtener creaCapitulo:" . $e->getMessage()) ;
            return false;
        }
    }
    public function editaCapitulo($idCapitulo,$titulo,$imagen,$parrafo){
        $dato=[
            'titulo' => $titulo,
            'imagen' => $imagen,
            'parrafo' => $parrafo
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