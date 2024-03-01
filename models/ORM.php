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
    public function getAllJoin($tablaUnida) { // se le agrega tabla del id relacionado a esa tabla
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
    // public function getByIdJoin($tablaUnida,$id) {
    //     try{
    //         $idTabla = "id{$tablaUnida}";
    //         $query = "SELECT * FROM {$this->tabla} INNER JOIN $tablaUnida ON {$this->tabla}.{$idTabla} = {$tablaUnida}.{$idTabla} WHERE {$this->tabla} =:id";
    //         $stm = $this->connection->prepare($query);
    //         $stm->bindValue(":id", $id);
    //         $stm->execute();
    //         return $stm->fetchAll();
    //     }catch (PDOException $e) {
    //         echo "Error al obtener registro join: " . $e->getMessage();
    //         error_log("Error al obtener registro join: " . $e->getMessage());
    //     }
    // }

    public function insert($dato){
        try {
            // Construir la consulta SQL
            $keys = implode(', ', array_keys($dato));
            $values = ':' . implode(', :', array_keys($dato));
            $query = "INSERT INTO {$this->tabla} ({$keys}) VALUES ({$values})";
            
            // Preparar la consulta
            $stm = $this->connection->prepare($query);
            
            // Vincular los parámetros y ejecutar la consulta
            foreach ($dato as $key => $value) {
                $stm->bindValue(":{$key}", $value);
            }  
             // Ejecutar la consulta
            $stm->execute();
            // retorna ultimo id insertado 
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

    // public function filtrarDatos($condiciones = array()) {
    //     $query = "SELECT * FROM {$this->tabla}";
    //     $params = array();

    //     if (!empty($condiciones)) {
    //         $query .= " WHERE ";
    //         $condiciones_sql = array();
    //         foreach ($condiciones as $campo => $valor) {
    //             $condiciones_sql[] = "$campo = ?";
    //             $params[] = $valor;
    //         }
    //         $query .= implode(" AND ", $condiciones_sql);
    //     }

    //     $stm = $this->connection->prepare($query);
    //     $stm->execute($params);
    //     return $stm->fetchAll();
    // }

    // public function getByFilterData($condiciones = array()) {
    //     $query = "SELECT * FROM {$this->tabla}";
    //     $params = array();
    
    //     if (!empty($condiciones)) {
    //         $query .= " WHERE ";
    //         $condiciones_sql = array();
    //         foreach ($condiciones as $campo => $valor) {
    //             $condiciones_sql[] = "$campo = ?";
    //             $params[$campo] = $valor; // Agregamos la condición al array de parámetros
    //         }
    //         $query .= implode(" AND ", $condiciones_sql);
    //     }
    
    //     $stm = $this->connection->prepare($query);
    
    //     // Asignamos valores utilizando bindValue()
    //     foreach ($params as $campo => $valor) {
    //         $stm->bindValue(":$campo", $valor);
    //     }
    
    //     $stm->execute();
    //     return $stm->fetchAll();
    // }
    
    public function getByFilterData($condiciones = array()) {
        try {
            $query = "SELECT * FROM {$this->tabla}";
            $params = array();
            if (!empty($condiciones)) {
                $query .= " WHERE ";
                $condiciones_sql = array();
                foreach ($condiciones as $clave => $valor) {
                    $condiciones_sql[] = "$clave = ?";
                    $params[] = $valor; // Agregamos el valor al array de parámetros
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
            // Verificar la dirección de ordenamiento para evitar posibles inyecciones SQL
            $validOrderDirections = array('ASC', 'DESC');
            $orderDirection = strtoupper($orderDirection);
            if (!in_array($orderDirection, $validOrderDirections)) {
                $orderDirection = 'ASC';
            }
    
            // Preparar la consulta SQL con la cláusula ORDER BY
            $query = "SELECT * FROM {$this->tabla} ORDER BY {$orderColumn} {$orderDirection}";
            $stm = $this->connection->prepare($query);
            $stm->execute();
            return $stm->fetchAll();
        } catch (PDOException $e) {
            echo "Error al obtener todos los registros ordenados: " . $e->getMessage();
            error_log("Error al obtener todos los registros ordenados: " . $e->getMessage());
        }
    }

    // public function deleteById($id) {
    //     try {
    //         $idTabla = "id{$this->tabla}";
    //         $query = "DELETE FROM {$this->tabla} WHERE {$idTabla} = :id";
    //         $stm = $this->connection->prepare($query);
    //         $stm->bindParam(':id', $id);
    //         return $stm->execute();
    //     } catch (PDOException $e) {
    //         echo "Error al eliminar el registro por ID: " . $e->getMessage();
    //         error_log("Error al eliminar el registro por ID: " . $e->getMessage());
    //     }
    // }
    
    // public function consultaJoin($condicionesJoin = array(),$condicionesWhere = array()) {
    //     try{
    //         $query = "SELECT * FROM {$this->tabla} ";
    //         $paramsJoin = array();
    //         $params = array();
    //         if (!empty($condicionesJoin)) {
    //             $query .= " JOIN ";
    //             $condiciones_join = array();
    //             foreach ($condicionesJoin as $clave => $valor) {
    //                 $condiciones_join[] = "$clave ON ?";
    //                 $paramsJoin[] = $valor; // Agregamos el valor al array de parámetros
    //             }
    //             $query .= implode(" JOIN ", $condiciones_join);
    //         }
    //         if (!empty($condicionesWhere)) {
    //             $query .= " WHERE ";
    //             $condiciones_sql = array();
    //             foreach ($condicionesWhere as $clave => $valor) {
    //                 $condiciones_sql[] = "$clave = ?";
    //                 $params[] = $valor; // Agregamos el valor al array de parámetros
    //             }
    //             $query .= implode(" AND ", $condiciones_sql);
    //         }
    //         $stm = $this->connection->prepare($query);
    //         // Asignamos valores utilizando bindValue()
    //         foreach ($paramsJoin as $index => $valor) {
    //             $stm->bindValue($index + 1, $valor);
    //         }
    //         foreach ($params as $index => $valor) {
    //             $stm->bindValue($index + 1, $valor);
    //         }
    //         $stm->execute();
    //         return $stm->fetchAll();
    //     } catch (PDOException $e) {
    //         echo "Error al consultaJoin: " . $e->getMessage();
    //         error_log("Error al consultaJoin: " . $e->getMessage());
    //         return false;
    //     }
    // }

    // public function consultaJoin($tablaPrincipal, $condiciones) {
    //     $sql = "SELECT * FROM $tablaPrincipal ";
    //     foreach ($condiciones as $join) {
    //         $sql .= " JOIN {$join['tabla']} ON {$join['condicion']} ";
    //     }
    //     $sql .= " WHERE {$condiciones[0]['condicion']}";

    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    
}