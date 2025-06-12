<?php

namespace App\Controllers;

use App\Models\DispositivoModel; 

class ServoController extends BaseController
{
    // El controlador ahora trabajará directamente con DispositivoModel
    protected $dispositivoModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
    }

    /**
     * Carga la vista principal de control de servo (ServoView)
     */
    public function estado()
    {
        // Simplemente carga la vista. El JavaScript se encargará del resto.
        return view('ServoView');
    }

    /**
     * Actualiza el estado de un dispositivo específico.
     * Ahora recibe el ID del dispositivo y el nuevo estado.
     */
    public function actualizarEstado($dispositivo_id, $estado)
    {
        // Verificamos que el dispositivo pertenezca al usuario actual para seguridad
        $dispositivo = $this->dispositivoModel->find($dispositivo_id);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return $this->failForbidden('No tienes permiso para acceder a este dispositivo.');
        }

        $data = [
            'estado' => strtoupper($estado),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $success = $this->dispositivoModel->update($dispositivo_id, $data);

        if (!$success) {
            return $this->response->setJSON([
                'status' => 'error',
                'errores' => $this->dispositivoModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ok',
            'estado' => strtoupper($estado)
        ]);
    }

    /**
     * Obtiene el último estado conocido de un dispositivo específico.
     */
    public function obtenerUltimoEstado($dispositivo_id)
    {
        // Verificamos que el dispositivo pertenezca al usuario actual
        $dispositivo = $this->dispositivoModel->find($dispositivo_id);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return $this->failForbidden('No tienes permiso para acceder a este dispositivo.');
        }

        if ($dispositivo && isset($dispositivo['estado'])) {
            return $this->response->setJSON(['estado' => strtoupper($dispositivo['estado'])]);
        } else {
            return $this->response->setJSON(['estado' => 'DESCONOCIDO']);
        }
    }
}