<?php

namespace App\Controllers;

use App\Models\HorariosModel;
use App\Models\DispositivoModel;

use App\Models\ServoModel; // Asegúrate de importar ServoModel
use CodeIgniter\API\ResponseTrait;

class HorariosController extends BaseController
{
    use ResponseTrait;

    protected $horariosModel;

    protected $dispositivoModel;
    protected $servoModel; // Propiedad para el nuevo ServoModel

    public function __construct()
    {
        $this->horariosModel = new HorariosModel();

        $this->dispositivoModel = new DispositivoModel();
        $this->servoModel = new ServoModel(); // Inicializar ServoModel
    }

    public function index()
    {
        $session = \Config\Services::session();

        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = $session->get('id');

        try {
            // Obtener horarios del usuario actual
            $horarios = $this->horariosModel
                ->where('usuario_id', $usuarioId)
                ->orderBy('idhorario', 'DESC')
                ->findAll();

            // Preparar datos para enviar a la vista
            $data = [
                'title' => 'Página de Inicio',
                'horarios' => $horarios, // Pasa los horarios obtenidos DIRECTAMENTE a la vista
                'usuario_id' => $usuarioId,
                'nombre_usuario' => $session->get('nombre')
            ];

            return view('inicio', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener horarios: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('error', 'Error al cargar los horarios');
        }
    }

    /**
     * Carga el formulario de configuración de horarios para una tarjeta específica.
     * Esta función se llama desde el botón "Configurar" en inicio.php.
     * Recibe el idhorario.
     */
    public function configuracion($idhorario = null)
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to(base_url('login'));
    }

    if (empty($idhorario)) {
        return redirect()->to(base_url('irainicio'))->with('error', 'No se especificó un ID de horario.');
    }

    // Obtener el horario específico por ID (esto ya lo tenías bien)
    $horarios = $this->horariosModel->find($idhorario);

    if (!$horarios || $horarios['usuario_id'] != $session->get('id')) {
        return redirect()->to(base_url('irainicio'))->with('error', 'Horario no encontrado o sin permisos.');
    }

    // --- LÓGICA MODIFICADA PARA OBTENER CONDICIONANTES ---

    // 1. Encontrar el dispositivo_id asociado a este horario
    $dispositivoId = $horarios['dispositivo_id'];
    $condicionantes = []; // Inicializamos el array que usará la vista

    if ($dispositivoId) {
        // 2. Buscar todos los servos de ese dispositivo
        $servos = $this->servoModel->where('dispositivo_id', $dispositivoId)->findAll();
        
        // 3. Construir el array $condicionantes con el formato que la vista espera
        foreach ($servos as $servo) {
            $tipo = strtolower($servo['tipo_elemento']); // 'VENTANA' -> 'ventana'
            
            $condicionantes[$tipo] = [
                'temp_min'              => $servo['temp_min_cierre'],
                'temp_max'              => $servo['temp_max_apertura'],
                'velocidad_viento_max'  => $servo['viento_max_cierre'],
                'permitir_lluvia'       => $servo['permitir_lluvia']
            ];
        }
    }
    
    // --- FIN DE LA LÓGICA MODIFICADA ---



