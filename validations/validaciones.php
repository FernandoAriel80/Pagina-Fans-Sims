<?php

function nombreValida(string $nombre):bool
{
    if (empty($nombre)) {
        return false;
    }else if(strlen($nombre) < 3 || strlen($nombre) > 50){
        return false;
    }else if(!ctype_alnum($nombre)){
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

function imagenValida($imagen):bool
{
    // Verificar si se proporcionó información sobre la imagen
    if (!empty($imagen) && isset($imagen['error']) && $imagen['error'] === UPLOAD_ERR_OK) {
        // Validar el tipo de archivo (imagen)
        $tipo_permitido = ['image/jpeg', 'image/jpg','image/png'];
        $tipo_archivo = $imagen['type'];
        if (in_array($tipo_archivo, $tipo_permitido)) {
            // Validar tamaño máximo del archivo (ejemplo: 2MB)
            $tamano_maximo = 2 * 1024 * 1024; // 2 MB
            $tamano_archivo = $imagen['size'];
            if ($tamano_archivo < $tamano_maximo) {
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }else {
        return false;
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

function codificaImagen($imagen){
    // Convertir datos binarios a cadena base64 para almacenar en la base de datos
    return base64_encode(file_get_contents($imagen['tmp_name']));
}

function dedificaImagen($imagen){
    // Convertir datos binarios a cadena base64 para almacenar en la base de datos
    return base64_decode($imagen);
}