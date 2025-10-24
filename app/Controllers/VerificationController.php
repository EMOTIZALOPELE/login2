<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class VerificationController extends Controller
{
    // Muestra el formulario para ingresar el código
    public function showCodeForm()
    {
        // Obtener email de múltiples fuentes
        $email = $this->request->getGet('email') 
                ?? session()->get('pending_verification_email')
                ?? session()->getFlashdata('email');
        
        if (empty($email)) {
            return redirect()->to('/iniciovalogin')->with('error', 'Falta el email para la verificación.');
        }
        
        // Guardar el email en sesión para reenvíos
        session()->set('pending_verification_email', $email);
        
        // Pasa el email a la vista
        return view('verification/code_form', ['email' => $email]);
    }

    // Procesa el código ingresado por el usuario
    public function verifyCode()
    {
        $userModel = new UserModel();
        $code = $this->request->getPost('code');
        $email = $this->request->getPost('email');
        
        if (empty($code) || empty($email)) {
            return redirect()->back()->with('error', 'Faltan datos de verificación.');
        }

        $user = $userModel->where('email', $email)
                          ->where('verificacion_registro', $code)
                          ->first();

        if ($user === null) {
            return redirect()->back()->with('error', 'Código de verificación incorrecto.')->with('email', $email);
        }

        // Comprobar la Expiración
        $expirationTime = Time::parse($user['expira_verificacion']);
        
        if (Time::now()->isAfter($expirationTime)) {
            // El código ha expirado. Borramos la cuenta.
            $userModel->delete($user['id']); 
            session()->remove('pending_verification_email');
            return redirect()->to('/iniciovalogin')->with('error', 'El código ha expirado. Por favor, regístrate de nuevo.');
        }

        // ✅ Éxito: El código es correcto y no ha expirado
        $userModel->update($user['id'], [
            'is_verified' => 1,
            'verificacion_registro' => null,
            'expira_verificacion' => null,
        ]);

        // Limpiar la sesión
        session()->remove('pending_verification_email');

        return redirect()->to('/iniciovalogin')->with('success', '¡Cuenta verificada! Ya puedes iniciar sesión.');
    }

    public function resendCode()
    {
        $email = session()->get('pending_verification_email');
        
        if (!$email) {
            return redirect()->to('/iniciovalogin')->with('error', 'No hay email pendiente de verificación.');
        }
        
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        
        if (!$user) {
            session()->remove('pending_verification_email');
            return redirect()->to('/iniciovalogin')->with('error', 'Usuario no encontrado.');
        }
        
        // Generar nuevo código
        $verificationCode = sprintf("%06d", mt_rand(1, 999999));
        $expirationTime = Time::now()->addHours(1);
        
        $userModel->update($user['id'], [
            'verificacion_registro' => $verificationCode,
            'expira_verificacion' => $expirationTime->toDateTimeString()
        ]);
        
        // Reenviar email
        $this->sendVerificationEmail($email, $verificationCode);
        
        return redirect()->to('verify-code-view?email=' . urlencode($email))->with('success', 'Se ha enviado un nuevo código de verificación.');
    }

    private function sendVerificationEmail($email, $code)
    {
        $emailService = \Config\Services::email();
        
        $emailService->setTo($email);
        $emailService->setSubject('Nuevo Código de Verificación - VECOPO');
        
        $message = "¡Hola! Has solicitado un nuevo código de verificación.\n\n"
                 . "Tu nuevo código es: \n\n"
                 . "➡️ **" . $code . "** ⬅️\n\n"
                 . "Este código expirará en 1 hora.\n"
                 . "Puedes verificar tu cuenta aquí: " . site_url('verify-code-view?email=' . urlencode($email));

        $emailService->setMessage($message);
        
        return $emailService->send();
    }

    // ✅ NUEVO MÉTODO: Verificar estado de verificación
    public function checkVerificationStatus()
    {
        $userModel = new UserModel();
        $email = session()->get('pending_verification_email');
        
        if (!$email) {
            return $this->response->setJSON(['verified' => false]);
        }
        
        $user = $userModel->where('email', $email)->first();
        
        if ($user && $user['is_verified'] == 1) {
            session()->remove('pending_verification_email');
            return $this->response->setJSON(['verified' => true]);
        }
        
        return $this->response->setJSON(['verified' => false]);
    }
}