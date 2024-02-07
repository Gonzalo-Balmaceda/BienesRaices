<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate( string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado() {
    session_start();

    if(!$_SESSION['login']) {
        return header('location: /');
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function sanitizar($html) : string {
    $sanitizado = htmlspecialchars($html);
    
    return $sanitizado;
}

function validarTipoContenido($tipo) {
    $tipos = ["propiedad", "vendedor"];

    return in_array($tipo, $tipos); // 1ro lo que vamos a buscar, 2do en donde lo vamos a buscar.
}

function mostrarMensaje($codigo) {
    $mensaje = "";

    switch($codigo) {
        case 1:
            $mensaje = "Creado Correctamente";
            break;
        case 2:
            $mensaje = "Actualizado Correctamente";
            break;
        case 3:
            $mensaje = "Eliminado Correctamente";
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

// Esta función hace que valide el id de una propiedad y si no es un id válido redirecciona.
function validarORedireccionar(string $url) {

        // Validamos el ID de la propiedad a actualizar.
        $id = $_GET['id']; // Tomamos el ID de la URL.
        $id = filter_var($id, FILTER_VALIDATE_INT);
    
        // Verificamos si hay un ID.
        if(!$id) {
            header("Location: $url"); // De no haberlo redireccionamos.
        }

        return $id;
}