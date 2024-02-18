<?php
  session_start();
function sesionActiva(){
  
    if (isset($_SESSION["idUsuario"]) && isset($_SESSION["usuario"]) && isset($_COOKIE['recuerdaTokenUsuario'])&&isset($_COOKIE['nombre'])) {
        //iniciarSesion($_COOKIE['idUsuario'],$_COOKIE['usuario'],$_COOKIE['nombre'],$_COOKIE['recuerdaTokenUsuario'],$_COOKIE['rolUsuario']);
        return true;
    }else {
        return false;
    }
}

function iniciarSesion(int $id,string $usuario,string $nombre,string $token,string $rol) {
    $_SESSION["idUsuario"] = $id;
    $_SESSION["usuario"] = $usuario;
    $_SESSION["nombre"] = $nombre;
    $_SESSION["token"] = $token;
    $_SESSION["rolUsuario"] = $rol;
}

function cerrarSesion() {
    // Eliminar todas las variables de sesión
    // session_unset();
    // Destruir la sesión
    session_destroy();
    // Destruir la cookie
    setcookie('recuerdaTokenUsuario', '', time() - 3600, '/', '', true, true);
    setcookie('nombre', '', time() - 3600, '/', '', true, true);
    setcookie('idUsuario', '', time() - 3600, '/', '', true, true);
    setcookie('rolUsuario', '', time() - 3600, '/', '', true, true);
    setcookie('usuario', '', time() - 3600, '/', '', true, true);
}

function crearCookie($nombre,$id,$rol) {
    $token = bin2hex(random_bytes(32)); // Generar un token aleatorio
    setcookie('recuerdaTokenUsuario', $token, time() + (86400 * 30), '/', '', true, true); // Caduca en 30 días, seguro y accesible solo por HTTPS
    setcookie('nombre', $nombre, time() + (86400 * 30), '/', '', true, true);
    setcookie('idUsuario', $id, time() + (86400 * 30), '/', '', true, true);
    setcookie('rolUsuario', $rol, time() + (86400 * 30), '/', '', true, true);
    setcookie('usuario', $rol, time() + (86400 * 30), '/', '', true, true);
    return $token;
}

// function verificarCookie() {
//     if (isset($_COOKIE['recuerdaUsuario'])) {
//         $token = $_COOKIE['recuerdaUsuario'];

//         if (!isset($_SESSION["token"])) {
//             $_SESSION["idUsuario"] = $usuarioId;
//         }
//     }

//     return false;
// }