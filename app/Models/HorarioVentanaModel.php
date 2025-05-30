<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioVentanaModel extends Model
{
    protected $table = 'horarios_ventana';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'diseno_id', 
        'hora_apertura', 
        'hora_cierre', 
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

    public function updateHorarios($disenoId, $data)
    {
        return $this->where('diseno_id', $disenoId)->set($data)->update();
    }

    public function actualizarEstado($disenoId, $estado)
    {
        return $this->where('diseno_id', $disenoId)
                    ->set('estado_actual', $estado)
                    ->update();
    }

    public function getEstadoActual($disenoId)
    {
        $horario = $this->where('diseno_id', $disenoId)->first();
        return $horario ? $horario['estado_actual'] : null;
    }
} 