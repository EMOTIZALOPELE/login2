<?php

namespace App\Models;

use CodeIgniter\Model;

class CondicionanteModel extends Model
{
    protected $table = 'condicionantes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'ID_VCP', 
        'temp_min', 
        'temp_max', 
        'velocidad_viento_max', 
        'permitir_lluvia'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'ID_VCP'                 => 'required|integer',
        'temp_min'               => 'permit_empty|numeric',
        'temp_max'               => 'permit_empty|numeric',
        'velocidad_viento_max'   => 'permit_empty|numeric',
        'permitir_lluvia'        => 'permit_empty|integer',
    ];
    protected $validationMessages   = [];
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