<?php

namespace App\Controllers;

use App\Models\CondicionantesModel;
use App\Models\HorariosModel;

class Configuracion extends BaseController
{
    protected $condicionantesModel;
    protected $horariosModel;

    public function __construct()
    {
        $this->condicionantesModel = new CondicionantesModel();
        $this->horariosModel = new HorariosModel();
    }

    public function index($vcpId)
    {
        // Obtener datos existentes
        $data = [
            'title' => 'Configurar Dispositivos Inteligentes',
            'vcpId' => $vcpId,
            'horarios' => $this->horariosModel->getByVcpId($vcpId),
            'condicionantes' => $this->condicionantesModel->getByVcpId($vcpId)
        ];

        return view('configuracion', $data);
    }

    public function guardar()
    {
        $vcpId = $this->request->getPost('diseno_id');
        
        // Procesar horarios (ya implementado)
        // ...

        // Procesar condicionantes para cada dispositivo
        $dispositivos = ['ventana', 'cortina', 'postigon'];
        
        foreach ($dispositivos as $dispositivo) {
            $dispositivoId = $this->getDispositivoId($dispositivo); // Implementa esta función según tu DB
            
            $condicionantesData = [
                'dispositivo_id' => $dispositivoId,
                'temp_min' => $this->request->getPost("min_temp_{$dispositivo}"),
                'temp_max' => $this->request->getPost("max_temp_{$dispositivo}"),
                'velocidad_viento_max' => $this->request->getPost("max_wind_speed_{$dispositivo}"),
                'permitir_lluvia' => $this->request->getPost("allow_rain_{$dispositivo}") ? 1 : 0,
                'ID_VCP' => $vcpId
            ];

            $this->condicionantesModel->saveCondicionantes($condicionantesData);
        }

        return redirect()->back()->with('success', 'Configuración guardada exitosamente');
    }

    // Función auxiliar para mapear nombres de dispositivos a IDs
    protected function getDispositivoId($nombreDispositivo)
    {
        // Implementa esta función según tu estructura de base de datos
        // Ejemplo:
        $map = [
            'ventana' => 1,
            'cortina' => 2,
            'postigon' => 3
        ];
        
        return $map[$nombreDispositivo] ?? null;
    }
}