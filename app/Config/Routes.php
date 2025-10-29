<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN Y REGISTER
$routes->get('/', 'Home::index'); 
$routes->post('login', 'Home::login');
$routes->get('/logout', 'Home::logout');  
$routes->post('/register/store', 'registerController::store'); 
$routes->get('verify-email/(:any)', 'registerController::verifyEmail/$1');
$routes->get('resend-code', 'VerificationController::resendCode');
$routes->get('check-verification-status', 'VerificationController::checkVerificationStatus');

// RECUPERACION DE CONTRASEÑA
$routes->get('/forgotpassword', 'Home::forgotpassword'); 
$routes->post('/forgotpassword1', 'Home::forgotPPassword'); 
$routes->get('/reset-password/(:any)', 'Home::showResetPasswordForm/$1'); 
$routes->post('/reset-password', 'Home::resetPassword'); 

<<<<<<< HEAD
// Ahora /irainicio apunta al controlador Home y a la función irainicio() que hemos preparado.
$routes->get('/irainicio', 'Home::irainicio');
=======
<<<<<<< HEAD
// Ahora /irainicio apunta al controlador Home y a la función irainicio() que hemos preparado.
$routes->get('/irainicio', 'Home::irainicio');
=======
// ====================================================================
// ===== CORRECCIÓN CLAVE =====
// Ahora /irainicio apunta al controlador Home y a la función irainicio() que hemos preparado.
$routes->get('/irainicio', 'Home::irainicio');
// ====================================================================
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
$routes->get('mishorarios', 'HorariosController::index');

// CONFIGURACIÓN DE DISPOSITIVOS
// Ruta principal de la vista de configuración
$routes->get('/configuracion', 'ConfiguracionController::index');
// Ruta para guardar la configuración (POST)
$routes->post('/configuracion/guardar', 'ConfiguracionController::guardar');
// Ruta con parámetro para ver la configuración de un dispositivo específico
<<<<<<< HEAD
$routes->get('/configuracion/(:num)', 'ConfiguracionController::index/$1');
$routes->post('/configuracion/guardar', 'ConfiguracionController::guardar'); // Ruta para el formulario
=======
<<<<<<< HEAD
$routes->get('/configuracion/(:num)', 'ConfiguracionController::index/$1');
$routes->post('/configuracion/guardar', 'ConfiguracionController::guardar'); // Ruta para el formulario
=======
$routes->get('configuracion/(:num)', 'ConfiguracionController::index/$1');
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

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
<<<<<<< HEAD
$routes->post('horarios/eliminar/(:num)', 'HorariosController::eliminarHorario/$1', ['filter' => 'auth']);
$routes->post('horarios/borrar-tarjeta/(:segment)', 'HorariosController::borrarTarjeta/$1');
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

// PÁGINA DE SERVO
$routes->get('/masivo/(:num)', 'ServoController::estado/$1');
$routes->get('/funcional/actualizarEstado/(:num)/(:any)', 'ServoController::actualizarEstado/$1/$2');
$routes->get('/dispositivos/estado/(:segment)', 'ServoController::obtenerEstadoDispositivo/$1');
$routes->get('/servos/set-mode/(:num)/(:segment)', 'ServoController::setModoOperacion/$1/$2');
$routes->get('/servos/report-state/(:num)/(:segment)', 'ServoController::reportEstado/$1/$2');
<<<<<<< HEAD
$routes->post('/servo/eliminar/(:num)', 'ServoController::eliminarServo/$1');
//RUTA PARA LA ELIMINACIÓN DEL SERVO
$routes->post('servo/eliminar/(:num)', 'ServoController::eliminarServo/$1', ['filter' => 'auth']);
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

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
$routes->post('/paypal/captureOrder', 'PayPalController::captureOrder');
$routes->get('/continuar-pago', 'PayPalController::continuarPago', ['filter' => 'auth']);
<<<<<<< HEAD
$routes->get('/api/mis-compras', 'PayPalController::apiMisCompras', ['filter' => 'auth']);
$routes->get('seleccionar-servos/(:num)', 'PayPalController::seleccionarServos/$1');
$routes->post('guardar-configuracion-servos', 'PayPalController::guardarConfiguracionServos');
$routes->post('verificar-servos-configurados', 'PayPalController::verificarServosConfigurados');
=======

<<<<<<< HEAD
$routes->get('/api/mis-compras', 'PayPalController::apiMisCompras', ['filter' => 'auth']);
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95


// Aplicamos el filtro 'auth' para forzar el login antes de crear la orden.
$routes->post('/paypal/createOrder', 'PayPalController::createOrder', ['filter' => 'auth']);
<<<<<<< HEAD
=======
$routes->post('/paypal/captureOrder', 'PayPalController::captureOrder'); // La captura no necesita filtro, la orden ya tiene el usuario_id.
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

// Estas son las rutas para el formulario de envío y validación de la compra de paypal
$routes->get('/mis-compras', 'PayPalController::misCompras', ['filter' => 'auth']); 
$routes->post('/guardar-direccion', 'PayPalController::guardarDireccion', ['filter' => 'auth']);
<<<<<<< HEAD
$routes->get('seleccionar-plan', 'PayPalController::seleccionarPlan'); //esto es lo que manda a los planes en caso de no tener compras realizadas

// CLIMA
=======

=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
// CLIMA
$routes->get('api/weather/current', 'WeatherController::getCurrentWeather');
$routes->get('api/weather/forecast', 'WeatherController::getForecastWeather');
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
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

$routes->get('verify-code-view', 'VerificationController::showCodeForm');
$routes->post('verify-code', 'VerificationController::verifyCode');