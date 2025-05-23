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
        // Ahora un solo campo 'identifier' que puede ser nombre de usuario o email
        $identifier = $this->request->getPost('identifier'); 
        $password = $this->request->getPost('password');

        // Validación básica para asegurar que los campos no estén vacíos
        if (empty($identifier) || empty($password)) {
            $session->setFlashdata('error', 'Por favor, ingresa tu nombre de usuario/email y contraseña.');
            return redirect()->back()->withInput(); // Redirige de vuelta con los datos para no perderlos
        }

        $user = null;

        // Intentar encontrar el usuario por email si el 'identifier' parece un email
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $usermodel->where('email', $identifier)->first();
        }

        // Si no se encontró por email o no era un email, intentar encontrarlo por nombre de usuario
        if (!$user) {
            $user = $usermodel->where('nombre', $identifier)->first();
        }
        
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
                $session->setFlashdata('error', 'Nombre de usuario/email o contraseña incorrectos.');
                return redirect()->back()->withInput();
            }
        } else {
            // Usuario no encontrado
            $session->setFlashdata('error', 'Nombre de usuario/email o contraseña incorrectos.');
            return redirect()->back()->withInput();
        }
    }
    public function logout()
    {
        // Destruir la sesión
        session()->destroy();
        return redirect()->to('/');
    }
    
    
    // RECUPERACIÓN DE CONTRASEÑA
    public function forgotPPassword() // Considera cambiar el nombre a 'forgotPassword' por consistencia
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
            $emailService->setFrom('valentinsalomone2001@gmail.com', 'VECOPO'); // Asegúrate de que este email sea válido para el envío
            $emailService->setSubject('Recuperación de contraseña');
            $emailService->setMessage("Haz clic en este enlace para recuperar tu contraseña: " . $resetLink);

            if ($emailService->send()) {
                // El correo se envió correctamente
                log_message('info', 'Correo de recuperación enviado a: ' . $user['email']);
            } else {
                // Error en el envío
                log_message('error', 'Error enviando correo de recuperación a ' . $user['email'] . ': ' . $emailService->printDebugger(['headers']));
            }
            
            if ($updated) {
                $session->setFlashdata('success', 'Se ha enviado un enlace de recuperación a tu correo.');
                return redirect()->back();
            } else {
                $session->setFlashdata('error', 'Error al actualizar el token de recuperación.');
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

        // Validación de contraseña (opcional pero muy recomendable)
        if (empty($password) || strlen($password) < 6) { // Ejemplo de validación mínima
            $session->setFlashdata('error', 'La contraseña debe tener al menos 6 caracteres.');
            return redirect()->back()->withInput();
        }

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

            $session->setFlashdata('success', 'Tu contraseña ha sido actualizada correctamente. Ya puedes iniciar sesión.');
            return redirect()->to('/iralogin'); // Redirige a la página de login
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
            // idhorario usualmente es auto-incrementado en la base de datos para nuevas entradas
            // y se usa para actualizaciones. Asegúrate de que tu formulario lo maneje correctamente.
            'idhorario'         => $this->request->getPost('idhorario'), // Puede ser null para nuevas entradas
            'ventana_apertura'  => $this->request->getPost('ventana_apertura'),
            'ventana_cierre'    => $this->request->getPost('ventana_cierre'),
            'cortina_apertura'  => $this->request->getPost('cortina_apertura'),
            'cortina_cierre'    => $this->request->getPost('cortina_cierre'),
            'postigon_apertura' => $this->request->getPost('postigon_apertura'),
            'postigon_cierre'   => $this->request->getPost('postigon_cierre'),
            // Asegúrate de que 'dispositivo_id' y 'usuario_id' también se manejen aquí si es una nueva tarjeta de horario
            'usuario_id' => $usuario_id, // Asegura que el horario se asocie al usuario
            // 'dispositivo_id' => $this->request->getPost('dispositivo_id'), // Si applies
        ];

        $horariosModel = new \App\Models\HorariosModel();

        // Si idhorario existe y no es nulo, intenta actualizar; de lo contrario, inserta.
        if (!empty($data['idhorario'])) {
            $existingHorario = $horariosModel->where('idhorario', $data['idhorario'])->first();
            if ($existingHorario) {
                // Verificar que el horario pertenezca al usuario para evitar manipulaciones
                if ($existingHorario['usuario_id'] != $usuario_id) {
                    session()->setFlashdata('error', 'No tienes permiso para actualizar este horario.');
                    return redirect()->back();
                }
                $horariosModel->update($existingHorario['idhorario'], $data); 
            } else {
                // Si el ID existe pero no se encontró el horario (ej: eliminado), se podría insertar uno nuevo o dar error.
                // Aquí, por simplicidad, si el ID no existe para actualización, asumimos que no se puede actualizar.
                session()->setFlashdata('error', 'El horario a actualizar no fue encontrado.');
                return redirect()->back();
            }
        } else {
            // Insertar un nuevo horario
            if (!$horariosModel->insert($data)) {
                session()->setFlashdata('error', 'Error al guardar los horarios.');
                return redirect()->back();
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
            // Si no hay horarios, puedes redirigir o mostrar un mensaje en la misma vista
            return view('horarios_view', ['error' => 'No se encontraron horarios.']);
        }

    // Pasar los datos a la vista
    return view('horarios_view', ['horarios' => $horarios]);
    }

}