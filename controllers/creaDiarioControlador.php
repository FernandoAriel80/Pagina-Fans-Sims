<?php
require_once 'config/DataBase.php';
require_once 'models/Categoria.php';
require_once 'models/Diario.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$categoriaModelo = new Categoria($coneccion);
$vistaCategoria = muestraCategorias($categoriaModelo);
$dataBase->desconectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CREAR DIARIO + CAPITULO ////////////////////
    if (isset($_POST["botonCrearDiario"])) {
        $diarioModelo = new Diario($coneccion);
        if (isset($_POST["tituloD"])&&isset($_POST["descripcionD"])&&isset($_POST["categoriaD"])&&
        isset($_POST["tituloE"])&&isset($_POST["contenidoE"])&&isset($_POST["imagenE"])&&isset($_POST["checkD"])) {
            $tituloDiario = sinEspaciosLados($_POST["tituloD"]);
            $descripcion = sinEspaciosLados($_POST["descripcionD"]);
            $categoria = sinEspaciosLados($_POST["categoriaD"]);
            $tituloEntrada = sinEspaciosLados($_POST["tituloE"]);
            $contenidoE = limpiarTexto($_POST["contenidoE"]);
            $imagen = codificaImagen($_POST["imagenE"]);
            $checkDiario = checkValida($_POST["checkD"]); /// de "on" : "off" a 1 : 0
            if(validaCreaDiario($tituloDiario,$descripcion,$tituloEntrada)){
                
            }

        }
    }
}

function muestraCategorias(Categoria $Modelo){
    $dato = $Modelo->getAll();
    $vista="";
    if (!empty($dato)) {
        foreach ($dato as $key) {
            $vista.="<div class='selector-categoria'>
                        <input type='checkbox' id='categoria-input' name='categoriaD[]' value='" . $key["idCategoria"] . "'>
                        <label for='categoria_" . $key["idCategoria"] . "' class='checkbox-label'>" . $key["descripcion"] . "</label>
                    </div>";
        } 
        return $vista;    
    }
}

function validaCreaDiario(string $tituloDiario,string $descripcion,string $tituloEntrada){
    if (nombreValida($tituloDiario) && nombreValida($descripcion) && nombreValida($tituloEntrada)) {
        return true;
    } else {
        return false;
    } 
}