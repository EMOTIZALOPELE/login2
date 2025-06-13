<?php

namespace App\Controllers;

use App\Models\DispositivoModel;

class ServoController extends BaseController
{
    protected $dispositivoModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
    }

    /**
     * Carga la vista de control del servo, pasándole los datos del dispositivo.
     */
    public function estado($dispositivo_id = null)
    {
        if (empty($dispositivo_id)) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'No se ha especificado un dispositivo.');
        }

        $dispositivo = $this->dispositivoModel->find($dispositivo_id);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return redirect()->to(base_url('/irainicio'))->with('error', 'No tienes permiso para controlar este dispositivo.');
        }

        $data = ['dispositivo' => $dispositivo];
        return view('ServoView', $data);
    }

    /**
     * El Frontend (página web) llama a esta función para establecer el estado deseado.
     */
    public function actualizarEstado($dispositivo_id, $estado)
    {
        $dispositivo = $this->dispositivoModel->find($dispositivo_id);
        if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Acceso denegado.'])->setStatusCode(403);
        }

        $data = ['estado' => strtoupper($estado)];
        if ($this->dispositivoModel->update($dispositivo_id, $data)) {
            return $this->response->setJSON(['status' => 'ok', 'estado' => strtoupper($estado)]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'El servidor no pudo procesar la orden.'])->setStatusCode(500);
        }
    }

    /**
     * ESTA ES LA FUNCIÓN QUE SE USARÁ TANTO PARA LA PÁGINA WEB COMO PARA EL ESP32
     */
    public function obtenerEstadoDispositivo($id_o_mac)
    {
        // Determinar si el identificador es numérico (ID) o una cadena (MAC)
        if (is_numeric($id_o_mac)) {
            $dispositivo = $this->dispositivoModel->find($id_o_mac);
        } else {
            $dispositivo = $this->dispositivoModel->where('codigo', $id_o_mac)->first();
        }

        // Para peticiones AJAX desde la web, verificamos la sesión del usuario
        if ($this->request->isAJAX()) {
             if (!$dispositivo || $dispositivo['usuario_id'] != session()->get('id')) {
                return $this->response->setJSON(['estado' => 'ERROR'])->setStatusCode(403);
             }
        }
        
        if ($dispositivo && isset($dispositivo['estado'])) {
            return $this->response->setJSON(['estado' => strtoupper($dispositivo['estado'])]);
        } else {
            return $this->response->setJSON(['estado' => 'DESCONOCIDO']);
        }
    }
}
