<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN Y REGISTER
$routes->get('/', 'Home::iniciar2'); 
$routes->post('/inicioo', 'Home::login'); 
$routes->get('/logout', 'Home::logout');  
$routes->post('/register/store', 'RegisterController::store'); 

// RECUPERACION DE CONTRASEÑA
$routes->get('/forgotpassword', 'Home::forgotpassword'); 
$routes->post('/forgotpassword1', 'Home::forgotPPassword'); 
$routes->get('/reset-password/(:any)', 'Home::showResetPasswordForm/$1'); 
$routes->post('/reset-password', 'Home::resetPassword'); 

// PAGINA DE INICIO
$routes->get('/configuracion', 'Home::iraconfiguracion'); 
$routes->get('/irainicio', 'HorariosController::index'); 
$routes->get('/horarios', 'HorariosController::index');  // Consolidar en HorariosController
$routes->get('configuracion/(:num)', 'HorariosController::configuracion/$1');

// PÁGINA DE HORARIOS
$routes->get('mishorarios', 'HorariosController::index');
$routes->post('configurar/(:any)', 'HorariosController::configurarHorario/$1');
$routes->get('addtarjeta', 'HorariosController::añadirtarjeta');
$routes->post('savetarjeta', 'HorariosController::savehorario');
$routes->post('borrar_tarjeta/(:num)', 'HorariosController::borrarTarjeta/$1');
$routes->post('add_name/(:num)', 'HorariosController::addname/$1');

// PÁGINA DE SERVO
$routes->post('/servo/open', 'ServoController::openServo'); 
$routes->post('/servo/close', 'ServoController::closeServo'); 

// INICIO 2
$routes->get('/iniciovalogin', 'Home::iralogin');
$routes->get('/iniciovaregister', 'Home::inicioregister');
$routes->get('/tercon', 'HorariosController::terminoscondiciones');
$routes->get('/pantalla', 'Home::iniciar2');


// PLANOS VENTANAS
$routes->get('/pele', 'Home::iradiseño');
$routes->get('diseno', 'DisenoController::crear');

// Rutas para horarios de ventana
$routes->get('horario-ventana/configurar/(:num)', 'HorarioVentanaController::configurar/$1');
$routes->get('api/horario-ventana/(:num)', 'HorarioVentanaController::index/$1');
$routes->put('api/horario-ventana/(:num)', 'HorarioVentanaController::update/$1');
$routes->get('api/horario-ventana/estado', 'HorarioVentanaController::getEstadoVentana');

// Rutas para diseños
$routes->get('diseno/crear', 'DisenoController::crear');
$routes->post('diseno/guardar', 'DisenoController::guardar');

// Rutas para horarios
$routes->get('horarios/configuracion/(:num)', 'HorariosController::configuracion/$1');
$routes->post('horarios/guardar', 'HorariosController::guardar');

// Rutas para la API de horarios
$routes->group('api', function($routes) {
    $routes->group('horarios', function($routes) {
        $routes->get('getHorarios', 'Api\HorarioController::getHorarios');
        $routes->post('actualizarEstado', 'Api\HorarioController::actualizarEstado');
    });
});

// Rutas para la API de la ventana
$routes->group('api', function($routes) {
    $routes->get('horario-ventana/estado', 'HorarioVentanaController::getEstadoVentana');
    $routes->put('horario-ventana/(:num)', 'HorarioVentanaController::update/$1');
    $routes->get('horario-ventana/(:num)', 'HorarioVentanaController::index/$1');
});