<?php
require_once 'config/DataBase.php';
require_once 'models/Capitulo.php';
//require_once 'validations/validaSesiones.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();

$capituloModelo = new Capitulo($coneccion);

if (isset($_GET['tokenC'])) {
    $idCapituloActual = obteneTokenId($_GET['tokenC']);
}
/* if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
} */

if (!empty($idCapituloActual)) {
    $capituloModelo->deleteById($idCapituloActual);
    $dataBase->desconectar(); 
    //header("Location: perfil.php"); 
    echo '<meta http-equiv="refresh" content="0;url=perfil.php">';
}


