<?php

// router.php


class Router
{
    private string $contenido;

    public function __construct(string $ruta, $dato = [])
    {
        extract($dato);
        ob_start();

        if (file_exists($ruta)) {
            include($ruta);
        } else {
            echo "Error: La ruta $ruta no existe.";
        }

        $this->contenido = ob_get_clean();
    }

    public function __toString()
    {
        return $this->contenido;
    }
}

// class Router
// {
//     private string $contenido;

//     public function __construct(string $ruta, $dato = []){
//         extract($dato);
//         ob_start();
//         include($ruta);
//         $this->contenido = ob_get_clean();
//     }

//     public function __toString(){
//         return $this->contenido;
//     }
// }



















// class Router {
//     private $ruta = [];

//     // Método para agregar una nueva ruta
//     public function agregaRuta($path, $callback) {
//         $this->ruta[$path] = $callback;
//     }

//     // Método para manejar la solicitud y llamar al controlador correspondiente
//     public function manejoRuta($path) {
//         if (array_key_exists($path, $this->ruta)) {
//             $callback = $this->ruta[$path];
//             // Puedes implementar la lógica necesaria aquí, como la creación de instancias de clases y llamadas a métodos.
//             // En este ejemplo, asumimos que $callback es una función, pero podría ser un controlador de clase, etc.
//             call_user_func($callback);
//         } else {
//             // Página no encontrada
//             echo "404 Not Found".$path;
//         }
//     }
// }

