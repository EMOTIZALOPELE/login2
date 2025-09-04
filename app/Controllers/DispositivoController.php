<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\HorariosModel;
use CodeIgniter\Controller;

class DispositivoController extends BaseController
{
    public function index()
    {
        $dispositivoModel = new DispositivoModel();
        $horariosModel = new HorariosModel();
        $userId = session()->get('id');

        // Obtenemos todos los dispositivos asociados al usuario
        $dispositivos = $dispositivoModel->where('usuario_id', $userId)->where('esta_usado', 1)->findAll();
        
        $data['dispositivos_y_tarjetas'] = [];

        foreach ($dispositivos as $dispositivo) {
            // Para cada dispositivo, encontramos la tarjeta (horario) asociada
            $tarjeta = $horariosModel->where('dispositivo_id', $dispositivo['id'])
                                     ->where('usuario_id', $userId)
                                     ->first();

            $data['dispositivos_y_tarjetas'][] = [
                'dispositivo' => $dispositivo,
                'tarjeta' => $tarjeta
            ];
        }

        return view('vistadispositivo', $data);
    }

    public function cambiarNombreDispositivo()
    {
        $dispositivoModel = new DispositivoModel();
        $dispositivoId = $this->request->getPost('dispositivo_id');
        $nuevoNombre = $this->request->getPost('nombre_dispositivo');
        $userId = session()->get('id');

        $dispositivo = $dispositivoModel->where('id', $dispositivoId)->where('usuario_id', $userId)->first();

        if ($dispositivo) {
            $dispositivoModel->update($dispositivoId, ['nombre_dispositivo' => $nuevoNombre]);
            return redirect()->to('/dispositivos')->with('success', 'Nombre del dispositivo actualizado correctamente.');
        }

        return redirect()->to('/dispositivos')->with('error', 'No se pudo actualizar el nombre del dispositivo.');
    }
    
    public function cambiarNombreTarjeta()
    {
        $horariosModel = new HorariosModel();
        $tarjetaId = $this->request->getPost('tarjeta_id');
        $nuevoNombre = $this->request->getPost('nombre_tarjeta');
        $userId = session()->get('id');

        // Usamos el método belongsToUser para verificar la propiedad de la tarjeta
        if ($horariosModel->belongsToUser($tarjetaId, $userId)) {
            $horariosModel->update($tarjetaId, ['nombre_tarjeta' => $nuevoNombre]);
            return redirect()->to('/dispositivos')->with('success', 'Nombre de la tarjeta actualizado correctamente.');
        }

        return redirect()->to('/dispositivos')->with('error', 'No se pudo actualizar el nombre de la tarjeta.');
    }

    public function eliminarDispositivo($dispositivoId)
    {
        $dispositivoModel = new DispositivoModel();
        $horariosModel = new HorariosModel(); // Necesitamos el modelo de Horarios
        $userId = session()->get('id');

        // Verificamos que el dispositivo pertenece al usuario
        $dispositivo = $dispositivoModel->where('id', $dispositivoId)->where('usuario_id', $userId)->first();

        if ($dispositivo) {
            // 1. Eliminar la tarjeta/horario asociado de la tabla 'horarios'
            $horariosModel->where('dispositivo_id', $dispositivoId)
                          ->where('usuario_id', $userId) // Doble chequeo de seguridad
                          ->delete();

            // 2. Actualizar el dispositivo para liberarlo y limpiar datos
            $updateData = [
                'esta_usado' => 0,
                'usuario_id' => 0, // Desvincular del usuario
                'nombre_dispositivo' => '' // Limpiar el nombre del dispositivo
            ];
            $dispositivoModel->update($dispositivoId, $updateData);
            
            return redirect()->to('/dispositivos')->with('success', 'Dispositivo y tarjeta asociada eliminados correctamente.');
        }

        return redirect()->to('/dispositivos')->with('error', 'No se pudo encontrar o eliminar el dispositivo.');
    }
}