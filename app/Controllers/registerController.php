<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class registerController extends Controller
{
    public function store()
    {
        // Validación del formulario
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nombre'  => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El campo nombre es obligatorio.',
                    'min_length' => 'El campo nombre debe tener al menos 3 caracteres.'
                ]
            ],
            'apellido' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El campo apellido es obligatorio.',
                    'min_length' => 'El campo apellido debe tener al menos 3 caracteres.'
                ]
            ],
            'email'   => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El campo email es obligatorio.',
                    'valid_email' => 'El campo email debe contener una dirección válida.',
                    'is_unique' => 'El email ya está registrado.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio.',
                    'min_length' => 'La contraseña debe tener al menos 6 caracteres.'
                ]
            ],
            'terms' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debes aceptar los términos y condiciones.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $userEmail = $this->request->getPost('email');

        // Verificar si el email ya existe (doble verificación)
        $existingUser = $userModel->where('email', $userEmail)->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('errors', ['El email ya está registrado.']);
        }

        // Generar código de verificación
        $verificationCode = sprintf("%06d", mt_rand(1, 999999));
        $expirationTime = Time::now()->addHours(1);

        // Guardar el usuario
        $userModel->save([
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $userEmail,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'verificacion_registro' => $verificationCode,
            'is_verified' => 0,
            'expira_verificacion' => $expirationTime->toDateTimeString()
        ]);

        // Enviar email con el código de verificación
        $this->sendVerificationEmail($userEmail, $verificationCode);

        // Redirigir a la vista donde el usuario ingresará el código
        return redirect()->to('/verify-code-view?email=' . urlencode($userEmail))->with('success', '¡Registro exitoso! Te hemos enviado un código de verificación por email.');
    }

    private function sendVerificationEmail($email, $code)
    {
        $emailService = \Config\Services::email();
        
        $subject = 'Código de Verificación de Cuenta Vecopo';
        
        // 1. Datos que se pasarán a la plantilla HTML
        $data = [
            'subject' => $subject,
            'code' => $code,
            'verification_link' => site_url('verify-code-view?email=' . urlencode($email))
        ];

        // 2. Cargar la vista (template HTML) y capturar el contenido
        // CodeIgniter 4 usa view() para renderizar la vista y devolver el HTML.
        $message = view('emails/verificacion', $data);

        $emailService->setTo($email);
        $emailService->setSubject($subject);
        
        // 3. Establecer el mensaje con el contenido HTML renderizado
        $emailService->setMessage($message);
        
        // 4. Asegurar que el tipo de correo sea HTML
        $emailService->setMailType('html'); 
        
        return $emailService->send();
    }
}