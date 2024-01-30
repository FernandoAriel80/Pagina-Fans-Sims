<?php

require_once __DIR__.'../models/Usuario.php';
require_once __DIR__.'../config/DataBase.php';
require_once __DIR__.'../validations/validaciones.php';
require_once __DIR__.'../validations/validaSesiones.php';

session_start();
$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$vistaLeft;
// if (!sesionActiva()) {
//     // Verificar si hay una cookie de "recordar" y restaurar la sesión si es necesario
//     Auth::verificarRecuerdaCookie();
//     header("Location: login.php");
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if(isset($_POST["formularioRegistro"])){
        $usuarioModelo = new Usuario($coneccion);

        $nombre = sinEspaciosLados(isset($_POST["nombreR"]));
        $correo = sinEspaciosLados(isset($_POST["emailR"]));
        $usuario = sinEspaciosLados(isset($_POST["usuarioR"]));
        $clave = sinEspaciosLados(isset($_POST["contraseñaR"]));
        $claveConfirmar = sinEspaciosLados(isset($_POST["confirmarContraseñaR"]));

        if (validaRegistro($nombre,$email,$usuario,$clave,$claveConfirmar)) {
            if (!validaUsuarioExistente($usuarioModelo,$dataBase,$usuario,$correo)) {
                $usuarioModelo->datosRegistro($nombre,$correo,$usuario,$clave);
                $resultado = registrarUsuario($usuarioModelo,$dataBase);
                // $dataBase->desconectar();
                if ($resultado) {
                    traerDatosUsuario($usuarioModelo,$dataBase);
                    iniciarSesion($usuarioModelo->getId(),$usuarioModelo->getUsuario());
                    $vistaLeft= muestraLogin();
                    # code... se creo correctamente
                } else {
                    # code... fallo al crear usuario
                }
                
            }
        }   
    }

}

function muestraRegistro(){
$vista="";
return $vista;
}
function muestraLogin(){
    
}
function muestraLogeado(){
    
}

function validaRegistro(string $nombre,string $correo,string $usuario,string $clave,string $claveConfirmar,){
    if (nombreValida($nombre) && emailValida($correo) && usuarioValida($usuario) 
    && claveValida($clave) && claveConfirmacionValida($clave, $claveConfirmar)) {
        return true;
    } else {
        return false;
    } 
}

function validaUsuarioExistente(Usuario $modelo,DataBase $dataBase, string $usuario, string $correo){  
    $dato = $modelo->getByUsuAndEmail($usuario,$correo);
    $dataBase->desconectar();
    foreach ($dato as $fila) {
        if($fila->usuario == $usuario){
            // echo ''; ejecute usuario existente un scrip js
        }if($fila->correo == $correo){
            // echo ''; ejecute correo existente un scrip js
            return true;
        }else {
            return false;
        }
    }
}

function registrarUsuario(Usuario $modelo,DataBase $dataBase){
    $dato=[
        'usuario' => $modelo->getUsuario(),
        'nombre' => $modelo->getNombre(),
        'correo' => $modelo->getCorreo(),
        'clave' => $modelo->getClaveIncript(),
        'sal' => $modelo->getSal()
    ];
    $resultado = $modelo->insert($dato);
    $dataBase->desconectar();
    if ($resultado) {
        return true;
    } else {
        return false;
    }  
}

function traerDatosUsuario(Usuario $modelo,DataBase $dataBase){
    $dato= $modelo->getByUsu($modelo->getUsuario());
    $dataBase->desconectar();
    foreach ($dato as $fila) {
        $modelo->datosUsuarioDB(
            $fila->idUsuario,
            $fila->usuario,
            $fila->token,
            $fila->nombre,
            $fila->foto,
            $fila->descripcion,
            $fila->fechaCreacion,
            $fila->activo,
            $fila->correo,
            $fila->clave,
            $fila->sal,
            $fila->rol
        );
    }
}
