<?php
namespace App\Models;

use CodeIgniter\Model;

class DisenoModel extends Model
{
    protected $table = 'disenos';
    protected $primaryKey = 'id_diseno';

    protected $allowedFields = [
        'nombre',
        'cortina',
        'ventana',
        'postigon',
        'usuario_id',
        
    ];

    protected $useTimestamps = true;

    // Método para obtener todos los diseños
    public function getAllDisenos()
    {
        return $this->findAll();
    }

    // Método para obtener diseños de un usuario específico (opcional)
    public function getDisenosByUser($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->findAll();
    }
}
