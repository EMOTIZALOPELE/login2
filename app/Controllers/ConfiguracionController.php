<?php

namespace App\Controllers;

use App\Models\ServoModel;
use App\Models\DispositivoModel;
use App\Models\ServosDiasModel;
use App\Models\DiasSemanasModel;
use App\Models\PagoModel;

class ConfiguracionController extends BaseController
{
    protected $servoModel;
    protected $dispositivoModel;
    protected $servosDiasModel;
    protected $diasSemanasModel;
    protected $pagoModel;
    protected $db;

    public function __construct()
    {
        $this->servoModel = new ServoModel();
        $this->dispositivoModel = new DispositivoModel();
        $this->servosDiasModel = new ServosDiasModel();
        $this->diasSemanasModel = new DiasSemanasModel();
        $this->pagoModel = new PagoModel();
        $this->db = \Config\Database::connect();
    }

   public function index($dispositivo_id = null) 
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to('login');
        }

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

        $usuarioId = $session->get('id');
        $dispositivoId = $this->request->getPost('dispositivo_id');

        $dispositivo = $this->dispositivoModel
                            ->where('usuario_id', $usuarioId)
                            ->where('id', $dispositivoId)
                            ->first();

        if (!$dispositivo) {
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

        $pin_map = [
            'ventana'  => 2,
            'cortina'  => 4,
            'postigon' => 16,
        ];

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
                    'temp_min_cierre'   => $this->request->getPost('min_temp_' . $tipo) ?: null,
                    'temp_max_apertura' => $this->request->getPost('max_temp_' . $tipo) ?: null,
                    'viento_max_cierre' => $this->request->getPost('max_wind_speed_' . $tipo) ?: null,
                    'permitir_lluvia'   => $this->request->getPost('allow_rain_' . $tipo) ? 1 : 0,
                ];

                $diasSeleccionados = $this->request->getPost($tipo . '_days') ?? [];

                $servoExistente = $this->servoModel
                    ->where('dispositivo_id', $dispositivoId)
                    ->where('tipo_elemento', $tipo)
                    ->first();

                $servo_id = null;

                if ($servoExistente) {
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

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->back()->with('error', 'Error al guardar la configuración.');
            } else {
                $this->db->transCommit();
                log_message('debug', "Guardar - Configuración guardada exitosamente para dispositivo $dispositivoId");
                return redirect()->to('/configuracion/'. $dispositivoId)->with('success', '¡Configuración guardada correctamente!');
            }

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', '[ConfiguracionController::guardar] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}