<?php
require_once __DIR__.'/Orm.php';
final class CategoriaDiario extends Orm{
    private  $id;
    private  $idDiario;
    private  $idCategoria;
 
    public function __construct(PDO $connecion){
        parent::__construct("CategoriaDiario",$connecion);
    }

    public function getId(){ return $this->id; }
    public function getIdDiario(){return $this->idDiario;}
    public function getIdCategoria(){return $this->idCategoria;}
    
    public function datosCategoriaDiario(
        $idDiario,
        $idCategoria,
        ) {
        $this->idDiario = $idDiario;
        $this->idCategoria = $idCategoria;
    }

    public function datosCategoriaDiarioDB(
        $id,
        $idDiario,
        $idCategoria,
        ) {
        $this->id = $id;
        $this->idDiario = $idDiario;
        $this->idCategoria = $idCategoria;
    }




}