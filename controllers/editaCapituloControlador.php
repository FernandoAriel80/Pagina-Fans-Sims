<?php
require_once 'config/DataBase.php';
require_once 'models/Capitulo.php';
require_once 'models/Diario.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$mensaje='';
$vistaDato= '';
$capituloModelo = new Capitulo($coneccion);

if (isset($_GET['tokenC'])) {
    $idCapituloActual = obteneTokenId($_GET['tokenC']);
}
if (isset($_GET['tokenD'])) {
    $idDiarioActual = obteneTokenId($_GET['tokenD']);
}

$datocapituloModelo=$capituloModelo->obtenerUnCapitulo($idCapituloActual);
$vistaDato = vistacapitulo($datocapituloModelo);
$dataBase->desconectar(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CAPITULO ////////////////////
    if (isset($_POST["botonEditaCapitulo"])) {
        $diarioModelo = new Diario($coneccion);
        if (isset($_POST["tituloE"])) {
            $tituloEntrada = sinEspaciosLados($_POST["tituloE"]);
            $contenidoE = sinEspaciosLados(limpiarTexto($_POST["contenidoE"]));
            if(validaCreaCapitulo($tituloEntrada,$contenidoE)){
                if(isset($_FILES["imagenE"]) && !empty($_FILES["imagenE"]["name"])){
                    if(imagenValida($_FILES["imagenE"])){
                        $imagen = $_FILES["imagenE"]["name"];
                        $temp = $_FILES["imagenE"]["tmp_name"];
                        $imagenNombre = guardaImagen($temp,'public/ImagenesDiario/',$imagen);
                        if ($datocapituloModelo->imagen) {
                            eliminaImagen('public/ImagenesDiario/',$datocapituloModelo->imagen);
                        }
                    }
                }else {
                    $imagenNombre = $datocapituloModelo->imagen;
                }   
               
                if($idDiarioActual !== null){
                    $resultado=$capituloModelo->editaCapitulo($idCapituloActual,$tituloEntrada,$imagenNombre,$contenidoE);
                    if($resultado){
                        $diarioModelo->fechaActualizarDiario($idDiarioActual); 
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

function vistacapitulo($datoCapitulo){
    $vista="";
    if (!empty($datoCapitulo)) {
   
        $vista .= ' <input type="text" id="tituloE" name="tituloE" value="'.$datoCapitulo->titulo.'" placeholder="Titulo de entrada" required>
                        <textarea id="contenidoE" name="contenidoE" rows="5" cols="40" 
                        placeholder="escribe detalles de tu entrada">'.$datoCapitulo->parrafo.'</textarea>';
        return $vista;    
    }
}