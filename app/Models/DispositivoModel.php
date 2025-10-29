<?php

namespace App\Models;
use CodeIgniter\Model;

class DispositivoModel extends Model
{
    protected $table = 'dispositivos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo',
        'Nombre_tarjeta',
        'usuario_id', 
        'created_at', 
        'updated_at',
        'esta_usado',
        'pago_id'
    ];

    // Función útil para verificar si un código está disponible
    public function codigoDisponible($codigo)
    {
        return $this->where('codigo', $codigo)->where('esta_usado', 0)->first();
    }
}