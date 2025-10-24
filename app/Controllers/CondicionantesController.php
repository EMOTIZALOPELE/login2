<?php
namespace App\Controllers;
use App\Models\CondicionantesModel;

class CondicionantesController extends Controller
{
    public function guardar()
    {
        $condicionantesModel = new CondicionantesModel();
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
        return redirect()->to('/ruta_de_exito')->with('success', 'Condicionantes guardados correctamente.');
    }
}