<?php

namespace App\Models;

use CodeIgniter\Model;

class ServoModel extends Model
{
    protected $table = 'servos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // Cambia a true si usas soft deletes

    protected $allowedFields    = [
        'dispositivo_id',
        'pin_gpio',
        'tipo_elemento',
        'nombre_servo',
        'horario_apertura',
        'horario_cierre',
        'estado_actual',
        'modo_operacion',
        'updated_at',
        'temp_min_cierre',
        'temp_max_apertura',
        'viento_max_cierre',
        'permitir_lluvia'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true; // Cambiar a true para usar created_at y updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'estado_actual' => 'required|in_list[ABIERTO,CERRADO]',
        'modo_operacion' => 'required|in_list[MANUAL,AUTOMATICO]'
    ];
    protected $validationMessages = [
        'estado_actual' => [
            'required' => 'El estado actual es requerido',
            'in_list' => 'El estado debe ser ABIERTO o CERRADO'
        ],
        'modo_operacion' => [
            'required' => 'El modo de operación es requerido',
            'in_list' => 'El modo debe ser MANUAL o AUTOMATICO'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}