<?php

namespace App\Controllers;

<<<<<<< HEAD
use App\Models\ServoModel;
use App\Models\DispositivoModel;
use App\Models\ServosDiasModel;
use App\Models\DiasSemanasModel;
use App\Models\PagoModel;
=======
<<<<<<< HEAD
use App\Models\ServoModel;
use App\Models\DispositivoModel;
use App\Models\ServosDiasModel;
use App\Models\DiasSemanasModel;
=======
use App\Models\CondicionanteModel;
use App\Models\ServoModel;
use App\Models\DispositivoModel;
use App\Models\ServosDiasModel;  // Agregamos este modelo para guardar días
use App\Models\DiasSemanasModel;  // Para cargar todos los días
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

class ConfiguracionController extends BaseController
{
    protected $servoModel;
    protected $dispositivoModel;
    protected $servosDiasModel;
    protected $diasSemanasModel;
<<<<<<< HEAD
    protected $pagoModel;
    protected $db;
=======
<<<<<<< HEAD
    protected $db; // Para transacciones
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

    public function __construct()
    {
        $this->servoModel = new ServoModel();
        $this->dispositivoModel = new DispositivoModel();
<<<<<<< HEAD
        $this->servosDiasModel = new ServosDiasModel();
        $this->diasSemanasModel = new DiasSemanasModel();
        $this->pagoModel = new PagoModel();
        $this->db = \Config\Database::connect();
    }

   public function index($dispositivo_id = null) 
=======
<<<<<<< HEAD
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
=======
        $this->servosDiasModel = new ServosDiasModel();  // Nuevo
        $this->diasSemanasModel = new DiasSemanasModel();  // Nuevo
    }

    /**
     * Muestra la página de configuración.
     * Carga datos actuales de servos para rellenar el formulario.
     */
    public function index()
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to('login');
        }

