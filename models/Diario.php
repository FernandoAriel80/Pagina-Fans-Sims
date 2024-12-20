<?php
require_once 'ORM.php';
final class Diario extends Orm{

    private $atributos = [];

    public function __construct(PDO $connecion) {
        parent::__construct('diario',$connecion);
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
    public function obtenerTodosDiariosOrden($columna,$orden= 'DESC'){
        try {
            $resultados = $this->getAllOrderBy($columna,$orden);
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
            echo "Error al obtener obtenerTodosDiariosOrden: " . $e->getMessage();
            error_log("Error al obtener obtenerTodosDiariosOrden:" . $e->getMessage()) ;
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
            'tituloDiario' => $titulo,
            'descripcionDiario' => $descripcion,
            'visible' => $visible
        ];
        try {
           return $this->insert($dato);

        } catch (PDOException $e) {
            echo "Error al creaDiario: " . $e->getMessage();
            error_log("Error al obtener creaDiario:" . $e->getMessage()) ;
            return false;
        }
    }
    function fechaActualizarDiario($id){
        try {
            $query = "UPDATE {$this->tabla} SET fechaActualizacionDiario = CURRENT_TIMESTAMP WHERE id{$this->tabla} = :id";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":id", $id);
            $resultado = $stm->execute();
            if (!empty($resultado)) {
                return true;
            } else {
                return false;
            }  
        } catch (PDOException $e) {
            echo "Error al fechaActualizarDiario: " . $e->getMessage();
            error_log("Error al obtener fechaActualizarDiario:" . $e->getMessage()) ;
            return false;
        }
    }

    public function editaDiario($idDiario,$titulo,$descripcion,$visible){
        $dato=[
            'tituloDiario' => $titulo,
            'descripcionDiario' => $descripcion,
            'visible' => $visible
        ];
        try {
           return $this->upDateById($idDiario,$dato);

        } catch (PDOException $e) {
            echo "Error al editaDiario: " . $e->getMessage();
            error_log("Error al obtener editaDiario:" . $e->getMessage()) ;
            return false;
        }
    }
    
}