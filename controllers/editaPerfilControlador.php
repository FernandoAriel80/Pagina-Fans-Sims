<?php
require_once 'config/DataBase.php';
require_once 'models/Usuario.php';
require_once 'validations/validaciones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$mensaje='';
$vistaDato= '';

$usuarioModelo = new Usuario($coneccion);
$idUsuarioActual = $_SESSION["idUsuario"];
$datoUsuarioModelo = $usuarioModelo->obtenerUnUsuario($idUsuarioActual);
//echo $datoUsuarioModelo->foto;
$dataBase->desconectar(); 
$vistaDato = vistaPerfil($datoUsuarioModelo);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CAPITULO ////////////////////
    if (isset($_POST["botonEditaPerfil"])) {
   
        if (isset($_POST["nombreP"])) {
            
            $nombre = sinEspaciosLados($_POST["nombreP"]);
            if(!validaNombreExistente($usuarioModelo,$datoUsuarioModelo->nombre,$nombre)){
                if(isset($_FILES["imagenP"]) && !empty($_FILES["imagenP"]["name"])){
                    if(imagenValida($_FILES["imagenP"])){
                        $imagen = $_FILES["imagenP"]["name"];
                        $temp = $_FILES["imagenP"]["tmp_name"];
                        $imagenNombre = guardaImagen($temp,'public/ImagenesPerfil/',$imagen);
                        if ($datoUsuarioModelo->foto) {
                            eliminaImagen('public/ImagenesPerfil/',$datoUsuarioModelo->foto);
                        }
                    }
                }else {
                   $imagenNombre = $datoUsuarioModelo->foto;
                } 
                $resultado=$usuarioModelo->editaPerfil($idUsuarioActual,$nombre,$imagenNombre);
                header("Location: perfil.php");
            }else{
                $mensaje = muestraMensajePerfil('¡nombre existente!');
            }
           
          
        }

        
    }
}

function muestraMensajePerfil($message){
    $vista='<div class="contenedor-cosas">
                <h4>'.$message.'</h4>
            </div>';
    return $vista;
}

function vistaPerfil($datoPerfil){
    $vista="";
    if (!empty($datoPerfil)) {
        if ($datoPerfil->foto != null) {
            $vista .= ' 
            <div class="imagenPerfil">
                <a href="public/ImagenesPerfil/'.$datoPerfil->foto.'">
                    <img src="public/ImagenesPerfil/'.$datoPerfil->foto.'" alt="Foto de perfil"/>
                </a>  
            </div>';

            
        }else {
            $vista .= ' 
            <div class="imagenPerfil">
                <a href="public/Iconos/perfilFoto.png">
                    <img src="public/Iconos/perfilFoto.png" alt="Foto de perfil"/>
                </a>  
            </div>';
        }

        $vista .= '<input type="text" id="nombreP" name="nombreP" value="'.$datoPerfil->nombre.'" placeholder="Nombre" required>';
        return $vista;   
    }
}

function validaNombreExistente(Usuario $modelo,string $myNombre,string $nombre){  
    $dato = $modelo->getNombreExistente($myNombre,$nombre);
    if (!empty($dato)) {
        return true;
    }else{
        return false;
    }
} 
