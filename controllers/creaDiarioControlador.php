<?php
require_once 'config/DataBase.php';
require_once 'models/Categoria.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$categoriaModelo = new Categoria($coneccion);
$vistaCategoria = muestraCategorias($categoriaModelo);
$dataBase->desconectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CREAR DIARIO + CAPITULO ////////////////////
    if (isset($_POST["botonCrearDiario"])) {
        
    }
}

function muestraCategorias(Categoria $Modelo){
   
    $dato = $Modelo->getAll();
    $vista="";
    if (!empty($dato)) {
        foreach ($dato as $key) {
            $vista.="<div class='selector-categoria'>
                        <input type='checkbox' id='categoria_" . $key["idCategoria"] . "' name='categorias[]' value='" . $key["idCategoria"] . "'>
                        <label for='categoria_" . $key["idCategoria"] . "' class='checkbox-label'>" . $key["descripcion"] . "</label>
                    </div>";
        } 
        return $vista;    
    }
}