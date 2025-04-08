<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\HorarioModel;
use CodeIgniter\API\ResponseTrait;

class HorarioController extends BaseController
{
    use ResponseTrait;

    protected $horarioModel;

    public function __construct()
    {
        $this->horarioModel = new HorarioModel();
    }

    public function getHorarios()
    {
        $disenoId = $this->request->getGet('diseno_id');
        
        if (!$disenoId) {
            return $this->fail('ID de diseño requerido', 400);
        }

        $horario = $this->horarioModel->getHorariosByDiseno($disenoId);
        
        if (!$horario) {
            return $this->fail('Horario no encontrado', 404);
        }

        return $this->respond([
            'ventana_apertura' => $horario['ventana_apertura'],
            'ventana_cierre' => $horario['ventana_cierre'],
            'dias_semana' => $horario['dias_semana'],
            'estado_actual' => $horario['estado_actual']
        ]);
    }

    public function actualizarEstado()
    {
        $json = $this->request->getJSON();
        
        if (!$json || !isset($json->diseno_id) || !isset($json->estado)) {
            return $this->fail('Datos inválidos', 400);
        }

        $result = $this->horarioModel->actualizarEstado($json->diseno_id, $json->estado);
        
        if (!$result) {
            return $this->fail('Error al actualizar el estado', 500);
        }

        return $this->respond(['message' => 'Estado actualizado correctamente']);
    }
} 