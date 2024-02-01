<?php

require_once 'models/Usuario.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';

session_start();
$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$vistaLeft = '';
$mensaje='';
if (!sesionActiva() && isset($_COOKIE['recuerdaUsuario'])) {
   $vistaLeft = muestraLogin();
//    header('Location: index.php');
//    exit();
}else{
    $vistaLeft = muestraLogeado();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["botonNavRegistrar"])) {
        $vistaLeft= muestraRegistro();
    }
    if (isset($_POST["botonNavOut"])) {
        cerrarSesion();
        // Redirigir al usuario a la página de inicio de sesión
        $vistaLeft = muestraLogin();
    }

   if(isset($_POST["formularioRegistro"])){
    //echo  $_SESSION["idUsuario"];
    //echo  $_SESSION["usuario"];
    //cerrarSesion();
        $usuarioModelo = new Usuario($coneccion);
        if (isset($_POST["nombreR"])&&isset($_POST["emailR"])&&
        isset($_POST["usuarioR"])&&isset($_POST["contraseñaR"])&&isset($_POST["confirmarContraseñaR"])) {
            $nombre = sinEspaciosLados($_POST["nombreR"]);
            $correo = sinEspaciosLados($_POST["emailR"]);
            $usuario = sinEspaciosLados($_POST["usuarioR"]);
            $clave = sinEspaciosLados($_POST["contraseñaR"]);
            $claveConfirmar = sinEspaciosLados($_POST["confirmarContraseñaR"]);
            if (validaRegistro($nombre,$correo,$usuario,$clave,$claveConfirmar)){ 
            $resultadoExistente=validaUsuarioExistente($usuarioModelo,$usuario,$correo);
                if (!$resultadoExistente) {
                    $usuarioModelo->datosRegistro($nombre,$correo,$usuario,$clave);
                    $resultado = registrarUsuario($usuarioModelo);
                    if ($resultado) {
                        traerDatosUsuario($usuarioModelo);
                        //cerrarSesion();
                        iniciarSesion($usuarioModelo->getId(),$usuarioModelo->getUsuario());
                        echo  $_SESSION["idUsuario"];
                        echo  $_SESSION["usuario"];
                        $mensaje = muestraMensaje("¡se registro correctamente!");
                        $vistaLeft= muestraLogin();
                        # code... se creo correctamente
                    }else{
                    $mensaje = muestraMensaje("¡Ha ocurrido un error al registrar!");
                    $vistaLeft= muestraRegistro(); 
                    }   
                }else{
                $mensaje = muestraMensaje($resultadoExistente[1]);
                $vistaLeft= muestraRegistro();
                }
            }else{   
            $mensaje = muestraMensaje("datos invalidos");
            $vistaLeft= muestraRegistro();
            }
        }   
        $dataBase->desconectar(); 
    }
}
function muestraMensaje($message){
    $vista='<div class="contenedor-cosas">
                <h4>'.$message.'</h4>
            </div>';
    return $vista;
}
function muestraLogin(){
    $vista='<div class="contenedor-cosas">
                <div class="contenedor-cosas-arriba">
                    <div class="contenedor-cosas-imagen-login"></div>
                </div>
                <div class="contenedor-cosas-abajo">
                    <form method="" class="formulario-login" action="post">
                        <input type="text" id="usuarioL" name="usuarioL" placeholder="Usuario" required>
                        <input type="password" id="contraseñaL" name="contraseñaL" placeholder="Contraseña" required>
                        <input type="submit" value="" class="boton-login" name="botonLogin" name="formularioLogin">
                        <div id="mensajeErrorLogin" class="mensaje-error" value="" style="display: none;"></div>
                    </form>
                </div>
            </div>
            <div class="contenedor-cosas">
                <form class="formulario-nav-registro" action=" " method="post">
                    <input type="submit" value="" class="boton-nav-registrar" name="botonNavRegistrar">
                </form>
            </div>';
return $vista;
}
// function muestraRegistro(){
//     $vista='<div class="contenedor-cosas">
//                 <div class="contenedor-cosas-arriba">
//                     <div class="contenedor-cosas-imagen-registro"></div>
//                 </div>
//                 <div class="contenedor-cosas-abajo">
//                     <form class="formulario-registro" action=" " method="post">
//                         <input type="text" id="nombreR" name="nombreR" placeholder="Nombre" required>
//                         <input type="email" id="emailR" name="emailR" placeholder="Email" required>
//                         <input type="text" id="usuarioR" name="usuarioR" placeholder="Usuario" required>
//                         <input type="password" id="contraseñaR" name="contraseñaR" placeholder="Contraseña" required>
//                         <input type="password" id="confirmarContraseñaR" name="confirmarContraseñaR"
//                             placeholder="ConfirmarContraseña" required>
//                         <input type="submit" value="" class="boton-registrar" name="formularioRegistro">
//                         <div id="mensajeErrorRegistro" class="mensaje-error" value="" style="display: none;"></div>
//                     </form>
//                 </div>
//             </div>';
// return $vista;
// }
function muestraRegistro(){
    $vista='<div class="contenedor-cosas">
                <div class="contenedor-cosas-arriba">
                    <div class="contenedor-cosas-imagen-registro"></div>
                </div>
                <div class="contenedor-cosas-abajo">
                    <form class="formulario-registro" action=" " method="post">
                        <input type="text" id="nombreR" name="nombreR" placeholder="Nombre" >
                        <input type="email" id="emailR" name="emailR" placeholder="Email" >
                        <input type="text" id="usuarioR" name="usuarioR" placeholder="Usuario" >
                        <input type="password" id="contraseñaR" name="contraseñaR" placeholder="Contraseña" >
                        <input type="password" id="confirmarContraseñaR" name="confirmarContraseñaR"
                            placeholder="ConfirmarContraseña" >
                        <input type="submit" value="" class="boton-registrar" name="formularioRegistro">
                        <div id="mensajeErrorRegistro" class="mensaje-error" value="" style="display: none;"></div>
                    </form>
                </div>
            </div>';
return $vista;
}
function muestraLogeado(){
       $vista='<div class="contenedor-cosas">
                <div class="contenedor-cosas-arriba">
                    <div class="contenedor-cosas-imagen-bienvenida"></div>
                </div>
                <div class="contenedor-cosas-abajo">
                    <h2>Bienvenido,'.$_SESSION['usuario'].'</h2>
                    <form class="formulario-nav-out" action=" " method="post">
                        <input type="submit" value="" class="boton-registrar" name="botonNavOut">
                    </form>
                </div>
            </div>';
return $vista;
}

