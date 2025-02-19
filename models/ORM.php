<?php

class Orm{

    protected string $tabla;
    protected $connection;

    public  function __construct($tabla, PDO $connection){
        $this->tabla = $tabla;
        $this->connection = $connection;
    }

    public function getAll(){
        try{
            $query = "SELECT * FROM {$this->tabla}";
            $stm = $this->connection->prepare($query);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener getAll: " . $e->getMessage();
            error_log("Error al obtener getAll: " . $e->getMessage());
        }
       
    }
    public function getById($id){
        try{
            $idTabla = "id{$this->tabla}";
            $query = "SELECT * FROM {$this->tabla} WHERE {$idTabla} =:id";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":id", $id);
            $stm->execute();
            return $stm->fetch();
        }catch (PDOException $e) {
            echo "Error al obtener el getById: " . $e->getMessage();
            error_log("Error al obtener el getById: " . $e->getMessage());
        }
    }
    public function getAllJoin($tablaUnida) { 
        try{
            $idTabla = "id{$tablaUnida}";
            $query = "SELECT * FROM {$this->tabla} INNER JOIN $tablaUnida ON {$this->tabla}.{$idTabla} = {$tablaUnida}.{$idTabla}";
            $stm = $this->connection->prepare($query);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener todos getAllJoin: " . $e->getMessage();
            error_log("Error al obtener getAllJoin: " . $e->getMessage());
        }
    }
 
    public function insert($dato){
        try {
            $keys = implode(', ', array_keys($dato));
            $values = ':' . implode(', :', array_keys($dato));
            $query = "INSERT INTO {$this->tabla} ({$keys}) VALUES ({$values})";
            
            $stm = $this->connection->prepare($query);
            
            foreach ($dato as $key => $value) {
                $stm->bindValue(":{$key}", $value);
            }  
            $stm->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            echo "Error al insertar registro: " . $e->getMessage();
            error_log("Error al insertar registro: " . $e->getMessage());
        }
    }
    
   
    public function upDateById($id,$dato){
        try{
            $query = "UPDATE {$this->tabla} SET ";
            foreach ($dato as $key => $value) {
               $query .= "{$key} = :{$key},";
            }
            $query = trim($query,",");
            $query .=" WHERE id".$this->tabla." = :id";
            
            $stm = $this->connection->prepare($query);
            foreach ($dato as $key => $value) {
                $stm->bindValue(":{$key}", $value);
            }
            $stm->bindValue(":id", $id);
            return $stm->execute();
        }catch (PDOException $e) {
            echo "Error al actualizar registro: " . $e->getMessage();
            error_log("Error al actualizar registro: " . $e->getMessage());
            return false;
        }
    }


    public function getByFilterData($condiciones = array()) {
        try {
            $query = "SELECT * FROM {$this->tabla}";
            $params = array();
            if (!empty($condiciones)) {
                $query .= " WHERE ";
                $condiciones_sql = array();
                foreach ($condiciones as $clave => $valor) {
                    $condiciones_sql[] = "$clave = ?";
                    $params[] = $valor; 
                }
                $query .= implode(" AND ", $condiciones_sql);
            }
            $stm = $this->connection->prepare($query);
            // Asignamos valores utilizando bindValue()
            foreach ($params as $index => $valor) {
                $stm->bindValue($index + 1, $valor);
            }
            $stm->execute();
            return $stm->fetchAll();
        } catch (PDOException $e) {
            echo "Error al getByFilterData: " . $e->getMessage();
            error_log("Error al getByFilterData: " . $e->getMessage());
            return false;
        }
    }

    public function getAllOrderBy($orderColumn, $orderDirection = 'ASC'){
        try{
            $validOrderDirections = array('ASC', 'DESC');
            $orderDirection = strtoupper($orderDirection);
            if (!in_array($orderDirection, $validOrderDirections)) {
                $orderDirection = 'ASC';
            }
    
            $query = "SELECT * FROM {$this->tabla} ORDER BY {$orderColumn} {$orderDirection}";
            $stm = $this->connection->prepare($query);
            $stm->execute();
            return $stm->fetchAll();
        } catch (PDOException $e) {
            echo "Error al obtener todos los registros ordenados: " . $e->getMessage();
            error_log("Error al obtener todos los registros ordenados: " . $e->getMessage());
        }
    }

     public function deleteById($id) {
         try {
             $idTabla = "id{$this->tabla}";
             $query = "DELETE FROM {$this->tabla} WHERE {$idTabla} = :id";
             $stm = $this->connection->prepare($query);
             $stm->bindParam(':id', $id);
             return $stm->execute();
         } catch (PDOException $e) {
             echo "Error al eliminar el registro por ID: " . $e->getMessage();
             error_log("Error al eliminar el registro por ID: " . $e->getMessage());
         }
     }
    
    public function filtroJoin(
        $condicionesJoin, 
        $condicionesWhere,
        $condicionLike,
        $condicionOrder ,
        $orderDirection
        ) {
        try {
            $query = "SELECT * FROM {$this->tabla} ";
            $params = [];
    
            if (!empty($condicionesJoin)) {
                $query .= "JOIN ";
                $condiciones_join = [];
                foreach ($condicionesJoin as $condicion) {
                    $condiciones_join[] = $condicion;
                }
                $query .= implode(" JOIN ", $condiciones_join) . " ";
            }
            $query .= "WHERE diario.visible = 1 ";
            if (!empty($condicionesWhere)) {
                $query .= " AND ";
                $condiciones_sql = [];
                foreach ($condicionesWhere as $clave => $key) {
                    foreach ($key as $nombre => $valor) {
                        $condiciones_sql[] = "$nombre = ?";
                        $params[] = $valor;
                    } 
                }
                    $query.= implode(" OR ", $condiciones_sql);
            }
            if (!empty($condicionLike)) {
                $query .= " AND Diario.tituloDiario LIKE ?";
                $params[] = "%{$condicionLike}%";
            }
            $query .= " GROUP BY {$this->tabla}.idDiario ";

            $query .= " ORDER BY {$this->tabla}.{$condicionOrder} {$orderDirection} ";

            $stm = $this->connection->prepare($query);
            foreach ($params as $index => $valor) {
                $stm->bindValue($index + 1, $valor);
            }
            $stm->execute();
            return $stm->fetchAll();
        } catch (PDOException $e) {
            echo "Error al consultar la base de datos: " . $e->getMessage();
            error_log("Error al consultar la base de datos: " . $e->getMessage());
            return false;
        }
    }  
    
}