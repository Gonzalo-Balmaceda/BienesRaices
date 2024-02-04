<?php

namespace MVC;

class Router {

    // Donde se almacenaran los rutas según su método.
    public $rutasGet = [];
    public $rutasPost = [];


    // Método que reaccionaran a un método GET.
    public function get($url, $fn) { // Toma la URL que se este visitando y la función asociada a esa URL.
        $this->rutasGet[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPost[$url] = $fn;
    }

    public function comprobarRutas() {

        $urlActual = $_SERVER['PATH_INFO'] ?? '/'; // Obtiene toda la URL en la que nos encontramos
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if($metodo === 'GET') {
            $fn = $this->rutasGet[$urlActual] ?? null; // Asigna la función de la URL actual.
        } else {
            $fn = $this->rutasPost[$urlActual] ?? null;
        }

        if($fn) {
            // La URL existe y hay una función asociada.

            // Nos va ayudar a llamar una función cuando no sabemos como se llama esa función.
            call_user_func($fn, $this); // 1ro = Función de la ruta actual, 2do = Pasamos todas las rutas.
        } else {
            echo 'Página no encontrada';
        }
    }

    // Función que mostrará el contenido de la URL que se esté visitando.
    public function render($view, $datos = []) { // Los datos serán pasados como un arreglo.

        foreach($datos as $key => $value) {
            $$key = $value;
        }

        ob_start(); // Hará que comienze a almacenar en memoria lo siguiente.

        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Obtenemos el contenido guardado en el buffer (memoria) y luego limpiamos.
        include __DIR__ . "/views/layout.php"; // Definimos la master page que es donde se mostrará el contenido.
    }
}