<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN Y REGISTER
$routes->get('/', 'Home::iniciar2'); 
$routes->post('login', 'Home::login');
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
$routes->post('/guardar_horarios', 'Home::guardar_horarios'); 
$routes->post('verificar-codigo', 'HorariosController::verificarCodigo');
$routes->get('addtarjeta/(:num)', 'HorariosController::añadirtarjeta/$1');
$routes->post('verificar-codigo', 'HorariosController::verificarCodigoDispositivo');
$routes->post('verificar-codigo-ajax', 'HorariosController::verificarCodigo'); // si usás AJAX
$routes->get('crear-tarjeta', 'HorariosController::formularioCrearTarjeta');

$routes->post('/guardar_horarios', 'HorariosController::guardar_horarios'); 
$routes->get('configuracion/(:num)', 'HorariosController::configuracion/$1');

// PÁGINA DE HORARIOS
$routes->get('mishorarios', 'HorariosController::index');
$routes->post('configurar/(:any)', 'HorariosController::configurarHorario/$1');
$routes->get('addtarjeta', 'HorariosController::añadirtarjeta');
$routes->post('savetarjeta', 'HorariosController::savehorario');
$routes->post('borrar_tarjeta/(:num)', 'HorariosController::borrarTarjeta/$1');
$routes->post('add_name/(:num)', 'HorariosController::addname/$1');
$routes->post('/actualizar_nombre_tarjeta', 'HorariosController::actualizarNombreTarjeta');


// PÁGINA DE SERVO
$routes->get('/funcional', 'ServoController::nazi');
$routes->get('/funcional/actualizarEstado/(:any)', 'ServoController::actualizarEstado/$1');
$routes->get('/funcional/obtenerUltimoEstado', 'ServoController::obtenerUltimoEstado');
$routes->get('/funcional/obtenerEstado', 'ServoController::obtenerEstado');
$routes->get('/masivo', 'ServoController::estado');


// INICIO 2
$routes->get('/iniciovalogin', 'Home::iralogin');
$routes->get('/iniciovaregister', 'Home::inicioregister');
$routes->get('/tercon', 'HorariosController::terminoscondiciones');
$routes->get('/pantalla', 'Home::iniciar2');


// PLANOS VENTANAS
$routes->get('/pele', 'Home::iradiseño');
$routes->get('diseno', 'DisenoController::crear');
$routes->post('diseno/guardar', 'DisenoController::guardar'); // Guarda el diseño en la BD

// PAYPAL
$routes->post('/paypal/createOrder', 'PayPalController::createOrder');
$routes->post('/paypal/captureOrder', 'PayPalController::captureOrder');
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



