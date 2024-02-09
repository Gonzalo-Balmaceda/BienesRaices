<?php
 
namespace Controllers;

use Model\Vendedor;
use MVC\Router;

 class VendedoresController {
    public static function crear(Router $router) {
        
        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores,
        ]);
    }

    public static function actualizar() {
        echo "Actualizando vendedor";
    }

    public static function eliminar() {
        echo "Eliminando vendedor";
    }
 }