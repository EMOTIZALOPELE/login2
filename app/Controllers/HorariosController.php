<?php

namespace App\Controllers;

use App\Models\HorariosModel;
use App\Models\DispositivoModel;
use App\Models\ServoModel;
use App\Models\ServosDiasModel;
use CodeIgniter\API\ResponseTrait;

class HorariosController extends BaseController
{
    use ResponseTrait;

    protected $horariosModel;
    protected $dispositivoModel;
    protected $servoModel;
    protected $servosDiasModel;

    public function __construct()
    {
        $this->horariosModel = new HorariosModel();
        $this->dispositivoModel = new DispositivoModel();
        $this->servoModel = new ServoModel();
        $this->servosDiasModel = new ServosDiasModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) return redirect()->to(base_url('login'));
        $usuarioId = $session->get('id');

        try {
            $horarios = $this->horariosModel->where('usuario_id', $usuarioId)->orderBy('idhorario', 'DESC')->findAll();
            $data = [
                'title' => 'Página de Inicio',
                'horarios' => $horarios,
                'usuario_id' => $usuarioId,
                'nombre_usuario' => $session->get('nombre')
            ];
            return view('inicio', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener horarios: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('error', 'Error al cargar los horarios');
        }
    }

    public function configuracion($idhorario = null)
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) return redirect()->to(base_url('login'));
        if (empty($idhorario)) return redirect()->to(base_url('irainicio'))->with('error', 'No se especificó un ID de horario.');

        $horarios = $this->horariosModel->find($idhorario);
        if (!$horarios || $horarios['usuario_id'] != $session->get('id')) {
            return redirect()->to(base_url('irainicio'))->with('error', 'Horario no encontrado o sin permisos.');
        }

        $condicionantes = [];
        $dispositivoId = $horarios['dispositivo_id'];
        if ($dispositivoId) {
            $servos = $this->servoModel->where('dispositivo_id', $dispositivoId)->findAll();
            foreach ($servos as $servo) {
                $tipo = strtolower($servo['tipo_elemento']);
                $condicionantes[$tipo] = [
                    'temp_min'              => $servo['temp_min_cierre'],
                    'temp_max'              => $servo['temp_max_apertura'],
                    'velocidad_viento_max'  => $servo['viento_max_cierre'],
                    'permitir_lluvia'       => $servo['permitir_lluvia']
                ];
            }
        }

        return view('configuracion', [
            'horarios'       => $horarios,
            'condicionantes' => $condicionantes
        ]);
    }

    public function guardar()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) return redirect()->to(base_url('login'));
        $idhorario = $this->request->getPost('idhorario');
        $usuarioId = $session->get('id');

        $horarioExistente = !empty($idhorario)
            ? $this->horariosModel->where('idhorario', $idhorario)->where('usuario_id', $usuarioId)->first()
            : null;
        if ($idhorario && !$horarioExistente) {
            return redirect()->back()->withInput()->with('error', 'Horario no encontrado o no tienes permiso.');
        }
        if (!$idhorario) {
            return redirect()->back()->withInput()->with('error', 'ID de horario no proporcionado.');
        }

        $datosHorarios = [
            'ventana_apertura'  => $this->request->getPost('open_hour_ventana'),
            'ventana_cierre'    => $this->request->getPost('close_hour_ventana'),
            'cortina_apertura'  => $this->request->getPost('open_hour_cortina'),
            'cortina_cierre'    => $this->request->getPost('close_hour_cortina'),
            'postigon_apertura' => $this->request->getPost('open_hour_postigon'),
            'postigon_cierre'   => $this->request->getPost('close_hour_postigon'),
        ];

        foreach ($datosHorarios as $key => $value) {
            if (empty($value)) $datosHorarios[$key] = null;
        }

        try {
            $this->horariosModel->update($horarioExistente['idhorario'], $datosHorarios);
            $dispositivosDelUsuario = $this->dispositivoModel->where('usuario_id', $usuarioId)->findAll();
            $dispositivoIds = array_column($dispositivosDelUsuario, 'id');

            if (!empty($dispositivoIds)) {
                $servosDelUsuario = $this->servoModel->whereIn('dispositivo_id', $dispositivoIds)->findAll();
                foreach ($servosDelUsuario as $servo) {
                    $tipo = strtolower($servo['tipo_elemento']);
                    $nuevosDatos = [
                        'horario_apertura'   => $this->request->getPost('open_hour_' . $tipo),
                        'horario_cierre'     => $this->request->getPost('close_hour_' . $tipo),
                        'temp_min_cierre'    => $this->request->getPost('min_temp_' . $tipo),
                        'temp_max_apertura'  => $this->request->getPost('max_temp_' . $tipo),
                        'viento_max_cierre'  => $this->request->getPost('max_wind_speed_' . $tipo),
                        'permitir_lluvia'    => $this->request->getPost('allow_rain_' . $tipo) ? 1 : 0,
                    ];
                    $servoDataToUpdate = [];
                    foreach($nuevosDatos as $key => $value) {
                        if ($servo[$key] !== $value) $servoDataToUpdate[$key] = $value;
                    }
                    if (!empty($servoDataToUpdate)) {
                        $this->servoModel->update($servo['id'], $servoDataToUpdate);
                    }
                }
            }
            return redirect()->to(base_url('irainicio'))->with('mensaje', 'Configuración guardada correctamente');
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar configuración: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar la configuración: ' . $e->getMessage());
        }
    }

    // Las siguientes funciones se mantienen igual pero pueden simplificarse si lo deseas.
    public function terminoscondiciones() 
    { 
        return view('Terminosycondiciones'); 
    }

    public function configurarHorario($id)
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) return redirect()->to(base_url('login'));
        $usuarioId = $session->get('id');
        $horario = $this->horariosModel->find($id);
        if ($horario['usuario_id'] !== $usuarioId) return redirect()->to(base_url('inicio'));
        return view('configuracion', ['title' => 'Configurar Horario', 'horario' => $horario]);
    }

    public function añadirtarjeta() 
    { 
        return view('addtarjeta'); 
    }

    public function savehorario()
    {
        $session = \Config\Services::session();
        $usuario_id = $session->get('id');
        if (!$usuario_id) return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión para realizar esta acción');
        $data = [
            'usuario_id' => $usuario_id,
            'ventana_apertura' => $this->request->getPost('ventana_apertura'),
            'ventana_cierre' => $this->request->getPost('ventana_cierre'),
            'cortina_apertura' => $this->request->getPost('cortina_apertura'),
            'cortina_cierre' => $this->request->getPost('cortina_cierre'),
            'postigon_apertura' => $this->request->getPost('postigon_apertura'),
            'postigon_cierre' => $this->request->getPost('postigon_cierre'),
        ];
        try {
            $this->horariosModel->insert($data);
            return redirect()->to(base_url('irainicio'))->with('mensaje', 'Horarios guardados correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar los horarios: ' . $e->getMessage());
        }
    }
    /**
     * FUNCIÓN ACTUALIZADA Y MÁS SEGURA
     * Borra "tarjeta", servos, días de servo y libera el dispositivo.
     */
    public function borrarTarjeta($idhorario = null)
    {
        $session = \Config\Services::session();
        $usuarioId = $session->get('id');

        if (!$usuarioId) {
            return redirect()->to('/login');
        }
        if (empty($idhorario)) {
            return redirect()->to('irainicio')->with('error', 'No se especificó la tarjeta.');
        }

        // 1. Iniciar la transacción
        $this->db->transStart();

        try {
            // 2. Buscar la tarjeta (horario)
            $horario = $this->horariosModel->find($idhorario); // Asumimos que idhorario es la PK

            // 3. ¡VERIFICACIÓN DE PERMISO!
            // Comprobar que la tarjeta existe y que pertenece al usuario logueado.
            if (!$horario || $horario['usuario_id'] != $usuarioId) {
                throw new \Exception('Tarjeta no encontrada o no autorizada.');
            }

            // 4. Obtener el ID del dispositivo vinculado
            $dispositivoId = $horario['dispositivo_id'];

            // 5. Si la tarjeta tiene un dispositivo asociado...
            if (!empty($dispositivoId)) {

                // --- NUEVO CHEQUEO DE SEGURIDAD ---
                // Verificamos que el dispositivo también pertenezca al usuario.
                $dispositivo = $this->dispositivoModel
                                    ->where('id', $dispositivoId)
                                    ->where('usuario_id', $usuarioId)
                                    ->first();
                
                // Si el dispositivo existe y SÍ pertenece al usuario...
                if ($dispositivo) {
                    
                    // --- Paso A: Encontrar los IDs de los servos a borrar ---
                    $servoIDs = $this->servoModel
                                    ->where('dispositivo_id', $dispositivoId)
                                    ->findColumn('id');

                    // --- Paso B: Borrar de la tabla "servo_dias" ---
                    if (!empty($servoIDs)) {
                        $this->servosDiasModel->whereIn('servo_id', $servoIDs)->delete();
                    }

                    // --- Paso C: Borrar los servos de la tabla "servos" ---
                    $this->servoModel->where('dispositivo_id', $dispositivoId)->delete();
                    
                    // --- Paso D: Actualizar la tabla "dispositivos" ---
                    $this->dispositivoModel->update($dispositivoId, ['esta_usado' => 0]);

                } else {
                    // Si el dispositivo_id de la tarjeta no pertenece al usuario,
                    // no borramos nada de ese dispositivo, pero SÍ la tarjeta.
                    // Esto previene el borrado en cascada de datos de otro usuario.
                    log_message('error', "Peligro: Usuario $usuarioId intentó borrar tarjeta $idhorario que apuntaba a dispositivo $dispositivoId que no le pertenece.");
                }
            }

            // 6. Finalmente, borrar la tarjeta (registro de horario)
            // Esto se hace siempre, incluso si el dispositivo_id estaba mal.
            $this->horariosModel->delete($idhorario);

            // 7. Si todo salió bien, confirmar la transacción
            if ($this->db->transStatus() === false) {
                 throw new \Exception('La transacción de borrado falló.');
            } else {
                $this->db->transCommit();
                return redirect()->to('irainicio')->with('success', 'Tarjeta eliminada y dispositivo liberado.');
            }

        } catch (\Exception $e) {
            // 8. Si algo falló, revertir todos los cambios
            $this->db->transRollback();
            log_message('error', '[HorariosController::borrarTarjeta] ' . $e->getMessage());
            return redirect()->to('irainicio')->with('error', 'Error al eliminar la tarjeta: ' . $e->getMessage());
        }
    }

    public function actualizarNombreTarjeta()
    {
        $session = \Config\Services::session();
        $usuario_id = $session->get('id');
        if (!$usuario_id) return $this->failUnauthorized('Debes iniciar sesión para realizar esta acción');
        $idhorario = $this->request->getPost('idhorario');
        $nombre_tarjeta = $this->request->getPost('nombre_tarjeta');
        if (empty($idhorario) || $nombre_tarjeta === null) return $this->failValidationError('ID de horario o nombre no proporcionado.');
        $horario = $this->horariosModel->where('idhorario', $idhorario)->where('usuario_id', $usuario_id)->first();
        if (!$horario) return $this->failForbidden('No tienes permiso para modificar este horario o no existe.');
        try {
            $this->horariosModel->update($idhorario, ['nombre_tarjeta' => $nombre_tarjeta]);
            return $this->respondUpdated(['success' => true, 'message' => 'Nombre de tarjeta actualizado correctamente.']);
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar nombre de tarjeta (ID ' . $idhorario . '): ' . $e->getMessage());
            return $this->failServerError('Error interno al actualizar el nombre.');
        }
    }

    public function verificarCodigoDispositivo()
    {
        $codigo = $this->request->getPost('codigo');
        $dispositivo = $this->dispositivoModel->where('codigo', $codigo)->where('esta_usado', 0)->first();
        if ($dispositivo) return redirect()->to('/addtarjeta')->with('dispositivo_id', $dispositivo['id']);
        return redirect()->back()->with('error', 'El código no es válido o ya está en uso.');
    }

    public function verificarCodigo()
    {
        if ($this->request->isAJAX()) {
            $codigo = $this->request->getJSON()->codigo;
            $dispositivo = $this->dispositivoModel->where('codigo', $codigo)->where('esta_usado', 0)->first();
            if ($dispositivo) return $this->response->setJSON(['success' => true, 'dispositivo_id' => $dispositivo['id']]);
            else return $this->response->setJSON(['success' => false]);
        }
    }

    public function guardarTarjeta()
    {
        $session = \Config\Services::session();
        $usuario_id = $session->get('id');
        if (!$usuario_id) return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión para realizar esta acción');
        $nombre_tarjeta = $this->request->getPost('nombre_tarjeta');
        if (empty($nombre_tarjeta)) return redirect()->back()->withInput()->with('error', 'Debes proporcionar un nombre para la tarjeta');
        $data = [
            'Nombre_tarjeta' => $nombre_tarjeta,
            'usuario_id' => $usuario_id,
            'esta_usado' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        try {
            $this->dispositivoModel->insert($data);
            return redirect()->to(base_url('irainicio'))->with('mensaje', 'Tarjeta creada correctamente');
        } catch (\Exception $e) {
            log_message('error', 'Error al crear la tarjeta: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al crear la tarjeta: ' . $e->getMessage());
        }
    }
    
    public function reclamarDispositivoPorMac()
    {
        if (!$this->request->isAJAX()) return $this->failForbidden('Acceso no permitido.');
        $macAddress = $this->request->getPost('mac_address');
        $usuarioId = session()->get('id');
        if (empty($macAddress) || empty($usuarioId)) return $this->fail('Faltan datos.', 400);

        $dispositivo = $this->dispositivoModel->where('codigo', $macAddress)->first();
        if (!$dispositivo) return $this->failNotFound('Dispositivo no encontrado. Verifique la dirección MAC.');
        if ($dispositivo['esta_usado'] == 1) return $this->fail('Este dispositivo ya ha sido reclamado.', 409);

        $this->dispositivoModel->update($dispositivo['id'], ['usuario_id' => $usuarioId, 'esta_usado' => 1]);
        $this->horariosModel->insert([
            'usuario_id'     => $usuarioId,
            'dispositivo_id' => $dispositivo['id'],
            'nombre_tarjeta' => 'Dispositivo ' . substr($macAddress, -5),
            'ventana_apertura' => '07:00:00', 'ventana_cierre' => '20:00:00',
            'cortina_apertura' => '07:00:00', 'cortina_cierre' => '20:00:00',
            'postigon_apertura' => '07:00:00', 'postigon_cierre' => '20:00:00',
        ]);
        return $this->respondCreated(['success' => true, 'message' => '¡Dispositivo reclamado y tarjeta creada!']);
    }

    public function seleccionarDispositivoPorNombre()
    {
        $nombreTarjeta = $this->request->getPost('nombre_tarjeta');
        $usuarioId = session()->get('id');

        if (empty($nombreTarjeta)) {
            return $this->response->setJSON([
                'success' => false,
                'messages' => ['error' => 'El nombre de la tarjeta es requerido.']
            ]);
        }

        // Usar una consulta SQL directa para evitar problemas del Query Builder
        $db = \Config\Database::connect();
        
        $query = $db->query("
            SELECT * FROM horarios 
            WHERE nombre_tarjeta = ? AND usuario_id = ?
        ", [$nombreTarjeta, $usuarioId]);
        
        $tarjeta = $query->getRowArray();

        if (!$tarjeta) {
            // Buscar todas las tarjetas para debug
            $todasQuery = $db->query("
                SELECT idhorario, nombre_tarjeta, dispositivo_id 
                FROM horarios 
                WHERE usuario_id = ?
            ", [$usuarioId]);
            $todasLasTarjetas = $todasQuery->getResultArray();
            
            log_message('debug', 'Todas las tarjetas del usuario: ' . print_r($todasLasTarjetas, true));
            
            return $this->response->setJSON([
                'success' => false,
                'messages' => ['error' => 'No se encontró una tarjeta con el nombre: "' . $nombreTarjeta . '"']
            ]);
        }

        // Verificar que la tarjeta tenga un dispositivo asociado
        if (empty($tarjeta['dispositivo_id'])) {
            return $this->response->setJSON([
                'success' => false,
                'messages' => ['error' => 'Esta tarjeta no tiene un dispositivo asociado.']
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'dispositivo_id' => $tarjeta['dispositivo_id'],
            'message' => 'Tarjeta encontrada: ' . $tarjeta['nombre_tarjeta']
        ]);
    }
}