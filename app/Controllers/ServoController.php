<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\HorariosModel; 
use App\Models\ServoModel;    
use CodeIgniter\API\ResponseTrait; // Para usar $this->response->setJSON() y setStatusCode()
use Psr\Log\LogLevel; // Importar para los niveles de log

class ServoController extends BaseController
{
    use ResponseTrait; // Habilita el ResponseTrait para manejar respuestas JSON fácilmente

    protected $dispositivoModel;
    protected $horariosModel;
    protected $servoModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
        $this->horariosModel = new HorariosModel();
        $this->servoModel = new ServoModel(); // Inicializar ServoModel
        date_default_timezone_set('America/Argentina/Buenos_Aires');

    }

    /**
     * Carga la vista de control del servo, pasándole los datos del dispositivo y sus servos.
     * La vista ahora mostrará múltiples servos.
     * Ruta: /masivo/{dispositivo_id}
     */
    public function estado($dispositivo_id = null)
    {
        if (empty($dispositivo_id)) {
            log_message(LogLevel::ERROR, 'ServoController::estado - Dispositivo_id no especificado.');
            return redirect()->to(base_url('/irainicio'))->with('error', 'No se ha especificado un dispositivo.');
        }

        $dispositivo = $this->dispositivoModel->find($dispositivo_id);

        if (!$dispositivo) {
            log_message(LogLevel::ERROR, 'ServoController::estado - Dispositivo con ID ' . $dispositivo_id . ' no encontrado.');
            return redirect()->to(base_url('/irainicio'))->with('error', 'Dispositivo no encontrado.');
        }

        // Verificar que el dispositivo pertenece al usuario logueado
        if ($dispositivo['usuario_id'] != session()->get('id')) {
            log_message(LogLevel::WARNING, 'ServoController::estado - Acceso denegado. Usuario ' . session()->get('id') . ' intentó acceder al dispositivo ' . $dispositivo_id . ' (propietario: ' . $dispositivo['usuario_id'] . ').');
            return redirect()->to(base_url('/irainicio'))->with('error', 'No tienes permiso para controlar este dispositivo.');
        }

        // Obtener TODOS los servos asociados a este dispositivo desde la nueva tabla 'servos'
        $servos = $this->servoModel->where('dispositivo_id', $dispositivo_id)->findAll();

        $data = [
            'dispositivo' => $dispositivo,
            'servos_asociados' => $servos // Pasar los servos a la vista
        ];
        return view('ServoView', $data);
    }

    /**
     * El Frontend (página web) llama a esta función para establecer el estado deseado
     * de un servo ESPECÍFICO (control manual).
     * Ruta: /funcional/actualizarEstado/{servo_id}/{estado}
     */
    public function actualizarEstado($servo_id, $estado)
    {
        // 1. Validaciones básicas (igual que antes)
        $servo = $this->servoModel->find($servo_id);
        if (!$servo) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Servo no encontrado.'])->setStatusCode(404);
        }

        $dispositivo = $this->dispositivoModel->find($servo['dispositivo_id']);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Acceso denegado.'])->setStatusCode(403);
        }

        // --- INICIO DE LA NUEVA LÓGICA DE CÁLCULO DE TIEMPO ---

        $timezone = new \DateTimeZone('America/Argentina/Buenos_Aires');
        $now = new \DateTime('now', $timezone);
        $targetEstado = strtoupper($estado);
        $expires = null; // Por defecto, no hay expiración

        // 2. Determinar a qué horario programado debemos apuntar
        $horarioReferencia = null;
        if ($targetEstado === 'ABIERTO' && !empty($servo['horario_apertura'])) {
            $horarioReferencia = $servo['horario_apertura'];
        } elseif ($targetEstado === 'CERRADO' && !empty($servo['horario_cierre'])) {
            $horarioReferencia = $servo['horario_cierre'];
        }

        // 3. Calcular la fecha de expiración si tenemos un horario de referencia
        if ($horarioReferencia) {
            try {
                // Creamos un objeto DateTime para el horario de hoy
                $horarioHoy = \DateTime::createFromFormat('H:i:s', $horarioReferencia, $timezone);
                // Le asignamos la fecha de hoy
                $horarioHoy->setDate($now->format('Y'), $now->format('m'), $now->format('d'));

                // Si la hora programada ya pasó hoy, asumimos que se refiere a la de mañana
                if ($horarioHoy < $now) {
                    $horarioHoy->modify('+1 day');
                }

                // El tiempo de expiración es el horario programado más 1 minuto de precaución
                $expires = (clone $horarioHoy)->modify('+1 minute');

            } catch (\Exception $e) {
                // Si hay un error en el formato de la hora, usamos un fallback
                log_message('error', 'Error al parsear horario para override: ' . $e->getMessage());
                // Fallback: 15 minutos de override manual si el horario es inválido
                $expires = (clone $now)->modify('+15 minutes');
            }
        } else {
            // Fallback: Si no hay horario configurado para esa acción, damos un override de 15 minutos
            $expires = (clone $now)->modify('+15 minutes');
        }

        // 4. Preparar los datos para actualizar la base de datos
        $dataToUpdate = [
            'estado_actual'           => $targetEstado,
            'modo_operacion'          => 'MANUAL',
            'manual_override_expires' => $expires->format('Y-m-d H:i:s') // Guardamos el timestamp calculado
        ];
        
        // --- FIN DE LA NUEVA LÓGICA ---

        try {
            $this->servoModel->update($servo_id, $dataToUpdate);
            return $this->response->setJSON([
                'status'   => 'ok',
                'estado'   => $dataToUpdate['estado_actual'],
                'servo_id' => $servo_id,
                'modo'     => $dataToUpdate['modo_operacion'],
                'expira'   => $dataToUpdate['manual_override_expires'] // Opcional: enviar la expiración a la vista
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar estado manual: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error interno del servidor.'])->setStatusCode(500);
        }
    }

    /**
     * Función principal para el ESP32 y la web. Decide y devuelve el estado de los servos.
     */
    public function obtenerEstadoDispositivo($macAddress)
    {
        $dispositivo = $this->dispositivoModel->where('codigo', $macAddress)->first();
        if (!$dispositivo) {
            return $this->failNotFound('Dispositivo no encontrado');
        }

        $timezone = new \DateTimeZone('America/Argentina/Buenos_Aires');
        $nowFormatted = (new \DateTime('now', $timezone))->format('Y-m-d H:i:s');

        // LÓGICA 1: REVERTIR A AUTOMÁTICO SI EL TIEMPO MANUAL HA EXPIRADO
        $servosExpirados = $this->servoModel
            ->where('dispositivo_id', $dispositivo['id'])
            ->where('modo_operacion', 'MANUAL')
            ->where('manual_override_expires IS NOT NULL')
            ->where('manual_override_expires <', $nowFormatted)
            ->findAll();

        if (!empty($servosExpirados)) {
            foreach ($servosExpirados as $servo) {
                $this->servoModel->update($servo['id'], [
                    'modo_operacion'          => 'AUTOMATICO',
                    'manual_override_expires' => null
                ]);
                log_message('info', 'Servo ID ' . $servo['id'] . ' revertido a modo AUTOMATICO por expiración.');
            }
        }
        
        // Volvemos a cargar los servos para tener los datos más actualizados
        $servos = $this->servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();

        // LÓGICA 2: CONSULTAR EL CLIMA (OpenWeatherMap)
        $apiKey = '0d132a7baaa02ea9cfc60077249f0254';
        $city = 'Rio Tercero,AR';
        $encodedCity = urlencode($city);
        $weatherApiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$encodedCity}&appid={$apiKey}&units=metric&lang=es";
        $client = \Config\Services::curlrequest(['timeout' => 5]);
        $climaData = [];
        try {
            $response = $client->request('GET', $weatherApiUrl);
            if ($response->getStatusCode() == 200) {
                $weatherBody = json_decode($response->getBody(), true);
                $weatherId = $weatherBody['weather'][0]['id'] ?? 800;
                $climaData = [
                    'temperatura'    => (float)($weatherBody['main']['temp'] ?? -100.0),
                    'esta_lloviendo' => ($weatherId >= 200 && $weatherId <= 531)
                ];
            } else {
                 $climaData = ['temperatura' => -100.0, 'esta_lloviendo' => false];
            }
        } catch (\Exception $e) {
            log_message('error', 'Excepción al consultar la API del clima: ' . $e->getMessage());
            $climaData = ['temperatura' => -100.0, 'esta_lloviendo' => false];
        }

        // LÓGICA 3: CONSTRUIR LA RESPUESTA FINAL
        $respuesta = ['clima'  => $climaData, 'servos' => []];
        foreach ($servos as $servo) {
            $decisionFinal = $servo['estado_actual']; // Por defecto, es el estado actual

            if ($servo['modo_operacion'] === 'AUTOMATICO') {
                $horaActual = date('H:i:s');
                $estadoBaseHorario = 'MANUAL'; // Valor si no hay horarios
                
                if ($servo['horario_apertura'] && $servo['horario_cierre']) {
                    $estadoBaseHorario = ($horaActual >= $servo['horario_apertura'] && $horaActual < $servo['horario_cierre']) ? 'ABIERTO' : 'CERRADO';
                }

                $decisionAutomatica = $estadoBaseHorario;

                // Aplicar overrides del clima
                $tempActual = $climaData['temperatura'];
                $estaLloviendo = $climaData['esta_lloviendo'];
                $tempCerrar = (float)$servo['temp_min_cierre'];
                $tempAbrir = (float)$servo['temp_max_apertura'];
                $ignorarLluvia = (bool)$servo['permitir_lluvia'];

                if ($tempActual != -100.0 && $tempAbrir != 0 && $tempActual >= $tempAbrir) $decisionAutomatica = 'ABIERTO';
                if ($tempActual != -100.0 && $tempCerrar != 0 && $tempActual <= $tempCerrar) $decisionAutomatica = 'CERRADO';
                if ($estaLloviendo && !$ignorarLluvia) $decisionAutomatica = 'CERRADO';

                if ($decisionAutomatica !== 'MANUAL' && $servo['estado_actual'] !== $decisionAutomatica) {
                    $this->servoModel->update($servo['id'], ['estado_actual' => $decisionAutomatica]);
                    $decisionFinal = $decisionAutomatica; // Actualizamos la decisión final
                    log_message('info', "Servo ID {$servo['id']} actualizado automáticamente a {$decisionFinal}.");
                }
            }
            
            $respuesta['servos'][] = [
                'id'              => (int)$servo['id'],
                'estado'          => $decisionFinal,
                'modo'            => $servo['modo_operacion'],
                'pin'             => (int)$servo['pin_gpio'],
            ];
        }
        return $this->respond($respuesta);
    }
    /**
     * Muestra la vista de configuración para un servo específico
     * Ruta: /servo/configuracion/{servo_id}
     */
    public function configuracion($servo_id)
    {
        $servo = $this->servoModel->find($servo_id);

        if (!$servo) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'Servo no encontrado.');
        }

        // Verificar que el servo pertenece a un dispositivo del usuario logueado
        $dispositivo = $this->dispositivoModel->find($servo['dispositivo_id']);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'No tienes permiso para configurar este servo.');
        }

        // Asegurarse de que los horarios estén en formato correcto
        if (!empty($servo['horario_apertura'])) {
            $servo['horario_apertura'] = date('H:i', strtotime($servo['horario_apertura']));
        }
        if (!empty($servo['horario_cierre'])) {
            $servo['horario_cierre'] = date('H:i', strtotime($servo['horario_cierre']));
        }

        return view('configuracion_servo', [
            'servo' => $servo,
            'dispositivo' => $dispositivo
        ]);
    }

    /**
     * Actualiza la configuración de un servo específico
     * Ruta: /servo/actualizar_configuracion/{servo_id}
     */
    public function actualizar_configuracion($servo_id)
    {
        $servo = $this->servoModel->find($servo_id);

        if (!$servo) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'Servo no encontrado.');
        }

        // Verificar que el servo pertenece a un dispositivo del usuario logueado
        $dispositivo = $this->dispositivoModel->find($servo['dispositivo_id']);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'No tienes permiso para configurar este servo.');
        }

        // Obtener y validar los datos del formulario
        $horario_apertura = $this->request->getPost('horario_apertura');
        $horario_cierre = $this->request->getPost('horario_cierre');
        $modo_operacion = $this->request->getPost('modo_operacion');

        if (empty($horario_apertura) || empty($horario_cierre) || empty($modo_operacion)) {
            return redirect()->back()->with('error', 'Todos los campos son requeridos.');
        }

        try {
            // Actualizar la configuración del servo
            $this->servoModel->update($servo_id, [
                'horario_apertura' => $horario_apertura,
                'horario_cierre' => $horario_cierre,
                'modo_operacion' => $modo_operacion
            ]);

            return redirect()->to(site_url('servo/estado/' . $servo['dispositivo_id']))->with('success', 'Configuración actualizada correctamente.');
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar la configuración del servo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar la configuración. Por favor, intente nuevamente.');
        }
    }

    /**
     * Permite al ESP32 cambiar el modo de operación de un servo.
     * Ruta: /servos/set-mode/{servo_id}/{modo}
     */
    public function setModoOperacion($servo_id, $modo)
    {
        $servo = $this->servoModel->find($servo_id);
        if (!$servo) {
            return $this->failNotFound('Servo no encontrado.');
        }

        $newMode = strtoupper($modo);
        if ($newMode !== 'AUTOMATICO' && $newMode !== 'MANUAL') {
            return $this->failValidationError('Modo no válido. Debe ser AUTOMATICO o MANUAL.');
        }

        try {
            $this->servoModel->update($servo_id, ['modo_operacion' => $newMode]);
            log_message('info', "Modo del servo {$servo_id} cambiado a {$newMode} por petición del ESP32.");
            return $this->respondUpdated(['success' => true, 'message' => 'Modo actualizado.']);
        } catch (\Exception $e) {
            log_message('error', 'Error al cambiar modo del servo ' . $e->getMessage());
            return $this->failServerError('Error interno del servidor.');
        }
    }

    /**
     * Permite al ESP32 reportar un cambio de estado para que se guarde en la BD.
     * Ruta: /servos/report-state/{servo_id}/{estado}
     */
    public function reportEstado($servo_id, $estado)
    {
        $servo = $this->servoModel->find($servo_id);
        if (!$servo) {
            return $this->failNotFound('Servo no encontrado para reportar estado.');
        }

        $newState = strtoupper($estado);
        if ($newState !== 'ABIERTO' && $newState !== 'CERRADO') {
            return $this->failValidationError('Estado no válido.');
        }

        try {
            // Solo actualizamos el estado_actual, no el modo
            $this->servoModel->update($servo_id, ['estado_actual' => $newState]);
            log_message('info', "ESP32 reportó nuevo estado para servo {$servo_id}: {$newState}");
            return $this->respondUpdated(['success' => true, 'message' => 'Estado reportado con éxito.']);
        } catch (\Exception $e) {
            log_message('error', 'Error al reportar estado del servo: ' . $e->getMessage());
            return $this->failServerError('Error interno del servidor.');
        }
    }
    
}