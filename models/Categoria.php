<?php
require_once __DIR__.'/Orm.php';
final class Categoria extends Orm{
    private  $id;
    private  $descripcion;


    public function __construct(PDO $connecion){
        parent::__construct("Categoria",$connecion);
    }

    public function getId(){ return $this->id; }
    public function getDescripcion(){ return $this->descripcion; }

    public function datosDescripcionDB($id,$descripcion) {
       $this->id = $id;
       $this->descripcion = $descripcion;
   }
}