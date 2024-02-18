<?php
require_once __DIR__.'/Orm.php';
final class Diario extends Orm{
    private  $id;
    private  $idUsuario;
    private  $titulo;
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
    public function getNombre(){return $this->titulo;}
    public function getFechaCreacion(){return $this->fechaCreacion;}
    public function getFechaActualizacion(){return $this->fechaActualizacion;}
    public function getDescripcion(){return $this->descripcion;}
    public function getPuntoPrimedio(){return $this->puntoPrimedio;}
    public function getFavoritoTotal(){return $this->favoritoTotal;}
    public function getVisible(){return $this->visible;}
    
    // public function datosDiario($nombre,$descripcion,$visible){
    //     $this->nombre = $nombre;
    //     $this->descripcion = $descripcion; 
    //     $this->visible = $visible;
    // }

    public function guardaDatosCreaDiarioDB($idUsuario,$titulo) {
        $datoFilt=array(
            'idUsuario' => $idUsuario,
            'titulo' => $titulo
        );

        $dato = $this->getByFilterData($datoFilt);
        if (!empty($dato)) {
            foreach ($dato as $key) {
                $this->id = $key["idDiario"];
                $this->idUsuario = $key["idUsuario"];
                $this->titulo = $key["titulo"];
                $this->fechaCreacion = $key["fechaCreacion"];
                $this->fechaActualizacion = $key["fechaActualizacion"];
                $this->descripcion = $key["descripcion"]; 
                $this->puntoPrimedio = $key["puntoPrimedio"];
                $this->favoritoTotal = $key["favoritoTotal"];
                $this->visible = $key["visible"];
            }
        }
    }
    // public function guardaDatosDiarioDB() {
    //     $dato = $this->getAll();
    //     if (!empty($dato)) {
    //         foreach ($dato as $key) {
    //             $this->id = $key["idDiario"];
    //             $this->idUsuario = $key["idUsuario"];
    //             $this->nombre = $key["nombreDiario"];
    //             $this->fechaCreacion = $key["fechaCreacion"];
    //             $this->fechaActualizacion = $key["fechaActualizacion"];
    //             $this->descripcion = $key["descripccion"]; 
    //             $this->puntoPrimedio = $key["puntoPrimedio"];
    //             $this->favoritoTotal = $key["favoritoTotal"];
    //             $this->visible = $key["visible"];
    //         }
    //     }
    // }

    public function creaDiario($idUsuario,$titulo,$descripcion,$visible){
        $dato=[
            'idUsuario' => $idUsuario,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'visible' => $visible
        ];
        
        return $this->insert($dato);
    }


}