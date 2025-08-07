<?php

namespace App\Models;

use CodeIgniter\Model;

class CondicionantesModel extends Model
{
    protected $table = 'condicionantes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'dispositivo_id',
        'ventana_apertura',
        'ventana_cierre',
        'temp_min',
        'temp_max',
        'velocidad_viento_max',
        'permitir_lluvia'
    ];

    // Opcional: Define reglas de validación para asegurar la integridad de los datos
    protected $validationRules = [
        'device_code' => 'required|max_length[20]',
        'ventana_apertura' => 'required',
        'ventana_cierre' => 'required',
        'min_temp' => 'required|numeric',
        'max_temp' => 'required|numeric',
        'allow_rain' => 'required|in_list[0,1]',
        'max_wind_speed' => 'required|numeric'
    ];
}