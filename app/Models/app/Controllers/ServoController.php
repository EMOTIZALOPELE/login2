<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\HorariosModel; // Todavía puede ser útil para otras lógicas de horarios si las tienes
use App\Models\ServoModel;    // ¡Importar el nuevo ServoModel!
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
        // 1. Determinar si el identificador es numérico (ID del dispositivo) o una cadena (MAC)
        if (is_numeric($id_o_mac)) {
            $dispositivo = $this->dispositivoModel->find($id_o_mac);
        } else {
            $dispositivo = $this->dispositivoModel->where('codigo', $id_o_mac)->first();
        }

        // Para peticiones AJAX desde la web, verificamos la sesión del usuario.
        if ($this->request->isAJAX()) {
            if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
                log_message(LogLevel::ERROR, 'obtenerEstadoDispositivo: Acceso denegado a dispositivo con identificador ' . $id_o_mac . ' por usuario ' . session()->get('id') . '.');
                return $this->response->setJSON(['servos' => [], 'message' => 'Acceso denegado'])->setStatusCode(403);
            }
        }

        if (!$dispositivo || empty($dispositivo['usuario_id'])) {
            log_message(LogLevel::WARNING, 'obtenerEstadoDispositivo: Dispositivo con identificador ' . $id_o_mac . ' no encontrado o no reclamado.');
            return $this->response->setJSON(['servos' => [], 'message' => 'Dispositivo no encontrado o no reclamado']);
        }

        // 2. Obtener TODOS los servos asociados a este dispositivo
        $servosAsociados = $this->servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();

        if (empty($servosAsociados)) {
            log_message(LogLevel::INFO, 'obtenerEstadoDispositivo: No hay servos configurados para el dispositivo ' . $dispositivo['id'] . '.');
            return $this->response->setJSON(['servos' => [], 'message' => 'No hay servos configurados para este dispositivo.']);
        }

        $responseServos = [];
        $currentTime = date('H:i:s');

        foreach ($servosAsociados as $servo) {
            $tipoElemento = strtoupper($servo['tipo_elemento'] ?? 'OTRO');
            $horarioApertura = $servo['horario_apertura'];
            $horarioCierre = $servo['horario_cierre'];
            $new_estado_calculado = $servo['estado_actual'];
            $new_modo_operacion = $servo['modo_operacion'];

            // Si está en modo MANUAL, solo cambiamos a AUTOMATICO si estamos en un punto de cambio de horario
            if (strtoupper($servo['modo_operacion']) === 'MANUAL') {
                $estado_por_horario = null;
                if (!empty($horarioApertura) && !empty($horarioCierre) && in_array($tipoElemento, ['VENTANA', 'CORTINA', 'POSTIGON'])) {
                    if ($currentTime >= $horarioApertura && $currentTime < $horarioCierre) {
                        $estado_por_horario = 'ABIERTO';
                    } else {
                        $estado_por_horario = 'CERRADO';
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
                if (abs($horario_actual - $horario_apertura_timestamp) <= 60 || 
                    abs($horario_actual - $horario_cierre_timestamp) <= 60) {
                    $cerca_del_horario = true;
                }

                if ($estado_por_horario !== null && 
                    (strtoupper($servo['estado_actual']) !== $estado_por_horario || $cerca_del_horario) && 
                    $tiempo_transcurrido >= 300) { // 300 segundos = 5 minutos
                    $new_estado_calculado = $estado_por_horario;
                    $new_modo_operacion = 'AUTOMATICO';
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Cambiando de MANUAL a AUTOMATICO por horario después de {$tiempo_transcurrido} segundos. Nuevo estado: {$new_estado_calculado}");
                } else {
                    // Mantener el estado actual y modo MANUAL
                    $new_estado_calculado = $servo['estado_actual'];
                    $new_modo_operacion = 'MANUAL';
                    log_message(LogLevel::INFO, "Servo ID {$servo['id']}: Manteniendo modo MANUAL. Tiempo transcurrido: {$tiempo_transcurrido} segundos");
                }
            } else {
                // Si está en AUTOMATICO, aplicamos la lógica horaria normal
                if (!empty($horarioApertura) && !empty($horarioCierre) && in_array($tipoElemento, ['VENTANA', 'CORTINA', 'POSTIGON'])) {
                    if ($currentTime >= $horarioApertura && $currentTime < $horarioCierre) {
                        $new_estado_calculado = 'ABIERTO';
                    } else {
                        $new_estado_calculado = 'CERRADO';
                    }
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
}