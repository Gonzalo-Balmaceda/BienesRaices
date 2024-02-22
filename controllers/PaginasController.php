<?php

namespace Controllers;

use Model\Propiedad;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {

        // Nos traemos solo 3 propiedades para mostrar en la página principal.
        $propiedades = Propiedad::get(3);

        // Esta variable al ser 'true' agregará la clase 'inicio en el layout y asi se podra ver todo el inicio de la página
        $inicio = true; 
        
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio,
        ]);
    }

    public static function nosotros(Router $router) {
        
        $router->render('paginas/nosotros', []);
    }

    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();
        
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar('/propiedades'); // Validamos el ID.
        $propiedad = Propiedad::find($id); // Buscamos la propiedad por su ID.
        
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad,
        ]);
    }

    public static function blog(Router $router) {
        
        $router->render('paginas/blog', []);
    }

    public static function entrada(Router $router) {
        
        $router->render('paginas/entrada', []);
    }
    
    public static function contacto(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto']; // Guardo el arreglo contacto y asi obtener el contenido de todos los campos del formulario.
            
            // Creo una instancia de PHPMailer.
            $mail = new PHPMailer();

            // Configuar SMTP.
            $mail->isSMTP(); // Decimos que usaremos SMTP para el envio de correos.
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // Coloco el puerto que me da mailtrap.
            $mail->SMTPAuth = true; // Decimos si necesitaremos autenticarnos.
            $mail->Username = 'b6fcd1a4e69cb5';
            $mail->Password = '674b65a18dd68b';
            $mail->SMTPSecure = 'tls'; // Hacemos que los mails se transporten seguramente. (Evitamos que un mail sea interseptado)
            $mail->Port = 2525;

            // Configurar el contenido del mail.
            $mail->setFrom('admin@bienesraices.com'); // Quien envia el mail.
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); // Dirección donde se reciben los mails.
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // Habilitar HTML.
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Contenido.
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';
            $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
            $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . ' </p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p>Comprar o Vender: ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p>Precio o presupuesto: ' . $respuestas['precio'] . ' </p>';
            $contenido .= '<p>Como prefiere que lo contacten: ' . $respuestas['contacto'] . ' </p>';
            $contenido .= '<p>Fecha: ' . $respuestas['fecha'] . ' </p>';
            $contenido .= '<p>Hora: ' . $respuestas['hora'] . ' </p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Texto alternativo sin HTML';

            // Enviar el mail.
            if($mail->send()) {
                echo "Mensaje enviado correctamente";
            } else {
                echo "El mensaje no se pudo enviar";
            }

        }
        
        $router->render('paginas/contacto', []);
    }
}