<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '232002', 'bienesraices_crud');

    if(!$db) {
        echo "Error no se pudo contectar";
        exit;
    }

    return $db;
}