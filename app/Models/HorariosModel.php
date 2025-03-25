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
        'diseno_id',
        'usuario_id'
    ];
    
    // Habilitar la protección contra modificaciones masivas
    protected $useTimestamps = true;
    
    // Validaciones
    protected $validationRules = [
        'ventana_apertura' => 'required',
        'ventana_cierre' => 'required',
        'cortina_apertura' => 'required',
        'cortina_cierre' => 'required',
        'postigon_apertura' => 'required',
        'postigon_cierre' => 'required',
        'diseno_id' => 'required|integer',
        'usuario_id' => 'required|integer'
    ];
    
    // Métodos adicionales si es necesario

    // Buscar horarios por usuario y diseño
    public function getHorariosByUserAndDesign($usuario_id, $diseno_id)
    {
        return $this->where('usuario_id', $usuario_id)
                    ->where('diseno_id', $diseno_id)
                    ->first(); // O usar ->findAll() si se requieren múltiples resultados
    }
}
