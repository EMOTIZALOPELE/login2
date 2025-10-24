<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\HorariosModel;
use App\Models\ServoModel;

class DispositivoController extends BaseController
{
    protected $dispositivoModel;
    protected $horariosModel;
    protected $servoModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
        $this->horariosModel = new HorariosModel();
        $this->servoModel = new ServoModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $db = \Config\Database::connect();
        
        $dispositivos = $this->dispositivoModel->where('usuario_id', $userId)->where('esta_usado', 1)->findAll();
        $data['dispositivos_y_tarjetas'] = [];

        foreach ($dispositivos as $dispositivo) {

            // CONSULTA DIRECTA A LA BASE DE DATOS
            $tarjeta = $db->table('horarios')
                ->where('dispositivo_id', $dispositivo['id'])
                ->where('usuario_id', $userId)
                ->get()
                ->getRowArray();
            
            if ($tarjeta) {
            } else {
            }
            
            $servos = $this->servoModel->where('dispositivo_id', $dispositivo['id'])->findAll();
            
            $data['dispositivos_y_tarjetas'][] = [
                'dispositivo' => $dispositivo,
                'tarjeta' => $tarjeta,
                'servos' => $servos
            ];
        }

        $data['tarjetas'] = $this->horariosModel
            ->where('usuario_id', $userId)
            ->findAll();

        return view('vistadispositivo', $data);
    }

    public function cambiarNombreDispositivo()
    {
        $dispositivoId = $this->request->getPost('dispositivo_id');
        $nuevoNombre = $this->request->getPost('nombre_dispositivo');
        $userId = session()->get('id');
        $dispositivo = $this->dispositivoModel->where('id', $dispositivoId)->where('usuario_id', $userId)->first();

        if ($dispositivo) {
            $this->dispositivoModel->update($dispositivoId, ['nombre_dispositivo' => $nuevoNombre]);
            return redirect()->to('/dispositivos')->with('success', 'Nombre del dispositivo actualizado correctamente.');
        }
        return redirect()->to('/dispositivos')->with('error', 'No se pudo actualizar el nombre del dispositivo.');
    }

    public function cambiarNombreTarjeta()
    {
        $tarjetaId = $this->request->getPost('tarjeta_id');
        $nuevoNombre = $this->request->getPost('nombre_tarjeta');
        $userId = session()->get('id');
        
        // 🔍 DEBUG DETALLADO
        log_message('debug', "=== CAMBIAR NOMBRE TARJETA ===");
        log_message('debug', "tarjeta_id recibido: " . $tarjetaId);
        log_message('debug', "nuevo_nombre: " . $nuevoNombre);
        log_message('debug', "usuario_id: " . $userId);
        
        // Verificar si la tarjeta existe y pertenece al usuario
        $tarjeta = $this->horariosModel
            ->where('idhorario', $tarjetaId)
            ->where('usuario_id', $userId)
            ->first();
        
        if ($tarjeta) {
            log_message('debug', "Tarjeta encontrada - ID: {$tarjeta['idhorario']}, Dispositivo ID: {$tarjeta['dispositivo_id']}, Nombre actual: {$tarjeta['nombre_tarjeta']}");
            
            $this->horariosModel->update($tarjetaId, ['nombre_tarjeta' => $nuevoNombre]);
            
            log_message('debug', "✅ Nombre actualizado exitosamente");
            return redirect()->to('/dispositivos')->with('success', 'Nombre de la tarjeta actualizado correctamente.');
        } else {
            log_message('error', "❌ Tarjeta $tarjetaId no encontrada o no pertenece al usuario $userId");
            return redirect()->to('/dispositivos')->with('error', 'No se pudo actualizar el nombre de la tarjeta.');
        }
    }

    public function cambiarNombreServo()
    {
        $servoId = $this->request->getPost('servo_id');
        $nuevoNombre = $this->request->getPost('nombre_servo');
        $userId = session()->get('id');
        if (empty($nuevoNombre)) {
            return redirect()->back()->with('error', 'El nombre del servo no puede estar vacío.');
        }
        $servo = $this->servoModel->find($servoId);
        if (!$servo) {
            return redirect()->back()->with('error', 'Servo no encontrado.');
        }
        $dispositivo = $this->dispositivoModel->where('id', $servo['dispositivo_id'])->where('usuario_id', $userId)->first();
        if (!$dispositivo) {
            return redirect()->back()->with('error', 'No tienes permisos para modificar este servo.');
        }
        $this->servoModel->update($servoId, [
            'nombre_servo' => $nuevoNombre,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('success', 'Nombre del servo actualizado correctamente.');
    }

    public function eliminarDispositivo($dispositivoId)
    {
        $userId = session()->get('id');
        $dispositivo = $this->dispositivoModel->where('id', $dispositivoId)->where('usuario_id', $userId)->first();

        if ($dispositivo) {
            $this->servoModel->where('dispositivo_id', $dispositivoId)->delete();
            $this->horariosModel->where('dispositivo_id', $dispositivoId)->where('usuario_id', $userId)->delete();
            $this->dispositivoModel->update($dispositivoId, [
                'esta_usado' => 0,
                'usuario_id' => null,
                'nombre_dispositivo' => ''
            ]);
            return redirect()->to('/dispositivos')->with('success', 'Dispositivo, servos y tarjeta asociada eliminados correctamente.');
        }
        return redirect()->to('/dispositivos')->with('error', 'No se pudo encontrar o eliminar el dispositivo.');
    }
}