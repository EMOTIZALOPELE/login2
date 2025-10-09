<?php

namespace App\Controllers;

use App\Models\CondicionanteModel;
use App\Models\ServoModel;
use App\Models\DispositivoModel;
use App\Models\ServosDiasModel;  // Agregamos este modelo para guardar días
use App\Models\DiasSemanasModel;  // Para cargar todos los días

class ConfiguracionController extends BaseController
{
    protected $servoModel;
    protected $dispositivoModel;
    protected $servosDiasModel;
    protected $diasSemanasModel;

    public function __construct()
    {
        $this->servoModel = new ServoModel();
        $this->dispositivoModel = new DispositivoModel();
        $this->servosDiasModel = new ServosDiasModel();  // Nuevo
        $this->diasSemanasModel = new DiasSemanasModel();  // Nuevo
    }

    /**
     * Muestra la página de configuración.
     * Carga datos actuales de servos para rellenar el formulario.
     */
    public function index()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = $session->get('id');
        $dispositivo = $this->dispositivoModel->where('usuario_id', $usuarioId)->first();

        if (!$dispositivo) {
            return redirect()->to('irainicio')->with('error', 'No tienes un dispositivo configurado.');
        }

        $dispositivoId = $dispositivo['id'];
        $condicionantes = [];
        $horarios_actuales = [];
        $dias_servos = [];  // Nuevo: Para cargar días pre-seleccionados

        // Buscar todos los servos de ese dispositivo
        $servos = $this->servoModel->where('dispositivo_id', $dispositivoId)->findAll();
        
        // Construir arrays para la vista
        foreach ($servos as $servo) {
            $tipo = strtolower($servo['tipo_elemento']);  // 'VENTANA' -> 'ventana'
            
            // Condicionantes
            $condicionantes[$tipo] = [
                'temp_min'              => $servo['temp_min_cierre'],
                'temp_max'              => $servo['temp_max_apertura'],
                'velocidad_viento_max'  => $servo['viento_max_cierre'],
                'permitir_lluvia'       => $servo['permitir_lluvia']
            ];

            // Horarios
            $horarios_actuales[$tipo] = [
                'apertura' => $servo['horario_apertura'],
                'cierre'   => $servo['horario_cierre']
            ];

            // Días pre-seleccionados (nuevo)
            $dias = $this->servosDiasModel->getDiasForServo($servo['id']);
            $dias_servos[$tipo] = array_column($dias, 'dia_semana_id');
        }

        // Todos los días disponibles para checkboxes
        $todos_dias = $this->diasSemanasModel->findAll();

        // Depuración: Log si no se cargan datos
        if (empty($servos)) {
            log_message('error', 'No se encontraron servos para dispositivo_id: ' . $dispositivoId);
        }

