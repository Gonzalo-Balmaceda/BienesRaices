<?php
 
namespace Controllers;

use Model\Vendedor;
use MVC\Router;

 class VendedoresController {
    public static function crear(Router $router) {
        
        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();

        // Envio del formulario para crear un nuevo vendedor.
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Crea una nueva instancia.
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validamos que no haya campos vacios.
            $errores = $vendedor->validar();

            // Guardamos si no hay errores en los campos.
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

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