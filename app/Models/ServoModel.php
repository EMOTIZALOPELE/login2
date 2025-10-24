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

<<<<<<< HEAD
    // ¡ESTA ES LA PARTE IMPORTANTE!
    // Lista completa de campos permitidos, según tu imagen de la BD.
    protected $allowedFields = [
=======
    protected $allowedFields    = [
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
        'dispositivo_id',
        'pin_gpio',
        'tipo_elemento',
        'nombre_servo',
        'horario_apertura',
        'horario_cierre',
        'estado_actual',
        'modo_operacion',
<<<<<<< HEAD
        'manual_override_expires',
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
        'updated_at',
        'temp_min_cierre',
        'temp_max_apertura',
        'viento_max_cierre',
<<<<<<< HEAD
        'permitir_lluvia'
=======
        'permitir_lluvia',
        'manual_override_expires'
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
    ];

    // Configuración de Timestamps (solo usamos updated_at)
    protected $useTimestamps = true;
    protected $createdField  = ''; // No usamos 'created_at'
    protected $updatedField  = 'updated_at'; // Tu campo se llama 'updated_at'
    protected $deletedField  = '';
}