        return view('configuracion', [
            'condicionantes' => $condicionantes,
            'horarios'       => $horarios_actuales,
            'dias_servos'    => $dias_servos,  // Nuevo
            'todos_dias'     => $todos_dias,   // Nuevo
            'dispositivo_id' => $dispositivoId // Nuevo: Para hidden input en form
        ]);
    }

    /**
     * Guarda TODO: horarios, condicionantes y días.
     */
    public function guardar()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = $session->get('id');
        $dispositivoId = $this->request->getPost('dispositivo_id');

        // Depuración: Log datos recibidos
        log_message('debug', 'Datos POST en guardar(): ' . print_r($this->request->getPost(), true));

        $dispositivo = $this->dispositivoModel->where('usuario_id', $usuarioId)
                                              ->where('id', $dispositivoId)
                                              ->first();

        if (!$dispositivo) {
            log_message('error', 'Dispositivo no encontrado o no pertenece al usuario ' . $usuarioId);
            // Cargar datos y mostrar la vista con el error.
            $data = $this->loadAllData($usuarioId);
            $data['error'] = 'Dispositivo no encontrado.';
            return view('configuracion', $data);
        }

        $servos = $this->servoModel->where('dispositivo_id', $dispositivoId)->findAll();
        if (empty($servos)) {
            log_message('error', 'No se encontraron servos para dispositivo_id: ' . $dispositivoId);
            // Cargar datos y mostrar la vista con el error.
            $data = $this->loadAllData($usuarioId);
            $data['error'] = 'No se encontraron elementos para configurar.';
            return view('configuracion', $data);
        }

        try {
            foreach ($servos as $servo) {
                $tipo = strtolower($servo['tipo_elemento']);

                $datosParaActualizar = [
                    'horario_apertura'   => $this->request->getPost('open_hour_' . $tipo) ?: $servo['horario_apertura'],
                    'horario_cierre'     => $this->request->getPost('close_hour_' . $tipo) ?: $servo['horario_cierre'],
                    'temp_min_cierre'    => $this->request->getPost('min_temp_' . $tipo) ?: null,
                    'temp_max_apertura'  => $this->request->getPost('max_temp_' . $tipo) ?: null,
                    'viento_max_cierre'  => $this->request->getPost('max_wind_speed_' . $tipo) ?: null,
                    'permitir_lluvia'    => $this->request->getPost('allow_rain_' . $tipo) ? 1 : 0,
                ];

                $updateSuccess = $this->servoModel->update($servo['id'], $datosParaActualizar);

                if (!$updateSuccess) {
                    log_message('error', 'Error al actualizar servo ID ' . $servo['id'] . ': ' . print_r($this->servoModel->errors(), true));
                    throw new \Exception('Error al actualizar configuración.');
                }

                $diasSeleccionados = $this->request->getPost($tipo . '_days') ?? [];
                $this->servosDiasModel->saveDiasForServo($servo['id'], $diasSeleccionados);
            }

            log_message('info', 'Configuración guardada exitosamente para dispositivo_id: ' . $dispositivoId);
            // Redirigir si fue exitoso
            return redirect()->to('/configuracion')->with('success', '¡Configuración guardada correctamente!');

        } catch (\Exception $e) {
            log_message('error', 'Error al guardar configuración: ' . $e->getMessage());
            // Cargar datos y mostrar la vista con el error.
            $data = $this->loadAllData($usuarioId);
            $data['error'] = 'Error al guardar. Revisa los logs para detalles.';
            return view('configuracion', $data);
        }
    }

    /**
     * Método auxiliar para cargar todas las variables de la vista.
     */
    protected function loadAllData($usuarioId) {
        $dispositivo = $this->dispositivoModel->where('usuario_id', $usuarioId)->first();
        if (!$dispositivo) {
            return [];
        }
        $dispositivoId = $dispositivo['id'];
        $condicionantes = [];
        $horarios_actuales = [];
        $dias_servos = [];

        $servos = $this->servoModel->where('dispositivo_id', $dispositivoId)->findAll();
        foreach ($servos as $servo) {
            $tipo = strtolower($servo['tipo_elemento']);
            $condicionantes[$tipo] = [
                'temp_min'              => $servo['temp_min_cierre'],
                'temp_max'              => $servo['temp_max_apertura'],
                'velocidad_viento_max'  => $servo['viento_max_cierre'],
                'permitir_lluvia'       => $servo['permitir_lluvia']
            ];
            $horarios_actuales[$tipo] = [
                'apertura' => $servo['horario_apertura'],
                'cierre'   => $servo['horario_cierre']
            ];
            $dias = $this->servosDiasModel->getDiasForServo($servo['id']);
            $dias_servos[$tipo] = array_column($dias, 'dia_semana_id');
        }
        $todos_dias = $this->diasSemanasModel->findAll();

        return [
            'condicionantes' => $condicionantes,
            'horarios'       => $horarios_actuales,
            'dias_servos'    => $dias_servos,
            'todos_dias'     => $todos_dias,
            'dispositivo_id' => $dispositivoId
        ];
    }
}