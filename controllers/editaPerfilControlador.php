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
$dataBase->desconectar(); 
$vistaDato = vistaPerfil($datoUsuarioModelo);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ////////////////////////// BOTON CAPITULO ////////////////////
    if (isset($_POST["botonEditaPerfil"])) {

        if (isset($_POST["nombreP"])) {
            $nombre = sinEspaciosLados($_POST["nombreP"]);

            if( $nombre == $datoUsuarioModelo->nombre ){

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
            }else if (!validaNombreExistente($usuarioModelo,$nombre)) {
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
            }
          
        }

        
    }
}

function vistaPerfil($datoPerfil){
    $vista="";
    if (!empty($datoPerfil)) {
        if ($datoPerfil->imagen != null) {
            $vista .= ' 
            <div class="imagenPerfil">
                <a href="public/ImagenesPefil/'.$datoPerfil->imagen.'">
                    <img src="public/ImagenesPefil/'.$datoPerfil->imagen.'"/>
                </a>  
            </div>';

            
        }else {
            $vista .= ' 
            <div class="imagenPerfil">
                <a href="public/Iconos/perfilFoto.png">
                    <img src="public/Iconos/perfilFoto.png"/>
                </a>  
            </div>';
        }

        $vista .= '<input type="text" id="tituloE" name="tituloE" value="'.$datoPerfil->nombre.'" placeholder="Titulo de entrada" required>';
        return $vista;   
    }
}

function validaNombreExistente(Usuario $modelo,string $nombre){  
    $dato = $modelo->obtenerTodosUsuarios();
    if (!empty($dato)) {
        foreach ($dato as $usuario) {
            if($usuario->nombre == $nombre){
                return [true,'¡nombre existente!'];
            }else{
                return false; 
            }
        }
    }
}