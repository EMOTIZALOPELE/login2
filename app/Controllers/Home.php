<?php

namespace App\Controllers;

use App\Models\HorariosModel;
use App\Models\UserModel;
use App\Models\ServoModel;
<<<<<<< HEAD
use App\Models\AuthTokenModel;
=======
<<<<<<< HEAD
use App\Models\AuthTokenModel;
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Home extends Controller
{
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    protected $horariosModel;
    protected $userModel;
    protected $servoModel;
    protected $authTokenModel;

    public function __construct()
<<<<<<< HEAD
    {
        helper('cookie');
        $this->horariosModel = new HorariosModel();
        $this->userModel = new UserModel();
        $this->servoModel = new ServoModel();
        $this->authTokenModel = new AuthTokenModel();
        $this->autoLogin();
    }

    public function index()
    {
        if (session()->get('logged_in')) {
            // Si el usuario ya tiene una sesión, lo enviamos al panel principal.
            return redirect()->to('/irainicio');
        }

        // Si no hay sesión, le mostramos la página de bienvenida.
        return view('inicio2');
    }

=======
    {
        helper('cookie');
        $this->horariosModel = new HorariosModel();
        $this->userModel = new UserModel();
        $this->servoModel = new ServoModel();
        $this->authTokenModel = new AuthTokenModel();
        $this->autoLogin();
    }
=======
    /**
     * Carga la vista de inicio con todas las tarjetas y sus servos asociados.
     */
    public function irainicio()
    {
        // 1. Instanciar los modelos necesarios
        $horariosModel = new HorariosModel();
        $servoModel = new ServoModel();

        // 2. Obtener el ID del usuario de la sesión actual
        $usuario_id = session()->get('id');

        // Si no hay usuario logueado, redirigir a la página de login
        if (!$usuario_id) {
            return redirect()->to('/login');
        }

        // 3. Obtener todas las tarjetas (horarios) que pertenecen al usuario
        $horarios = $horariosModel->where('usuario_id', $usuario_id)->findAll();

        // 4. Recorrer cada tarjeta para añadirle la información de sus servos
        foreach ($horarios as &$horario) {
            
            if (!empty($horario['dispositivo_id'])) {
                // Busca en la tabla 'servos' usando el 'dispositivo_id' de la tarjeta
                $servosAsociados = $servoModel->where('dispositivo_id', $horario['dispositivo_id'])->findAll();
                
                // Añade el array de servos encontrados a la tarjeta actual
                $horario['servos'] = $servosAsociados;
            } else {
                // Si no hay dispositivo_id, asigna un array vacío para evitar errores
                $horario['servos'] = [];
            }
        }
        unset($horario); // Buena práctica después de un bucle con referencia

        // 5. Preparar los datos para enviar a la vista
        $data['horarios'] = $horarios;

        // 6. Cargar la vista de inicio, pasándole los datos ya procesados
        return view('inicio', $data);
    }
    
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

>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4

    public function index()
    {
        if (session()->get('logged_in')) {
            // Si el usuario ya tiene una sesión, lo enviamos al panel principal.
            return redirect()->to('/irainicio');
        }

        // Si no hay sesión, le mostramos la página de bienvenida.
        return view('inicio2');
    }

>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    public function irainicio()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) return redirect()->to('/login');
        $horarios = $this->horariosModel->where('usuario_id', $usuario_id)->findAll();

        foreach ($horarios as &$horario) {
            $horario['servos'] = !empty($horario['dispositivo_id'])
                ? $this->servoModel->where('dispositivo_id', $horario['dispositivo_id'])->findAll()
                : [];
        }
        unset($horario);
        return view('inicio', ['horarios' => $horarios]);
    }

    public function iniciar2()      { return view('inicio2'); }
    public function iralogin()      { return view('login'); }
    public function inicioregister(){ return view('register'); }
    public function iraconfiguracion(){ return view('configuracion'); }

    public function login()
    {
        $session = session();
        $identifier = $this->request->getPost('identifier');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('remember_me');

        if (empty($identifier) || empty($password)) {
            $session->setFlashdata('error', 'Por favor, ingresa tu nombre de usuario/email y contraseña.');
            return redirect()->back()->withInput();
        }

        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? $this->userModel->where('email', $identifier)->first()
            : $this->userModel->where('nombre', $identifier)->first();

        if ($user && password_verify($password, $user['password'])) {
            $this->logUserIn($user);

            if ($rememberMe) {
                $this->rememberUser($user['id']);
            }

<<<<<<< HEAD
            // Redirigir a continuación de pago si venía del proceso de PayPal
=======
            // 🔥 NUEVA LÓGICA: Redirigir a continuación de pago si venía del proceso de PayPal
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
            if ($session->get('redirect_after_login') && $session->get('payment_data')) {
                return redirect()->to('/continuar-pago');
            }

            // Redirección normal si no venía de un proceso de pago
            return redirect()->to('/irainicio');
        }

        $userModel = new \App\Models\UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // ✅ VERIFICAR SI EL EMAIL ESTÁ CONFIRMADO
            if ($user['is_verified'] != 1) {
                // Si no está verificado, redirigir a la página de verificación
                session()->set('pending_verification_email', $user['email']);
                return redirect()->to('verify-code-view?email=' . urlencode($user['email']))->with('error', 'Por favor, verifica tu email antes de iniciar sesión.');
            }

            // Verificar contraseña
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión
                $session = session();
                $session->set([
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'nombre' => $user['nombre'],
                    'logged_in' => true
                ]);
                
                return redirect()->to('/irainicio');
            } else {
                return redirect()->back()->with('error', 'Credenciales incorrectas.');
            }
        } else {
            return redirect()->back()->with('error', 'Credenciales incorrectas.');
        }
    }

    public function logout()
    {
        $userId = session()->get('id');
        if ($userId) {
            $this->authTokenModel->deleteUserTokens($userId);
        }
        
        // ===== CAMBIO CLAVE: BORRANDO LA COOKIE NATIVAMENTE =====
        // Se borra una cookie estableciendo su tiempo de expiración en el pasado.
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/', 'vecopo.ddns.net', true, true);
        }
        // =======================================================

        session()->destroy();
        return redirect()->to('/');
    }

    public function forgotPPassword()
    {
        $session = session();
        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();
        if ($user) {
            $token = bin2hex(random_bytes(50));
            $expires = Time::now()->addHours(1);
            $updated = $this->userModel->update($user['id'], ['reset_token' => $token, 'reset_expires' => $expires->toDateTimeString()]);
            $resetLink = base_url("/reset-password/$token");
            $emailService = \Config\Services::email();
            $emailService->setTo($user['email']);
            $emailService->setFrom('valentinsalomone2001@gmail.com', 'VECOPO');
            $emailService->setSubject('Recuperación de contraseña');
            $emailService->setMessage("Haz clic en este enlace para recuperar tu contraseña: " . $resetLink);
            $emailService->send();
            if ($updated) {
                $session->setFlashdata('success', 'Se ha enviado un enlace de recuperación a tu correo.');
                return redirect()->back();
            }
            $session->setFlashdata('error', 'Error al actualizar el token de recuperación.');
            return redirect()->back();
<<<<<<< HEAD
        }
        $session->setFlashdata('error', 'Correo electrónico no encontrado.');
        return redirect()->back();
=======
<<<<<<< HEAD
        }
        $session->setFlashdata('error', 'Correo electrónico no encontrado.');
        return redirect()->back();
