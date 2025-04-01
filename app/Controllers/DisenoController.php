<?php

namespace App\Controllers;

use App\Models\DisenoModel;

class DisenoController extends BaseController
{
    public function crear()
    {
        return view('pele'); // Vista para crear diseño
    }

    public function guardar()
{
    $session = \Config\Services::session();

    if (!$session->has('id')) {
        return redirect()->to(base_url('login'));
    }

    if (!$this->validate([
        'nombre'   => 'required',
        'cortina'  => 'required',
        'ventana'  => 'required',
        'postigon' => 'required',
    ])) {
        return redirect()->back()->withInput()->with('error', 'Faltan datos obligatorios.');
    }

    $disenoModel = new DisenoModel();

    $datos = [
        'nombre'     => $this->request->getPost('nombre'),
        'cortina'    => $this->request->getPost('cortina'),
        'ventana'    => $this->request->getPost('ventana'),
        'postigon'   => $this->request->getPost('postigon'),
        'usuario_id' => $session->get('id'),
    ];

    // Guardar el diseño y obtener el ID insertado
    $disenoModel->insert($datos);
    $disenoId = $disenoModel->insertID();

    return redirect()->to(base_url("configuracion/$disenoId"))->with('mensaje', 'Diseño guardado correctamente.');
}
}
