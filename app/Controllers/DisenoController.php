<?php

namespace App\Controllers;

use App\Models\DisenoModel;

class DisenoController extends BaseController
{
    public function crear()
    {
        return view('pele'); // Tu vista para crear diseño
    }

    public function guardar()
    {
        $session = \Config\Services::session();

        // Validar que el usuario esté logueado
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        // Validación de los datos del formulario
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

        // Guardar el diseño
        if (!$disenoModel->save($datos)) {
            return redirect()->back()->withInput()->with('error', 'Error al guardar el diseño.');
        }

        return redirect()->to(base_url('configuracion'))->with('mensaje', 'Diseño guardado correctamente.');
    }
}
