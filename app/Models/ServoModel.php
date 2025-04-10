<?php

namespace App\Models;
use CodeIgniter\Model;

class Servomodel extends Model
{
    protected $table = 'funcional';
    protected $primaryKey = 'id';
    protected $allowedFields = ['estado', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}