<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\HorariosModel;
use App\Models\ServoModel;
use CodeIgniter\Controller;

class DispositivoController extends BaseController
{
    public function index()
    {
        $dispositivoModel = new DispositivoModel();
        $horariosModel = new HorariosModel();
        $servoModel = new ServoModel();
        $userId = session()->get('id');

        // Obtenemos todos los dispositivos asociados al usuario
        $dispositivos = $dispositivoModel->where('usuario_id', $userId)->where('esta_usado', 1)->findAll();
        
        $data['dispositivos_y_tarjetas'] = [];

        foreach ($dispositivos as $dispositivo) {
            // Para cada dispositivo, encontramos la tarjeta (horario) asociada
            $tarjeta = $horariosModel->where('dispositivo_id', $dispositivo['id'])
                                     ->where('usuario_id', $userId)
                                     ->first();

            // Obtenemos los servos asociados a este dispositivo
            $servos = $servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();

            $data['dispositivos_y_tarjetas'][] = [
                'dispositivo' => $dispositivo,
                'tarjeta' => $tarjeta,
                'servos' => $servos
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

    public function cambiarNombreServo()
    {
        try {
            $servoModel = new ServoModel();
            $dispositivoModel = new DispositivoModel();
            
            $servoId = $this->request->getPost('servo_id');
            $nuevoNombre = $this->request->getPost('nombre_servo');
            $userId = session()->get('id');

            // Validar que el nombre no esté vacío
            if (empty($nuevoNombre)) {
                return redirect()->back()->with('error', 'El nombre del servo no puede estar vacío.');
            }

            // Verificar que el servo pertenece a un dispositivo del usuario
            $servo = $servoModel->find($servoId);
            if (!$servo) {
                return redirect()->back()->with('error', 'Servo no encontrado.');
            }

            $dispositivo = $dispositivoModel->where('id', $servo['dispositivo_id'])
                                           ->where('usuario_id', $userId)
                                           ->first();

            if (!$dispositivo) {
                return redirect()->back()->with('error', 'No tienes permisos para modificar este servo.');
            }

            // Actualizar en la base de datos
            $servoModel->update($servoId, [
                'nombre_servo' => $nuevoNombre,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', 'Nombre del servo actualizado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el nombre del servo: ' . $e->getMessage());
        }
    }

    public function eliminarDispositivo($dispositivoId)
    {
        $dispositivoModel = new DispositivoModel();
        $horariosModel = new HorariosModel();
        $servoModel = new ServoModel();
        $userId = session()->get('id');

        // Verificamos que el dispositivo pertenece al usuario
        $dispositivo = $dispositivoModel->where('id', $dispositivoId)->where('usuario_id', $userId)->first();

        if ($dispositivo) {
            // 1. Eliminar los servos asociados al dispositivo
            $servoModel->where('dispositivo_id', $dispositivoId)->delete();

            // 2. Eliminar la tarjeta/horario asociado de la tabla 'horarios'
            $horariosModel->where('dispositivo_id', $dispositivoId)
                          ->where('usuario_id', $userId)
                          ->delete();

            // 3. Actualizar el dispositivo para liberarlo y limpiar datos
            $updateData = [
                'esta_usado' => 0,
                'usuario_id' => null,
                'nombre_dispositivo' => ''
            ];
            $dispositivoModel->update($dispositivoId, $updateData);
            
            return redirect()->to('/dispositivos')->with('success', 'Dispositivo, servos y tarjeta asociada eliminados correctamente.');
        }

        return redirect()->to('/dispositivos')->with('error', 'No se pudo encontrar o eliminar el dispositivo.');
    }
    
}