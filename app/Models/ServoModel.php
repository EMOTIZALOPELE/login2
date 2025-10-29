<?php

namespace App\Models;

use CodeIgniter\Model;

class ServoModel extends Model
{
    // Nombre de la tabla de tu base de datos
    protected $table = 'servos'; 

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Lista completa de campos permitidos, AHORA INCLUYE 'horario_id' para la relación FK
    protected $allowedFields = [
        'dispositivo_id',
        'pin_gpio',
        'tipo_elemento',
        'nombre_servo',
        'horario_apertura',
        'horario_cierre',
        'estado_actual',
        'modo_operacion',
        'manual_override_expires',
        'updated_at',
        'temp_min_cierre',
        'temp_max_apertura',
        'viento_max_cierre',
        'permitir_lluvia'
    ];

    // Configuración de Timestamps (solo usamos updated_at)
    protected $useTimestamps = true;
    protected $createdField  = ''; // No usamos 'created_at'
    protected $updatedField  = 'updated_at'; // Tu campo se llama 'updated_at'
    protected $deletedField  = '';

    // =========================================================================
    // 🔥 FUNCIÓN DE ELIMINACIÓN EN CASCADA (SOBRESCRITURA DE MÉTODO NATIVO)
    // Cuando borras un Servo (PADRE), primero borra sus días asignados (HIJO: servos_dias).
    // =========================================================================

    /**
     * Sobrescribe el método delete() nativo para forzar la eliminación en cascada.
     * Siempre elimina los registros dependientes (servos_dias) primero, dentro de una transacción.
     * @param int|array|null $id El ID del servo a eliminar.
     * @param bool $purge Parámetro no usado pero requerido por la firma base.
     * @return bool
     */
    public function delete($id = null, bool $purge = false): bool
    {
        // Aseguramos que $id sea un entero (o null si el Framework maneja múltiples IDs)
        $singleId = is_array($id) ? array_shift($id) : $id;
        
        if (empty($singleId)) {
            return false;
        }

        // 1. Iniciar la transacción
        $this->db->transBegin(); 

        try {
            log_message('info', 'Iniciando limpieza de dependencias para servo ID: ' . $singleId);
            
            // PASO 1: Eliminar primero los registros dependientes (Tabla HIJA: servos_dias)
            $builder = $this->db->table('servos_dias');
            // La columna de clave foránea es 'servo_id'
            $builder->where('servo_id', $singleId)->delete(); 
            
            $affectedRows = $this->db->affectedRows();

            log_message('info', "Registros eliminados de 'servos_dias': " . $affectedRows);

            // Verificamos si hubo un error de DB no capturado
            if ($this->db->error()['code'] != 0) {
                 throw new \Exception("Error al eliminar registros de servos_dias: " . $this->db->error()['message']);
            }

            // PASO 2: Eliminar el registro principal (Tabla PADRE: servos)
            // Usamos el Query Builder de la conexión directamente para evitar recursión
            $result = $this->db->table($this->table)->where($this->primaryKey, $singleId)->delete();
            
            // Verificamos si la eliminación del padre fue exitosa o si no existía
            if (!$result || $this->db->affectedRows() === 0) {
                // Forzar un rollback si el registro no se encontró o no se pudo borrar
                $this->db->transRollback();
                throw new \Exception("La eliminación del registro principal (servos) falló o el registro no existe.");
            }

            // 3. Si todo fue bien, confirmar la transacción
            $this->db->transCommit();
            log_message('info', 'Eliminación en cascada FINALIZADA exitosamente para servo ID: ' . $singleId);
            return true;

        } catch (\Exception $e) {
            // 4. Si algo falla, revertir la transacción y registrar el error exacto
            $this->db->transRollback();
            log_message('error', 'Error en delete (Override/Rollback) para ID ' . $singleId . ': ' . $e->getMessage());
            // Lanzar el error para que sea capturado por el controlador y retorne un 500
            throw $e; 
        }
    }
}
