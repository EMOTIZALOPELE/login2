<?php

namespace App\Controllers;
use App\Models\Servomodel;
use CodeIgniter\HTTP\Response;

class ServoController extends BaseController
{
    public function nazi()
    {
        $model = new Servomodel();
        $data['ultimo_estado'] = $model->orderBy('id', 'DESC')->first();
        return view('funcional_view', $data);
    }

    public function actualizarEstado($estado)
{
    $model = new Servomodel();

    // Siempre actualiza el registro con id = 1
    $data = [
        'estado' => strtoupper($estado),
        'created_at' => date('Y-m-d H:i:s') // por si querés actualizar también la fecha
    ];

    $success = $model->update(1, $data);

    if (!$success) {
        return $this->response->setJSON([
            'status' => 'error',
            'errores' => $model->errors()
        ]);
    }

    return $this->response->setJSON([
        'status' => 'ok',
        'estado' => strtoupper($estado)
    ]);
}

    public function obtenerUltimoEstado()
{
    $model = new Servomodel();
    $ultimo = $model->orderBy('id', 'DESC')->first();

    if ($ultimo && isset($ultimo['estado'])) {
        return $this->response->setJSON(['estado' => strtoupper($ultimo['estado'])]);
    } else {
        return $this->response->setJSON(['estado' => 'DESCONOCIDO']);
    }
}


    public function obtenerEstado()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('funcional');
        $builder->select('estado');
        $builder->orderBy('created_at', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        $row = $query->getRow();

        if ($row) {
            return $this->response->setJSON(['estado' => $row->estado]);
        } else {
            return $this->response->setJSON(['estado' => 'desconocido']);
        }
    }

    public function estado()
    {
        return view('ServoView');
    }
}