<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.paypal.com/sdk/js?client-id=AdGS2GrGBbZXq41yYDW2A-0dVD5avVuWiQO-XQDVAOxMepuO0HmkCL6kFfwIbLLjIc0gT9tB3KmIL0hJ&currency=USD"></script>
    <title>Seleccionar Plan - VECOPO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #00b4d8;
            --primary-dark: #1f53c5;
            --secondary: #2c3e50;
            --dark: #1a1a1a;
            --light: rgba(255, 255, 255, 0.9);
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
            color: white;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding-top: 2rem;
        }

        .logo {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(45deg, #00b4d8, #1f53c5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }

        .plans-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .plan-card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 0;
            width: 350px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .price-header {
            background: rgba(43, 63, 104, 0.78);
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .price-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .price-header:hover::before {
            transform: translateX(100%);
        }

        .price-amount {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .price-symbol {
            font-size: 1.5rem;
            vertical-align: super;
            margin-right: 5px;
        }

        .plan-name {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: normal;
        }

        .features {
            padding: 25px;
            text-align: left;
        }

        .feature-item {
            padding: 12px 0;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.9);
            transition: transform 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-item:last-child {
            border-bottom: none;
        }

        .feature-item:hover {
            transform: translateX(10px);
            color: var(--primary);
        }

        .feature-item i {
            margin-right: 15px;
            color: var(--primary);
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .feature-item:hover i {
            transform: scale(1.2);
        }

        .cart-button-container {
            padding: 0 25px 25px;
        }

        .cart-button {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 50px;
            color: white;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            position: relative;
            overflow: hidden;
        }

        .cart-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
            background: linear-gradient(45deg, #218838, #1e9e8a);
        }

        .cart-button:active {
            transform: translateY(-1px);
        }

        .cart-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .cart-button:hover::before {
            left: 100%;
        }

        .cart-button i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .cart-button:hover i {
            transform: scale(1.2);
        }

        .cart-button.loading {
            background: linear-gradient(45deg, #6c757d, #adb5bd);
            cursor: not-allowed;
        }

        .cart-button.loading i {
            animation: spin 1s linear infinite;
        }

        .back-button {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 1rem;
        }

        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(31, 83, 197, 0.6);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .paypal-container {
            min-height: 60px;
            margin: 15px 0;
            transition: all 0.3s ease;
        }

        /* Modal de éxito */
        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: white;
        }

        .modal-header {
            border-bottom: 1px solid var(--card-border);
        }

        .modal-footer {
            border-top: 1px solid var(--card-border);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .plans-container {
                gap: 20px;
            }
            
            .plan-card {
                width: 100%;
                max-width: 350px;
            }
            
            .logo {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1.1rem;
            }
        }

        .paypal-container {
            min-height: 60px;
            margin: 15px 0;
            transition: all 0.3s ease;
        }

        .paypal-container iframe {
            min-height: 45px !important;
        }

        .text-info, .text-success, .text-warning, .text-danger {
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .text-info {
            background: rgba(23, 162, 184, 0.1);
            border: 1px solid rgba(23, 162, 184, 0.3);
        }

        .text-success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .text-warning {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .text-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
    </style>
</head>
<body>
    <?= $this->include('partials/header') ?>

    <div class="container">
        <div class="header">
            <h1 class="logo">VECOPO</h1>
            <p class="subtitle">Selecciona el plan que mejor se adapte a tus necesidades</p>
        </div>

        <div class="plans-container">
            <!-- Plan Básico -->
            <div class="plan-card">
                <div class="price-header">
                    <div class="price-amount">
                        <span class="price-symbol">$</span>90.00
                    </div>
                    <div class="plan-name">Plan Básico</div>
                </div>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Control básico de dispositivos</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Programación básica</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Soporte por email</span>
                    </div>
                </div>
                <div class="cart-button-container">
                    <button class="cart-button" onclick="comprarPlan('90.00', 'Plan básico')">
                        <i class="fas fa-shopping-cart"></i>
                        Comprar Plan Básico
                    </button>
                </div>
                <div id="paypal-button-container-1" class="paypal-container"></div>
            </div>

            <!-- Plan Pro -->
            <div class="plan-card">
                <div class="price-header">
                    <div class="price-amount">
                        <span class="price-symbol">$</span>130.00
                    </div>
                    <div class="plan-name">Plan Pro</div>
                </div>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Control total de dispositivos</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Programación avanzada</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Soporte 24/7</span>
                    </div>
                </div>
                <div class="cart-button-container">
                    <button class="cart-button" onclick="comprarPlan('130.00', 'Plan Pro')">
                        <i class="fas fa-shopping-cart"></i>
                        Comprar Plan Pro
                    </button>
                </div>
                <div id="paypal-button-container-2" class="paypal-container"></div>
            </div>

            <!-- Plan Enterprise -->
            <div class="plan-card">
                <div class="price-header">
                    <div class="price-amount">
                        <span class="price-symbol">$</span>200.00
                    </div>
                    <div class="plan-name">Plan Enterprise</div>
                </div>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Control total de dispositivos</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Programación avanzada</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Soporte 24/7 + Asistente</span>
                    </div>
                </div>
                <div class="cart-button-container">
                    <button class="cart-button" onclick="comprarPlan('200.00', 'Plan Enterprise')">
                        <i class="fas fa-shopping-cart"></i>
                        Comprar Plan Enterprise
                    </button>
                </div>
                <div id="paypal-button-container-3" class="paypal-container"></div>
            </div>
        </div>

        <div class="text-center">
            <a href="<?= base_url('/mis-compras') ?>" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Volver a Mis Compras
            </a>
        </div>
    </div>

    <!-- Modal de Mensaje de Pago Exitoso -->
    <div class="modal fade" id="pagoExitosoModal" tabindex="-1" role="dialog" aria-labelledby="pagoExitosoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalTitulo">¡Pago Completado!</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modalCuerpo">Tu compra se ha completado con éxito.</p>
                    <div id="contenedorOrderId" style="display:none; margin-top: 15px; padding: 10px; background-color: #f3f3f3; border-radius: 5px;">
                        <p class="mb-1"><strong>Order ID:</strong></p>
                        <div class="input-group">
                            <p id="orderIDparaCopiar" class="form-control" style="background-color: #fff; font-weight: bold;"></p>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="btnCopiarId" onclick="copiarOrderId()">
                                    <i class="far fa-copy"></i> Copiar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalBotonCerrar">Cerrar</button>
                    <a href="#" class="btn btn-primary" id="modalBotonPrincipal">Continuar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Base URL para las llamadas a tu controlador
        const baseUrl = '<?= base_url() ?>'; 
        
        // Obtener el token CSRF de CodeIgniter
        const csrfToken = '<?= csrf_hash() ?>';
        const csrfName = '<?= csrf_token() ?>';

        // Función para manejar errores
        function handleError(err) {
            console.error("Error:", err);
            const errorMessage = err.message || 'Ocurrió un error desconocido durante el proceso de pago. Por favor, inténtalo de nuevo.';
            
            $('#modalTitulo').text('Error de Pago');
            $('#modalCuerpo').text(errorMessage);
            $('#contenedorOrderId').hide();
            $('#modalBotonPrincipal').text('Cerrar').attr('href', '#');
            $('#modalBotonCerrar').hide();
            $('#pagoExitosoModal').modal('show');
        }

        // Función para mostrar éxito (MODIFICADA PARA ACEPTAR REDIRECCIÓN CONDICIONAL)
        function showSuccess(responseData) {
            const modal = $('#pagoExitosoModal');
            const titulo = $('#modalTitulo');
            const cuerpo = $('#modalCuerpo');
            const btnPrincipal = $('#modalBotonPrincipal');
            
            // 🚨 Corrección: Si no hay redirect_url, va a mis-compras por defecto
            const defaultRedirect = '<?= base_url('/mis-compras') ?>'; 
            const redirectUrl = responseData.redirect_url || defaultRedirect; 
            
            titulo.text('¡Compra Exitosa!');
            
            if (responseData.redirect_url) {
                cuerpo.text('Tu pago ha sido procesado. Ahora debes seleccionar tus servomotores para completar la configuración.');
                btnPrincipal.text('Seleccionar Servomotores');
            } else {
                cuerpo.text('Tu compra se ha completado con éxito.');
                btnPrincipal.text('Ir a Mis Compras');
            }
            
            $('#contenedorOrderId').hide();
            btnPrincipal.attr('href', redirectUrl); 
            $('#modalBotonCerrar').hide();

            modal.modal('show');
        }

        // Función principal para comprar plan - VERSIÓN CORREGIDA
        function comprarPlan(amount, planName) {
            const button = event.target.closest('.cart-button') || event.target;
            const originalText = button.innerHTML;
            const planCard = button.closest('.plan-card');
            const paypalContainer = planCard.querySelector('[id^="paypal-button-container"]');
            
            console.log('Comprando:', planName, amount);
            
            // Variable de ámbito superior para el ID del backend (Solución al ReferenceError: orderId is not defined)
            let orderIdFromBackend = null; 

            // Limpiar contenedor anterior
            paypalContainer.innerHTML = '';
            paypalContainer.style.display = 'block';
            paypalContainer.style.minHeight = '50px';
            paypalContainer.style.border = '2px dashed #ccc';
            paypalContainer.style.padding = '10px';
            paypalContainer.style.textAlign = 'center';

            // Mostrar mensaje de carga en el contenedor
            paypalContainer.innerHTML = '<div class="text-info"><i class="fas fa-spinner fa-spin"></i> Cargando PayPal...</div>';

            // Ocultar botón de carrito
            button.style.display = 'none';

            // Preparar datos
            const postData = { amount: amount };
            if (csrfName && csrfToken) {
                postData[csrfName] = csrfToken;
            }

            // Crear orden
            fetch(baseUrl + '/paypal/createOrder', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(postData)
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`Error del servidor: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Orden creada:', data);
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                if (!data.id) {
                    throw new Error('No se pudo crear la orden de PayPal');
                }
                
                // 🎯 Solución al ReferenceError: orderId is not defined
                orderIdFromBackend = data.id;

                // Limpiar el contenedor antes de renderizar
                paypalContainer.innerHTML = '';
                paypalContainer.style.border = 'none';
                paypalContainer.style.padding = '0';

                // Renderizar botón de PayPal con configuración específica
                return paypal.Buttons({
                    style: {
                        layout: 'vertical',
                        color:  'gold',
                        shape:  'pill',
                        label:  'paypal',
                        height: 45
                    },
                    createOrder: function(data, actions) {
                        // Usar el ID de orden que creamos en el backend
                        console.log('Creando orden PayPal con ID:', orderIdFromBackend);
                        return orderIdFromBackend; 
                    },
                    onApprove: function(data, actions) {
                        console.log('Orden aprobada:', data.orderID);
                        
                        // Mostrar mensaje de procesamiento
                        paypalContainer.innerHTML = '<div class="text-success"><i class="fas fa-spinner fa-spin"></i> Procesando pago...</div>';
                        
                        const captureData = { orderID: data.orderID };
                        if (csrfName && csrfToken) {
                            captureData[csrfName] = csrfToken;
                        }
                        
                        return fetch(baseUrl + '/paypal/captureOrder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(captureData)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al capturar el pago');
                            }
                            return response.json();
                        })
                        .then(captureData => {
                            console.log('Pago capturado:', captureData);
                            
                            // 🔥 Lógica de redirección inmediata para seleccionar servos
                            if (captureData.redirect_url) {
                                window.location.href = captureData.redirect_url;
                                return; // Detener la ejecución
                            }
                            
                            showSuccess(captureData);
                            // Limpiar contenedor
                            paypalContainer.innerHTML = '';
                            // Restaurar botón
                            button.style.display = 'block';
                        })
                        .catch(err => {
                            console.error('Error en capture:', err);
                            handleError(err);
                            // Restaurar UI
                            button.style.display = 'block';
                            paypalContainer.innerHTML = '';
                        });
                    },
                    onError: function(err) {
                        console.error('Error de PayPal:', err);
                        handleError(err);
                        // Restaurar UI
                        button.style.display = 'block';
                        paypalContainer.innerHTML = '';
                    },
                    onCancel: function(data) {
                        console.log('Pago cancelado por usuario');
                        // Restaurar UI
                        button.style.display = 'block';
                        paypalContainer.innerHTML = '<div class="text-warning"><i class="fas fa-times-circle"></i> Pago cancelado</div>';
                        
                        // Restaurar después de 3 segundos
                        setTimeout(() => {
                            paypalContainer.innerHTML = '';
                        }, 3000);
                    }
                }).render(paypalContainer);
            })
            // Eliminamos el bloque .then(paypalButtons => ...) para evitar el error de renderización
            .catch(err => {
                console.error('Error en el proceso:', err);
                handleError(err);
                // Restaurar UI
                button.style.display = 'block';
                paypalContainer.innerHTML = '';
            });
        }

        // Función para copiar Order ID
        function copiarOrderId() {
            const orderIdText = document.getElementById('orderIDparaCopiar').textContent;
            navigator.clipboard.writeText(orderIdText).then(function() {
                const btn = document.getElementById('btnCopiarId');
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copiado!';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 2000);
            });
        }

        console.log('PayPal SDK cargado:', typeof paypal !== 'undefined');
        console.log('PayPal Buttons disponibles:', typeof paypal.Buttons !== 'undefined');
    </script>
</body>
</html>