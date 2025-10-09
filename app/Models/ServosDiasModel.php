<?php

namespace App\Models;

use CodeIgniter\Model;

class ServosDiasModel extends Model
{
    protected $table = 'servos_dias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['servo_id', 'dia_semana_id'];

    /**
     * Obtiene los IDs de los días de la semana para un servo específico.
     * @param int $servoId
     * @return array
     */
    public function getDiasForServo(int $servoId): array
    {
        return $this->where('servo_id', $servoId)->findAll();
    }

    /**
     * Guarda los días de la semana para un servo, eliminando los existentes y creando nuevos.
     * @param int $servoId
     * @param array $diasIds
     * @return bool
     */
    public function saveDiasForServo(int $servoId, array $diasIds): bool
    {
        // 1. Eliminar los días existentes para el servo
        $this->where('servo_id', $servoId)->delete();

        // 2. Insertar los nuevos días
        $data = [];
        foreach ($diasIds as $diaId) {
            $data[] = [
                'servo_id' => $servoId,
                'dia_semana_id' => $diaId,
            ];
        }
        
        if (!empty($data)) {
            return $this->insertBatch($data);
        }

        return true;
    }

    /**
     * Obtiene todos los días de la semana de la tabla 'dias_semanas'.
     * @return array
     */
    public function getDiasSemanaReference(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dias_semanas');
        return $builder->get()->getResultArray();
    }
}