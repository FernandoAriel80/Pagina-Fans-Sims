<?php
require_once 'config/DataBase.php';
require_once 'models/Capitulo.php';
require_once 'models/Diario.php';
require_once 'models/CategoriaDiario.php';
require_once 'models/Favorito.php';
require_once 'models/Puntaje.php';
require_once 'validations/validaciones.php';
//require_once 'validations/validaSesiones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();

$capituloModelo = new Capitulo($coneccion);
$diarioModelo = new Diario($coneccion);
$categoriaDiarioModelo = new CategoriaDiario($coneccion);
$favoritoModelo = new Favorito($coneccion);
$puntajeModelo = new Puntaje($coneccion);

$datoCapituloModelo = $capituloModelo->obtenerTodosCapitulos();
$datoCategoriaDiarioModelo = $categoriaDiarioModelo->obtenerTodosCategoriaDiario();
$datoFavoritoModelo = $favoritoModelo->obtenerTodosFavorito();
$datoPuntajeModelo = $puntajeModelo->obtenerTodosPuntaje();

if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
}

if (!empty($idDiarioActual)) {
    if (!empty($datoCapituloModelo)) {
        foreach ($datoCapituloModelo as $capitulo ) {
            if ($capitulo->idDiario == $idDiarioActual) {
                $capituloModelo->deleteById($capitulo->idCapitulo);
            }
        }
    }
    if (!empty($datoCategoriaDiarioModelo)) {
        foreach ($datoCategoriaDiarioModelo as $categoriaDiario) {
            if ($categoriaDiario->idDiario == $idDiarioActual) {
                $categoriaDiarioModelo->deleteById($categoriaDiario->idCategoriaDiario);
            }
        }
    }
    if (!empty($datoFavoritoModelo)) {
        foreach ($datoFavoritoModelo as $favorito) {
            if ($favorito->idDiario == $idDiarioActual) {
                $favoritoModelo->deleteById($favorito->idFavorito);
            }
        }
    }
    if (!empty($datoPuntajeModelo)) {
        foreach ($datoPuntajeModelo as $puntaje) {
            if ($puntaje->idDiario == $idDiarioActual) {
                $puntajeModelo->deleteById($puntaje->idPuntaje);
            }
        }
    }
    $diarioModelo->deleteById($idDiarioActual);
    $dataBase->desconectar(); 
    header("Location: perfil.php"); 
}