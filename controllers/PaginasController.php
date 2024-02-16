<?php

namespace Controllers;

use Model\Propiedad;
use MVC\Router;

class PaginasController {
    public static function index(Router $router) {

        // Nos traemos solo 3 propiedades para mostrar en la página principal.
        $propiedades = Propiedad::get(3);

        // Esta variable al ser 'true' agregará la clase 'inicio en el layout y asi se podra ver todo el inicio de la página
        $inicio = true; 
        
        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
        ]);
    }

    public static function nosotros(Router $router) {
        
        $router->render('/paginas/nosotros', []);
    }

    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();
        
        $router->render('/paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar('/propiedades'); // Validamos el ID.
        $propiedad = Propiedad::find($id); // Buscamos la propiedad por su ID.
        
        $router->render('/paginas/propiedad', [
            'propiedad' => $propiedad,
        ]);
    }

    public static function blog(Router $router) {
        
        $router->render('/paginas/blog', []);
    }

    public static function entrada() {
        echo "Desde entrada";
    }
    
    public static function contacto() {
        echo "Desde contacto";
    }
}