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
        $horaActual = date('H:i:s');
        $disenoId = $this->request->getGet('diseno_id');

        $horario = $this->model->getHorariosByDiseno($disenoId);
        if ($horario === null) {
            return $this->failNotFound('No se encontraron horarios para este diseño');
        }

        $estado = [
            'hora_actual' => $horaActual,
            'ventana_apertura' => $horario['hora_apertura'],
            'ventana_cierre' => $horario['hora_cierre']
        ];

        return $this->respond($estado);
    }

    public function configurar($disenoId)
    {
        // Redirigir a la vista de configuración existente
        return redirect()->to(base_url('configuracion/' . $disenoId));
    }
} 