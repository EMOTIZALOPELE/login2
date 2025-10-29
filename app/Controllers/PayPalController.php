<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class PayPalController extends Controller
{
    private $clientId = "AdGS2GrGBbZXq41yYDW2A-0dVD5avVuWiQO-XQDVAOxMepuO0HmkCL6kFfwIbLLjIc0gT9tB3KmIL0hJ";
    private $clientSecret = "ENwZmSdEKvlXWlybPNngQbhf1KZhN9S_1bVV3lfJbtTFV1oc0waa3RxmYjImQaeeafjMKQe48pbJM07A";

    public function createOrder()
    {
        $session = \Config\Services::session();
        
<<<<<<< HEAD
        // VERIFICAR AMBAS VARIABLES POSIBLES DE SESIÓN
=======
        // 🔥 VERIFICAR AMBAS VARIABLES POSIBLES DE SESIÓN
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        $usuario_id = $session->get('usuario_id') ?? $session->get('id');
        
        if (!$usuario_id) {
            $input = $this->request->getJSON();
            $amount = $input->amount ?? "10.00";
            
            // Guardar datos del pago
            $session->set('payment_data', [
                'amount' => $amount,
                'plan' => $this->getPlanName($amount),
                'timestamp' => time()
            ]);
            
            // Guardar URL de retorno
            $session->set('redirect_after_login', current_url());
            
            return $this->response->setJSON([
                "error" => "not_authenticated",
                "redirect_url" => base_url('/iniciovalogin'),
                "message" => "Debes iniciar sesión antes de realizar una compra"
            ])->setStatusCode(401);
        }

        $input = $this->request->getJSON();
        $amount = $input->amount ?? "10.00";

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return $this->response->setJSON(["error" => "No se pudo obtener el token"])->setStatusCode(500);
        }

        $url = "https://api-m.sandbox.paypal.com/v2/checkout/orders";
        $body = json_encode([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ],
                    "description" => $this->getPlanDescription($amount)
                ]
            ]
        ]);

        $options = [
            "http" => [
                "header" => "Authorization: Bearer $accessToken\r\n" .
                            "Content-Type: application/json\r\n",
                "method" => "POST",
                "content" => $body
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return $this->response->setJSON(json_decode($result, true));
    }

    public function captureOrder()
    {
        $input = $this->request->getJSON();
        $orderID = $input->orderID ?? null;
        $db = \Config\Database::connect();
        $session = \Config\Services::session();

        if (!$orderID) {
            return $this->response->setJSON(["error" => "No se recibió un Order ID"])->setStatusCode(400);
        }

<<<<<<< HEAD
        // OBTENER USUARIO DE AMBAS VARIABLES POSIBLES
=======
        // 🔥 OBTENER USUARIO DE AMBAS VARIABLES POSIBLES
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        $usuario_id = $session->get('usuario_id') ?? $session->get('id');

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return $this->response->setJSON(["error" => "No se pudo obtener el token"])->setStatusCode(500);
        }

        $url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderID/capture";
        $options = [
            "http" => [
                "header" => "Authorization: Bearer $accessToken\r\n" .
                            "Content-Type: application/json\r\n",
                "method" => "POST"
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultData = json_decode($result, true);

        $nuevoUsuarioCreado = false;
        $pagoGuardadoId = null;

        if (isset($resultData['status']) && $resultData['status'] === 'COMPLETED') {
            
            $emailPagador = $resultData['payer']['email_address'] ?? null;
            
            // CASO 1: Usuario NO autenticado durante la compra
            if (!$usuario_id && $emailPagador) {
                // Buscar si existe usuario con ese email
                $usuarioExistente = $db->table('usuarios')
<<<<<<< HEAD
                                    ->where('email', $emailPagador)
                                    ->get()->getRow();
=======
                                      ->where('email', $emailPagador)
                                      ->get()->getRow();
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                
                if ($usuarioExistente) {
                    // Usuario existe pero no estaba logueado - vincular compra
                    $usuario_id = $usuarioExistente->id;
                } else {
                    // Crear nuevo usuario automáticamente
                    $usuario_id = $this->crearUsuarioDesdePayPal($resultData);
                    $nuevoUsuarioCreado = true;
                    
                    // Iniciar sesión automáticamente para el nuevo usuario
                    if ($usuario_id) {
                        $session->set([
                            'usuario_id' => $usuario_id,
                            'nombre' => $resultData['payer']['name']['given_name'] ?? 'Usuario',
                            'email' => $emailPagador,
                            'logged_in' => true
                        ]);
                    }
                }
            }

            // Guardar el pago vinculado al usuario (existente o nuevo)
            $pagoGuardadoId = $this->savePaymentToDatabase($orderID, $resultData, $usuario_id);
            
            // Enviar email de confirmación
            if ($emailPagador) {
                $this->sendConfirmationEmail($emailPagador, $orderID, $nuevoUsuarioCreado, $usuario_id);
            }
<<<<<<< HEAD

            // 🔥 NUEVO: VERIFICAR SI NECESITA SELECCIÓN DE SERVOS
            $montoCapturado = $resultData['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? 0;
            $planInfo = $this->determinarPlan($montoCapturado);
            
            // Si el plan requiere selección de servos (tipos_servos está vacío)
            if (empty($planInfo['tipos_servos']) && $pagoGuardadoId) {
                return $this->response->setJSON([
                    'success' => true,
                    'redirect_url' => base_url('seleccionar-servos/' . $pagoGuardadoId),
                    'user_created' => $nuevoUsuarioCreado,
                    'user_id' => $usuario_id,
                    'orderID' => $orderID
                ]);
            }
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }

        return $this->response->setJSON([
            'success' => true,
            'details' => $resultData,
            'orderID' => $orderID,
            'user_created' => $nuevoUsuarioCreado,
            'user_id' => $usuario_id
        ]);
<<<<<<< HEAD

        // Limpiar datos temporales
        $this->clearPaymentTempData();
=======
        // Limpiar datos temporales
    $this->clearPaymentTempData();
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    }

    private function getPlanName($amount)
    {
        $plans = [
            '19.99' => 'Plan Básico',
            '49.99' => 'Plan Pro', 
            '99.99' => 'Plan Enterprise'
        ];
        
        return $plans[$amount] ?? 'Plan VECOPO';
    }

private function sendConfirmationEmail($email, $orderID, $nuevoUsuario, $usuarioId)
{
    try {
        $emailService = \Config\Services::email();
        $asunto = "¡Confirmación de compra en VECOPO! (Orden: $orderID)";
        
        // 1. Datos que se inyectarán en la vista HTML
        $data = [
            'subject' => $asunto,
            'order_id' => $orderID,
            'is_new_user' => $nuevoUsuario, // true o false
            'login_link' => site_url('login') // Cambia a la ruta correcta de inicio de sesión
        ];

        // 2. Cargar la vista HTML y capturar el contenido
        $mensaje_html = view('emails/confirmacion_compra', $data); 

        $emailService->setTo($email);
        $emailService->setFrom('valentinsalomone2001@gmail.com', 'VECOPO');
        $emailService->setSubject($asunto);
        
        // 3. Establecer el mensaje con el contenido HTML
        $emailService->setMessage($mensaje_html); 
        $emailService->setMailType('html');

        $emailService->send();

    } catch (\Exception $e) {
        log_message('error', 'Error al enviar email de confirmación: ' . $e->getMessage());
    }
}

    /**
     * Crear usuario automáticamente desde datos de PayPal
     */
    private function crearUsuarioDesdePayPal($paymentData)
    {
        $db = \Config\Database::connect();
        $userModel = new \App\Models\UserModel();

        $email = $paymentData['payer']['email_address'] ?? null;
        $nombre = $paymentData['payer']['name']['given_name'] ?? 'Usuario';
        $apellido = $paymentData['payer']['name']['surname'] ?? 'PayPal';

        if (!$email) {
            return null;
        }

        // Generar contraseña temporal segura
        $passwordTemporal = bin2hex(random_bytes(8));

        $userData = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'password' => password_hash($passwordTemporal, PASSWORD_DEFAULT),
            'email_verified' => 1, // Verificado porque viene de PayPal
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($userModel->insert($userData)) {
                $nuevoUsuarioId = $userModel->getInsertID();
                
                // Enviar email con credenciales
                $this->sendWelcomeEmail($email, $nombre, $passwordTemporal);
                
                return $nuevoUsuarioId;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al crear usuario desde PayPal: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Encuentra o crea un usuario basado en el email de PayPal
     */
    private function findOrCreateUserFromEmail($email, $paymentData)
    {
        $db = \Config\Database::connect();
        $userModel = new \App\Models\UserModel();

        // Buscar usuario existente
        $usuarioExistente = $db->table('usuarios')
                              ->where('email', $email)
                              ->get()->getRow();

        if ($usuarioExistente) {
            return $usuarioExistente->id;
        }

        // Crear nuevo usuario
        $nombre = $paymentData['payer']['name']['given_name'] ?? 'Usuario';
        $apellido = $paymentData['payer']['name']['surname'] ?? 'PayPal';

        // Generar contraseña temporal
        $passwordTemporal = bin2hex(random_bytes(8));

        $userData = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'password' => password_hash($passwordTemporal, PASSWORD_DEFAULT),
            'email_verified' => 1 // Asumimos verificado ya que viene de PayPal
        ];

        if ($userModel->insert($userData)) {
            $nuevoUsuarioId = $userModel->getInsertID();
            
            // Enviar email con credenciales
            $this->sendWelcomeEmail($email, $nombre, $passwordTemporal);
            
            return $nuevoUsuarioId;
        }

        return null;
    }

    public function continuarPago()
    {
        $session = \Config\Services::session();
        
        // Verificar que el usuario venga del proceso de pago
        if (!$session->get('payment_data')) {
            return redirect()->to('/pantalla');
        }
        
        // Esta vista se muestra después del login cuando el usuario venía del proceso de pago
        return view('continuar_pago');
    }

    /**
     * Guardar orden temporal para vinculación
     */
    private function saveTempOrder($orderId, $usuarioId, $amount)
    {
        $db = \Config\Database::connect();
        
        $db->table('ordenes_temporales')->insert([
            'order_id' => $orderId,
            'usuario_id' => $usuarioId,
            'monto' => $amount,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ]);
    }

    private function getTempOrder($orderId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('ordenes_temporales')
                 ->where('order_id', $orderId)
                 ->get()
                 ->getRowArray();
    }

    private function clearTempOrder($orderId)
    {
        $db = \Config\Database::connect();
        
        $db->table('ordenes_temporales')
           ->where('order_id', $orderId)
           ->delete();
    }

    private function getPlanDescription($amount)
    {
        $plans = [
            '19.99' => 'Plan Básico - Control básico de dispositivos',
            '49.99' => 'Plan Pro - Control total de dispositivos', 
            '99.99' => 'Plan Enterprise - Control total + Soporte premium'
        ];
        
        return $plans[$amount] ?? 'Plan VECOPO';
    }

    private function sendWelcomeEmail($email, $nombre, $password)
    {
        try {
            $emailService = \Config\Services::email();
            
            $asunto = "¡Bienvenido a VECOPO! Tu cuenta ha sido creada";
            $mensaje = "¡Hola $nombre!\n\n" .
                      "Tu cuenta en VECOPO ha sido creada automáticamente después de tu compra.\n\n" .
                      "Tus credenciales de acceso:\n" .
                      "Email: $email\n" .
                      "Contraseña temporal: $password\n\n" .
                      "Te recomendamos cambiar tu contraseña después de iniciar sesión.\n\n" .
                      "Accede a tu cuenta aquí: " . base_url('/iniciovalogin') . "\n\n" .
                      "Atentamente,\nEl equipo de VECOPO";

            $emailService->setTo($email);
            $emailService->setFrom('valentinsalomone2001@gmail.com', 'VECOPO');
            $emailService->setSubject($asunto);
            $emailService->setMessage($mensaje);
            $emailService->send();

        } catch (\Exception $e) {
            log_message('error', 'Error al enviar email de bienvenida: ' . $e->getMessage());
        }
    }

    // --- FUNCIÓN savePaymentToDatabase MODIFICADA ---
    // (Le añadimos el parámetro $usuario_id)
    private function savePaymentToDatabase($orderID, $paymentData, $usuario_id = null)
    {
        $db = \Config\Database::connect();
        
        try {
            $db->transStart();
            
            $montoCapturado = $paymentData['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? 0;
            $monedaCapturada = $paymentData['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? 'USD';

<<<<<<< HEAD
            // Determinar plan basado en el monto
            $planInfo = $this->determinarPlan($montoCapturado);
            
            $data = [
                'usuario_id' => $usuario_id,
=======
            $data = [
                'usuario_id' => $usuario_id, // El nuevo campo
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                'order_id' => $orderID,
                'email' => $paymentData['payer']['email_address'] ?? '',
                'monto' => $montoCapturado,
                'moneda' => $monedaCapturada,
                'fecha' => date('Y-m-d H:i:s'),
                'estado' => strtolower($paymentData['status']),
                'detalles' => json_encode($paymentData),
                'cant_servos' => $planInfo['cant_servos'],
                'tipos_servos' => $planInfo['tipos_servos']
            ];

            $db->table('pagos')->insert($data);
<<<<<<< HEAD
            $pagoIdInsertado = $db->insertID();
=======
            $pagoIdInsertado = $db->insertID(); // Obtenemos el ID del pago guardado
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
            
            $db->transComplete();
            
            if(!$db->transStatus()) {
                log_message('error', 'Error al guardar pago en BD: ' . print_r($db->error(), true));
                return null;
            }

<<<<<<< HEAD
            return $pagoIdInsertado;
=======
            return $pagoIdInsertado; // Devolvemos el ID
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
            
        } catch (\Exception $e) {
            log_message('error', 'Excepción al guardar pago: ' . $e->getMessage());
            return null;
<<<<<<< HEAD
        }
    }

    private function determinarPlan($monto)
    {
        $monto = floatval($monto);
        
        // Plan Enterprise - $200
        if ($monto >= 190 && $monto <= 210) {
            return [
                'cant_servos' => 3,
                'tipos_servos' => 'ventana,cortina,postigon',
                'plan_nombre' => 'Plan Enterprise'
            ];
        } 
        // Plan Intermedio - $130  
        elseif ($monto >= 125 && $monto <= 135) {
            return [
                'cant_servos' => 2,
                'tipos_servos' => '', // El usuario elegirá después
                'plan_nombre' => 'Plan Intermedio'
            ];
        } 
        // Plan Básico - $99 (por defecto)
        else {
            return [
                'cant_servos' => 1,
                'tipos_servos' => '', // El usuario elegirá después
                'plan_nombre' => 'Plan Básico'
            ];
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }
    }

    private function getAccessToken()
    {
        $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
        $credentials = base64_encode("$this->clientId:$this->clientSecret");

        $options = [
            "http" => [
                "header" => "Authorization: Basic $credentials\r\n" .
                            "Content-Type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => "grant_type=client_credentials"
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result, true)["access_token"] ?? null;
    }

    public function guardarDireccion()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        
        $usuario_id = $session->get('usuario_id');
        if (!$usuario_id) {
            return $this->response->setJSON(["error" => "No autorizado. Debes iniciar sesión."])->setStatusCode(401);
        }

        $input = $this->request->getJSON();
        $order_id_ingresado = $input->order_id ?? null;

        if (!$order_id_ingresado) {
            return $this->response->setJSON(["error" => "El Order ID es obligatorio."])->setStatusCode(400);
        }

        try {
            // 3. Buscar el pago
            $pago = $db->table('pagos')
                       ->where('order_id', $order_id_ingresado)
                       ->where('estado', 'completed')
                       ->get()->getRow();

            if (!$pago) {
                return $this->response->setJSON(["error" => "El Order ID no es válido o el pago no se ha completado."])->setStatusCode(404);
            }

            // --- NUEVA VALIDACIÓN DE PROPIEDAD ---
            // Revisamos si el pago ya tiene un dueño (usuario_id)
            if ($pago->usuario_id !== null) {
                
                // El pago ya tiene dueño. ¿Es este usuario?
                if ($pago->usuario_id != $usuario_id) {
                    // ¡FRAUDE/ERROR! Alguien más (o el auto-link) ya reclamó este pago.
                    return $this->response->setJSON(["error" => "Este Order ID ya ha sido reclamado por otro usuario."])->setStatusCode(409); // 409 Conflict
                }
                // Si es el mismo usuario, no hay problema, puede estar actualizando su dirección
                
            }
            // ----------------------------------------

            // 4. Verificar que este pago no tenga YA una DIRECCIÓN (evitar duplicados)
            $direccionExistente = $db->table('direcciones_envio')
                                     ->where('pago_id', $pago->id)
                                     ->get()->getRow();
            
            if ($direccionExistente) {
                 // Podríamos permitir actualizar la dirección, pero por ahora lo bloqueamos.
                 return $this->response->setJSON(["error" => "Ya existe una dirección de envío registrada para este pago."])->setStatusCode(409);
            }

            // 5. Preparar y guardar los datos de envío
            $dataEnvio = [
                'pago_id' => $pago->id,
                'usuario_id' => $usuario_id,
                'nombre' => $input->nombre ?? '',
                'apellido' => $input->apellido ?? '',
                'telefono' => $input->telefono ?? '',
                'pais' => $input->pais ?? '',
                'provincia' => $input->provincia ?? '',
                'ciudad' => $input->ciudad ?? '',
                'calle' => $input->calle ?? '',
                'numero_calle' => $input->numero_calle ?? '',
                'piso' => $input->piso ?? NULL,
                'depto' => $input->depto ?? NULL,
                'codigopostal' => $input->codigopostal ?? ''
            ];
            
            $db->table('direcciones_envio')->insert($dataEnvio);
            
            // 6. --- RECLAMAR EL PAGO ---
            // Si el pago no tenía dueño (era NULL), se lo asignamos a este usuario.
            if ($pago->usuario_id === null) {
                $db->table('pagos')
                   ->where('id', $pago->id)
                   ->update(['usuario_id' => $usuario_id]);
            }
            
            return $this->response->setJSON(["success" => true, "message" => "¡Dirección guardada! Tu compra ha sido validada y asociada a tu cuenta."]);

        } catch (\Exception $e) {
            log_message('error', 'Error al guardar dirección: ' . $e->getMessage());
            return $this->response->setJSON(["error" => "Ocurrió un error en el servidor."])->setStatusCode(500);
        }
    }

    public function misCompras()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        $usuario_id = $session->get('usuario_id'); // Usamos la variable de sesión correcta

        if (!$usuario_id) {
            // Doble chequeo por si el filtro falla
            return redirect()->to('/iniciovalogin');
        }

        // Aquí deberías buscar en la BD las compras YA validadas por este usuario
        // (Tanto las auto-vinculadas como las reclamadas con /guardar-direccion)
        
        $comprasValidadas = $db->table('pagos p')
                               ->join('direcciones_envio d', 'd.pago_id = p.id', 'left') // LEFT JOIN por si solo pagó pero no puso dirección
                               ->where('p.usuario_id', $usuario_id)
                               ->where('p.estado', 'completed')
                               ->select('p.order_id, p.monto, p.moneda, p.fecha, d.nombre, d.pais') // Pide los datos que quieras mostrar
                               ->get()
                               ->getResultArray();

        // Carga la vista HTML y le pasa los datos de las compras
        // (NOTA: Debes crear este archivo de vista: /Views/mis_compras_view.php)
        return view('miscompras', ['compras' => $comprasValidadas]);
    }

    /**
     * Limpiar datos de pago temporales después de una compra exitosa
     */
    private function clearPaymentTempData()
    {
        $session = \Config\Services::session();
        $session->remove('payment_data');
        $session->remove('redirect_after_login');
    }

    public function apiMisCompras()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();

<<<<<<< HEAD
           //  Verificar qué datos de sesión tenemos
=======
           // 🔥 DEBUG: Verificar qué datos de sesión tenemos
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        log_message('debug', 'Sesión usuario_id: ' . ($session->get('usuario_id') ?? 'NULL'));
        log_message('debug', 'Sesión id: ' . ($session->get('id') ?? 'NULL'));

        $usuario_id = $session->get('usuario_id');

        if (!$usuario_id) {
            return $this->response->setJSON(["error" => "No autorizado"])->setStatusCode(401);
        }

        try {

            log_message('debug', 'Buscando compras para usuario_id: ' . $usuario_id);

            $comprasValidadas = $db->table('pagos p')
                                ->join('direcciones_envio d', 'd.pago_id = p.id', 'left')
                                ->where('p.usuario_id', $usuario_id)
                                ->where('p.estado', 'completed')
                                ->select('p.order_id, p.monto, p.moneda, p.fecha, d.nombre, d.pais, p.estado')
                                ->orderBy('p.fecha', 'DESC')
                                ->get()
                                ->getResultArray();

        log_message('debug', 'Compras encontradas: ' . count($comprasValidadas));


            return $this->response->setJSON([
                "success" => true,
                "compras" => $comprasValidadas
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error al obtener compras: ' . $e->getMessage());
            return $this->response->setJSON([
                "success" => false,
                "error" => "Error al cargar las compras"
            ])->setStatusCode(500);
        }
    }
<<<<<<< HEAD
    public function seleccionarPlan()
    {
        $session = \Config\Services::session();
        
        // Verificar que el usuario esté logueado
        $usuario_id = $session->get('usuario_id') ?? $session->get('id');
        if (!$usuario_id) {
            return redirect()->to('/iniciovalogin');
        }
        
        return view('seleccionar_plan'); // Esta es la nueva vista que creamos
    }

    public function seleccionarServos($pago_id)
    {
        $db = \Config\Database::connect();
        $pago = $db->table('pagos')->where('id', $pago_id)->get()->getRow();
        
        if (!$pago) {
            return redirect()->to('/mis-compras')->with('error', 'Pago no encontrado');
        }
        
        $planInfo = $this->determinarPlan($pago->monto);
        
        $data = [
            'pago_id' => $pago_id,
            'cant_servos' => $pago->cant_servos,
            'plan_nombre' => $planInfo['plan_nombre'],
            'plan_tipo' => $pago->cant_servos == 3 ? 'enterprise' : ($pago->cant_servos == 2 ? 'intermedio' : 'basico')
        ];
        
        return view('seleccionar_servos', $data);
    }

    public function guardarConfiguracionServos()
    {
        $pago_id = $this->request->getPost('pago_id');
        $servos_seleccionados = $this->request->getPost('servos');
        $dispositivo_id = $this->request->getPost('dispositivo_id'); // NUEVO
        
        if (empty($servos_seleccionados)) {
            return redirect()->back()->with('error', 'Debes seleccionar los servomotores');
        }
        
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $usuario_id = $session->get('usuario_id') ?? $session->get('id');
        
        // Validar según el plan
        $pago = $db->table('pagos')->where('id', $pago_id)->get()->getRow();
        
        if ($pago->cant_servos == 2 && count($servos_seleccionados) != 2) {
            return redirect()->back()->with('error', 'Debes seleccionar exactamente 2 servomotores diferentes');
        }
        
        if ($pago->cant_servos == 1 && count($servos_seleccionados) != 1) {
            return redirect()->back()->with('error', 'Debes seleccionar exactamente 1 servomotor');
        }
        
        // Guardar los tipos de servos en el pago
        $db->table('pagos')
        ->where('id', $pago_id)
        ->update(['tipos_servos' => implode(',', $servos_seleccionados)]);
        
        // 🔥 ASIGNAR automáticamente este pago al dispositivo actual
        if ($dispositivo_id) {
            $db->table('dispositivos')
            ->where('id', $dispositivo_id)
            ->where('usuario_id', $usuario_id)
            ->update(['pago_id' => $pago_id]);
            log_message('debug', 'Pago ' . $pago_id . ' asignado al dispositivo ' . $dispositivo_id);
        }
        
        return redirect()->to('/mis-compras')->with('success', 'Configuración de servomotores guardada exitosamente');
    }

    private function getNombrePlan($monto)
    {
        $planes = [
            '99.99' => 'Plan Básico',
            '130.00' => 'Plan Intermedio', 
            '200.00' => 'Plan Enterprise'
        ];
        
        foreach ($planes as $montoPlan => $nombre) {
            if (abs(floatval($monto) - floatval($montoPlan)) < 1.0) {
                return $nombre;
            }
        }
        
        return 'Plan Personalizado';
    }

    private function getTipoPlan($monto)
    {
        if (abs(floatval($monto) - 99.99) < 1.0) return 'basico';
        if (abs(floatval($monto) - 130.00) < 1.0) return 'intermedio';
        if (abs(floatval($monto) - 200.00) < 1.0) return 'enterprise';
        return 'basico';
    }

    public function verificarServosConfigurados()
    {
        $dispositivo_id = $this->request->getPost('dispositivo_id');
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        
        $usuario_id = $session->get('usuario_id') ?? $session->get('id');
        
        log_message('debug', 'Verificar servos - Dispositivo ID: ' . $dispositivo_id . ', Usuario ID: ' . $usuario_id);

        if (!$usuario_id) {
            return $this->response->setJSON([
                'error' => 'Usuario no autenticado'
            ])->setStatusCode(401);
        }

        try {
            // 🔥 CAMBIO IMPORTANTE: Buscar el pago ESPECÍFICO del dispositivo
            $pago = null;
            
            // PRIMERO: Intentar encontrar el pago relacionado con este dispositivo específico
            $dispositivo = $db->table('dispositivos')
                            ->where('id', $dispositivo_id)
                            ->where('usuario_id', $usuario_id)
                            ->get()
                            ->getRow();
            
            if ($dispositivo && !empty($dispositivo->pago_id)) {
                // El dispositivo tiene un pago específico asignado
                $pago = $db->table('pagos')
                        ->where('id', $dispositivo->pago_id)
                        ->where('usuario_id', $usuario_id)
                        ->where('estado', 'completed')
                        ->get()
                        ->getRow();
                log_message('debug', 'Pago específico del dispositivo encontrado - ID: ' . $dispositivo->pago_id);
            }
            
            // SEGUNDO: Si no encontró pago específico, buscar el ÚLTIMO pago del usuario
            if (!$pago) {
                $pago = $db->table('pagos')
                        ->where('usuario_id', $usuario_id)
                        ->where('estado', 'completed')
                        ->orderBy('fecha', 'DESC')
                        ->get()
                        ->getRow();
                log_message('debug', 'Usando último pago del usuario');
            }

            if (!$pago) {
                log_message('debug', 'No se encontraron pagos para el usuario: ' . $usuario_id);
                return $this->response->setJSON([
                    'error' => 'No se encontraron pagos completados. Primero debes realizar una compra.'
                ]);
            }

            log_message('debug', 'Pago encontrado - ID: ' . $pago->id . ', Tipos Servos: ' . $pago->tipos_servos);

            // Verificar si los servos están configurados
            if (!empty($pago->tipos_servos)) {
                log_message('debug', 'Servos YA configurados - Redirigiendo a configuración');
                return $this->response->setJSON([
                    'configurado' => true,
                    'pago_id' => $pago->id,
                    'tipos_servos' => $pago->tipos_servos,
                    'cant_servos' => $pago->cant_servos,
                    'redirect_url' => base_url('configuracion/' . $dispositivo_id)
                ]);
            } else {
                log_message('debug', 'Servos NO configurados - Redirigiendo a selección');
                return $this->response->setJSON([
                    'configurado' => false,
                    'pago_id' => $pago->id,
                    'cant_servos' => $pago->cant_servos,
                    'redirect_url' => base_url('seleccionar-servos/' . $pago->id)
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error al verificar servos: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Error del servidor: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

}