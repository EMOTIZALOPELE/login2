<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN Y REGISTER
$routes->get('/', 'Home::iniciar2'); 
$routes->post('login', 'Home::login');
$routes->get('/logout', 'Home::logout');  
$routes->post('/register/store', 'registerController::store'); 

// RECUPERACION DE CONTRASEÑA
$routes->get('/forgotpassword', 'Home::forgotpassword'); 
$routes->post('/forgotpassword1', 'Home::forgotPPassword'); 
$routes->get('/reset-password/(:any)', 'Home::showResetPasswordForm/$1'); 
$routes->post('/reset-password', 'Home::resetPassword'); 

// ====================================================================
// ===== CORRECCIÓN CLAVE =====
// Ahora /irainicio apunta al controlador Home y a la función irainicio() que hemos preparado.
$routes->get('/irainicio', 'Home::irainicio');
// ====================================================================
$routes->get('mishorarios', 'HorariosController::index');

// CONFIGURACIÓN DE DISPOSITIVOS
// Ruta principal de la vista de configuración
$routes->get('/configuracion', 'ConfiguracionController::index');
// Ruta para guardar la configuración (POST)
$routes->post('/configuracion/guardar', 'ConfiguracionController::guardar');
// Ruta con parámetro para ver la configuración de un dispositivo específico
$routes->get('configuracion/(:num)', 'ConfiguracionController::index/$1');

// RUTAS DE LA VISTA DE DISPOSITIVOS
$routes->get('/dispositivos', 'DispositivoController::index');
$routes->post('/dispositivos/cambiar-nombre-dispositivo', 'DispositivoController::cambiarNombreDispositivo');
$routes->post('/dispositivos/cambiar-nombre-tarjeta', 'DispositivoController::cambiarNombreTarjeta');
$routes->post('dispositivos/cambiar-nombre-servo', 'DispositivoController::cambiarNombreServo');
$routes->post('/dispositivos/eliminar/(:num)', 'DispositivoController::eliminarDispositivo/$1');

// PÁGINA DE HORARIOS (Rutas consolidadas de tu código)
$routes->post('configurar/(:any)', 'HorariosController::configurarHorario/$1');
$routes->get('addtarjeta', 'HorariosController::añadirtarjeta');
$routes->get('addtarjeta/(:num)', 'HorariosController::añadirtarjeta/$1');
$routes->post('savetarjeta', 'HorariosController::savehorario');
$routes->post('borrar_tarjeta/(:num)', 'HorariosController::borrarTarjeta/$1');
$routes->post('add_name/(:num)', 'HorariosController::addname/$1');
$routes->post('/actualizar_nombre_tarjeta', 'HorariosController::actualizarNombreTarjeta');
$routes->post('verificar-codigo', 'HorariosController::verificarCodigo');
$routes->post('verificar-codigo', 'HorariosController::verificarCodigoDispositivo');
$routes->post('verificar-codigo-ajax', 'HorariosController::verificarCodigo');
$routes->get('crear-tarjeta', 'HorariosController::formularioCrearTarjeta');
$routes->get('horarios/configuracion/(:num)', 'HorariosController::configuracion/$1');
$routes->post('/dispositivos/reclamar', 'HorariosController::reclamarDispositivoPorMac');
$routes->post('/servos/seleccionar', 'HorariosController::seleccionarDispositivoPorNombre');
$routes->post('/guardar_horarios', 'HorariosController::guardar_horarios');

// PÁGINA DE SERVO
$routes->get('/masivo/(:num)', 'ServoController::estado/$1');
$routes->get('/funcional/actualizarEstado/(:num)/(:any)', 'ServoController::actualizarEstado/$1/$2');
$routes->get('/dispositivos/estado/(:segment)', 'ServoController::obtenerEstadoDispositivo/$1');
$routes->get('/servos/set-mode/(:num)/(:segment)', 'ServoController::setModoOperacion/$1/$2');
$routes->get('/servos/report-state/(:num)/(:segment)', 'ServoController::reportEstado/$1/$2');

// INICIO 2
$routes->get('/iniciovalogin', 'Home::iralogin');
$routes->get('/iniciovaregister', 'Home::inicioregister');
$routes->get('/tercon', 'HorariosController::terminoscondiciones');
$routes->get('/pantalla', 'Home::iniciar2');

// Rutas para modificar nombre y contraseña
$routes->get('/modifyname', 'Home::irAModifyName');
$routes->post('/update-username', 'Home::updateUsername');
$routes->get('/modifypass', 'Home::irAModifyPass');
$routes->post('/update-password', 'Home::updatePassword');

// PAYPAL
$routes->post('/paypal/createOrder', 'PayPalController::createOrder');
$routes->post('/paypal/captureOrder', 'PayPalController::captureOrder');

// CLIMA
$routes->get('api/weather/current', 'WeatherController::getCurrentWeather');
$routes->get('api/weather/forecast', 'WeatherController::getForecastWeather');
$routes->get('/config', 'HorariosController::apiclima');

// RUTAS PARA LA ESP32
$routes->get('api/esp32/settings', 'ConfiguracionController::apiSettings');
$routes->post('api/esp32/settings', 'ConfiguracionController::apiUpdateSettings');
$routes->post('api/esp32/status', 'ConfiguracionController::apiStatus');

// Rutas para DiasServoController (consolidadas)
$routes->post('servo/(:num)/dias/guardar', 'ConfiguracionController::guardarDiasServo/$1');
$routes->get('servo/(:num)/dias', 'ConfiguracionController::obtenerDiasServo/$1');
$routes->get('servo/(:num)/verificar-hoy', 'ConfiguracionController::verificarActivacionHoy/$1');
$routes->get('dispositivo/(:num)/configuracion-dias', 'ConfiguracionController::obtenerConfiguracionCompleta/$1');

