<?php
require_once 'ORM.php';

final class CategoriaDiario extends Orm{

    private $atributos = [];

    public function __construct(PDO $connecion){
        parent::__construct("categoriadiario",$connecion);
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

    public function obtenerTodosCategoriaDiario() {
        try {
            $resultados = $this->getAll();
            $categoriaDiarios = [];
            foreach ($resultados as $fila) {
                $categoriaDiario = new CategoriaDiario($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $categoriaDiario->setAtributos($nombre,$valor);
                }
                $categoriaDiarios[] = $categoriaDiario;
            }
            return $categoriaDiarios;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosCategoriaDiario: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosCategoriaDiario:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnCategoriaDiario($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $categoriaDiario = new CategoriaDiario($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $categoriaDiario->setAtributos($nombre,$valor);
                }
                return $categoriaDiario;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnCategoriaDiario: " . $e->getMessage();
            error_log("Error al obtener obtenerUnCategoriaDiario:" . $e->getMessage()) ;
            return [];
        }
    }
    public function categoriaSeleccionada($id,$categorias){
        foreach ($categorias as $idCategoria) {
            $dato=[
                'idDiario' => $id,
                'idCategoria' => $idCategoria
            ];
            $this->insert($dato);
        }
    }
    public function eliminaCategoria($idDiario,$idCategoria){
        try {
            $query = "DELETE FROM {$this->tabla} WHERE idDiario = :idDiario AND idCategoria = :idCategoria";
            $stm = $this->connection->prepare($query);
            $stm->bindParam(':idDiario', $idDiario);
            $stm->bindParam(':idCategoria', $idCategoria);

            return  $stm->execute(); 

        } catch (PDOException $e) {
            echo "Error al eliminar eliminaCategoria: " . $e->getMessage();
            error_log("Error al eliminar eliminaCategoria: " . $e->getMessage());
        }

    }
}