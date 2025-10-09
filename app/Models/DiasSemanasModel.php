<?php

namespace App\Models;
use CodeIgniter\Model;

class DiasSemanasModel extends Model
{
    protected $table = 'dias_semanas';
    protected $primaryKey = 'ID';
    protected $allowedFields = [
        'DIA_semana'
    ];
}