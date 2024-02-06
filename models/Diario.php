<?php
require_once __DIR__.'/Orm.php';
final class Diario extends Orm{
    private  $id;
    private  $idUsuario;
    private  $nombre;
    private  $fechaCreacion;
    private  $fechaActualizacion;
    private  $descripcion;
    private  $puntoPrimedio;
    private  $favoritoTotal;
    private  $visible;
    


    public function __construct(PDO $connecion){
        parent::__construct("Diario",$connecion);
    }

    public function getId(){ return $this->id; }
    public function getIdUsuario(){return $this->idUsuario;}
    public function getNombre(){return $this->nombre;}
    public function getFechaCreacion(){return $this->fechaCreacion;}
    public function getFechaActualizacion(){return $this->fechaActualizacion;}
    public function getDescripcion(){return $this->descripcion;}
    public function getPuntoPrimedio(){return $this->puntoPrimedio;}
    public function getFavoritoTotal(){return $this->favoritoTotal;}
    public function getVisible(){return $this->visible;}
    
    public function datosDescripcionDB(
        $id,
        $idUsuario,
        $nombre,
        $fechaCreacion,
        $fechaActualizacion,
        $descripcion,
        $puntoPrimedio,
        $favoritoTotal,
        $visible
        ) {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaActualizacion = $fechaActualizacion;
        $this->descripcion = $descripcion; 
        $this->puntoPrimedio = $puntoPrimedio;
        $this->favoritoTotal = $favoritoTotal;
        $this->visible = $visible;
    }
}