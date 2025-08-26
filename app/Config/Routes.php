<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN Y REGISTER
$routes->get('/', 'Home::iniciar2'); 
$routes->post('login', 'Home::login');
$routes->get('login', 'Home::iralogin');
$routes->get('/logout', 'Home::logout');  
$routes->post('/register/store', 'registerController::store'); 

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
$routes->get('irainicio', 'ConfiguracionController::inicio');


// PÁGINA DE SERVO
$routes->get('/masivo/(:num)', 'ServoController::estado/$1'); // Para cargar la vista
$routes->get('/funcional/actualizarEstado/(:num)/(:any)', 'ServoController::actualizarEstado/$1/$2'); // Para enviar comandos
$routes->get('/dispositivos/estado/(:segment)', 'ServoController::obtenerEstadoDispositivo/$1'); // Para pedir el estado
$routes->post('/servos/cancelar-horario', 'ServoController::cancelarHorario');
$routes->post('servos/cancelar-horario', 'ServoController::cancelarHorario');


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
$routes->post('/dispositivos/reclamar', 'HorariosController::reclamarDispositivoPorMac');
$routes->post('/servos/seleccionar', 'HorariosController::seleccionarDispositivoPorNombre');
$routes->post('horarios/guardar', 'HorariosController::guardar');
//Esta ruta crea la URL que el ESP32 usará para decirle al servidor que ponga un servo de nuevo en modo automático.
$routes->get('/servos/set-mode/(:num)/(:segment)', 'ServoController::setModoOperacion/$1/$2');
//Esta ruta Crea la URL que el ESP32 usará para reportar un cambio.
$routes->get('/servos/report-state/(:num)/(:segment)', 'ServoController::reportEstado/$1/$2');

$routes->get('api/weather/current', 'WeatherController::getCurrentWeather');
$routes->get('api/weather/forecast', 'WeatherController::getForecastWeather');


// Rutas para el controlador de clima
$routes->get('configuracion/(:num)', 'HorariosController::configuracion/$1');
$routes->post('configuracion/guardar', 'HorariosController::guardar');
$routes->get('/config', 'HorariosController::apiclima');


// Rutas para la ESP32 para obtener/establecer configuraciones
// Estas rutas son las que tu ESP32 consultaría
$routes->get('api/esp32/settings', function() {
    // Aquí debes cargar las configuraciones guardadas para la ESP32 (horarios, condicionantes)
    // Carga desde una base de datos (modelo), un archivo, o un array de ejemplo.
    // Ejemplo simple (idealmente desde un modelo/DB):
    $settings = [
        'open_hour_ventana' => '08:00',
        'close_hour_ventana' => '18:00',
        'open_hour_cortina' => '07:00',
        'close_hour_cortina' => '20:00',
        'open_hour_postigon' => '07:30',
        'close_hour_postigon' => '19:30',
        'city' => 'Rio Tercero,AR', // La ciudad que la ESP32 usaría para su propia lógica o referencia
        'min_temp_global' => 10.0,
        'max_temp_global' => 30.0,
        'max_wind_speed_global' => 20.0,
        'allow_rain_global' => false,
        // ... otras configuraciones que la ESP32 necesita
    ];
    return $this->response->setJSON($settings);
});

$routes->post('api/esp32/settings', function() {
    $request = \Config\Services::request();
    $newSettings = $request->getJSON(true); // Obtener el JSON del body como array

    // Aquí debes guardar las configuraciones recibidas del frontend o de la ESP32
    // en tu base de datos o sistema de persistencia de CodeIgniter.
    // Ejemplo de log (idealmente a DB):
    log_message('info', 'Configuraciones recibidas: ' . json_encode($newSettings));

    return $this->response->setJSON(['message' => 'Configuraciones guardadas con éxito']);
});

// Opcional: Ruta para que la ESP32 envíe su estado actual
$routes->post('api/esp32/status', function() {
    $request = \Config\Services::request();
    $status = $request->getJSON(true); // Obtener el JSON del body como array

    // Aquí puedes guardar el estado (temperatura interna, estado de las ventanas, etc.)
    // en tu base de datos o sistema de persistencia.
    log_message('info', 'Estado de la ESP32 recibido: ' . json_encode($status));

    return $this->response->setJSON(['message' => 'Estado recibido con éxito']);
});


