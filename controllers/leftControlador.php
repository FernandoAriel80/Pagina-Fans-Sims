<?php

require_once 'models/Usuario.php';
require_once 'config/DataBase.php';
require_once 'validations/validaciones.php';
require_once 'validations/validaSesiones.php';

$dataBase = new DataBase();
$coneccion = $dataBase->conectar();
$vistaLeft = '';
$mensaje='';

if (!sesionActiva()) {
   $vistaLeft = muestraLogin();
}else{
    $vistaLeft = muestraLogeado();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    ////////////////////////// BOTON REGISTRAR ////////////////////
    if (isset($_POST["botonNavRegistrar"])) {
        $vistaLeft= muestraRegistro();
    }
    ////////////////////////// BOTON LOGOUT ////////////////////
    if (isset($_POST["botonNavOut"])) {
        cerrarSesion();
        // Redirigir al usuario a la página de inicio de sesión
        $vistaLeft = muestraLogin();
    }
    ////////////////////////// LOGIN ////////////////////
    if (isset($_POST["formularioLogin"])) {
        $usuarioModeloLogin = new Usuario($coneccion);
        if (isset($_POST["usuarioL"]) && isset($_POST["contraseñaL"])){
            $usuario = sinEspaciosLados($_POST["usuarioL"]);
            $clave = sinEspaciosLados($_POST["contraseñaL"]);
            if(validaLogin($usuario,$clave)){   
                $datoValidar = $usuarioModeloLogin->getByUsu($usuario);   
                if(validaLoginExistente($usuario,$clave,$datoValidar)){
                    $token = crearCookie($datoValidar['nombre'],$datoValidar['idUsuario'],$datoValidar['rol']);
                    iniciarSesion($datoValidar['idUsuario'],$datoValidar['nomUsuario'],$datoValidar['nombre'],$token,$datoValidar['rol']);
                    if(guardaToken($usuarioModeloLogin,$datoValidar['idUsuario'],$token)){
                        $datoGuardar = $usuarioModeloLogin->getById($datoValidar['idUsuario']);
                        traerDatosUsuario($usuarioModeloLogin,$datoGuardar);
                        $mensaje = muestraMensaje("¡Ha iniciado sesion correctamente!");
                        $vistaLeft = muestraLogeado(); 
                    }else{
                        $mensaje = muestraMensaje("¡Ha ocurrido un error al iniciar sesion!");
                        $vistaLeft = muestraLogin();
                    }
                }else{
                    $mensaje = muestraMensaje("¡Ha ocurrido un error, datos no coinciden!");
                    $vistaLeft = muestraLogin();
                }
            }else{
                $mensaje = muestraMensaje("¡Ha ocurrido un error!");
                $vistaLeft = muestraLogin();
            }
        }
        $dataBase->desconectar(); 
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ///////////////////////// REGISTRO ////////////////////
   if(isset($_POST["formularioRegistro"])){
        $usuarioModeloRegistro = new Usuario($coneccion);
        if (isset($_POST["nombreR"])&&isset($_POST["emailR"])&&
        isset($_POST["usuarioR"])&&isset($_POST["contraseñaR"])&&isset($_POST["confirmarContraseñaR"])) {
            $nombre = sinEspaciosLados($_POST["nombreR"]);
            $correo = sinEspaciosLados($_POST["emailR"]);
            $usuario = sinEspaciosLados($_POST["usuarioR"]);
            $clave = sinEspaciosLados($_POST["contraseñaR"]);
            $claveConfirmar = sinEspaciosLados($_POST["confirmarContraseñaR"]);
            if (validaRegistro($nombre,$correo,$usuario,$clave,$claveConfirmar)){ 
                $resultadoExistente =validaRegistroExistente($usuarioModeloRegistro,$usuario,$nombre,$correo);
                if (!$resultadoExistente) {
                    $usuarioModeloRegistro->datosRegistro($nombre,$correo,$usuario,$clave);
                    $resultado = registrarUsuario($usuarioModeloRegistro);
                    if ($resultado) {
                        $datoGuardar= $usuarioModeloRegistro->getByUsu($usuarioModeloRegistro->getUsuario());
                        traerDatosUsuario($usuarioModeloRegistro,$datoGuardar);
                        $mensaje = muestraMensaje("¡Se registro correctamente!");
                        $vistaLeft = muestraLogin();
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
                $mensaje = muestraMensaje("¡Datos invalidos!");
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
                    <form class="formulario-login" action=" " method="post">
                        <input type="text" id="usuarioL" name="usuarioL" placeholder="Usuario" required>
                        <input type="password" id="contraseñaL" name="contraseñaL" placeholder="Contraseña" required>
                        <input type="submit" value="" class="boton-login" name="formularioLogin">
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
function muestraRegistro(){
    $vista='<div class="contenedor-cosas">
                <div class="contenedor-cosas-arriba">
                    <div class="contenedor-cosas-imagen-registro"></div>
                </div>
                <div class="contenedor-cosas-abajo">
                    <form class="formulario-registro" action=" " method="post">
                        <input type="text" id="nombreR" name="nombreR" placeholder="Nombre" required>
                        <input type="email" id="emailR" name="emailR" placeholder="Email" required>
                        <input type="text" id="usuarioR" name="usuarioR" placeholder="Usuario" required>
                        <input type="password" id="contraseñaR" name="contraseñaR" placeholder="Contraseña" required>
                        <input type="password" id="confirmarContraseñaR" name="confirmarContraseñaR"
                            placeholder="ConfirmarContraseña" required>
                        <input type="submit" value="" class="boton-registrar" name="formularioRegistro">
                        <div id="mensajeErrorRegistro" class="mensaje-error" value="" style="display: none;"></div>
                    </form>
                </div>
            </div>';
return $vista;
}
function muestraLogeado(){
       $vista='<div class="contenedor-cosas">
                <div class="contenedor-cosas-abajo">
                    <div class = "Bienvenida-login">Bienvenido,'.$_SESSION['nombre'].' '.$_SESSION['rolUsuario'].'</div>  
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

function validaLogin(string $usuario,string $clave){
    if (usuarioValida($usuario) && claveValida($clave)) {
        return true;
    } else {
        return false;
    } 
}

function validaRegistroExistente(Usuario $modelo,string $usuario,string $nombre,string $correo){  
    $dato = $modelo->getByUsuAndEmail($usuario,$correo);
    if (!empty($dato)) {
        foreach ($dato as $key) {
            if($key['nomUsuario'] == $usuario){
                return [true,'¡usuario existente!'];
            }else if($key['correo'] == $correo){
                return [true,'¡correo existente!'];
            }else if($key['nombre'] == $nombre){
                return [true,'¡nombre existente!'];
            }else{
                return false; 
            }
        }
    }
}
function validaLoginExistente(string $usuario,string $clave,$dato){
    if (!empty($dato)) {
        $usuDB = $dato["nomUsuario"];
        $salDB = $dato["sal"];
        $clavDB = $dato["clave"];
        if ( $usuario == $usuDB && password_verify($clave.$salDB,$clavDB)){  
            return true;
        }else{
           return false; 
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

function guardaToken(Usuario $modelo,$id, string $token){
    $dato=[
        'token' => $token,
    ];
    $resultado = $modelo->upDateById($id,$dato);
    if (!empty($resultado)) {
        return true;
    } else {
        return false;
    }  
}
function traerDatosUsuario(Usuario $modelo,$dato){
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