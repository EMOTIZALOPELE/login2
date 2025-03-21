<?php

namespace App\Models;

use CodeIgniter\Model;

class HorariosModel extends Model
{
    protected $table = 'horarios';           // Nombre de la tabla
    protected $primaryKey = 'idhorario';     // Clave primaria
    protected $allowedFields = [             // Campos que se pueden insertar/actualizar
        'ventana_apertura',
        'ventana_cierre',
        'cortina_apertura',
        'cortina_cierre',
        'postigon_apertura',
        'postigon_cierre',
        'usuario_id',
        'nombre_tarjeta',
    ];
    protected $useTimestamps = true;         // Para gestionar created_at y updated_at
}
