<?php
    require_once __DIR__ . '/../includes/app.php'; // Llamamos a los modelos creados.

    use MVC\Router; // Usamos el router creado.
    use Controllers\PropiedadController;

    $router = new Router();

    // Vamos asociando las funciones que se ejecutaran en las distintas URL.
    $router->get('/admin', [PropiedadController::class, 'index']); // Pasamos la ubicación en donde están las funciones y después pasamos la función para la ruta.
    $router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);

    // Verifica que existe la URL ingresada y que tenga una función asociada, caso contratario muestra un error.
    $router->comprobarRutas();
    
