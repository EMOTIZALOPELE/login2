<?php

namespace App\Models;
use CodeIgniter\Model;

class DispositivoModel extends Model
{
    protected $table = 'dispositivos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'mac_address', 
        'Nombre_tarjeta',
        'usuario_id', 
        'created_at', 
        'updated_at',
        'esta_usado'  
    ];

    // Función útil para verificar si una MAC está disponible
    public function macDisponible($mac)
    {
        // CAMBIADO: Ahora busca en la columna 'mac_address'
        return $this->where('mac_address', $mac)->where('esta_usado', 0)->first();
    }
}