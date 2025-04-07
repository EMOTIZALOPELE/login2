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
$routes->post('/guardar_horarios', 'HorariosController::guardar_horarios'); 
$routes->get('configuracion/(:num)', 'HorariosController::configuracion/$1');

// PÁGINA DE HORARIOS
$routes->get('/horarios', 'Home::mostrarHorarios');  // Ruta para mostrar los horarios configurados
$routes->get('mishorarios', 'MisHorarios::horariosmodifica');

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
$routes->post('diseno/guardar', 'DisenoController::guardar'); // Guarda el diseño en la BD

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