function validaRegistro(string $nombre,string $correo,string $usuario,string $clave,string $claveConfirmar,){
    if (nombreValida($nombre) && emailValida($correo) && usuarioValida($usuario) 
    && claveValida($clave) && claveConfirmacionValida($clave, $claveConfirmar)) {
        return true;
    } else {
        return false;
    } 
}

function validaUsuarioExistente(Usuario $modelo, string $usuario, string $correo){  
    $dato = $modelo->getByUsuAndEmail($usuario,$correo);
    if (!empty($dato)) {
        foreach ($dato as $key) {
            if($key['nomUsuario'] == $usuario){
                return [true,'usuario: "'.$usuario.'" existente'];
            }else if($key['correo'] == $correo){
                return [true,'correo: "'.$correo.'" existente'];
            }else{
                return false; 
            }
        }
    } 
}

function registrarUsuario(Usuario $modelo){
    $dato=[
        'nomUsuario' => $modelo->getUsuario(),
        'nombre' => $modelo->getNombre(),
        'correo' => $modelo->getCorreo(),
        'clave' => $modelo->getClaveEncript(),
        'sal' => $modelo->getSal()
    ];
    $resultado = $modelo->insert($dato);
    if (!empty($resultado)) {
        return true;
    } else {
        return false;
    }  
}

function traerDatosUsuario(Usuario $modelo){
    $dato= $modelo->getByUsu($modelo->getUsuario());
    if (!empty($dato)) {
        $modelo->datosUsuarioDB(
            $dato['idUsuario'],
            $dato['nomUsuario'],
            $dato['token'],
            $dato['nombre'],
            $dato['foto'],
            $dato['descripcion'],
            $dato['fechaCreacion'],
            $dato['activo'],
            $dato['correo'],
            $dato['clave'],
            $dato['sal'],
            $dato['rol']
        ); 
    } 
}