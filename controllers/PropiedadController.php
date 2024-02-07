<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;


class PropiedadController
{
    public static function index(Router $router)
    {

        // Traemos las propiedades de la DB.
        $propiedades = Propiedad::all();

        // Muestra mensaje condicional.
        $resultado = $_GET['resultado'] ?? null;

        $router->render('/propiedades/admin', [
            "propiedades" => $propiedades, // Mostramos las propiedades obtenidas.
            "resultado" => $resultado,
        ]);
    }

    public static function crear(Router $router)
    {

        // Instanciamos vacia propieda. 
        $propiedad = new Propiedad;

        // Obtenemos los vendedores.
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores.
        $errores = Propiedad::getErrores();

        // Ejecutar el código después de que el usuario envie el formulario.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** Crea una nueva instacia **/
            $propiedad = new Propiedad($_POST['propiedad']);

            /** Subida de archivos **/

            // Generar un nombre unico para las imagenes. 
            $nombreImg = md5(uniqid(rand(), true))  . '.jpg';

            // Setear la imagen.
            // Realiza el size de la imagen con Intervention.
            if ($_FILES['propiedad']['tmp_name']['imagen']) { // Verificamos que haiga una imagen.
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImg); // Asiganamos la iamgen si no hay o elimina la anterior y asigna la nueva.
            }

            // Validar.
            $errores = $propiedad->validar();

            // Revisar que el arreglo de errores este vacio.
            if (empty($errores)) {

                // Crear la carpeta para subir imagenes.
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guardar la imagen en el servidor.
                $image->save(CARPETA_IMAGENES . $nombreImg);

                // Guardamos en la base de datos.
                $propiedad->guardar();
            };
        }


        $router->render('/propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores,
        ]);
    }

    public static function actualizar(Router $router) {
        
        $id = validarORedireccionar('/admin'); // Pasamos la URL a donde redireccionará en el caso del que el ID no sea válido.

        $propiedad = Propiedad::find($id); // Obtenemos la propiedad a actualizar por su ID.

        $vendedores = Vendedor::all(); // Obtenemos todos los vendedores.

        // Arreglo con mensajes de errores.
        $errores = Propiedad::getErrores();

          // Ejecuta el código después de que el usuario envie el formulario.
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos actualizados.
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            // Validación
            $errores = $propiedad->validar();

            /** Subida de archivos **/

            // Generar un nombre unico para las imagenes. 
            $nombreImg = md5(uniqid(rand(), true))  . '.jpg';

            // Setear la imagen.
            // Realiza el size de la imagen con Intervention.
            if($_FILES['propiedad']['tmp_name']['imagen']) { // Verificamos que haiga una imagen.
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImg);
            }

            // Revisar que el arreglo de errores este vacio.
            if(empty($errores)) {
                
                if($_FILES['propiedad']['tmp_name']['imagen']) {
                    // Almacenar la imagen.
                    $image->save(CARPETA_IMAGENES . $nombreImg);
                }

                $propiedad->guardar();
            };   
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' =>$vendedores,
        ]);
    }
}
