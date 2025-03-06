<?php

namespace App\Controllers;

use App\Models\HorariosModel;

class HorariosController extends BaseController
{
    public function index()
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

        // Obtener datos de horarios asociados al usuario autenticado
        $horariosModel = new HorariosModel();
        $horarios = $horariosModel->where('usuario_id', $usuarioId)->findAll();

        // Preparar datos para enviar a la vista
        $data = [
            'title' => 'Página de Inicio',
            'horarios' => $horarios,
        ];

        // Cargar la vista inicio.php con los datos
        return view('inicio', $data);
    }
    public function terminoscondiciones()
    {
        return view('Terminosycondiciones');
    }
}
