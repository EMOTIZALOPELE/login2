<?php

namespace App\Controllers;

use App\Models\HorariosModel;

class HorariosController extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();

        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = $session->get('id');

        // Obtener horarios del usuario
        $horariosModel = new HorariosModel();
        $horarios = $horariosModel->where('usuario_id', $usuarioId)->findAll();

        $data = [
            'title' => 'Página de Inicio',
            'horarios' => $horarios,
        ];

        return view('inicio', $data);
    }
    public function configuracion($idDiseno = null)
{
    $session = session();
    if (!$session->has('usuario_id')) {
        return redirect()->to(base_url('configuracion'));
    }

    $usuarioId = $session->get('usuario_id');

    // Obtener el diseño específico
    $disenoModel = new \App\Models\DisenoModel();
    $diseno = $disenoModel->where('id', $idDiseno)->where('usuario_id', $usuarioId)->first();

    if (!$diseno) {
        return redirect()->to(base_url('pele'))->with('error', 'No se encontró el diseño.');
    }

    // Obtener los horarios del usuario
    $horariosModel = new \App\Models\HorariosModel();
    $horarios = $horariosModel->where('usuario_id', $usuarioId)->findAll();

    // Cargar la vista con los datos del diseño guardado
    return view('configuracion', [
        'diseno' => $diseno,
        'horarios' => $horarios
    ]);
    }
    public function guardar_horarios()
{
    $usuarioId = session()->get('id');

    if (!$usuarioId) {
        return 'Usuario no logueado'; 
    }

    if (!$this->validate([
        'ventana_apertura' => 'required',
        'ventana_cierre' => 'required',
        'cortina_apertura' => 'required',
        'cortina_cierre' => 'required',
        'postigon_apertura' => 'required',
        'postigon_cierre' => 'required'
    ])) {
        return 'Validación fallida'; 
    }

    $data = [
        'ventana_apertura' => $this->request->getPost('ventana_apertura'),
        'ventana_cierre' => $this->request->getPost('ventana_cierre'),
        'cortina_apertura' => $this->request->getPost('cortina_apertura'),
        'cortina_cierre' => $this->request->getPost('cortina_cierre'),
        'postigon_apertura' => $this->request->getPost('postigon_apertura'),
        'postigon_cierre' => $this->request->getPost('postigon_cierre'),
        'usuario_id' => $usuarioId,
        'diseno_id' => $this->request->getPost('diseno_id')
    ];

    $horariosModel = new \App\Models\HorariosModel();
    $existingHorario = $horariosModel->where('usuario_id', $usuarioId)->where('diseno_id', $data['diseno_id'])->first();

    if ($existingHorario) {
        $horariosModel->update($existingHorario['idhorario'], $data);
    } else {
        $horariosModel->insert($data);
    }

    return redirect()->to(base_url('inicio'))->with('status', 'Horarios guardados correctamente.');
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
