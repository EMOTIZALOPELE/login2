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
        'diseno_id',
        'ventana_apertura',
        'ventana_cierre',
        'cortina_apertura',
        'cortina_cierre',
        'postigon_apertura',
        'postigon_cierre',
        'dias_semana',
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

    protected function checkUsuarioAccess(array $data)
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            throw new \RuntimeException('No hay sesión de usuario activa');
        }

        $userId = $session->get('id');
        
        // Si no hay where clause, agregar el filtro de usuario
        if (!isset($data['builder'])) {
            $data['builder'] = $this->builder();
        }
        
        // Asegurarse de que siempre se filtre por usuario_id
        $data['builder']->where('usuario_id', $userId);
        
        // Limpiar cualquier condición where anterior que no sea usuario_id
        $data['builder']->resetQuery();
        $data['builder']->where('usuario_id', $userId);
        
        return $data;
    }

    public function getHorariosByUserId($userId)
    {
        if (!$userId) {
            throw new \RuntimeException('ID de usuario no válido');
        }
        
        // Limpiar cualquier condición where anterior
        $this->builder()->resetQuery();
        
        return $this->where('usuario_id', $userId)
                   ->orderBy('idhorario', 'DESC')
                   ->findAll();
    }

    public function belongsToUser($horarioId, $userId)
    {
        if (!$userId || !$horarioId) {
            return false;
        }
        return $this->where('idhorario', $horarioId)
                   ->where('usuario_id', $userId)
                   ->countAllResults() > 0;
    }

    // Método para limpiar horarios inválidos
    public function cleanInvalidHorarios()
    {
        return $this->where('usuario_id', 0)->delete();
    }
}