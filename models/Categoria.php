<?php
require_once __DIR__.'/Orm.php';
final class Categoria extends Orm{
 
    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('Categoria',$connecion);
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

    public function obtenerTodosCategorias() {
        try {
            $resultados = $this->getAll();
            $Categorias = [];
            foreach ($resultados as $fila) {
                $Categoria = new Categoria($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $Categoria->setAtributos($nombre,$valor);
                }
                $Categorias[] = $Categoria;
            }
            return $Categorias;
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
                $Categoria = new Categoria($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $Categoria->setAtributos($nombre,$valor);
                }
                return $Categoria;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnCategoria: " . $e->getMessage();
            error_log("Error al obtener obtenerUnCategoria:" . $e->getMessage()) ;
            return [];
        }
    }

}