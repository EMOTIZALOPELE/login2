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
        // 1. Logear la entrada a la función y los parámetros
        log_message(LogLevel::DEBUG, 'actualizarEstado: Recibiendo servo_id: ' . $servo_id . ', estado: ' . $estado);

        $servo = $this->servoModel->find($servo_id);

        if (!$servo) {
            log_message(LogLevel::ERROR, 'actualizarEstado: Servo con ID ' . $servo_id . ' no encontrado.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'Servo no encontrado.'])->setStatusCode(404);
        }
        log_message(LogLevel::DEBUG, 'actualizarEstado: Servo encontrado: ' . json_encode($servo));

        // Verificar que el servo pertenece a un dispositivo del usuario logueado
        $dispositivo = $this->dispositivoModel->find($servo['dispositivo_id']);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            log_message(LogLevel::ERROR, 'actualizarEstado: Acceso denegado. Usuario ' . session()->get('id') . ' intentó controlar servo ' . $servo_id . ' del dispositivo ' . $servo['dispositivo_id'] . ' (propietario: ' . ($dispositivo['usuario_id'] ?? 'N/A') . ').');
            return $this->response->setJSON(['status' => 'error', 'message' => 'Acceso denegado a este servo.'])->setStatusCode(403);
        }
        log_message(LogLevel::DEBUG, 'actualizarEstado: Usuario autorizado.');

        // Datos a actualizar: el nuevo estado y forzar el modo a MANUAL
        $dataToUpdate = [
            'estado_actual' => strtoupper($estado),
            'modo_operacion' => 'MANUAL',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        log_message(LogLevel::DEBUG, 'actualizarEstado: Datos a actualizar para servo ' . $servo_id . ': ' . json_encode($dataToUpdate));

        try {
            // Intentar actualizar la base de datos
            $updated = $this->servoModel->update($servo_id, $dataToUpdate);
            
            if ($updated) {
                // Verificar que la actualización fue exitosa
                $servoActualizado = $this->servoModel->find($servo_id);
                log_message(LogLevel::INFO, 'actualizarEstado: Servo actualizado. Estado actual en DB: ' . json_encode($servoActualizado));
                
                return $this->response->setJSON([
                    'status' => 'ok',
                    'estado' => $dataToUpdate['estado_actual'],
                    'servo_id' => $servo_id,
                    'modo' => $dataToUpdate['modo_operacion'],
                    'debug_info' => [
                        'estado_anterior' => $servo['estado_actual'],
                        'modo_anterior' => $servo['modo_operacion'],
                        'estado_actual_db' => $servoActualizado['estado_actual'],
                        'modo_actual_db' => $servoActualizado['modo_operacion']
                    ]
                ])->setStatusCode(200);
            } else {
                $errors = $this->servoModel->errors();
                if (!empty($errors)) {
                    $errorMessage = 'Errores de validación en la actualización del servo: ' . json_encode($errors);
                    log_message(LogLevel::ERROR, 'actualizarEstado: ' . $errorMessage);
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Error de validación: ' . current($errors)])->setStatusCode(400);
                } else {
                    log_message(LogLevel::ERROR, 'actualizarEstado: Fallo al actualizar el servo ' . $servo_id . ' sin errores de validación explícitos.');
                    return $this->response->setJSON(['status' => 'error', 'message' => 'El servidor no pudo procesar la orden para el servo.'])->setStatusCode(500);
                }
            }
        } catch (\Exception $e) {
            log_message(LogLevel::CRITICAL, 'actualizarEstado: Excepción al intentar actualizar el servo ' . $servo_id . ': ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error interno del servidor al actualizar el servo.'])->setStatusCode(500);
        }
    }

    /**
     * ESTA ES LA FUNCIÓN QUE SE USARÁ TANTO PARA LA PÁGINA WEB COMO PARA EL ESP32.
     * Devuelve el estado de TODOS los servos asociados a un dispositivo.
     * Esta función también aplica la lógica horaria y actualiza la DB si es necesario.
     * Ruta: /dispositivos/estado/{id_o_mac}
     */
    public function obtenerEstadoDispositivo($id_o_mac)
    {
        // Configurar zona horaria para Argentina
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        log_message(LogLevel::INFO, "obtenerEstadoDispositivo: Iniciando con ID/MAC: " . $id_o_mac);
        
        // 1. Determinar si el identificador es numérico (ID del dispositivo) o una cadena (MAC)
        if (is_numeric($id_o_mac)) {
            $dispositivo = $this->dispositivoModel->find($id_o_mac);
            log_message(LogLevel::INFO, "Buscando por ID numérico: " . $id_o_mac);
        } else {
            $dispositivo = $this->dispositivoModel->where('codigo', $id_o_mac)->first();
            log_message(LogLevel::INFO, "Buscando por MAC: " . $id_o_mac);
        }

        if (!$dispositivo) {
            log_message(LogLevel::ERROR, "Dispositivo no encontrado para ID/MAC: " . $id_o_mac);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dispositivo no encontrado',
                'debug_info' => [
                    'id_o_mac' => $id_o_mac,
                    'is_numeric' => is_numeric($id_o_mac)
                ]
            ])->setStatusCode(404);
        }

        log_message(LogLevel::INFO, "Dispositivo encontrado: " . json_encode($dispositivo));

        // Para peticiones AJAX desde la web, verificamos la sesión del usuario.
        if ($this->request->isAJAX()) {
            if ($dispositivo['usuario_id'] != session()->get('id')) {
                log_message(LogLevel::ERROR, 'obtenerEstadoDispositivo: Acceso denegado a dispositivo con identificador ' . $id_o_mac . ' por usuario ' . session()->get('id') . '.');
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Acceso denegado',
                    'debug_info' => [
                        'usuario_sesion' => session()->get('id'),
                        'dispositivo_usuario' => $dispositivo['usuario_id']
                    ]
                ])->setStatusCode(403);
            }
        }

        // 2. Obtener TODOS los servos asociados a este dispositivo
        $servosAsociados = $this->servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();
        log_message(LogLevel::INFO, "Servos encontrados: " . count($servosAsociados));

        if (empty($servosAsociados)) {
            log_message(LogLevel::INFO, 'obtenerEstadoDispositivo: No hay servos configurados para el dispositivo ' . $dispositivo['id'] . '.');
            return $this->response->setJSON([
                'status' => 'ok',
                'servos' => [],
                'message' => 'No hay servos configurados para este dispositivo.'
            ]);
        }

        $responseServos = [];
        $currentTime = date('H:i:s');
        log_message(LogLevel::INFO, "Hora actual (Argentina): " . $currentTime);

        foreach ($servosAsociados as $servo) {
            $tipoElemento = strtoupper($servo['tipo_elemento'] ?? 'OTRO');
            $horarioApertura = $servo['horario_apertura'];
            $horarioCierre = $servo['horario_cierre'];
            $new_estado_calculado = $servo['estado_actual'];
            $new_modo_operacion = $servo['modo_operacion'];

            log_message(LogLevel::INFO, "Procesando servo ID {$servo['id']}:");
            log_message(LogLevel::INFO, "- Hora actual: {$currentTime}");
            log_message(LogLevel::INFO, "- Horario apertura: {$horarioApertura}");
            log_message(LogLevel::INFO, "- Horario cierre: {$horarioCierre}");
            log_message(LogLevel::INFO, "- Estado actual: {$servo['estado_actual']}");
            log_message(LogLevel::INFO, "- Modo actual: {$servo['modo_operacion']}");

            // Si está en modo MANUAL, solo cambiamos a AUTOMATICO si estamos en un punto de cambio de horario
            if (strtoupper($servo['modo_operacion']) === 'MANUAL') {
                $estado_por_horario = null;
                if (!empty($horarioApertura) && !empty($horarioCierre) && in_array($tipoElemento, ['VENTANA', 'CORTINA', 'POSTIGON'])) {
                    // Convertir horarios a timestamps para comparación más precisa
                    $currentTimestamp = strtotime($currentTime);
                    $aperturaTimestamp = strtotime($horarioApertura);
                    $cierreTimestamp = strtotime($horarioCierre);
                    
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']} - Comparación de horarios:");
                    log_message(LogLevel::INFO, "- Hora actual (timestamp): " . $currentTimestamp);
                    log_message(LogLevel::INFO, "- Horario apertura (timestamp): " . $aperturaTimestamp);
                    log_message(LogLevel::INFO, "- Horario cierre (timestamp): " . $cierreTimestamp);
                    
                    if ($currentTimestamp >= $aperturaTimestamp && $currentTimestamp < $cierreTimestamp) {
                        $estado_por_horario = 'ABIERTO';
                        log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Dentro del horario de apertura");
                    } else {
                        $estado_por_horario = 'CERRADO';
                        log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Fuera del horario de apertura");
                    }
                }

                // Solo cambiamos a AUTOMATICO si el estado actual es diferente al que indica el horario
                // Y si han pasado al menos 5 minutos desde la última actualización
                $ultima_actualizacion = strtotime($servo['updated_at'] ?? 'now');
                $tiempo_transcurrido = time() - $ultima_actualizacion;
                
                // Si estamos en un punto de cambio de horario (dentro de 1 minuto del horario programado)
                $horario_actual = strtotime($currentTime);
                $horario_apertura_timestamp = strtotime($horarioApertura);
                $horario_cierre_timestamp = strtotime($horarioCierre);
                
                $cerca_del_horario = false;
                $diferencia_apertura = abs($horario_actual - $horario_apertura_timestamp);
                $diferencia_cierre = abs($horario_actual - $horario_cierre_timestamp);
                
                if ($diferencia_apertura <= 10 || $diferencia_cierre <= 10) {
                    $cerca_del_horario = true;
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Cerca de un horario programado");
                    log_message(LogLevel::INFO, "- Diferencia con apertura: " . $diferencia_apertura . " segundos");
                    log_message(LogLevel::INFO, "- Diferencia con cierre: " . $diferencia_cierre . " segundos");
                }

                // Si estamos cerca de un horario programado, forzamos el cambio a AUTOMATICO
                if ($cerca_del_horario && $estado_por_horario !== null) {
                    $new_estado_calculado = $estado_por_horario;
                    $new_modo_operacion = 'AUTOMATICO';
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Forzando cambio a AUTOMATICO por horario programado");
                    log_message(LogLevel::INFO, "- Nuevo estado: {$new_estado_calculado}");
                } else {
                    // Mantener el estado actual y modo MANUAL
                    $new_estado_calculado = $servo['estado_actual'];
                    $new_modo_operacion = 'MANUAL';
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Manteniendo modo MANUAL");
                    log_message(LogLevel::INFO, "- Razón: " . ($tiempo_transcurrido < 300 ? "Tiempo transcurrido insuficiente" : "No hay cambios necesarios"));
                }
            } else {
                // Si está en AUTOMATICO, aplicamos la lógica horaria normal
                if (!empty($horarioApertura) && !empty($horarioCierre) && in_array($tipoElemento, ['VENTANA', 'CORTINA', 'POSTIGON'])) {
                    $currentTimestamp = strtotime($currentTime);
                    $aperturaTimestamp = strtotime($horarioApertura);
                    $cierreTimestamp = strtotime($horarioCierre);
                    
                    if ($currentTimestamp >= $aperturaTimestamp && $currentTimestamp < $cierreTimestamp) {
                        $new_estado_calculado = 'ABIERTO';
                    } else {
                        $new_estado_calculado = 'CERRADO';
                    }
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']}: En modo AUTOMATICO");
                    log_message(LogLevel::INFO, "- Nuevo estado calculado: {$new_estado_calculado}");
                }
            }

            // Solo actualizamos la DB si hay cambios
            if (strtoupper($servo['estado_actual']) !== $new_estado_calculado || 
                strtoupper($servo['modo_operacion']) !== $new_modo_operacion) {
                try {
                    $this->servoModel->update($servo['id'], [
                        'estado_actual' => $new_estado_calculado,
                        'modo_operacion' => $new_modo_operacion,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']} actualizado: Estado={$new_estado_calculado}, Modo={$new_modo_operacion}");
                } catch (\Exception $e) {
                    log_message(LogLevel::ERROR, "Error al actualizar servo ID {$servo['id']}: " . $e->getMessage());
                }
            }

            $responseServos[] = [
                'id' => (string)$servo['id'],
                'pin' => (string)$servo['pin_gpio'],
                'estado' => strtoupper($new_estado_calculado),
                'modo' => strtoupper($new_modo_operacion)
            ];
        }

        return $this->response->setJSON(['servos' => $responseServos]);
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
}