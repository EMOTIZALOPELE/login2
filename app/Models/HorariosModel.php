<?php

namespace App\Models;

use CodeIgniter\Model;

class HorariosModel extends Model
{
    // Definir la tabla y los campos
    protected $table = 'horarios';
    protected $primaryKey = 'idhorario';
    
    // Definir los campos que se pueden insertar/actualizar
    protected $allowedFields = [
        'ventana_apertura',
        'ventana_cierre',
        'cortina_apertura',
        'cortina_cierre',
        'postigon_apertura',
        'postigon_cierre',
        'usuario_id',
        'nombre_tarjeta',
    ]; 
}
