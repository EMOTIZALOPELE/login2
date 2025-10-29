<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 
        'apellido', 
        'email', 
        'password', 
        'ciudad',
        'reset_token',
        'reset_expires',
        'verificacion_token',
        'verificacion_registro',
        'expira_verificacion',
        'is_verified'];
    protected $useTimestamps = true;
}