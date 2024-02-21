<?php
require_once __DIR__.'/Orm.php';
final class CategoriaDiario extends Orm{

    public function __construct(PDO $connecion){
        parent::__construct("CategoriaDiario",$connecion);
    }

    public function categoriaSelecionada($id,$categorias){
        foreach ($categorias as $idCategoria) {
            $dato=[
                'idDiario' => $id,
                'idCategoria' => $idCategoria
            ];
            $this->insert($dato);
        }
    }
}