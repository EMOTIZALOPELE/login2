<?php
namespace App\Controllers;
<<<<<<< HEAD
use App\Models\CondicionantesModel;

=======
use App\Models\Condicionantes_model;
use CodeIgniter\Controller;
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
class CondicionantesController extends Controller
{
    public function guardar()
    {
        $condicionantesModel = new CondicionantesModel();
<<<<<<< HEAD
        $tipos = ['ventana', 'cortina', 'postigon'];

        foreach ($tipos as $tipo) {
            $data = [
                'dispositivo_id' => $this->request->getPost("dispositivo_id_$tipo"),
                'ID_VCP' => $this->request->getPost("ID_VCP_$tipo"),
                'usuario_ID' => $this->request->getPost("usuario_ID_$tipo"),
                'temp_min' => $this->request->getPost("min_temp_$tipo"),
                'temp_max' => $this->request->getPost("max_temp_$tipo"),
                'velocidad_viento_max' => $this->request->getPost("max_wind_speed_$tipo"),
                'permitir_lluvia' => $this->request->getPost("allow_rain_$tipo"),
            ];
            $condicionantesModel->save($data);
        }
=======

        // Datos para Ventana (ID_VCP = 1)
        $dataVentana = [
            'dispositivo_id' => $this->request->getPost('dispositivo_id_ventana'),
            'ID_VCP' => $this->request->getPost('ID_VCP_ventana'),
            'usuario_ID' => $this->request->getPost('usuario_ID_ventana'),
            'temp_min' => $this->request->getPost('min_temp_ventana'),
            'temp_max' => $this->request->getPost('max_temp_ventana'),
            'velocidad_viento_max' => $this->request->getPost('max_wind_speed_ventana'),
            'permitir_lluvia' => $this->request->getPost('allow_rain_ventana'),
        ];
        $condicionantesModel->save($dataVentana);

        // Datos para Cortina (ID_VCP = 2)
        $dataCortina = [
            'dispositivo_id' => $this->request->getPost('dispositivo_id_cortina'),
            'ID_VCP' => $this->request->getPost('ID_VCP_cortina'),
            'usuario_ID' => $this->request->getPost('usuario_ID_cortina'),
            'temp_min' => $this->request->getPost('min_temp_cortina'),
            'temp_max' => $this->request->getPost('max_temp_cortina'),
            'velocidad_viento_max' => $this->request->getPost('max_wind_speed_cortina'),
            'permitir_lluvia' => $this->request->getPost('allow_rain_cortina'),
        ];
        $condicionantesModel->save($dataCortina);

        // Datos para Postigón (ID_VCP = 3)
        $dataPostigon = [
            'dispositivo_id' => $this->request->getPost('dispositivo_id_postigon'),
            'ID_VCP' => $this->request->getPost('ID_VCP_postigon'),
            'usuario_ID' => $this->request->getPost('usuario_ID_postigon'),
            'temp_min' => $this->request->getPost('min_temp_postigon'),
            'temp_max' => $this->request->getPost('max_temp_postigon'),
            'velocidad_viento_max' => $this->request->getPost('max_wind_speed_postigon'),
            'permitir_lluvia' => $this->request->getPost('allow_rain_postigon'),
        ];
        $condicionantesModel->save($dataPostigon);

>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
        return redirect()->to('/ruta_de_exito')->with('success', 'Condicionantes guardados correctamente.');
    }
}