<?php

// function tituloValido(string $titulo){

//     // Verifica si el nombre tiene una longitud adecuada
//     if (strlen($titulo) < 3) {
//         return false;
//     }else if (strpos($titulo, '=') !== false) {
//         return false; // Verifica si el nombre contiene el signo "="
//     }else if (!preg_match('/^[a-zA-Z0-9_!@#$%^&*()-]+$/', $titulo)) {
//         return false;  // Verifica si el nombre contiene solo caracteres alfanuméricos y especiales permitidos
//     }else{
//         return true;
//     } 
// }

function textoValido(string $titulo){
    // Verifica si el nombre está vacío
    if (empty($titulo)) {
        return true;
    } 
    if (strpos($titulo, '=') !== false) {
        return false; // Verifica si el nombre contiene el signo "="
    }
    if (!preg_match('/^[a-zA-ZÀ-ÿ0-9_!@#$%^&*()<>\s¿?"¡,.:]+$/', $titulo)) {
        return false;  // Verifica si el nombre contiene solo caracteres alfanuméricos y especiales permitidos
    } 
    return true;
}
function tituloValido(string $titulo){
    if (strpos($titulo, '=') !== false) {
        return false; // Verifica si el nombre contiene el signo "="
    }
    if (!preg_match('/^[a-zA-ZÀ-ÿ0-9_!@#$%^&*()<>\s¿?"¡,.:]+$/', $titulo)) {
        return false;  // Verifica si el nombre contiene solo caracteres alfanuméricos y especiales permitidos
    } 
    return true;
}

function nombreValida(string $nombre):bool
{
     // Verifica si el nombre está vacío
    if (empty($nombre)) {
        return false;
    } 
    // Elimina los espacios en blanco
    $nombreSinEspacio = str_replace(' ', '', $nombre);

    // Verifica si el nombre tiene una longitud adecuada
    if (strlen($nombreSinEspacio) < 3 || strlen($nombreSinEspacio) > 50) {
        return false;
    }else if (strpos($nombreSinEspacio, '=') !== false) {
        return false; // Verifica si el nombre contiene el signo "="
    }else if (!preg_match('/^[a-zA-ZÀ-ÿ0-9_!@#$%^&*()-]+$/', $nombreSinEspacio)) {
        return false;  // Verifica si el nombre contiene solo caracteres alfanuméricos y especiales permitidos
    }else if ($nombre !== $nombreSinEspacio) {
        return false;
    }else{
        return true;
    } 
}
function usuarioValida(string $usuario):bool
{
    if (empty($usuario)) {
        return false;
    }else if(strlen($usuario) < 3 || strlen($usuario) > 50){
        return false;
    }else if(!ctype_alnum($usuario)){
        return false; // Manejar error de usuario no alfanumérico ej:!, @, #, $, %, &, etc.,
    }else{
        return true;
    }
}

function emailValida(string $email):bool
{
    if (empty($email)) {
        return false;
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }else{
        return true;
    }
}
function claveValida(string $contrasena):bool
{
    if (strlen($contrasena) < 8 || strlen($contrasena) > 20) {
        return false; //'La contraseña debe tener entre 8 y 20 caracteres.';
    }else if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,20}$/', $contrasena)) {
        return false;// 'La contraseña debe incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.';
    }else{
        return true;
    }
}
function claveConfirmacionValida(string $contrasena,string $confirmacionContrasena):bool
{
    if ($contrasena !== $confirmacionContrasena) {
        return false;// 'Las contraseñas no coinciden.';
    }else{
        return true;
    }
}
function numeroValida($numero):bool
{
    if (!ctype_digit($numero)) {
        return false;// 'no numerico.';
    }else{
        return true;
    }
}

function imagenValida($imagen = null): bool {
    // Verifica si no se proporcionó ninguna imagen
    if ($imagen === null) {
        return true; // Si no se proporcionó ninguna imagen, se considera válida
    }
    // Verifica si hay errores en la carga de la imagen
    if (!isset($imagen['error']) || $imagen['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    // Verificación del tipo de archivo
    $tipo_permitido = ['image/jpeg', 'image/jpg', 'image/png'];
    $tipo_archivo = $imagen['type'];
    if (!in_array($tipo_archivo, $tipo_permitido)) {
        return false;
    }
    // Verificación del tamaño del archivo
    $tamano_maximo = 2 * 1024 * 1024; // 2 MB
    $tamano_archivo = $imagen['size'];
    if ($tamano_archivo > $tamano_maximo) {
        return false;
    }
    // Si pasa todas las verificaciones, la imagen es válida
    return true;
}


// function imagenValida($imagen):bool
// {
//     // Verificar si se proporcionó información sobre la imagen
//     if (isset($imagen['error']) && $imagen['error'] === UPLOAD_ERR_OK) {
//         // Validar el tipo de archivo (imagen)
//         $tipo_permitido = ['image/jpeg', 'image/jpg','image/png'];
//         $tipo_archivo = $imagen['type'];
//         if (in_array($tipo_archivo, $tipo_permitido)) {//"Error: Solo se permiten imágenes JPEG, PNG o GIF."
//             // Validar tamaño máximo del archivo (ejemplo: 2MB)
//             $tamano_maximo = 2 * 1024 * 1024; // 2 MB
//             $tamano_archivo = $imagen['size'];
//             if ($tamano_archivo < $tamano_maximo) {
//                 return true;
//             }else {
//                 return false;
//             }
//         }else {
//             return false;
//         }
//     }else {
//         return false;
//     }  
// }

function categoriaValida($categoria){
    if(isset($categoria) && !empty($categoria)) {
       return true;
    } else {
       return false;
    }
}
function checkValida($check){
    if ($check == 'on') {
        return 1;
    } else {
        return 0;
    }
}
///////////////// otros /////////////////
function sinEspaciosLados(string $cadena):string
{
    return trim($cadena);
}

function limpiarTexto(string $texto):string
{
    // Eliminar etiquetas HTML
    $texto_sin_tags = strip_tags($texto);
    // Escapar caracteres especiales para evitar XSS
    $texto_escapado = htmlspecialchars($texto_sin_tags, ENT_QUOTES, 'UTF-8');
    return $texto_escapado; //Limpia y filtra los datos de entrada para prevenir ataques de script entre sitios.
}

// function codificaImagen($imagen){
//     return addslashes(file_get_contents($imagen['tmp_name']));
// }

function codificaImagen($imagen){
    return base64_encode(file_get_contents($imagen['tmp_name']));
}

function generaSal(){
    return password_hash(random_bytes(16), PASSWORD_DEFAULT);
}
function encriptaClave($clave,$sal){
    return password_hash($clave . $sal, PASSWORD_DEFAULT);
}
function soloFecha($fecha){
    return date('d-m-Y', strtotime($fecha));
}
// function dedificaImagen($imagen){
//     // Convertir datos binarios a cadena base64 para almacenar en la base de datos
//     return base64_decode($imagen);
// }
