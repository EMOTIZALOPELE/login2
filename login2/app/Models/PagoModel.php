<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'pagos';

    // Nombre de la clave primaria de la tabla
    protected $primaryKey = 'id';

    // Indica si la clave primaria es auto-incremental
    protected $useAutoIncrement = true;

    // Tipo de dato para la clave primaria. Por defecto es int.
    // protected $returnType     = 'array'; // Puedes cambiar a 'object' si prefieres objetos

    // Indica si se deben usar timestamps (created_at, updated_at)
    // En este caso, tu controlador ya guarda la fecha manualmente,
    // pero puedes habilitarlos si prefieres que el modelo los maneje.
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Si usas soft deletes

    // Indica si se usan soft deletes (no se borran registros, solo se marcan)
    // protected $useSoftDeletes = false;

    // Campos permitidos para inserción o actualización masiva
    protected $allowedFields = [
        'order_id',
        'email',
        'monto',
        'moneda',
        'fecha', // Campo para la fecha y hora del pago
        'estado',
        'detalles', // Para almacenar los detalles completos de la respuesta de PayPal (JSON)
    ];

    // Reglas de validación antes de insertar o actualizar
    // Puedes añadir reglas más específicas aquí si es necesario
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false; // No saltar validación por defecto

    // Callbacks que se ejecutarán en ciertos eventos del ciclo de vida del modelo
    // protected $beforeInsert = [];
    // protected $afterInsert  = [];
    // protected $beforeUpdate = [];
    // protected $afterUpdate  = [];
    // protected $beforeFind   = [];
    // protected $afterFind    = [];
    // protected $beforeDelete = [];
    // protected $afterDelete  = [];

    // Nota: Tu PayPalController inserta directamente usando $db->table('pagos')->insert($data);
    // Si quisieras usar este modelo para insertar, podrías hacerlo así en el controlador:
    // $pagoModel = new \App\Models\PagoModel();
    // $pagoModel->insert($data);
    // Esto activaría los callbacks definidos en este modelo si los tuvieras.
}