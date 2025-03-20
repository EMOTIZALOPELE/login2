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
    public function añadirtarjeta(){
        return view('addtarjeta');
    }
    public function savehorario(){
        $usuario_id = session()->get('id');

        // Verifica si el ID de usuario está en la sesión
        if (!$usuario_id) {
            return 'Usuario no logueado'; 
        }

        $data = [
            'usuario_id'         =>$usuario_id,
            'ventana_apertura'  => $this->request->getPost('ventana_apertura'),
            'ventana_cierre'    => $this->request->getPost('ventana_cierre'),
            'cortina_apertura'  => $this->request->getPost('cortina_apertura'),
            'cortina_cierre'    => $this->request->getPost('cortina_cierre'),
            'postigon_apertura' => $this->request->getPost('postigon_apertura'),
            'postigon_cierre'   => $this->request->getPost('postigon_cierre'),
        ];

        $horariosModel = new \App\Models\HorariosModel();

        // Actualizar los horarios existentes
            if (!$horariosModel->insert($data)) {
                return 'Error al guardar los horarios';
            
        return redirect()->to(base_url('irainicio'))->with('status', 'Horarios guardados correctamente.');
    }
    return redirect()->to(base_url('irainicio'))->with('status', 'Horarios guardados correctamente.');
} 

public function borrarTarjeta($idhorario)
{
    $horariosModel = new \App\Models\HorariosModel();

    // Verificar si el horario existe antes de eliminarlo
    $horario = $horariosModel->find($idhorario);

    if ($horario) {
        $horariosModel->delete($idhorario);
        return redirect()->to(base_url('irainicio'))->with('message', 'Tarjeta eliminada correctamente.');
    } else {
        return redirect()->to('/')->with('error', 'La tarjeta no existe.');
    }
}

} 