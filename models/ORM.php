<?php

class Orm{

    protected string $tabla;
    protected $connection;

    public  function __construct($tabla, PDO $connection){
        $this->tabla = $tabla;
        $this->connection = $connection;
    }

    public function getAll(){
        $query = "SELECT * FROM {$this->tabla}";
        $stm = $this->connection->prepare($query);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getById($id){
        $idTabla = "id{$this->tabla}";
        $query = "SELECT * FROM {$this->tabla} WHERE {$idTabla} =:id";
        $stm = $this->connection->prepare($query);
        $stm->bindValue(":id", $id);
        $stm->execute();
        return $stm->fetch();
    }
    public function getAllJoin($tabla1, $tabla2) {
        $idTabla = "id{$tabla1}";
        $query = "SELECT * FROM $tabla1 INNER JOIN $tabla2 ON {$tabla1}.{$idTabla} = {$tabla2}.{$idTabla}";
        $stm = $this->connection->prepare($query);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getByIdJoin($tabla1, $tabla2, $id) {
        $idTabla = "id{$tabla1}";
        $query = "SELECT * FROM $tabla1 INNER JOIN $tabla2 ON {$tabla1}.{$idTabla} = {$tabla2}.{$idTabla} WHERE {$idTabla} =:id";
        $stm = $this->connection->prepare($query);
        $stm->bindValue(":id", $id);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function insert($dato){
        $query = "INSERT INTO {$this->tabla}(";
        foreach ($dato as $key => $value) {
            $query .= "{$key},";
         }
         $query = trim($query,",");
         $query .= ") VALUES (";
         
         foreach ($dato as $key => $value) {
            $query .= ":{$key}";
         }
         $query = trim($query,",");
         $query .= ")";
         
         $stm = $this->connection->prepare($query);
         foreach ($dato as $key => $value) {
            $stm->bindValue(":{$key}", $value);
         }  
         $stm->execute();
    }
    // public function getByField($id){
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
        $stm->execute();
    }
}