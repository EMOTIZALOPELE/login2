<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DesignModel;

class DesignController extends Controller
{
    public function saveDesign()
    {
        // Obtener los datos del formulario
        $nombreventana = $this->request->getPost('Nombreventana');  // Cambiar 'nombre' por 'Nombreventana'
        $ventana = $this->request->getPost('ventana');
        $cortina = $this->request->getPost('cortina');
        $postigon = $this->request->getPost('postigon');

        // Validar los datos
        if ($nombreventana && $ventana && $cortina && $postigon) {
            $model = new DesignModel();

            // Guardar en la base de datos
            $model->save([
                'Nombreventana' => $nombreventana,  // Cambiar 'nombre' por 'Nombreventana'
                'ventana' => $ventana,
                'cortina' => $cortina,
                'postigon' => $postigon,
            ]);

            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
}