=======
        }       
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    }

    public function forgotpassword()   { return view('forgotpassword'); }

    public function showResetPasswordForm($token)
    {
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_expires >=', Time::now()->toDateTimeString())
                                ->first();
        if ($user) {
            return view('reset_password', ['token' => $token]);
        }
        session()->setFlashdata('error', 'Token de recuperación inválido o expirado.');
        return redirect()->to('/forgotpassword');
    }

    public function resetPassword()
    {
        $session = session();
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        if (empty($password) || strlen($password) < 6) {
            $session->setFlashdata('error', 'La contraseña debe tener al menos 6 caracteres.');
            return redirect()->back()->withInput();
        }
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_expires >=', Time::now()->toDateTimeString())
                                ->first();
        if ($user) {
            $this->userModel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'reset_token' => null,
                'reset_expires' => null,
            ]);
            $session->setFlashdata('success', 'Tu contraseña ha sido actualizada correctamente. Ya puedes iniciar sesión.');
<<<<<<< HEAD
            return redirect()->to('/iniciovalogin');
=======
            return redirect()->to('/iralogin');
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }
        $session->setFlashdata('error', 'Token de recuperación inválido o expirado.');
        return redirect()->back();
    }

    public function guardar_horarios()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) return 'Usuario no logueado';

        $data = [
            'idhorario' => $this->request->getPost('idhorario'),
            'ventana_apertura'  => $this->request->getPost('ventana_apertura'),
            'ventana_cierre'    => $this->request->getPost('ventana_cierre'),
            'cortina_apertura'  => $this->request->getPost('cortina_apertura'),
            'cortina_cierre'    => $this->request->getPost('cortina_cierre'),
            'postigon_apertura' => $this->request->getPost('postigon_apertura'),
            'postigon_cierre'   => $this->request->getPost('postigon_cierre'),
            'usuario_id' => $usuario_id,
        ];

        $horariosModel = $this->horariosModel;
        if (!empty($data['idhorario'])) {
            $existingHorario = $horariosModel->where('idhorario', $data['idhorario'])->first();
            if ($existingHorario) {
                if ($existingHorario['usuario_id'] != $usuario_id) {
                    session()->setFlashdata('error', 'No tienes permiso para actualizar este horario.');
                    return redirect()->back();
                }
                $horariosModel->update($existingHorario['idhorario'], $data);
            } else {
                session()->setFlashdata('error', 'El horario a actualizar no fue encontrado.');
                return redirect()->back();
            }
        } else {
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
        if (!$session->get('logged_in')) return redirect()->to('/login');
        $horarios = $this->horariosModel->where('usuario_id', $session->get('id'))->findAll();
        if (empty($horarios)) return view('horarios_view', ['error' => 'No se encontraron horarios.']);
        return view('horarios_view', ['horarios' => $horarios]);
    }

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    public function irAModifyName() { return view('modifyname'); }
    public function irAModifyPass() { return view('modifypass'); }

    public function updateUsername()
    {
        $session = session();
        $identifier = $this->request->getPost('identifier');
        $password = $this->request->getPost('password');
        $newUsername = $this->request->getPost('new_username');
<<<<<<< HEAD
=======
=======
    // Cargar la vista para modificar el nombre de usuario
    public function irAModifyName()
    {
        return view('modifyname');
    }

    // Cargar la vista para modificar la contraseña
    public function irAModifyPass()
    {
        return view('modifypass');
    }

    // Procesar la actualización del nombre de usuario
    public function updateUsername()
    {
        $session = session();
        $userModel = new UserModel();

        $identifier = $this->request->getPost('identifier');
        $password = $this->request->getPost('password');
        $newUsername = $this->request->getPost('new_username');

        // 1. Validación de campos
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        if (empty($identifier) || empty($password) || empty($newUsername)) {
            $session->setFlashdata('error', 'Todos los campos son obligatorios.');
            return redirect()->back()->withInput();
        }
<<<<<<< HEAD
        $existingUser = $this->userModel->where('nombre', $newUsername)->first();
=======
<<<<<<< HEAD
        $existingUser = $this->userModel->where('nombre', $newUsername)->first();
=======
        
        // 2. Buscar si el nuevo nombre de usuario ya existe
        $existingUser = $userModel->where('nombre', $newUsername)->first();
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        if ($existingUser) {
            $session->setFlashdata('error', 'El nuevo nombre de usuario ya está en uso. Por favor, elige otro.');
            return redirect()->back()->withInput();
        }
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? $this->userModel->where('email', $identifier)->first()
            : $this->userModel->where('nombre', $identifier)->first();
        if ($user && password_verify($password, $user['password'])) {
            $this->userModel->update($user['id'], ['nombre' => $newUsername]);
            if (session()->get('id') == $user['id']) {
                session()->set('nombre', $newUsername);
            }
            $session->setFlashdata('success', '¡Nombre de usuario actualizado con éxito! Ya puedes iniciar sesión con tu nuevo nombre.');
<<<<<<< HEAD
            return redirect()->to('/iniciovalogin');
=======
            return redirect()->to('/login');
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }
        $session->setFlashdata('error', 'Email/Usuario actual o contraseña incorrectos.');
        return redirect()->back()->withInput();
    }

    public function updatePassword()
    {
        $session = session();
        $identifier = $this->request->getPost('identifier');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_new_password');
        if (empty($identifier) || empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $session->setFlashdata('error', 'Todos los campos son obligatorios.');
            return redirect()->back()->withInput();
        }
        if ($newPassword !== $confirmPassword) {
            $session->setFlashdata('error', 'Las nuevas contraseñas no coinciden.');
            return redirect()->back()->withInput();
        }
        if (strlen($newPassword) < 6) {
            $session->setFlashdata('error', 'La nueva contraseña debe tener al menos 6 caracteres.');
            return redirect()->back()->withInput();
        }
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? $this->userModel->where('email', $identifier)->first()
            : $this->userModel->where('nombre', $identifier)->first();
        if ($user && password_verify($currentPassword, $user['password'])) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->userModel->update($user['id'], ['password' => $hashedPassword]);
            $session->setFlashdata('success', '✅ ¡Contraseña actualizada con éxito! Ya puedes usar tu nueva contraseña.');
<<<<<<< HEAD
            return redirect()->to(base_url('iniciovalogin'));
=======
            return redirect()->to(base_url('modify-pass'));
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }
        $session->setFlashdata('error', 'Email/Usuario o contraseña actual incorrectos.');
        return redirect()->back()->withInput();
    }

    /**
     * Inicia la sesión del usuario estableciendo los datos en la sesión.
     */
    private function logUserIn(array $user)
    {
        session()->set([
            'id' => $user['id'], 
<<<<<<< HEAD
            'usuario_id' => $user['id'], // ESTABLECER AMBAS VARIABLES
=======
            'usuario_id' => $user['id'], // 🔥 ESTABLECER AMBAS VARIABLES
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
            'nombre' => $user['nombre'], 
            'email' => $user['email'], 
            'logged_in' => true
        ]);
    }

    /**
     * Genera un token, lo guarda en la BD y establece la cookie "remember_me".
     */
    /**
     * Genera un token, lo guarda en la BD y establece la cookie "remember_me".
     */
    private function rememberUser(int $userId)
    {
        // Borrar tokens antiguos para mayor seguridad
        $this->authTokenModel->deleteUserTokens($userId);

        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));
        $hashedValidator = password_hash($validator, PASSWORD_DEFAULT);
        $expires = new Time('+30 days');

        $this->authTokenModel->insert([
            'user_id' => $userId,
            'selector' => $selector,
            'hashed_validator' => $hashedValidator,
            'expires' => $expires->toDateTimeString()
        ]);
        
        $cookieValue = $selector . ':' . $validator;

        // ===== CAMBIO CLAVE: USANDO LA FUNCIÓN NATIVA DE PHP =====
        $cookieOptions = [
            'expires' => $expires->getTimestamp(),
            'path' => '/',
            'domain' => 'vecopo.ddns.net', // Tu dominio exacto
            'secure' => true,              // true porque usas HTTPS
            'httponly' => true,            // Esencial para seguridad
            'samesite' => 'Lax'            // Estándar de seguridad moderno
        ];
        setcookie('remember_me', $cookieValue, $cookieOptions);
        // ==========================================================
    }

    /**
     * Verifica la cookie "remember_me" e inicia sesión si es válida.
     */
    private function autoLogin()
    {
        // 1. Si ya hay sesión, no hacemos nada.
        if (session()->get('logged_in')) {
            return;
        }

        // 2. Leemos la cookie directamente con la variable nativa de PHP.
        if (!isset($_COOKIE['remember_me'])) {
            return;
        }
        $cookie = $_COOKIE['remember_me'];

        // 3. El resto de la lógica de validación se mantiene igual.
        $parts = explode(':', $cookie);
        if (count($parts) !== 2) {
             // Si la cookie es inválida, la borramos nativamente.
            setcookie('remember_me', '', time() - 3600, '/', 'vecopo.ddns.net', true, true);
            return;
        }
        list($selector, $validator) = $parts;

        $tokenData = $this->authTokenModel->findBySelector($selector);

        if ($tokenData && password_verify($validator, $tokenData['hashed_validator'])) {
            if (Time::parse($tokenData['expires'])->isAfter(Time::now())) {
                $user = $this->userModel->find($tokenData['user_id']);
                if ($user) {
                    $this->logUserIn($user);
                }
            } else {
                $this->authTokenModel->delete($tokenData['id']);
                // Borramos la cookie expirada nativamente.
                setcookie('remember_me', '', time() - 3600, '/', 'vecopo.ddns.net', true, true);
            }
        }
    }

    
