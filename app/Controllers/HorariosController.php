<?php

namespace App\Controllers;

use App\Models\HorariosModel;
use App\Models\DisenoModel;

class HorariosController extends BaseController
{
    protected $horariosModel;
    protected $disenoModel;

    public function __construct()
    {
        $this->horariosModel = new HorariosModel();
        $this->disenoModel = new DisenoModel();
    }

    public function index()
    {
        $session = \Config\Services::session();

        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = $session->get('id');

        $horarios = $this->horariosModel->where('usuario_id', $usuarioId)->findAll();

        $data = [
            'title' => 'Página de Inicio',
            'horarios' => $horarios,
        ];

        return view('inicio', $data);
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

    public function mostrarHorarios()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $horariosModel = new HorariosModel();
        $usuarioId = $session->get('id');

        $horarios = $horariosModel->where('usuario_id', $usuarioId)->findAll();

        if (empty($horarios)) {
            return view('horarios_view', ['error' => 'No se encontraron horarios.']);
        }

        return view('horarios_view', ['horarios' => $horarios]);
    }

    public function terminoscondiciones()
    {
        return view('Terminosycondiciones');
    }
}
