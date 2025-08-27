<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CondicionanteModel;
use App\Models\ServoModel;
use App\Models\DispositivoModel;

class ConfiguracionController extends BaseController
{

     public function __construct()
    {
        $this->servoModel = new ServoModel();
        $this->dispositivoModel = new DispositivoModel();
    }

    /**
     * Muestra la página de configuración.
     * Lee los datos actuales de los servos para rellenar el formulario.
     */
    public function index()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        // --- LÓGICA PARA CARGAR DATOS Y EVITAR EL ERROR ---
        
        // Asumimos que el usuario tiene UN dispositivo asignado.
        // Si tienes varios, necesitarás una lógica para seleccionarlo.
        $dispositivo = $this->dispositivoModel->where('usuario_id', $session->get('id'))->first();

        if (!$dispositivo) {
            return redirect()->to('irainicio')->with('error', 'No tienes un dispositivo configurado.');
        }

        $condicionantes = [];
        $horarios_actuales = [];

        // Buscar todos los servos de ese dispositivo
        $servos = $this->servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();
        
        // Construir los arrays que la vista necesita
        foreach ($servos as $servo) {
            $tipo = strtolower($servo['tipo_elemento']); // 'VENTANA' -> 'ventana'
            
            // Para rellenar los campos de condicionantes
            $condicionantes[$tipo] = [
                'temp_min'              => $servo['temp_min_cierre'],
                'temp_max'              => $servo['temp_max_apertura'],
                'velocidad_viento_max'  => $servo['viento_max_cierre'],
                'permitir_lluvia'       => $servo['permitir_lluvia']
            ];

            // Para rellenar los campos de horarios
            $horarios_actuales[$tipo] = [
                'apertura' => $servo['horario_apertura'],
                'cierre'   => $servo['horario_cierre']
            ];
        }

        return view('configuracion', [
            'condicionantes' => $condicionantes,
            'horarios'       => $horarios_actuales, // Pasamos los horarios a la vista
            // 'diseno'      => $diseno, // Si necesitas pasar el diseño, debes cargarlo aquí
        ]);
    }

    /**
     * Guarda la configuración enviada desde el formulario.
     * Actualiza los horarios Y las condiciones en la tabla `servos`.
     */
    public function guardar()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = $session->get('id');
        $dispositivo = $this->dispositivoModel->where('usuario_id', $usuarioId)->first();

        if (!$dispositivo) {
            return redirect()->to('irainicio')->with('error', 'Dispositivo no encontrado para guardar configuración.');
        }
        $dispositivoId = $dispositivo['id'];

        $elementos = ['ventana', 'cortina', 'postigon'];

        try {
            foreach ($elementos as $elemento) {
                $tipoElementoDB = strtoupper($elemento);

                // Recolectar todos los datos del formulario para este elemento
                $datosParaActualizar = [
                    'horario_apertura'   => $this->request->getPost('open_hour_' . $elemento),
                    'horario_cierre'     => $this->request->getPost('close_hour_' . $elemento),
                    'temp_min_cierre'    => $this->request->getPost('min_temp_' . $elemento) ?: null, // Guarda NULL si está vacío
                    'temp_max_apertura'  => $this->request->getPost('max_temp_' . $elemento) ?: null, // Guarda NULL si está vacío
                    'viento_max_cierre'  => $this->request->getPost('max_wind_speed_' . $elemento) ?: null, // Guarda NULL si está vacío
                    'permitir_lluvia'    => $this->request->getPost('allow_rain_' . $elemento) ? 1 : 0,
                ];

                // Actualizar la base de datos en la tabla `servos`
                $this->servoModel
                     ->where('dispositivo_id', $dispositivoId)
                     ->where('tipo_elemento', $tipoElementoDB)
                     ->set($datosParaActualizar)
                     ->update();
            }

            return redirect()->to('/configuracion')->with('success', '¡Configuración guardada correctamente!');
        
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar configuración: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar la configuración.');
        }
    }


    public function inicio(){
        return view('inicio');
    }
}