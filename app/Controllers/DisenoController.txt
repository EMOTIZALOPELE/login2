<?php

namespace App\Controllers;

use App\Models\DisenoModel;

class DisenoController extends BaseController
{
    protected $disenoModel;

    public function __construct()
    {
        $this->disenoModel = new DisenoModel();
    }

    public function crear()
    {
        $session = \Config\Services::session();
        
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        return view('pele'); // Vista para crear diseño
    }

    public function guardar()
    {
        $session = \Config\Services::session();
        
        if (!$session->has('id')) {
            return redirect()->to(base_url('login'));
        }

        if (!$this->validate([
            'nombre'   => 'required|min_length[3]',
            'cortina'  => 'required|in_list[si,no]',
            'ventana'  => 'required|in_list[si,no]',
            'postigon' => 'required|in_list[si,no]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Por favor verifica los datos ingresados.');
        }

        $datos = [
            'nombre'     => $this->request->getPost('nombre'),
            'cortina'    => strtolower($this->request->getPost('cortina')),
            'ventana'    => strtolower($this->request->getPost('ventana')),
            'postigon'   => strtolower($this->request->getPost('postigon')),
            'usuario_id' => $session->get('id'),
        ];

        try {
            // Logging de los datos antes de guardar
            log_message('debug', '=== INTENTANDO GUARDAR DISEÑO ===');
            log_message('debug', 'Nombre: ' . $datos['nombre']);
            log_message('debug', 'Cortina: ' . $datos['cortina']);
            log_message('debug', 'Ventana: ' . $datos['ventana']);
            log_message('debug', 'Postigon: ' . $datos['postigon']);
            log_message('debug', 'Usuario ID: ' . $datos['usuario_id']);

            // Guardar el diseño y obtener el ID insertado
            if (!$this->disenoModel->insert($datos)) {
                log_message('error', 'Error al insertar: ' . print_r($this->disenoModel->errors(), true));
                throw new \Exception('Error al insertar en la base de datos');
            }
            
            $disenoId = $this->disenoModel->insertID();
            
            if (!$disenoId) {
                log_message('error', 'No se pudo obtener el ID del diseño insertado');
                throw new \Exception('No se pudo obtener el ID del diseño');
            }

            log_message('debug', 'Diseño guardado con ID: ' . $disenoId);

            // Redirigir a la página de configuración de horarios
            return redirect()->to(base_url("horarios/configuracion/$disenoId"))
                           ->with('mensaje', 'Diseño guardado correctamente. Ahora puedes configurar los horarios.');
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar diseño: ' . $e->getMessage());
            log_message('error', 'Trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()
                           ->with('error', 'Error al guardar el diseño: ' . $e->getMessage());
        }
    }
}