<<<<<<< HEAD
        if (empty($dispositivo_id)) {
            return redirect()->to('irainicio')->with('error', 'No se especificó un dispositivo para configurar.');
        }

        $usuarioId = $session->get('id');

        $dispositivo = $this->dispositivoModel
                            ->where('usuario_id', $usuarioId)
                            ->where('id', $dispositivo_id)
                            ->first();

        if (!$dispositivo) {
            $errorMessage = "Error: No tienes permiso para acceder al dispositivo ID: $dispositivo_id (Usuario: $usuarioId)";
            log_message('error', $errorMessage);
            return redirect()->to('irainicio')->with('error', $errorMessage);
        }
        
        // --- LÓGICA MEJORADA: BUSCAR PAGO ESPECÍFICO ---
        $servos_disponibles = [];
        $layout_class = '';
        
        try {
            // PRIMERO: Buscar el pago específico usando pago_id del dispositivo
            $pago = null;
            
            if (!empty($dispositivo['pago_id'])) {
                $pago = $this->pagoModel
                            ->where('id', $dispositivo['pago_id'])
                            ->where('usuario_id', $usuarioId)
                            ->first();
                
                log_message('debug', "Pago específico del dispositivo {$dispositivo_id}: " . ($pago ? $pago['id'] : 'No encontrado'));
            }
            
            if ($pago && !empty($pago['tipos_servos'])) {
                $servos_disponibles = explode(',', $pago['tipos_servos']);
                log_message('debug', "Servos desde pago {$pago['id']}: " . implode(', ', $servos_disponibles));
            } else {
                // Si no encontramos pago específico, usar los servos ya configurados
                $servos_existentes = $this->servoModel
                                        ->where('dispositivo_id', $dispositivo_id)
                                        ->findAll();
                
                if (!empty($servos_existentes)) {
                    $servos_disponibles = array_map(function($servo) {
                        return strtolower($servo['tipo_elemento']);
                    }, $servos_existentes);
                    log_message('debug', "Servos desde configuración existente: " . implode(', ', $servos_disponibles));
                } else {
                    // Si no hay nada, mostrar todos (pero esto debería ser temporal)
                    $servos_disponibles = ['ventana', 'cortina', 'postigon'];
                    log_message('debug', "Usando servos por defecto (sin pago específico)");
                }
            }
            
            // Determinar la clase CSS para el layout
            $count_servos = count($servos_disponibles);
            if ($count_servos === 1) {
                $layout_class = 'form-1-servo';
            } elseif ($count_servos === 2) {
                $layout_class = 'form-2-servos';
            } else {
                $layout_class = ''; // 3 servos - layout normal
            }
            
            log_message('debug', "Dispositivo {$dispositivo_id} - pago_id: " . ($dispositivo['pago_id'] ?? 'No asignado') . 
                                ", servos: " . implode(', ', $servos_disponibles) . 
                                ", layout: $layout_class");
            
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener servos disponibles: ' . $e->getMessage());
            $servos_disponibles = ['ventana', 'cortina', 'postigon'];
        }
        
        // --- CARGAR DATOS EXISTENTES (REEMPLAZO DE loadAllData) ---
        $data = [
            'condicionantes' => [],
            'horarios'       => [],
            'dias_servos'    => [],
            'servos'         => [], 
            'todos_dias'     => $this->diasSemanasModel->findAll(),
            'dispositivo_id' => $dispositivo_id
        ];

        $dispositivo = $this->dispositivoModel->where('id', $dispositivo_id)->first();
        if (!$dispositivo) {
            \Config\Services::session()->setFlashdata('error', 'Dispositivo no encontrado.');
        } else {
            $servos = $this->servoModel->where('dispositivo_id', $dispositivo_id)->findAll();

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
        }
        
        // Agregar las nuevas variables
        $data['servos_disponibles'] = $servos_disponibles;
        $data['layout_class'] = $layout_class;
        
        return view('configuracion', $data);
    }
    /**
     * Método para encontrar el pago específico de un dispositivo
     * Basado en tu lógica existente que SÍ funciona
     */
    protected function encontrarPagoPorDispositivo($dispositivo_id, $usuarioId)
    {
        // Intenta diferentes métodos para encontrar el pago correcto
        
        // Método 1: Buscar por dispositivo_id si existe la columna
        if ($this->pagoModel->db->fieldExists('dispositivo_id', 'pagos')) {
            return $this->pagoModel
                    ->where('dispositivo_id', $dispositivo_id)
                    ->where('usuario_id', $usuarioId)
                    ->first();
        }
        
        // Método 2: Buscar en los detalles (JSON) por referencia al dispositivo
        $pagos = $this->pagoModel
                    ->where('usuario_id', $usuarioId)
                    ->findAll();
        
        foreach ($pagos as $pago) {
            // Si los detalles contienen referencia al dispositivo
            if (strpos($pago['detalles'] ?? '', (string)$dispositivo_id) !== false) {
                return $pago;
            }
            
            // Si el order_id contiene referencia al dispositivo
            if (strpos($pago['order_id'] ?? '', (string)$dispositivo_id) !== false) {
                return $pago;
            }
        }
        
        // Método 3: Buscar el pago más reciente que tenga tipos_servos
        return $this->pagoModel
                ->where('usuario_id', $usuarioId)
                ->where('tipos_servos IS NOT NULL')
                ->where("tipos_servos != ''")
                ->orderBy('created_at', 'DESC')
                ->first();
    }

    public function guardar()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to('login');
        }

=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        $usuarioId = $session->get('id');
        $dispositivoId = $this->request->getPost('dispositivo_id');

        $dispositivo = $this->dispositivoModel
                            ->where('usuario_id', $usuarioId)
                            ->where('id', $dispositivoId)
                            ->first();

        if (!$dispositivo) {
<<<<<<< HEAD
            return redirect()->back()->with('error', 'Dispositivo no válido o no autorizado.');
        }

        // --- LÓGICA CORREGIDA: SOLO PROCESAR SERVOS DISPONIBLES ---
        $servos_disponibles = [];
        
        try {
            // Buscar el pago específico del dispositivo para saber qué servos están disponibles
            $pago = $this->pagoModel
                        ->where('id', $dispositivo['pago_id'] ?? 0)
                        ->where('usuario_id', $usuarioId)
                        ->first();
            
            if ($pago && !empty($pago['tipos_servos'])) {
                $servos_disponibles = explode(',', $pago['tipos_servos']);
                log_message('debug', "Guardar - Servos disponibles desde pago: " . implode(', ', $servos_disponibles));
            } else {
                // Si no hay pago, usar los servos que ya están configurados
                $servos_existentes = $this->servoModel
                                        ->where('dispositivo_id', $dispositivoId)
                                        ->findAll();
                
                if (!empty($servos_existentes)) {
                    $servos_disponibles = array_map(function($servo) {
                        return strtolower($servo['tipo_elemento']);
                    }, $servos_existentes);
                    log_message('debug', "Guardar - Servos desde configuración existente: " . implode(', ', $servos_disponibles));
                } else {
                    // Si no hay nada, usar todos (esto debería ser temporal)
                    $servos_disponibles = ['ventana', 'cortina', 'postigon'];
                    log_message('debug', "Guardar - Usando servos por defecto");
                }
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener servos disponibles en guardar: ' . $e->getMessage());
            $servos_disponibles = ['ventana', 'cortina', 'postigon'];
        }

        // SOLO procesar los tipos de servo que están disponibles
        $tipos_servo = $servos_disponibles;
        
        log_message('debug', "Guardar - Procesando servos: " . implode(', ', $tipos_servo));

=======
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
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
     */
    public function guardar()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
<<<<<<< HEAD
            return redirect()->to('login');
=======
            return redirect()->to(base_url('login'));
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
        }

        $usuarioId = $session->get('id');
        $dispositivoId = $this->request->getPost('dispositivo_id');

