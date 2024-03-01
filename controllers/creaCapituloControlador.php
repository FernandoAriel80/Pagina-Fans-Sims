<?php
require_once 'config/DataBase.php';
require_once 'models/Capitulo.php';
require_once 'models/Diario.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();

$mensaje='';

if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
}
if (isset($_GET['diario'])) {
    $diarioActual = $_GET['diario'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CAPITULO ////////////////////
    if (isset($_POST["botonCrearCapitulo"])) {
        $capituloModelo = new Capitulo($coneccion);
        $capituloDiario = new Diario($coneccion);
        if (isset($_POST["tituloE"])) {
            $tituloEntrada = sinEspaciosLados($_POST["tituloE"]);
            $contenidoE = sinEspaciosLados(limpiarTexto($_POST["contenidoE"]));
            if(validaCreaCapitulo($tituloEntrada,$contenidoE)){
                if(isset($_FILES["imagenE"])){
                    if(imagenValida($_FILES["imagenE"])){
                        $imagen = $_FILES["imagenE"]["name"];
                        $temp = $_FILES["imagenE"]["tmp_name"];
                        $imagenNombre = guardaImagen($temp,'public/ImagenesDiario/',$imagen);
                    }
                }   
                if($idDiarioActual !== null){
                    $idCapitulo=$capituloModelo->creaCapitulo($idDiarioActual,$tituloEntrada,$imagenNombre,$contenidoE);
                    if($idCapitulo){
                        $capituloDiario->actualizarDiario($idDiarioActual); 
                    }
                   header("Location: perfil.php");
                }
            }else{
                $mensaje=muestraMensajea("problema con validaCreaCapitulo");
            }

        }else{
            $mensaje=muestraMensajea("problema ingresar datos");
        }
    }
    $dataBase->desconectar();
}
function muestraMensajea($message){
    $vista='<div class="contenedor-cosas">
                <h4>'.$message.'</h4>
            </div>';
    return $vista;
}

function validaCreaCapitulo(string $tituloEntrada,string $descripcionCapitulo){
    if (tituloValido($tituloEntrada)&&textoValido($descripcionCapitulo)) {
        return true;
    } 
    return false;
}
