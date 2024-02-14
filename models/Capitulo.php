<?php
require_once __DIR__.'/Orm.php';
final class Capitulo extends Orm{
    private  $id;
    private  $idDiario;
    private  $titulo;
    private  $imagen;
    private  $parrafo;
    private  $fechaCreacion;
 
    public function __construct(PDO $connecion){
        parent::__construct("Capitulo",$connecion);
    }

    public function getId(){ return $this->id; }
    public function getIdDiario(){return $this->idDiario;}
    public function getTitulo(){return $this->titulo;}
    public function getImagen(){return $this->imagen;}
    public function getParrafo(){return $this->parrafo;}
    public function getFechaCreacion(){return $this->fechaCreacion;}


    public function datosDiarioDB(
        $id,
        $idDiario,
        $titulo,
        $imagen,
        $parrafo,
        $fechaCreacion,
        ) {
        $this->id = $id;
        $this->idDiario = $idDiario;
        $this->titulo = $titulo;
        $this->fechaCreacion = $fechaCreacion;
        $this->imagen = $imagen;
        $this->parrafo = $parrafo; 
        $this->fechaCreacion = $fechaCreacion;
    }
    public function guardaDatosCapituloDB($idDiario,$titulo) {
        $datoFilt=array(
            'idDiario' => $idDiario,
            'titulo' => $titulo
        );

        $dato = $this->getByFilterData($datoFilt);
        if (!empty($dato)) {
            foreach ($dato as $key) {
                $this->id = $key["idCapitulo"];
                $this->idDiario = $key["idDiario"];
                $this->titulo = $key["titulo"];
                $this->imagen = $key["imagen"];
                $this->parrafo = $key["parrafo"];
                $this->fechaCreacion = $key["fechaCreacion"]; 
            }
        }
    }
    public function creaCapitulo($idDiario,$titulo,$imagen,$parrafo){
        $dato=[
            'idDiario' => $idDiario,
            'titulo' => $titulo,
            'imagen' => $imagen,
            'parrafo' => $parrafo
        ];
        $resultado = $this->insert($dato);
        return !empty($resultado);
    }


}