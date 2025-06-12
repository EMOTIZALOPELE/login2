<?php

namespace App\Controllers;

use App\Models\HorariosModel;
use App\Models\DispositivoModel; 
use App\Models\DisenoModel;
use CodeIgniter\API\ResponseTrait; // Importar ResponseTrait para respuestas JSON

class HorariosController extends BaseController
{
    use ResponseTrait; // Usar ResponseTrait

    protected $horariosModel;
    protected $disenoModel;

    public function __construct()
    {
        $this->horariosModel = new HorariosModel();
        $this->disenoModel = new DisenoModel();
        $this->dispositivoModel = new DispositivoModel();
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

    public function configuracion($id)
    {
        $session = \Config\Services::session();

        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        // Obtener el diseño específico por ID
        $diseno = $this->disenoModel->find($id);

        if (!$diseno) {
            log_message('error', 'Diseño no encontrado con ID: ' . $id);
            return redirect()->to(base_url('irainicio'))->with('error', 'Diseño no encontrado');
        }

        // Verificar que el diseño pertenece al usuario actual
        if ($diseno['usuario_id'] != $session->get('id')) {
            log_message('error', 'Usuario ' . $session->get('id') . ' intentó acceder al diseño ' . $id . ' que pertenece a ' . $diseno['usuario_id']);
            return redirect()->to(base_url('irainicio'))->with('error', 'No tienes permiso para acceder a este diseño');
        }

        // Asegurar que los valores sean exactamente 'si' o 'no' en minúsculas
        $diseno['ventana'] = strtolower(trim($diseno['ventana']));
        $diseno['cortina'] = strtolower(trim($diseno['cortina']));
        $diseno['postigon'] = strtolower(trim($diseno['postigon']));

        // Depuración detallada
        log_message('debug', '=== DATOS DEL DISEÑO ANTES DE PASAR A LA VISTA ===');
        log_message('debug', 'ID: ' . $diseno['id_diseno']);
        log_message('debug', 'Nombre: ' . $diseno['nombre']);
        log_message('debug', 'Ventana (raw): [' . $diseno['ventana'] . ']');
        log_message('debug', 'Cortina (raw): [' . $diseno['cortina'] . ']');
        log_message('debug', 'Postigon (raw): [' . $diseno['postigon'] . ']');
        log_message('debug', 'Ventana === "si": ' . ($diseno['ventana'] === 'si' ? 'true' : 'false'));
        log_message('debug', 'Cortina === "si": ' . ($diseno['cortina'] === 'si' ? 'true' : 'false'));
        log_message('debug', 'Postigon === "si": ' . ($diseno['postigon'] === 'si' ? 'true' : 'false'));
        log_message('debug', 'Longitud Ventana: ' . strlen($diseno['ventana']));
        log_message('debug', 'Longitud Cortina: ' . strlen($diseno['cortina']));
        log_message('debug', 'Longitud Postigon: ' . strlen($diseno['postigon']));
        log_message('debug', '=== FIN DATOS DEL DISEÑO ===');

        // Obtener horarios existentes si los hay
        $horarios = $this->horariosModel->where('diseno_id', $id)->first();

        return view('configuracion', [
            'diseno' => $diseno,
            'horarios' => $horarios ?? null
        ]);
    }

    public function guardar()
    {
        $session = \Config\Services::session();

        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $disenoId = $this->request->getPost('diseno_id');
        $diseno = $this->disenoModel->find($disenoId);

        if (!$diseno) {
            return redirect()->to(base_url('irainicio'))->with('error', 'Diseño no encontrado');
        }

        // Verificar que el diseño pertenece al usuario actual
        if ($diseno['usuario_id'] != $session->get('id')) {
            return redirect()->to(base_url('irainicio'))->with('error', 'No tienes permiso para modificar este diseño');
        }

        // Asegurar que los valores sean exactamente 'si' o 'no' en minúsculas
        $diseno['ventana'] = strtolower(trim($diseno['ventana']));
        $diseno['cortina'] = strtolower(trim($diseno['cortina']));
        $diseno['postigon'] = strtolower(trim($diseno['postigon']));

        // Preparar los datos del horario
        $datos = [
            'diseno_id' => $disenoId,
            'usuario_id' => $session->get('id')
        ];

        // Solo agregar los horarios para los elementos que están activos en el diseño
        if ($diseno['ventana'] === 'si') {
            $ventana_apertura = $this->request->getPost('ventana_apertura');
            $ventana_cierre = $this->request->getPost('ventana_cierre');

            if (empty($ventana_apertura) || empty($ventana_cierre)) {
                return redirect()->back()->withInput()->with('error', 'Debes especificar los horarios de la ventana');
            }

            $datos['ventana_apertura'] = $ventana_apertura;
            $datos['ventana_cierre'] = $ventana_cierre;
        }

        if ($diseno['cortina'] === 'si') {
            $cortina_apertura = $this->request->getPost('cortina_apertura');
            $cortina_cierre = $this->request->getPost('cortina_cierre');

            if (empty($cortina_apertura) || empty($cortina_cierre)) {
                return redirect()->back()->withInput()->with('error', 'Debes especificar los horarios de la cortina');
            }

            $datos['cortina_apertura'] = $cortina_apertura;
            $datos['cortina_cierre'] = $cortina_cierre;
        }

        if ($diseno['postigon'] === 'si') {
            $postigon_apertura = $this->request->getPost('postigon_apertura');
            $postigon_cierre = $this->request->getPost('postigon_cierre');

            if (empty($postigon_apertura) || empty($postigon_cierre)) {
                return redirect()->back()->withInput()->with('error', 'Debes especificar los horarios del postigo');
            }

            $datos['postigon_apertura'] = $postigon_apertura;
            $datos['postigon_cierre'] = $postigon_cierre;
        }

        try {
            // Verificar si ya existe un horario para este diseño
            $horarioExistente = $this->horariosModel->where('diseno_id', $disenoId)->first();

            if ($horarioExistente) {
                // Actualizar horario existente
                $this->horariosModel->update($horarioExistente['idhorario'], $datos);
            } else {
                // Crear nuevo horario
                $this->horariosModel->insert($datos);
            }

            return redirect()->to(base_url('irainicio'))->with('mensaje', 'Horarios guardados correctamente');
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar horarios: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar los horarios: ' . $e->getMessage());
        }
    }

    public function getEstadoVentana()
    {
        $disenoId = $this->request->getGet('diseno_id');
        if (!$disenoId) {
            return $this->response->setJSON(['error' => 'ID de diseño no proporcionado']);
        }

        $estado = $this->horariosModel->getEstadoVentana($disenoId);
        if (!$estado) {
            return $this->response->setJSON(['error' => 'No se encontraron horarios para este diseño']);
        }

        return $this->response->setJSON($estado);
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
    // Usamos el ResponseTrait que ya tienes en tu controlador para respuestas JSON
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Acceso no permitido.');
    }

    $macAddress = $this->request->getPost('mac_address');
    $usuarioId = session()->get('id');

    if (empty($macAddress) || empty($usuarioId)) {
        return $this->fail('Faltan datos o no ha iniciado sesión.', 400);
    }

    $dispositivoModel = new DispositivoModel();
    
    // Buscamos un dispositivo que coincida con la MAC (que está en la columna 'codigo')
    $dispositivo = $dispositivoModel->where('codigo', $macAddress)->first();

    if (!$dispositivo) {
        return $this->failNotFound('Dispositivo no encontrado. Verifique la dirección MAC.');
    }
    
    if ($dispositivo['esta_usado'] == 1) {
        if ($dispositivo['usuario_id'] == $usuarioId) {
            return $this->fail('Ya has reclamado este dispositivo anteriormente.', 409);
        } else {
            return $this->fail('Este dispositivo ya pertenece a otro usuario.', 409); 
        }
    }

    // ¡Éxito! El dispositivo está disponible. Lo reclamamos.
    $dataToUpdate = [
        'usuario_id' => $usuarioId,
        'esta_usado' => 1,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    if ($dispositivoModel->update($dispositivo['id'], $dataToUpdate)) {
        // Creamos automáticamente una nueva "tarjeta de horario" para este dispositivo
        $horariosModel = new HorariosModel();
        $horariosModel->insert([
            'usuario_id'     => $usuarioId,
            'dispositivo_id' => $dispositivo['id'],
            'nombre_tarjeta' => 'Dispositivo ' . substr($macAddress, -5),
            'ventana_apertura'  => '07:00:00', 'ventana_cierre'    => '20:00:00',
            'cortina_apertura'  => '07:00:00', 'cortina_cierre'    => '20:00:00',
            'postigon_apertura' => '07:00:00', 'postigon_cierre'   => '20:00:00',
        ]);
        
        return $this->respondCreated([
            'success' => true,
            'message' => '¡Dispositivo reclamado y tarjeta creada con éxito! La página se recargará.'
        ]);
    } else {
        return $this->failServerError('No se pudo reclamar el dispositivo en este momento.');
    }
}

    public function seleccionarDispositivoPorNombre()
    {
        // Aseguramos que sea una petición AJAX
        if (!$this->request->isAJAX()) {
            return $this->failForbidden('Acceso no permitido.');
        }

        $nombreTarjeta = $this->request->getPost('nombre_tarjeta');
        $usuarioId = session()->get('id');

        if (empty($nombreTarjeta) || empty($usuarioId)) {
            return $this->fail('Falta el nombre de la tarjeta o no ha iniciado sesión.', 400);
        }

        // Buscamos en la tabla de horarios una tarjeta con ese nombre que pertenezca al usuario
        $horario = $this->horariosModel
                        ->where('nombre_tarjeta', $nombreTarjeta)
                        ->where('usuario_id', $usuarioId)
                        ->first();

        if (!$horario) {
            return $this->failNotFound('No se encontró una tarjeta con ese nombre.');
        }

        // Si la tarjeta no tiene un dispositivo asociado, devolvemos el error que estás viendo
        if (empty($horario['dispositivo_id'])) {
            return $this->fail('Esta tarjeta no está vinculada a un dispositivo físico.', 409);
        }

        // ¡Éxito! Devolvemos el ID del dispositivo para que el frontend pueda redirigir
        return $this->respond([
            'success' => true, 
            'dispositivo_id' => $horario['dispositivo_id']
        ]);
    }
}
