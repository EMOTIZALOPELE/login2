<?php
namespace App\Models;

use CodeIgniter\Model;

class DesignModel extends Model
{
    protected $table = 'designs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['Nombreventana', 'ventana', 'cortina', 'postigon'];  // Cambié 'nombre' por 'Nombreventana'
    protected $useTimestamps = true;
}
