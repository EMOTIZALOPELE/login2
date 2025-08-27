<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\HorariosModel; 
use App\Models\ServoModel;    
use CodeIgniter\API\ResponseTrait;
use Psr\Log\LogLevel;

class ServoController extends BaseController
{
    use ResponseTrait;

    protected $dispositivoModel;
    protected $horariosModel;
    protected $servoModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
        $this->horariosModel = new HorariosModel();
        $this->servoModel = new ServoModel();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    }

    /**
     * Carga la vista de control del servo.
     */
    public function estado($dispositivo_id = null)
    {
        if (empty($dispositivo_id)) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'No se ha especificado un dispositivo.');
        }

        $dispositivo = $this->dispositivoModel->find($dispositivo_id);

        if (!$dispositivo) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'Dispositivo no encontrado.');
        }

        if ($dispositivo['usuario_id'] != session()->get('id')) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'No tienes permiso para controlar este dispositivo.');
        }

        $servos = $this->servoModel->where('dispositivo_id', $dispositivo_id)->findAll();

        $data = [
            'dispositivo' => $dispositivo,
            'servos_asociados' => $servos
        ];
        return view('ServoView', $data);
    }

    /**
     * Establece el estado manual de un servo y calcula dinámicamente el tiempo de expiración.
     */
    public function actualizarEstado($servo_id, $estado)
    {
        $servo = $this->servoModel->find($servo_id);
        if (!$servo) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Servo no encontrado.'])->setStatusCode(404);
        }

        $dispositivo = $this->dispositivoModel->find($servo['dispositivo_id']);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Acceso denegado.'])->setStatusCode(403);
        }

        $timezone = new \DateTimeZone('America/Argentina/Buenos_Aires');
        $ahora = new \DateTime('now', $timezone);
        $minutosDeExpiracion = 1; // Valor por defecto: 1 minuto

        // Determinar qué horario buscar (apertura o cierre)
        $tipoHorario = ($estado === 'abierto') ? 'horario_apertura' : 'horario_cierre';
        
        // Verificar si hay un horario programado para esa acción
        if (!empty($servo[$tipoHorario])) {
            $horaProgramada = \DateTime::createFromFormat('H:i:s', $servo[$tipoHorario], $timezone);
            if ($horaProgramada) {
                $horaProgramada->setDate((int)$ahora->format('Y'), (int)$ahora->format('m'), (int)$ahora->format('d'));

                if ($horaProgramada < $ahora) {
                    $horaProgramada->modify('+1 day');
                }

                $diferencia = $ahora->diff($horaProgramada);
                $minutosHastaHorario = ($diferencia->days * 24 * 60) + ($diferencia->h * 60) + $diferencia->i;
                $minutosDeExpiracion = $minutosHastaHorario + 1;
            }
        }
        
        $expires = (clone $ahora)->modify("+" . $minutosDeExpiracion . " minutes");

        $dataToUpdate = [
            'estado_actual' => strtoupper($estado),
            'modo_operacion' => 'MANUAL',
            'manual_override_expires' => $expires->format('Y-m-d H:i:s')
        ];

        try {
            $this->servoModel->update($servo_id, $dataToUpdate);
            return $this->response->setJSON([
                'status' => 'ok',
                'estado' => $dataToUpdate['estado_actual'],
                'servo_id' => $servo_id,
                'modo' => $dataToUpdate['modo_operacion']
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar estado manual: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error interno del servidor.'])->setStatusCode(500);
        }
    }

    // ... (El resto de tus funciones como obtenerEstadoDispositivo, etc., se mantienen igual)
    public function obtenerEstadoDispositivo($macAddress)
    {
        $dispositivo = $this->dispositivoModel->where('codigo', $macAddress)->first();
        if (!$dispositivo) {
            return $this->failNotFound('Dispositivo no encontrado');
        }

        $timezone = new \DateTimeZone('America/Argentina/Buenos_Aires');
        $nowFormatted = (new \DateTime('now', $timezone))->format('Y-m-d H:i:s');

        $servosExpirados = $this->servoModel
            ->where('dispositivo_id', $dispositivo['id'])
            ->where('modo_operacion', 'MANUAL')
            ->where('manual_override_expires IS NOT NULL')
            ->where('manual_override_expires <', $nowFormatted)
            ->findAll();

        if (!empty($servosExpirados)) {
            foreach ($servosExpirados as $servo) {
                $this->servoModel->update($servo['id'], [
                    'modo_operacion' => 'AUTOMATICO',
                    'manual_override_expires' => null
                ]);
                log_message('info', 'Servo ID ' . $servo['id'] . ' revertido a modo AUTOMATICO por expiración.');
            }
        }
        
        $servos = $this->servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();

        // ... (resto de la lógica de clima y estado)
        return $this->respond(['servos' => $servos]); // Ejemplo simplificado
    }
}
