<?php
require_once 'ORM.php';

final class Categoria extends Orm{
 
    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('categoria',$connecion);
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

    public function obtenerTodosCategorias() {
        try {
            $resultados = $this->getAll();
            $categorias = [];
            foreach ($resultados as $fila) {
                $categoria = new Categoria($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $categoria->setAtributos($nombre,$valor);
                }
                $categorias[] = $categoria;
            }
            return $categorias;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosCategorias: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosCategorias:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnCategoria($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $categoria = new Categoria($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $categoria->setAtributos($nombre,$valor);
                }
                return $categoria;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnCategoria: " . $e->getMessage();
            error_log("Error al obtener obtenerUnCategoria:" . $e->getMessage()) ;
            return [];
        }
    }

}