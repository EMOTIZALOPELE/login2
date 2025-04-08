<?php

namespace App\Controllers;

use App\Models\HorarioVentanaModel;
use CodeIgniter\RESTful\ResourceController;

class HorarioVentanaController extends ResourceController
{
    protected $modelName = 'App\Models\HorarioVentanaModel';
    protected $format = 'json';

    public function index($disenoId = null)
    {
        if ($disenoId === null) {
            return $this->fail('ID de diseño no proporcionado');
        }

        $horario = $this->model->getHorariosByDiseno($disenoId);
        if ($horario === null) {
            return $this->failNotFound('No se encontraron horarios para este diseño');
        }

        return $this->respond($horario);
    }

    public function update($disenoId = null)
    {
        if ($disenoId === null) {
            return $this->fail('ID de diseño no proporcionado');
        }

        $json = $this->request->getJSON();
        
        if ($json && isset($json->estado)) {
            // Actualizar solo el estado
            if ($this->model->actualizarEstado($disenoId, $json->estado)) {
                return $this->respond(['message' => 'Estado actualizado correctamente']);
            }
            return $this->fail('Error al actualizar el estado');
        }

        // Actualizar horarios
        $data = [
            'hora_apertura' => $this->request->getPost('hora_apertura'),
            'hora_cierre' => $this->request->getPost('hora_cierre'),
            'dias_semana' => $this->request->getPost('dias_semana')
        ];

        if ($this->model->updateHorarios($disenoId, $data)) {
            return $this->respond(['message' => 'Horarios actualizados correctamente']);
        }

        return $this->fail('Error al actualizar los horarios');
    }

    public function getEstadoVentana()
    {
        $disenoId = $this->request->getGet('diseno_id');
        if (!$disenoId) {
            return $this->fail('ID de diseño requerido');
        }

        $horario = $this->model->getHorariosByDiseno($disenoId);
        if ($horario === null) {
            return $this->failNotFound('No se encontraron horarios para este diseño');
        }

        $estado = [
            'estado_actual' => $horario['estado_actual'],
            'hora_actual' => date('H:i:s'),
            'ventana_apertura' => $horario['hora_apertura'],
            'ventana_cierre' => $horario['hora_cierre'],
            'dias_semana' => $horario['dias_semana']
        ];

        return $this->respond($estado);
    }

    public function configurar($disenoId)
    {
        return redirect()->to(base_url('configuracion/' . $disenoId));
    }
} 