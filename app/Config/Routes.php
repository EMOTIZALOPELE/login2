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
$routes->post('/guardar_horarios', 'Home::guardar_horarios'); 

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
$routes->post('design/saveDesign', 'DesignController::saveDesign');