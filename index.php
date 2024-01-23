<?php
// Incluir el archivo que contiene la clase Router
require_once 'router/Router.class.php';
// Crear una instancia del Router
$carpetaPrincipal = "/paginaSims";
$url = $_SERVER['REQUEST_URI'];
$urlPartes = explode($carpetaPrincipal.'/',$url);
array_shift($urlPartes);

$cuerpo = new Router("views/index.html",[
    "indexControlador" => 'controllers/indexControlador.php'
]);

// buffer 
$view = new Router("views/app.html",[
    "titulo" => 'Pagina Fans Sims',
    "css" => '<link rel="stylesheet" href= "public/CSS/styles.css">',
    "script" => '<script src="public/JS/script.js"></script>
                <script src="public/JS/validations/validaciones.js"></script>',
    "child" => $cuerpo
]);
echo $view;
