<?php

namespace App\Models;

use CodeIgniter\Model;

class DisenoModel extends Model
{
    protected $table = 'disenos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'cortina',
        'ventana',
        'postigon',
        'usuario_id',
        
    ];

    protected $useTimestamps = true;
}
