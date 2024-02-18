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
            echo "Error al obtener todos los registros: " . $e->getMessage();
            error_log("Error al obtener todos los registros: " . $e->getMessage());
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
            echo "Error al obtener el registro: " . $e->getMessage();
            error_log("Error al obtener el registro: " . $e->getMessage());
        }
    }
    public function getAllJoin($tabla1, $tabla2) {
        try{
            $idTabla = "id{$tabla1}";
            $query = "SELECT * FROM $tabla1 INNER JOIN $tabla2 ON {$tabla1}.{$idTabla} = {$tabla2}.{$idTabla}";
            $stm = $this->connection->prepare($query);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener todos los registros join: " . $e->getMessage();
            error_log("Error al obtener todos los registros join: " . $e->getMessage());
        }
    }
    public function getByIdJoin($tabla1, $tabla2, $id) {
        try{
            $idTabla = "id{$tabla1}";
            $query = "SELECT * FROM $tabla1 INNER JOIN $tabla2 ON {$tabla1}.{$idTabla} = {$tabla2}.{$idTabla} WHERE {$idTabla} =:id";
            $stm = $this->connection->prepare($query);
            $stm->bindValue(":id", $id);
            $stm->execute();
            return $stm->fetchAll();
        }catch (PDOException $e) {
            echo "Error al obtener registro join: " . $e->getMessage();
            error_log("Error al obtener registro join: " . $e->getMessage());
        }
    }

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
    
    // public function insert($dato){
    //     try{
    //         $query = "INSERT INTO {$this->tabla}(";
    //         foreach ($dato as $key => $value) {
    //             $query .= "{$key},";
    //          }
    //          $query = trim($query,",");
    //          $query .= ") VALUES (";
             
    //          foreach ($dato as $key => $value) {
    //             $query .= ":{$key}";
    //          }
    //          $query = trim($query,",");
    //          $query .= ")";
             
    //          $stm = $this->connection->prepare($query);
    //          foreach ($dato as $key => $value) {
    //             $stm->bindValue(":{$key}", $value);
    //          }  
    //          return $stm->execute();
    //     }catch (PDOException $e) {
    //         echo "Error al insertar registro: " . $e->getMessage();
    //         return false;
    //     }
    // }
    // public function getByField($id){
    //    try{
    //       
    //    }catch (PDOException $e) {
    //        echo "Error al obtener todos los registros: " . $e->getMessage();
    //    }
    //     $query = "SELECT * FROM {$this->tabla} WHERE id".$this->tabla." =:id";
    //     $stm = $this->connection->prepare($query);
    //     $stm->bindValue(":id", $id);
    //     $stm->execute();
    //     return $stm->fetch();
    // }

//     SELECT *
// FROM usuarios_productos up
// INNER JOIN usuarios u ON u.idUsuario = up.idUsuario
// INNER JOIN productos p ON p.idProducto = up.idProducto;

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
    
}