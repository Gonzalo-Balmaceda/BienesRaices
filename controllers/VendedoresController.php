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

    public static function actualizar(Router $router) {

        // Obtenemos los errores.
        $errores = Vendedor::getErrores();

        // Validamos el ID.
        $id = validarORedireccionar('/admin');

        // Buscamos al vendedor por el ID.
        $vendedor = Vendedor::find($id);

        // Envio del formualario para actualizar un vendedor.
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los valores nuevos.
            $args = $_POST['vendedor'];

            // Sincroniza el objeto en memoria con los nuevos cambios.
            $vendedor->sincronizar($args);

            // Validamos para que no haiga errores.
            $errores = $vendedor->validar();

            if(empty($errores)) {
                $vendedor->guardar(); // Guardamos los datos actualizados
            }
        }

        $router->render('vendedores/actualizar', [
            "errores" => $errores,
            "vendedor" => $vendedor,
        ]);
    }

    public static function eliminar() {
        echo "Eliminando vendedor";
    }
 }