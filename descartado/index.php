
<?php
// Incluir el archivo que contiene la clase Router
require_once 'router/Router.class.php';
$carpetaPrincipal = "/paginaSims/";
// Obtener la ruta actual
$url = $_SERVER['REQUEST_URI'];
$urlPartes = explode('/', $url);

// Eliminar elementos vacíos del array generado
$urlPartes = array_filter($urlPartes);
// Obtener la última parte de la URL como la ruta actual
$rutaActual = end($urlPartes);

// Definir las rutas y sus controladores o contenido asociado
$rutas = array(
    "index" => [
        "view" => "/paginaSims/views/index.html",
        "content" => '<p>Puedes ir a diarios <a href="views/diario.html">diario</a>.</p>'
    ],
    "diario" => [
        "view" => "/paginaSims/views/diario.html",
        "content" => "controllers/diarioControlador.php"
    ],
    // Agrega más rutas según sea necesario
);

// Verificar si la ruta actual existe en el arreglo de rutas
if (array_key_exists($rutaActual, $rutas)) {
    $ruta = $rutas[$rutaActual];
    $cuerpo = new Router($ruta['view'], $ruta['content']);

    // Si hay un controlador asociado, incluirlo
    // if (isset($ruta['controller'])) {
    //     include $ruta['controller'];
    // }

    // buffer
    $view = new Router("/paginaSims/views/app.html", [
        "titulo" => 'Pagina Fans Sims',
        "css" => '<link rel="stylesheet" href="public/CSS/styles.css">',
        "script" => '<script src="public/JS/script.js"></script>
                    <script src="public/JS/validations/validaciones.js"></script>',
        "child" => $cuerpo
    ]);

    echo $view;
} else {
    // Manejar la página no encontrada
    echo "404 Not Found ".$url;
}



// // Incluir el archivo que contiene la clase Router
// require_once 'router/Router.class.php';
// // Crear una instancia del Router
// $carpetaPrincipal = "/paginaSims";
// $url = $_SERVER['REQUEST_URI'];
// $urlPartes = explode($carpetaPrincipal.'/',$url);
// array_shift($urlPartes);


// $cuerpo = new Router("views/index.html",[
//    "rutaDiarios" => '<p>puedes ir a diarios <a href="views/diario.html">diario</a>.</p>'
// ]);
// // $cuerpo = new Router("views/diario.html",[
// //     "indexControlador" => 'controllers/indexControlador.php'
// // ]);

// // buffer 
// $view = new Router("views/app.html",[
//     "titulo" => 'Pagina Fans Sims',
//     "css" => '<link rel="stylesheet" href= "public/CSS/styles.css">',
//     "script" => '<script src="public/JS/script.js"></script>
//                 <script src="public/JS/validations/validaciones.js"></script>',
//     "child" => $cuerpo
// ]);
// echo $view;



// // Definir un arreglo de rutas
// $routes = array(
//     '/' => 'homeController',
//     '/about' => 'aboutController',
//     '/contact' => 'contactController',
// );

// // Obtener la ruta actual
// $currentRoute = $_SERVER['REQUEST_URI'];

// // Verificar si la ruta existe en el arreglo de rutas
// if (array_key_exists($currentRoute, $routes)) {
//     // Obtener el nombre del controlador asociado a la ruta
//     $controller = $routes[$currentRoute];

//     // Incluir el archivo del controlador
//     include $controller . '.php';

//     // Llamar a la función principal del controlador
//     call_user_func($controller);
// } else {
//     // Manejar la página no encontrada
//     echo "404 Not Found";
// }
