<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.paypal.com/sdk/js?client-id=AdGS2GrGBbZXq41yYDW2A-0dVD5avVuWiQO-XQDVAOxMepuO0HmkCL6kFfwIbLLjIc0gT9tB3KmIL0hJ&currency=USD"></script>
    <title>Continuar Pago - VECOPO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85);
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .continue-container {
            background: var(--card-bg);
            padding: 3rem;
            border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            text-align: center;
            max-width: 600px;
            width: 100%;
            margin-bottom: 2rem;
        }
        
        .continue-container h1 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
        }
        
        .plan-info {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 1.5rem 0;
            border-left: 4px solid var(--primary-color);
        }
        
        .plan-name {
            font-size: 1.4rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .plan-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        
        .continue-container p {
            color: var(--text-secondary);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .payment-container {
            margin: 2rem 0;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            border: 1px solid rgba(100, 255, 218, 0.1);
        }
        
        .btn-alternative {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: 1px solid var(--input-border);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .btn-alternative:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .security-note {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 1.5rem;
            padding: 1rem;
            background: rgba(0, 242, 254, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(0, 242, 254, 0.2);
        }
    </style>
</head>
<body>
    <div class="continue-container">
        <h1>¡Sesión Iniciada Exitosamente!</h1>
        <p>Ahora puedes continuar con tu proceso de compra de forma segura.</p>
        
        <div class="plan-info">
            <div class="plan-name"><?= session()->get('payment_data')['plan'] ?? 'Plan Seleccionado' ?></div>
            <div class="plan-amount">$<?= session()->get('payment_data')['amount'] ?? '0.00' ?> USD</div>
        </div>

        <p>Completa el pago utilizando PayPal para activar tu plan.</p>
        
        <div class="payment-container">
            <div id="paypal-button-container"></div>
        </div>

        <a href="<?= base_url('/pantalla') ?>" class="btn-alternative">
            ← Volver a ver otros planes
        </a>
        
        <div class="security-note">
            <i class="fas fa-shield-alt"></i> Tu información de pago está protegida por PayPal
        </div>
    </div>

    <script>
        // Base URL para las llamadas a tu controlador
        const baseUrl = '<?= base_url() ?>';
        const planAmount = '<?= session()->get('payment_data')['amount'] ?? '19.99' ?>';

        // Función para manejar errores
        function handleError(err) {
            console.error("Error de PayPal/Fetch:", err);
            const errorMessage = err.message || 'Ocurrió un error durante el proceso de pago.';
            
            alert('Error: ' + errorMessage);
        }

        // Función para crear orden
        function createOrderHandler(amount) {
            return fetch(baseUrl + '/paypal/createOrder', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ amount: amount })
            }).then(res => {
                if (!res.ok) {
                    return res.json().then(error => { 
                        throw new Error(error.error || "Error de servidor al crear orden"); 
                    });
                }
                return res.json();
            }).then(order => {
                if (!order.id) {
                    throw new Error("La respuesta de PayPal no contiene un Order ID.");
                }
                return order.id;
            }).catch(handleError);
        }

        // Función onApprove
        function handleApproval(data, actions) {
            return fetch(baseUrl + '/paypal/captureOrder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    orderID: data.orderID
                })
            }).then(function(response) {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error('Error al capturar el pago: ' + (errorData.error || response.statusText));
                    });
                }
                return response.json();
            }).then(function(responseData) {
                if (responseData.success) {
                    // Redirigir a página de éxito o mis compras
                    window.location.href = '<?= base_url('/mis-compras') ?>';
                } else {
                    throw new Error('Error en la captura del pago');
                }
            }).catch(handleError);
        }

        // Renderizar botón de PayPal
        paypal.Buttons({
            createOrder: function(data, actions) {
                return createOrderHandler(planAmount);
            },
            onApprove: handleApproval,
            onError: handleError,
            style: { 
                layout: 'vertical', 
                color: 'gold', 
                shape: 'pill', 
                label: 'pay',
                height: 45
            }
        }).render('#paypal-button-container');
    </script>

    <!-- Font Awesome para iconos -->
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
</body>
</html>