<<<<<<< HEAD
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
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        $pin_map = [
            'ventana'  => 2,
            'cortina'  => 4,
            'postigon' => 16,
        ];
<<<<<<< HEAD

        $this->db->transStart();

        try {
            foreach ($tipos_servo as $tipo) {
                
                // Verificar que el tipo tenga datos en el formulario
                $openHour = $this->request->getPost('open_hour_' . $tipo);
                $closeHour = $this->request->getPost('close_hour_' . $tipo);
                
                // Si no hay datos para este servo, saltar a la siguiente iteración
                if ($openHour === null && $closeHour === null) {
                    log_message('debug', "Guardar - Saltando servo $tipo: no hay datos en formulario");
                    continue;
                }
                
                log_message('debug', "Guardar - Procesando servo $tipo: $openHour - $closeHour");

                $datosServo = [
                    'horario_apertura'  => $openHour,
                    'horario_cierre'    => $closeHour,
=======
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
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                    'temp_min_cierre'   => $this->request->getPost('min_temp_' . $tipo) ?: null,
                    'temp_max_apertura' => $this->request->getPost('max_temp_' . $tipo) ?: null,
                    'viento_max_cierre' => $this->request->getPost('max_wind_speed_' . $tipo) ?: null,
                    'permitir_lluvia'   => $this->request->getPost('allow_rain_' . $tipo) ? 1 : 0,
                ];

                $diasSeleccionados = $this->request->getPost($tipo . '_days') ?? [];

<<<<<<< HEAD
=======
                // --- b. Lógica "Upsert": Buscar si ya existe ---
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                $servoExistente = $this->servoModel
                    ->where('dispositivo_id', $dispositivoId)
                    ->where('tipo_elemento', $tipo)
                    ->first();

                $servo_id = null;

                if ($servoExistente) {
<<<<<<< HEAD
                    // ACTUALIZAR servo existente
                    $this->servoModel->update($servoExistente['id'], $datosServo);
                    $servo_id = $servoExistente['id'];
                    log_message('debug', "Guardar - Actualizado servo $tipo: ID $servo_id");
                
                } else {
                    // CREAR nuevo servo solo si está en los disponibles
                    if (in_array($tipo, $servos_disponibles)) {
                        $datosServo['dispositivo_id'] = $dispositivoId;
                        $datosServo['tipo_elemento']  = $tipo;
                        $datosServo['pin_gpio']       = $pin_map[$tipo] ?? 0;
                        $datosServo['nombre_servo']   = ucfirst($tipo); 
                        $datosServo['estado_actual']  = 'CERRADO';
                        $datosServo['modo_operacion'] = 'AUTOMATICO';

                        $this->servoModel->insert($datosServo);
                        $servo_id = $this->servoModel->getInsertID();
                        log_message('debug', "Guardar - Creado nuevo servo $tipo: ID $servo_id");
                    } else {
                        log_message('debug', "Guardar - Saltando creación de servo $tipo: no está disponible");
                        continue;
                    }
                }

                // Actualizar los días de la semana
                if ($servo_id) {
                    $this->servosDiasModel->saveDiasForServo($servo_id, $diasSeleccionados);
                    log_message('debug', "Guardar - Días actualizados para servo $tipo: " . implode(', ', $diasSeleccionados));
                }
            }

=======
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
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->back()->with('error', 'Error al guardar la configuración.');
            } else {
                $this->db->transCommit();
<<<<<<< HEAD
                log_message('debug', "Guardar - Configuración guardada exitosamente para dispositivo $dispositivoId");
                return redirect()->to('/configuracion/'. $dispositivoId)->with('success', '¡Configuración guardada correctamente!');
            }

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', '[ConfiguracionController::guardar] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
=======
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
=======
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
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
    }
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
}