<?php

function sesionActiva(){
    if (isset($_SESSION["idUsuario"]) && isset($_SESSION["usuario"]) && isset($_COOKIE['recuerdaUsuario'])) {
        return true;
    }else {
        return false;
    }
}

function iniciarSesion(int $id,string $usuario,string $token) {
    $_SESSION["idUsuario"] = $id;
    $_SESSION["usuario"] = $usuario;
    $_SESSION["token"] = $token;
}

function cerrarSesion() {
    // Eliminar todas las variables de sesión
    // session_unset();
    // Destruir la sesión
    session_destroy();
    // Destruir la cookie
    setcookie('recuerdaUsuario', '', time() - 3600, '/', '', true, true);
}

function crearCookie() {
    $token = bin2hex(random_bytes(32)); // Generar un token aleatorio
    setcookie('recuerdaTokenUsuario', $token, time() + (86400 * 30), '/', '', true, true); // Caduca en 30 días, seguro y accesible solo por HTTPS

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