<<<<<<< HEAD
}
=======
}
=======

        // 3. Verificar al usuario actual
        $user = null;
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $userModel->where('email', $identifier)->first();
        } else {
            $user = $userModel->where('nombre', $identifier)->first();
        }
        
        // 4. Si el usuario existe y la contraseña es correcta, actualizar
        if ($user && password_verify($password, $user['password'])) {
            $userModel->update($user['id'], ['nombre' => $newUsername]);
            
            // Opcional: si el usuario está logueado, actualiza la sesión
            if (session()->get('id') == $user['id']) {
                session()->set('nombre', $newUsername);
            }

            $session->setFlashdata('success', '¡Nombre de usuario actualizado con éxito! Ya puedes iniciar sesión con tu nuevo nombre.');
            return redirect()->to('/login');
        } else {
            $session->setFlashdata('error', 'Email/Usuario actual o contraseña incorrectos.');
            return redirect()->back()->withInput();
        }
    }

    // Procesar la actualización de la contraseña
    public function updatePassword()
{
    $session = session();
    $userModel = new UserModel();

    $identifier = $this->request->getPost('identifier');
    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_new_password');

    // 1. Validación de campos
    if (empty($identifier) || empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $session->setFlashdata('error', 'Todos los campos son obligatorios.');
        return redirect()->back()->withInput();
    }
    
    if ($newPassword !== $confirmPassword) {
        $session->setFlashdata('error', 'Las nuevas contraseñas no coinciden.');
        return redirect()->back()->withInput();
    }
    
    if (strlen($newPassword) < 6) { // Puedes añadir más reglas de validación
        $session->setFlashdata('error', 'La nueva contraseña debe tener al menos 6 caracteres.');
        return redirect()->back()->withInput();
    }

    // 2. Verificar al usuario
    $user = null;
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $user = $userModel->where('email', $identifier)->first();
    } else {
        $user = $userModel->where('nombre', $identifier)->first();
    }

    // 3. Si el usuario existe y la contraseña actual es correcta, actualizar
    if ($user && password_verify($currentPassword, $user['password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel->update($user['id'], ['password' => $hashedPassword]);
        
        $session->setFlashdata('success', '✅ ¡Contraseña actualizada con éxito! Ya puedes usar tu nueva contraseña.');
        
        // 🌟 CORRECCIÓN: Redirige a la misma vista (modifypass) para mostrar el mensaje
        return redirect()->to(base_url('modify-pass')); 
    } else {
        $session->setFlashdata('error', 'Email/Usuario o contraseña actual incorrectos.');
        return redirect()->back()->withInput();
    }
}

}

>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
