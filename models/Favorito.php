<?php
require_once './ORM.php';

final class Favorito extends Orm{
 
    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('Favorito',$connecion);
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

    public function obtenerTodosFavorito() {
        try {
            $resultados = $this->getAll();
            $favoritos = [];
            foreach ($resultados as $fila) {
                $favorito = new Favorito($this->connection);
                // Asignar atributos utilizando __set
                foreach ($fila as $nombre => $valor) {
                    $favorito->setAtributos($nombre,$valor);
                }
                $favoritos[] = $favorito;
            }
            return $favoritos;
        } catch (PDOException $e) {
            echo "Error al obtener obtenerTodosFavorito: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosFavorito:" . $e->getMessage()) ;
            return [];
        }
    }

    public function obtenerUnFavorito($id) {
        try {
            $resultado = $this->getById($id);
            if ($resultado) {
                $favorito = new Favorito($this->connection);
                foreach ($resultado as $nombre => $valor) {
                    // Asignar atributos utilizando __set
                    $favorito->setAtributos($nombre,$valor);
                }
                return $favorito;
            }
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnFavorito: " . $e->getMessage();
            error_log("Error al obtener obtenerUnFavorito:" . $e->getMessage()) ;
            return [];
        }
    }

    public function favoritoExistente($idUsuario, $idDiario) {
        try {
           $dato = [
            "idUsuario" => $idUsuario,
            "idDiario" => $idDiario
           ];

           $resultado = $this->getByFilterData($dato);
           return $resultado;
        }catch (PDOException $e) {
            echo "Error al obtener obtenerUnFavorito: " . $e->getMessage();
            error_log("Error al obtener obtenerUnFavorito:" . $e->getMessage()) ;
            return false;
        }
    }

    public function creaFavorito($idUsuario, $idDiario){
        $dato=[
            "idUsuario" => $idUsuario,
            "idDiario" => $idDiario
        ];
        try {
           return $this->insert($dato);

        } catch (PDOException $e) {
            echo "Error al creaFavorito: " . $e->getMessage();
            error_log("Error al obtener creaFavorito:" . $e->getMessage()) ;
            return false;
        }
    }

    public function eliminaFavorito($idUsuario, $idDiario){
        try {
            $query = "DELETE FROM {$this->tabla} WHERE idDiario = :idDiario AND idUsuario = :idUsuario";
            $stm = $this->connection->prepare($query);
            $stm->bindParam(':idDiario', $idDiario);
            $stm->bindParam(':idUsuario', $idUsuario);

            return  $stm->execute(); 

        } catch (PDOException $e) {
            echo "Error al eliminar eliminaFavorito: " . $e->getMessage();
            error_log("Error al eliminar eliminaFavorito: " . $e->getMessage());
        }

    }

}