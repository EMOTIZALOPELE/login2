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
        'ventana_apertura',
        'ventana_cierre',
        'cortina_apertura',
        'cortina_cierre',
        'postigon_apertura',
        'postigon_cierre',
        'usuario_id',
        'nombre_tarjeta',
        'diseno_id',
        'dias_semana'
    ]; 

    protected $beforeInsert = ['setUsuarioId'];
    protected $beforeUpdate = ['checkUsuarioId'];

    protected function setUsuarioId(array $data)
    {
        $session = \Config\Services::session();
        if ($session->has('id')) {
            $data['data']['usuario_id'] = $session->get('id');
        }
        return $data;
    }

    protected function checkUsuarioId(array $data)
    {
        $session = \Config\Services::session();
        if ($session->has('id')) {
            $data['data']['usuario_id'] = $session->get('id');
        }
        return $data;
    }

    public function getHorariosByUserId($userId)
    {
        return $this->where('usuario_id', $userId)->findAll();
    }
}