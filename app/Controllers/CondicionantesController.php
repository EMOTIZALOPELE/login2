<?php
namespace App\Controllers;
use App\Models\Condicionantes_model;
use CodeIgniter\Controller;
class CondicionantesController extends Controller
{
    public function guardar()
    {
        $condicionantesModel = new CondicionantesModel();

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

        return redirect()->to('/ruta_de_exito')->with('success', 'Condicionantes guardados correctamente.');
    }
}