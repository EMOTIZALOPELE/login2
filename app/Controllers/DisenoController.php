<?php

namespace App\Controllers;

use App\Models\DisenoModel;

class DisenoController extends BaseController
{
    public function crear()
    {
        return view('pele'); // Tu vista se llama 'pele'
    }

    public function guardar()
    {
        $session = \Config\Services::session();

        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        $disenoModel = new DisenoModel();

        $datos = [
            'nombre'    => $this->request->getPost('nombre'),
            'cortina'   => $this->request->getPost('cortina'),
            'ventana'   => $this->request->getPost('ventana'),
            'postigon'  => $this->request->getPost('postigon'),
            'usuario_id'=> $session->get('id'),
        ];

        $disenoModel->save($datos);

        return redirect()->to(base_url('inicio'))->with('mensaje', 'Diseño guardado correctamente');
    }
}
