<?php
    require_once __DIR__ . '/../includes/app.php'; // Llamamos a los modelos creados.

    use MVC\Router; // Usamos el router creado.
    use Controllers\PropiedadController;
    use Controllers\VendedoresController;
    use Controllers\PaginasController;

    $router = new Router();

    // ZONA PRIVADA.
    // Funciones y URL para las propiedades
    $router->get('/admin', [PropiedadController::class, 'index']); // Pasamos la ubicación en donde están las funciones y después pasamos la función para la ruta.
    $router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
    $router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
    $router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

    // Funciones y URL para los vendedores.
    $router->get('/vendedores/crear', [VendedoresController::class, 'crear']);
    $router->post('/vendedores/crear', [VendedoresController::class, 'crear']);
    $router->get('/vendedores/actualizar', [VendedoresController::class, 'actualizar']);
    $router->post('/vendedores/actualizar', [VendedoresController::class, 'actualizar']);
    $router->post('/vendedores/eliminar', [VendedoresController::class, 'eliminar']);

    // ZONA PÚBLICA
    // Funciones y URL para las paginas sin autenticación.
    $router->get('/', [PaginasController::class, 'index']);
    $router->get('/nosotros', [PaginasController::class, 'nosotros']);
    $router->get('/propiedades', [PaginasController::class, 'propiedades']);
    $router->get('/propiedad', [PaginasController::class, 'propiedad']);
    $router->get('/blog', [PaginasController::class, 'blog']);
    $router->get('/entrada', [PaginasController::class, 'entrada']);
    $router->get('/contacto', [PaginasController::class, 'contacto']); 
    $router->post('/contacto', [PaginasController::class, 'contacto']);

    // Verifica que existe la URL ingresada y que tenga una función asociada, caso contratario muestra un error.
    $router->comprobarRutas();
    
