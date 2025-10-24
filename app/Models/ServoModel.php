<?php

namespace App\Models;

use CodeIgniter\Model;

class ServoModel extends Model
{
    // Nombre de la tabla de tu base de datos
    protected $table = 'servos'; 

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // ¡ESTA ES LA PARTE IMPORTANTE!
    // Lista completa de campos permitidos, según tu imagen de la BD.
    protected $allowedFields = [
        'dispositivo_id',
        'pin_gpio',
        'tipo_elemento',
        'nombre_servo',
        'horario_apertura',
        'horario_cierre',
        'estado_actual',
        'modo_operacion',
        'manual_override_expires',
        'updated_at',
        'temp_min_cierre',
        'temp_max_apertura',
        'viento_max_cierre',
        'permitir_lluvia'
    ];

    // Configuración de Timestamps (solo usamos updated_at)
    protected $useTimestamps = true;
    protected $createdField  = ''; // No usamos 'created_at'
    protected $updatedField  = 'updated_at'; // Tu campo se llama 'updated_at'
    protected $deletedField  = '';
}