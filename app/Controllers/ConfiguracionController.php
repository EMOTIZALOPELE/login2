<?php

namespace App\Controllers;

use App\Models\ServoModel;
use App\Models\DispositivoModel;
use App\Models\ServosDiasModel;
use App\Models\DiasSemanasModel;

class ConfiguracionController extends BaseController
{
    protected $servoModel;
    protected $dispositivoModel;
    protected $servosDiasModel;
    protected $diasSemanasModel;
    protected $db; // Para transacciones

    public function __construct()
    {
        $this->servoModel = new ServoModel();
        $this->dispositivoModel = new DispositivoModel();
        $this->servosDiasModel = new ServosDiasModel();
        $this->diasSemanasModel = new DiasSemanasModel();
        $this->db = \Config\Database::connect(); // Inicializa la conexión a la BD
    }

   /**
     * Muestra la página de configuración para un DISPOSITIVO ESPECÍFICO.
     */
    public function index($dispositivo_id = null) 
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to('login');
        }

        if (empty($dispositivo_id)) {
            // Redirección si la URL es /configuracion/ (sin número)
            return redirect()->to('irainicio')->with('error', 'No se especificó un dispositivo para configurar.');
        }

        $usuarioId = $session->get('id');

        $dispositivo = $this->dispositivoModel
                            ->where('usuario_id', $usuarioId)
                            ->where('id', $dispositivo_id)
                            ->first();

        if (!$dispositivo) {
            // ----- ¡AQUÍ ESTÁ EL CAMBIO! -----
            // Le pasamos el error a la sesión (flash) para que inicio.php lo muestre
            $errorMessage = "Error: No tienes permiso para acceder al dispositivo ID: $dispositivo_id (Usuario: $usuarioId)";
            log_message('error', $errorMessage); // Deja un registro en tus logs
            
            return redirect()->to('irainicio')->with('error', $errorMessage);
        }
        
        // Si todo va bien, carga los datos y muestra la vista
        $data = $this->loadAllData($usuarioId, $dispositivo_id); 
        return view('configuracion', $data);
    }
    /**
     * Guarda los datos de configuración (Actualiza o Crea).
     */
    public function guardar()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to('login');
        }

        $usuarioId = $session->get('id');
        $dispositivoId = $this->request->getPost('dispositivo_id');

        // 1. Verificar que el dispositivo pertenece al usuario
        $dispositivo = $this->dispositivoModel
                            ->where('usuario_id', $usuarioId)
                            ->where('id', $dispositivoId)
                            ->first();

        if (!$dispositivo) {
            return redirect()->back()->with('error', 'Dispositivo no válido o no autorizado.');
        }

        // 2. Definir los tipos de servo
        $tipos_servo = ['ventana', 'cortina', 'postigon'];
        
        // --- ¡AQUÍ ESTÁ EL CAMBIO! ---
        // Definimos tu mapa de pines por defecto
        $pin_map = [
            'ventana'  => 2,
            'cortina'  => 4,
            'postigon' => 16,
        ];
        // ---------------------------------

        // 3. Iniciar una transacción
        $this->db->transStart();

        try {
            // 4. Iterar sobre cada TIPO de servo
            foreach ($tipos_servo as $tipo) {
                
                // --- a. Recolectar datos del POST ---
                $datosServo = [
                    'horario_apertura'  => $this->request->getPost('open_hour_' . $tipo),
                    'horario_cierre'    => $this->request->getPost('close_hour_' . $tipo),
                    'temp_min_cierre'   => $this->request->getPost('min_temp_' . $tipo) ?: null,
                    'temp_max_apertura' => $this->request->getPost('max_temp_' . $tipo) ?: null,
                    'viento_max_cierre' => $this->request->getPost('max_wind_speed_' . $tipo) ?: null,
                    'permitir_lluvia'   => $this->request->getPost('allow_rain_' . $tipo) ? 1 : 0,
                ];

                $diasSeleccionados = $this->request->getPost($tipo . '_days') ?? [];

                // --- b. Lógica "Upsert": Buscar si ya existe ---
                $servoExistente = $this->servoModel
                    ->where('dispositivo_id', $dispositivoId)
                    ->where('tipo_elemento', $tipo)
                    ->first();

                $servo_id = null;

                if ($servoExistente) {
                    // --- ACTUALIZAR ---
                    // No tocamos el pin_gpio, solo actualizamos los datos del formulario
                    $this->servoModel->update($servoExistente['id'], $datosServo);
                    $servo_id = $servoExistente['id'];
                
                } else {
                    // --- CREAR ---
                    $datosServo['dispositivo_id'] = $dispositivoId;
                    $datosServo['tipo_elemento']  = $tipo;
                    
                    // Valores por defecto
                    
                    // --- ¡AQUÍ USAMOS EL MAPA DE PINES! ---
                    // Asigna el pin 2, 4, o 16 según el $tipo.
                    // Si $tipo no está en el mapa, asigna 0 como fallback.
                    $datosServo['pin_gpio']       = $pin_map[$tipo] ?? 0;
                    // ----------------------------------------
                    
                    $datosServo['nombre_servo']   = ucfirst($tipo); 
                    $datosServo['estado_actual']  = 'CERRADO';
                    $datosServo['modo_operacion'] = 'AUTOMATICO';

                    $this->servoModel->insert($datosServo);
                    $servo_id = $this->servoModel->getInsertID();
                }

                // --- c. Actualizar los días de la semana ---
                if ($servo_id) {
                    $this->servosDiasModel->saveDiasForServo($servo_id, $diasSeleccionados);
                }
            } // Fin del bucle foreach

            // 5. Finalizar la transacción
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->back()->with('error', 'Error al guardar la configuración.');
            } else {
                $this->db->transCommit();
                return redirect()->to('/configuracion/'. $dispositivoId)->with('success', '¡Configuración guardada correctamente!');
            }

        } catch (\Exception $e) {
            // Capturar cualquier error
            $this->db->transRollback();
            log_message('error', '[ConfiguracionController::guardar] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
    


    /**
     * Carga todos los datos necesarios para la vista de configuración
     */
    protected function loadAllData($usuarioId, $dispositivo_id) // <-- ACEPTA EL ID
    {
        // 1. Estructura de datos por defecto
        $data = [
            'condicionantes' => [],
            'horarios'       => [],
            'dias_servos'    => [],
            'servos'         => [], 
            'todos_dias'     => $this->diasSemanasModel->findAll(),
            'dispositivo_id' => $dispositivo_id // Pasa el ID a la vista
        ];

        // 2. Buscar dispositivo (la verificación ya se hizo en index(), pero la necesitamos)
        $dispositivo = $this->dispositivoModel->where('id', $dispositivo_id)->first();
        if (!$dispositivo) {
             \Config\Services::session()->setFlashdata('error', 'Dispositivo no encontrado.');
            return $data; // Devuelve datos vacíos
        }

        // 3. Cargar servos SÓLO para este dispositivo
        $servos = $this->servoModel->where('dispositivo_id', $dispositivo_id)->findAll();

        // 4. Procesar servos encontrados
        foreach ($servos as $servo) {
            $tipo = strtolower($servo['tipo_elemento']); 

            $data['servos'][$tipo] = $servo;
            $data['condicionantes'][$tipo] = [
                'temp_min'             => $servo['temp_min_cierre'],
                'temp_max'             => $servo['temp_max_apertura'],
                'velocidad_viento_max' => $servo['viento_max_cierre'],
                'permitir_lluvia'      => $servo['permitir_lluvia']
            ];
            $data['horarios'][$tipo] = [
                'apertura' => $servo['horario_apertura'],
                'cierre'   => $servo['horario_cierre']
            ];
            
            $dias = $this->servosDiasModel->getDiasForServo($servo['id']);
            $data['dias_servos'][$tipo] = array_column($dias, 'dia_semana_id'); 
        }
        
        return $data;
    }
}