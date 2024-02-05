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