<?php

namespace App\Models;

use CodeIgniter\Model;

class CondicionantesModel extends Model
{
    // Define la tabla a la que se conectará este modelo
    protected $table = 'condicionantes';
    // Define la clave primaria de la tabla
    protected $primaryKey = 'id';
    // Define los campos que se pueden modificar/guardar a través del modelo
    protected $allowedFields = ['dispositivo_id', 'temp_min', 'temp_max', 'velocidad_viento_max', 'permitir_lluvia', 'ID_VCP', 'usuario_ID'];
}