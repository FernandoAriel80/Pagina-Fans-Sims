<?php
require_once 'config/DataBase.php';
require_once 'models/Capitulo.php';
require_once 'models/Diario.php';
require_once 'models/CategoriaDiario.php';
require_once 'validations/validaSesiones.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();

$capituloModelo = new Capitulo($coneccion);
$diarioModelo = new Diario($coneccion);
$categoriaDiarioModelo = new CategoriaDiario($coneccion);

$datoCapituloModelo = $capituloModelo->obtenerTodosCapitulos();
$datoCategoriaDiarioModelo = $categoriaDiarioModelo->obtenerTodosCategoriaDiario();

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
    $diarioModelo->deleteById($idDiarioActual);
    $dataBase->desconectar(); 
    header("Location: perfil.php"); 
}