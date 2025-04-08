<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $table = 'horarios';
    protected $primaryKey = 'idhorario';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'diseno_id',
        'ventana_apertura',
        'ventana_cierre',
        'dias_semana',
        'estado_actual'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getHorariosByDiseno($disenoId)
    {
        return $this->where('diseno_id', $disenoId)->first();
    }

    public function actualizarEstado($disenoId, $estado)
    {
        return $this->where('diseno_id', $disenoId)
                    ->set('estado_actual', $estado)
                    ->update();
    }
} 