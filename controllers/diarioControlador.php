<?php
require_once 'models/Usuario.php';
require_once 'models/Diario.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$diarioModelo = new Diario($coneccion);
$usuarioModelo = new Usuario($coneccion);
$misDiarios = [];
$todosDiarios = [];
$perfil= '';
$idUsuarioActual = $_SESSION['idUsuario'];

if (isset($_GET['token'])) {
    $idUsuarioActual = obteneTokenId($_GET['token']);
}
