<?php

namespace App\Controllers;

use App\Models\HorariosModel; 
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Home extends Controller
{
    public function iniciar2()
    {
        return view('inicio2');
    }
    public function iralogin()
    {
        return view('login');
    }
    public function inicioregister()
    {
        return view('register');
    }
    public function iraconfiguracion()
    {
        return view('configuracion');
    }
    public function iradiseño()
    {
        return view('pele');
    }



////////////////////// ACA EMPIEZA LOGIN //////////////////////////
    public function login()
    {
        $session = session();
        $usermodel = new UserModel();

        // Captura los datos enviados desde el formulario
        $nombre = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Buscar el usuario en la base de datos
        $user = $usermodel->where('nombre', $nombre)
                          ->where('email', $email)
                          ->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Guardar datos en la sesión y redirigir al inicio
                $session->set([
                    'id'        => $user['id'],
                    'nombre'    => $user['nombre'],
                    'email'     => $user['email'],
                    'logged_in' => true,
                ]);
                
                return redirect()->to('/irainicio'); // Redirigir a la página de inicio
            } else {
                // Contraseña incorrecta
                $session->setFlashdata('error', 'Algo no ha salido bien');
                return redirect()->back();
            }
        } else {
            // Usuario no encontrado
            $session->setFlashdata('error', 'Algo no ha salido bien');
            return redirect()->back();
        }
    }
    public function logout()
    {
        // Destruir la sesión
        session()->destroy();
        return redirect()->to('/');
    }
    
   
    // RECUPERACIÓN DE CONTRASEÑA
    public function forgotPPassword()
    {
        $session = session();
        $usermodel = new UserModel();

        // Captura el email ingresado
        $email = $this->request->getPost('email');

        // Verifica si el usuario existe
        $user = $usermodel->where('email', $email)->first();

        if ($user) {
            // Genera el token de recuperación
            $token = bin2hex(random_bytes(50));
            $expires = Time::now()->addHours(1);

            // Actualiza el token en la base de datos
            $updated = $usermodel->update($user['id'], [
                'reset_token' => $token,
                'reset_expires' => $expires->toDateTimeString(),
            ]);

            // Enviar un correo electrónico con el enlace de recuperación
            $resetLink = base_url("/reset-password/$token");

            $emailService = \Config\Services::email();
            $emailService->setTo($user['email']);
            $emailService->setFrom('valentinsalomone2001@gmail.com', 'VECOPO');
            $emailService->setSubject('Recuperación de contraseña');
            $emailService->setMessage("Haz clic en este enlace para recuperar tu contraseña: " . $resetLink);

            if ($emailService->send()) {
                // El correo se envió correctamente
            } else {
                // Error en el envío
                log_message('error', 'Error enviando correo: ' . $emailService->printDebugger(['headers']));
            }
            
            if ($updated) {
                $session->setFlashdata('success', 'Se ha enviado un enlace de recuperación a tu correo.');
                return redirect()->back();
            } else {
                $session->setFlashdata('error', 'Error al actualizar el token.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Correo electrónico no encontrado.');
            return redirect()->back();
        }       
    }

    public function forgotpassword()
    {
        return view('forgotpassword');
    }

    public function showResetPasswordForm($token)
    {
        $usermodel = new UserModel();
        $user = $usermodel->where('reset_token', $token)
                          ->where('reset_expires >=', Time::now()->toDateTimeString())
                          ->first();

        if ($user) {
            return view('reset_password', ['token' => $token]);
        } else {
            session()->setFlashdata('error', 'Token de recuperación inválido o expirado.');
            return redirect()->to('/forgotpassword');
        }
    }

    public function resetPassword()
    {
        $session = session();
        $usermodel = new UserModel();

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        // Busca el usuario por el token
        $user = $usermodel->where('reset_token', $token)
                          ->where('reset_expires >=', Time::now()->toDateTimeString())
                          ->first();

        if ($user) {
            // Actualiza la contraseña y elimina el token
            $usermodel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'reset_token' => null,
                'reset_expires' => null,
            ]);

            $session->setFlashdata('success', 'Tu contraseña ha sido actualizada.');
            return redirect()->to('/');
        } else {
            $session->setFlashdata('error', 'Token de recuperación inválido o expirado.');
            return redirect()->back();
        }
    }

    // GESTIÓN DE HORARIOS

    public function guardar_horarios()
    {
        $usuario_id = session()->get('id');

        // Verifica si el ID de usuario está en la sesión
        if (!$usuario_id) {
            return 'Usuario no logueado'; 
        }

        $data = [
            'idhorario'         => $this->request->getPost('idhorario'),
            'ventana_apertura'  => $this->request->getPost('ventana_apertura'),
            'ventana_cierre'    => $this->request->getPost('ventana_cierre'),
            'cortina_apertura'  => $this->request->getPost('cortina_apertura'),
            'cortina_cierre'    => $this->request->getPost('cortina_cierre'),
            'postigon_apertura' => $this->request->getPost('postigon_apertura'),
            'postigon_cierre'   => $this->request->getPost('postigon_cierre'),
        ];

        $horariosModel = new \App\Models\HorariosModel();

        // Actualizar los horarios existentes
        $existingHorario = $horariosModel->where('idhorario', $data['idhorario'])->first();
        if ($existingHorario) {
            $horariosModel->update($existingHorario['idhorario'], $data); 
        } else {
            if (!$horariosModel->insert($data)) {
                return 'Error al guardar los horarios';
            }
        }

        return redirect()->to(base_url('irainicio'))->with('status', 'Horarios guardados correctamente.');
    }

    public function mostrarHorarios()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login'); // Redirigir si no está logueado
        }

        $horariosModel = new HorariosModel();
        $usuarioId = $session->get('id'); // Obtener el ID del usuario de la sesión

        // Obtener horarios del usuario usando where para filtrar por usuario_id
        $horarios = $horariosModel->where('usuario_id', $usuarioId)->findAll();

        // Comprobar si se obtuvieron horarios
        if (empty($horarios)) {
            return view('horarios_view', ['error' => 'No se encontraron horarios.']);
        }

    // Pasar los datos a la vista
    return view('horarios_view', ['horarios' => $horarios]);
    }

}