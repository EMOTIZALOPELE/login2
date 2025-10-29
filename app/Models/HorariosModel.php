<?php

namespace App\Models;

use CodeIgniter\Model;

class HorariosModel extends Model
{
    // Definir la tabla y los campos
    protected $table = 'horarios';
    protected $primaryKey = 'idhorario';
    protected $useAutoIncrement = true;
    
    // Definir los campos que se pueden insertar/actualizar
    protected $allowedFields = [
        'dispositivo_id', 
        'ventana_apertura',
        'ventana_cierre',
        'cortina_apertura',
        'cortina_cierre',
        'postigon_apertura',
        'postigon_cierre',
        'created_at',
        'updated_at',
        'usuario_id',
        'nombre_tarjeta'
    ];

    protected $beforeInsert = ['setUsuarioId'];
    protected $beforeUpdate = ['checkUsuarioId'];
    protected $beforeFind = ['checkUsuarioAccess'];

    protected function setUsuarioId(array $data)
    {
        $session = \Config\Services::session();
        if ($session->has('id')) {
            $data['data']['usuario_id'] = $session->get('id');
        } else {
            throw new \RuntimeException('No hay sesión de usuario activa');
        }
        return $data;
    }

    protected function checkUsuarioId(array $data)
    {
        $session = \Config\Services::session();
        if ($session->has('id')) {
            $data['data']['usuario_id'] = $session->get('id');
        } else {
            throw new \RuntimeException('No hay sesión de usuario activa');
        }
        return $data;
    }

    /**
     * ✅ CORRECCIÓN DEL BUG: Se elimina resetQuery() para evitar 
     * el error "Call to a member function getResult() on false"
     */
    protected function checkUsuarioAccess(array $data)
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            throw new \RuntimeException('No hay sesión de usuario activa');
        }

        $userId = $session->get('id');
        
        if (!isset($data['builder'])) {
            $data['builder'] = $this->builder();
        }
        
        // Simplemente añade la condición WHERE
        $data['builder']->where('usuario_id', $userId);
        
        return $data;
    }

    // =========================================================================
    // 🔥 MÉTODO DE ELIMINACIÓN EN CASCADA (Horarios -> Servos -> Servos_Dias)
    // =========================================================================
    public function delete($id = null, bool $purge = false): bool
    {
        $horarioId = is_array($id) ? array_shift($id) : $id;
        
        if (empty($horarioId)) {
            return false;
        }

        // 1. Iniciar la transacción para asegurar atomicidad
        $this->db->transBegin(); 
        
        try {
            // A. Obtener el dispositivo_id del horario que se va a borrar
            $horario = $this->select('dispositivo_id')
                            ->where($this->primaryKey, $horarioId)
                            ->first();

            if (!$horario) {
                $this->db->transRollback();
                return false;
            }

            $dispositivoId = $horario['dispositivo_id'];
            
            $servoModel = new \App\Models\ServoModel(); 

            // B. Obtener todos los Servos asociados a este Dispositivo
            // Esta es la lógica requerida: se borran TODOS los Servos del dispositivo de la tarjeta.
            $servosAsociados = $servoModel
                ->where('dispositivo_id', $dispositivoId) // <-- Usando dispositivo_id
                ->findAll();

            // C. Eliminar CADA Servo. El ServoModel se encarga de borrar sus 'servos_dias'.
            foreach ($servosAsociados as $servo) {
                // Llama al delete() del ServoModel (Servos -> Servos_Dias)
                $servoModel->delete($servo['id']); 
            }

            // D. Eliminar el registro principal (Tabla horarios)
            $result = $this->db->table($this->table)
                               ->where($this->primaryKey, $horarioId)
                               ->delete();

            if (!$result || $this->db->affectedRows() === 0) {
                $this->db->transRollback();
                return false;
            }

            // E. Commit de la transacción
            $this->db->transCommit();
            return true;

        } catch (\Exception $e) {
            // F. Rollback en caso de fallo
            $this->db->transRollback();
            log_message('error', 'Error en delete (HorariosModel Override/Rollback) para ID ' . $horarioId . ': ' . $e->getMessage());
            throw $e; 
        }
    }
    
    // ... otros métodos ...
    public function getHorariosByUserId($userId)
    {
        if (!$userId) {
            throw new \RuntimeException('ID de usuario no válido');
        }
        // Ya no necesita resetQuery()
        return $this->orderBy('idhorario', 'DESC')
                   ->findAll();
    }

    public function belongsToUser($horarioId, $userId)
    {
        if (!$userId || !$horarioId) {
            return false;
        }
        // Ya no necesita where('usuario_id', $userId) porque lo hace el hook beforeFind
        return $this->where('idhorario', $horarioId)
                   ->countAllResults() > 0;
    }

    public function cleanInvalidHorarios()
    {
        return $this->where('usuario_id', 0)->delete();
    }
}