    return view('configuracion', [
        'horarios'       => $horarios,
        'condicionantes' => $condicionantes // Pasamos el array recién creado a la vista
    ]);
}

    /**
     * Procesa el formulario de configuración de horarios y guarda los datos en la base de datos.
     * Se llama desde el formulario en configuracion.php.
     */
    public function guardar()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to(base_url('login'));
    }

    $idhorario = $this->request->getPost('idhorario');
    $usuarioId = $session->get('id');

    // Validación del horario (esto ya lo tienes y está bien)
    $horarioExistente = null;
    if (!empty($idhorario)) {
        $horarioExistente = $this->horariosModel->where('idhorario', $idhorario)
                                                ->where('usuario_id', $usuarioId)
                                                ->first();
        if (!$horarioExistente) {
            return redirect()->back()->withInput()->with('error', 'Horario no encontrado o no tienes permiso.');
        }
    } else {
        return redirect()->back()->withInput()->with('error', 'ID de horario no proporcionado.');
    }

    // --- PRIMERA PARTE: Actualizar la tabla principal de horarios (esto ya lo tienes) ---
    $datosHorarios = [
        'ventana_apertura'  => $this->request->getPost('open_hour_ventana'),
        'ventana_cierre'    => $this->request->getPost('close_hour_ventana'),
        'cortina_apertura'  => $this->request->getPost('open_hour_cortina'),
        'cortina_cierre'    => $this->request->getPost('close_hour_cortina'),
        'postigon_apertura' => $this->request->getPost('open_hour_postigon'),
        'postigon_cierre'   => $this->request->getPost('close_hour_postigon'),
    ];

    // Limpiar valores vacíos
    foreach ($datosHorarios as $key => $value) {
        if (empty($value)) {
            $datosHorarios[$key] = null;
        }
    }

    try {
        // Actualiza la tabla `horarios`
        $this->horariosModel->update($horarioExistente['idhorario'], $datosHorarios);
        log_message('info', 'Horario ID ' . $horarioExistente['idhorario'] . ' actualizado en tabla horarios.');

        // --- SEGUNDA PARTE: Propagar cambios y CONDICIONANTES a la tabla `servos` ---
        $dispositivosDelUsuario = $this->dispositivoModel->where('usuario_id', $usuarioId)->findAll();
        $dispositivoIds = array_column($dispositivosDelUsuario, 'id');

        if (!empty($dispositivoIds)) {
            $servosDelUsuario = $this->servoModel->whereIn('dispositivo_id', $dispositivoIds)->findAll();

            foreach ($servosDelUsuario as $servo) {
                $servoDataToUpdate = [];
                $updateNeeded = false; // Asumimos que no hay cambios

                // --- AÑADIDO: Recolectar datos de condicionantes del formulario ---
                $elemento_form_name = strtolower($servo['tipo_elemento']); // 'VENTANA' -> 'ventana'

                // Construimos el array con TODOS los datos a actualizar
                $nuevosDatos = [
                    'horario_apertura'   => $this->request->getPost('open_hour_' . $elemento_form_name),
                    'horario_cierre'     => $this->request->getPost('close_hour_' . $elemento_form_name),
                    'temp_min_cierre'    => $this->request->getPost('min_temp_' . $elemento_form_name),
                    'temp_max_apertura'  => $this->request->getPost('max_temp_' . $elemento_form_name),
                    'viento_max_cierre'  => $this->request->getPost('max_wind_speed_' . $elemento_form_name),
                    'permitir_lluvia'    => $this->request->getPost('allow_rain_' . $elemento_form_name) ? 1 : 0,
                ];
                
                // Comparamos los datos nuevos con los existentes en la BD para cada servo
                foreach($nuevosDatos as $key => $value) {
                    // Si el dato del form es diferente al de la BD, lo añadimos para actualizar
                    if ($servo[$key] !== $value) {
                        $servoDataToUpdate[$key] = $value;
                        $updateNeeded = true;
                    }
                }

                if ($updateNeeded) {
                    try {
                        $this->servoModel->update($servo['id'], $servoDataToUpdate);
                        log_message('info', 'Servo ID ' . $servo['id'] . ' actualizado con nuevos horarios y/o condiciones.');
                    } catch (\Exception $e) {
                        log_message('error', 'Error al actualizar Servo ID ' . $servo['id'] . ': ' . $e->getMessage());
                    }
                }
            }
        }

        return redirect()->to(base_url('irainicio'))->with('mensaje', 'Configuración guardada correctamente');

    } catch (\Exception $e) {
        log_message('error', 'Error al guardar configuración: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Error al guardar la configuración: ' . $e->getMessage());
    }
}


    public function terminoscondiciones()
    {
        return view('Terminosycondiciones');
    }

    public function configurarHorario($id)
    {
        // Iniciar sesión
        $session = \Config\Services::session();

        // Verificar si el usuario está autenticado
        if ($session->has('id')) {
            $usuarioId = $session->get('id'); // Obtener el ID del usuario desde la sesión
        } else {
            // Redirigir al login si no hay sesión activa
            return redirect()->to(base_url('login'));
        }

        // Obtener datos del horario a configurar
        $horariosModel = new HorariosModel();
        $horario = $horariosModel->find($id);

        // Verificar si el horario pertenece al usuario autenticado
        if ($horario['usuario_id'] !== $usuarioId) {
            // Redirigir al inicio si el horario no pertenece al usuario
            return redirect()->to(base_url('inicio'));
        }

        // Preparar datos para enviar a la vista
        $data = [
            'title' => 'Configurar Horario',
            'horario' => $horario,
        ];

        // Cargar la vista configurar.php con los datos
        return view('configuracion', $data);
    }

    public function añadirtarjeta()
    {
        return view('addtarjeta');

    }

    public function savehorario()
    {
        $session = \Config\Services::session();
        $usuario_id = $session->get('id');

        // Verifica si el ID de usuario está en la sesión
        if (!$usuario_id) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión para realizar esta acción');
        }

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

    public function borrarTarjeta($idhorario)
    {
        $session = \Config\Services::session();
        $usuario_id = $session->get('id');

        if (!$usuario_id) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión para realizar esta acción');
        }

        // Verificar si el horario existe y pertenece al usuario actual
        $horario = $this->horariosModel
            ->where('idhorario', $idhorario)
            ->where('usuario_id', $usuario_id)
            ->first();

        if (!$horario) {
            return redirect()->to(base_url('irainicio'))->with('error', 'No tienes permiso para eliminar este horario');
        }

        try {
            $this->horariosModel->delete($idhorario);
            return redirect()->to(base_url('irainicio'))->with('mensaje', 'Horario eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->to(base_url('irainicio'))->with('error', 'Error al eliminar el horario: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza el nombre de una tarjeta de horario existente.
     * Recibe el ID del horario y el nuevo nombre por POST.
     * Devuelve una respuesta JSON.
     */
    public function actualizarNombreTarjeta()
    {
        $session = \Config\Services::session();
        $usuario_id = $session->get('id');

        // Verificar autenticación
        if (!$usuario_id) {
            return $this->failUnauthorized('Debes iniciar sesión para realizar esta acción');
        }

        // Obtener datos del POST
        $idhorario = $this->request->getPost('idhorario');
        $nombre_tarjeta = $this->request->getPost('nombre_tarjeta');

        // Validar datos
        if (empty($idhorario) || $nombre_tarjeta === null) { // Permitimos nombre_tarjeta vacío si se quiere borrar
             return $this->failValidationError('ID de horario o nombre no proporcionado.');
        }

        // Verificar si el horario existe y pertenece al usuario actual
        $horario = $this->horariosModel
            ->where('idhorario', $idhorario)
            ->where('usuario_id', $usuario_id)
            ->first();

        if (!$horario) {
            return $this->failForbidden('No tienes permiso para modificar este horario o no existe.');
        }

        try {
            // Actualizar el nombre de la tarjeta
            $this->horariosModel->update($idhorario, ['nombre_tarjeta' => $nombre_tarjeta]);

            // Devolver respuesta de éxito en formato JSON
            return $this->respondUpdated([
                'success' => true,
                'message' => 'Nombre de tarjeta actualizado correctamente.'
            ]);

        } catch (\Exception $e) {
            // Registrar el error y devolver respuesta de error en formato JSON
            log_message('error', 'Error al actualizar nombre de tarjeta (ID ' . $idhorario . '): ' . $e->getMessage());
            return $this->failServerError('Error interno al actualizar el nombre.');
        }
    }

    public function verificarCodigoDispositivo()
    {
        $codigo = $this->request->getPost('codigo');
        $dispositivoModel = new \App\Models\DispositivoModel();

        $dispositivo = $dispositivoModel->where('codigo', $codigo)->where('esta_usado', 0)->first();

        if ($dispositivo) {
            // Código válido y disponible
            return redirect()->to('/addtarjeta')->with('dispositivo_id', $dispositivo['id']);
        } else {
            return redirect()->back()->with('error', 'El código no es válido o ya está en uso.');
        }
    }

    public function verificarCodigo()
    {
        if ($this->request->isAJAX()) {
            $codigo = $this->request->getJSON()->codigo;
            $dispositivoModel = new \App\Models\DispositivoModel();
            $dispositivo = $dispositivoModel->where('codigo', $codigo)->where('esta_usado', 0)->first();

            if ($dispositivo) {
                return $this->response->setJSON(['success' => true, 'dispositivo_id' => $dispositivo['id']]);
            } else {
                return $this->response->setJSON(['success' => false]);
            }
        }
    }

    public function guardarTarjeta()
    {
    $session = \Config\Services::session();
    $usuario_id = $session->get('id');

    // Verifica si el ID de usuario está en la sesión
    if (!$usuario_id) {
        return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión para realizar esta acción');
    }

    $nombre_tarjeta = $this->request->getPost('nombre_tarjeta');

    // Validar que se haya proporcionado un nombre de tarjeta
    if (empty($nombre_tarjeta)) {
        return redirect()->back()->withInput()->with('error', 'Debes proporcionar un nombre para la tarjeta');
    }

    $dispositivoModel = new \App\Models\DispositivoModel();

    // Preparar los datos para la nueva tarjeta
    $data = [
        'Nombre_tarjeta' => $nombre_tarjeta,
        'usuario_id' => $usuario_id,
        'esta_usado' => 1, // Marcar como usado
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $dispositivoModel->insert($data);
        return redirect()->to(base_url('irainicio'))->with('mensaje', 'Tarjeta creada correctamente');
    } catch (\Exception $e) {
        log_message('error', 'Error al crear la tarjeta: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Error al crear la tarjeta: ' . $e->getMessage());
    }
    }

   public function reclamarDispositivoPorMac()
    {
        if (!$this->request->isAJAX()) { return $this->failForbidden('Acceso no permitido.'); }
        $macAddress = $this->request->getPost('mac_address');
        $usuarioId = session()->get('id');
        if (empty($macAddress) || empty($usuarioId)) { return $this->fail('Faltan datos.', 400); }

        $dispositivo = $this->dispositivoModel->where('codigo', $macAddress)->first();

        if (!$dispositivo) {
            return $this->failNotFound('Dispositivo no encontrado. Verifique la dirección MAC.');
        }
        if ($dispositivo['esta_usado'] == 1) {
            return $this->fail('Este dispositivo ya ha sido reclamado.', 409);
        }
        
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
        if (!$this->request->isAJAX()) { return $this->failForbidden('Acceso no permitido.'); }
        
        $nombreTarjeta = $this->request->getPost('nombre_tarjeta');
        $usuarioId = session()->get('id');

        if (empty($nombreTarjeta) || empty($usuarioId)) { return $this->fail('Faltan datos.', 400); }

        $horario = $this->horariosModel
                        ->where('nombre_tarjeta', $nombreTarjeta)
                        ->where('usuario_id', $usuarioId)
                        ->first();

        if (!$horario) { return $this->failNotFound('No se encontró una tarjeta con ese nombre.'); }
        if (empty($horario['dispositivo_id'])) { return $this->fail('Esta tarjeta no está vinculada a un dispositivo físico.', 409); }

        // Éxito: Guardamos el ID en la sesión y respondemos al JavaScript
        session()->set('selected_device_id', $horario['dispositivo_id']);
        return $this->respond(['success' => true, 'dispositivo_id' => $horario['dispositivo_id']]);
    }
    
    

}