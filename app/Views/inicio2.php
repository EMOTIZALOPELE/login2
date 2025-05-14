<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>VECOPO</title> <style>
        /* Reset de estilos básicos */
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
            overflow-x: hidden;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background: rgba(0, 0, 0, 0.2);
            background: linear-gradient(to right, rgb(17, 17, 17) 0%, rgb(19, 63, 71) 50%, rgb(17, 17, 17) 100%);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }


        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg,rgb(51, 116, 255),rgb(0, 213, 255));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-btn, .register-btn {
            text-decoration: none;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 500;
            margin: 0 10px;
        }

        .login-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .register-btn {
            background: linear-gradient(45deg, #1f53c5, #00b4d8);
            border: none;
            box-shadow: 0 4px 15px rgba(31, 83, 197, 0.4);
        }

        .login-btn:hover, .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(31, 83, 197, 0.6);
            box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
            border-radius: 15px;
        }

        .presentation {
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0 5%;
            position: relative;
            overflow: hidden;
        }

        .presentation-content {
            max-width: 800px;
            text-align: center;
            animation: fadeIn 1s ease-in;
        }

        .presentation::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('<?= base_url("img/fondo4.jpg") ?>') no-repeat center center;
            background-size: cover;
            opacity: 0.2;
            z-index: -1;
        }

        .presentation h2 {
            margin-top: 100px;
            font-size: 3.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
            background: linear-gradient(45deg, #fff, #00b4d8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .presentation p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        .aboutus {
            min-height: 100%;
            display: flex;
            width: 100%; /* Ancho total de la ventana */
            padding: 60px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0; /* Elimina bordes redondeados */
            backdrop-filter: blur(5px);
            flex-direction: column;
            justify-content: center;
            text-align: center;
            color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .aboutus-content{

        }

        .aboutus h3 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #00b4d8, #1f53c5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .aboutus p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.9);
        }

        .about-grid {

            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .about-item {
            background: rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 15px;
            width: 250px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }

        .about-item::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.1) 25%,
                rgba(255, 255, 255, 0.5) 50%,
                rgba(255, 255, 255, 0.1) 75%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(45deg);
            transition: 0.6s;
            opacity: 0;
        }

        .about-item:hover::before {
            animation: shine 1.5s;
        }

        @keyframes shine {
            0% {
                transform: translate(-100%, -100%) rotate(45deg);
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: translate(100%, 100%) rotate(45deg);
                opacity: 0;
            }
        }

        .about-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.12);
        }

        .about-item i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #00b4d8;
            position: relative;
            z-index: 1;
        }

        .about-item h4 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .about-item p {
            position: relative;
            z-index: 1;
        }

        .coverletter {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .coverletter-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 1.0s ease;
            width: 200px;
            animation: slideIn 0.5s ease-out;
        }

        .coverletter-item:hover {
            transform: translateY(-5px) scale(1.05); /* Levanta y agranda el botón */
            background: rgba(119, 101, 101, 0.2); /* Fondo semitransparente */
            box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
            border-radius: 15px; /* Aumenta el redondeo para mayor suavidad */
        }

        .coverletter-item i {
            font-size: 2rem;
            margin-bottom: 15px;
            background: linear-gradient(45deg, #1f53c5, #00b4d8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .paypal {
            min-height: 100%;
            display: flex; /* Convierte en contenedor flex */
            justify-content: center; /* Centra horizontalmente los ítems en fila */
            align-items: center; /* Centra verticalmente los ítems en fila */
            width: 100%;
            padding: 60px;
            background: rgba(231, 221, 221, 0.25);
            border-radius: 0;
            background: linear-gradient(to right,rgb(0, 0, 0),rgb(4, 121, 145));
            backdrop-filter: blur(5px);
            text-align: center; /* Esto ya no será necesario para centrar los ítems flex */
            color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            flex-wrap: wrap; /* Agrega esto si quieres que los elementos salten de línea en pantallas pequeñas */
            gap: 40px; /* Agrega espacio entre los elementos */

            /* === NUEVOS ESTILOS PARA EL FONDO ANIMADO === */
            position: relative; /* Asegura que los elementos hijos absolutos se posicionen respecto a este */
            overflow: hidden; /* Oculta la animación al salir de la sección */
            /* ========================================== */
        }

        /* === NUEVOS ESTILOS PARA EL CONTENEDOR DE SÍMBOLOS === */
        .dollar-rain {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Permite clics a través de este elemento */
            z-index: 0; /* Coloca esta capa detrás del contenido principal */
        }

        /* Estilo base para cada símbolo de dólar */
        .dollar-rain span {
            position: absolute;
            bottom: 0; /* Inicia desde la parte inferior */
            color: rgba(255, 255, 255, 0.4); /* Color blanco semi-transparente */
            font-size: 25px; /* Tamaño base del símbolo */
            opacity: 0; /* Inicia invisible */
            animation: rise 10s infinite linear; /* Aplica la animación 'rise' */
        }

        /* Keyframes para la animación de subida */
        @keyframes rise {
            0% {
                transform: translateY(0); /* Posición inicial */
                opacity: 0; /* Invisible al inicio */
            }
             10% {
                 opacity: 0.6; /* Se vuelve visible */
             }
            90% {
                 opacity: 0.6; /* Mantiene visibilidad */
            }
            100% {
                transform: translateY(-150vh); /* Sube fuera del viewport */
                opacity: 0; /* Se vuelve invisible al final */
            }
        }

        /* Posiciones, tamaños y retrasos individuales para los símbolos */
        .dollar-rain span:nth-child(1) { left: 5%; font-size: 80px; animation-delay: 0s; }
        .dollar-rain span:nth-child(2) { left: 15%; font-size: 60px; animation-delay: 1s; }
        .dollar-rain span:nth-child(3) { left: 25%; font-size: 22px; animation-delay: 2s; }
        .dollar-rain span:nth-child(4) { left: 35%; font-size: 28px; animation-delay: 3s; }
        .dollar-rain span:nth-child(5) { left: 45%; font-size: 24px; animation-delay: 4s; }
        .dollar-rain span:nth-child(6) { left: 55%; font-size: 26px; animation-delay: 0.5s; }
        .dollar-rain span:nth-child(7) { left: 65%; font-size: 300px; animation-delay: 1.5s; }
        .dollar-rain span:nth-child(8) { left: 75%; font-size: 35px; animation-delay: 2.5s; }
        .dollar-rain span:nth-child(9) { left: 85%; font-size: 21px; animation-delay: 3.5s; }
        .dollar-rain span:nth-child(10) { left: 95%; font-size: 29px; animation-delay: 4.5s; }
        .dollar-rain span:nth-child(11) { left: 8%; font-size: 100px; animation-delay: 5s; }
        .dollar-rain span:nth-child(12) { left: 18%; font-size: 27px; animation-delay: 6s; }
        .dollar-rain span:nth-child(13) { left: 28%; font-size: 70px; animation-delay: 7s; }
        .dollar-rain span:nth-child(14) { left: 38%; font-size: 30px; animation-delay: 8s; }
        .dollar-rain span:nth-child(15) { left: 48%; font-size: 150px; animation-delay: 9s; }
        /* Agrega más si añadiste más <span> en el HTML */
        /* ================================================= */


        .paypal-container {
            background: linear-gradient(to left,rgb(39, 38, 38),rgb(3, 74, 88));
            padding: 0px 0px 60px 00px;
            border-radius: 15px;
            height: 450px;
            width: 350px; /* Ancho similar */
            transition: all 0.3s ease;
            position: relative; /* Asegura que esté posicionado encima del .dollar-rain */
            overflow: hidden;
            margin-top: 60px; /* Ajusta el margen superior si es necesario debido al header fijo */
            text-align: center;
            border: none; /* Eliminamos el borde */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2); /* Sombra similar */
            z-index: 1; /* Asegura que esté encima del .dollar-rain (que tiene z-index: 0) */
        }

        .paypal-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .precio-container {
            background: rgba(43, 63, 104, 0.78);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 4px 15px rgba(13, 13, 14, 0.4);
            position: relative;
            overflow: hidden;
        }

        .precio-container::before {
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

        .precio-container:hover::before {
            transform: translateX(100%);
        }

        .precio-simbolo {
            font-size: 1.5rem;
            vertical-align: super;
            margin-right: 5px;
        }

        .precio-descripcion {
            font-size: 1.2rem;
            margin-top: 10px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: normal;
        }

        .paypalcard {
            margin-top: 0px;
            text-align: left;
        }

        .paypalcard-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.9);
            transition: transform 0.3s ease;
        }

        .paypalcard-item:hover {
            transform: translateX(10px);
            color: #00b4d8;
        }

        .paypalcard-item i {
            margin-right: 15px;
            color: #00b4d8;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .paypalcard-item:hover i {
            transform: scale(1.2);
        }

        .copyright {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8), rgba(19, 63, 71, 0.8));
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .copyright::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, transparent, #00b4d8, transparent);
        }

        .copyright p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            header {
                padding: 15px;
                flex-direction: column;
                gap: 15px;
            }

            .logo {
                font-size: 2rem;
                order: 2;
            }

            .presentation {
                width: 100%;
                padding: 20px;
            }

            .presentation h2 {
                font-size: 2rem;
                margin-top: 150px;
            }

            .presentation p {
                font-size: 1rem;
            }

            .aboutus {
                width: 100%;
                padding: 30px;
            }

            .about-grid {
                gap: 20px;
            }

            .about-item {
                width: 100%;
                max-width: 300px;
            }

            .paypal {
                padding: 30px;
            }

            .paypal-container {
                width: 100%;
                max-width: 350px;
                 margin-top: 30px; /* Ajuste en móvil */
            }

            .copyright {
                width: 100%;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>
    <header>
        <a href="<?= base_url('/iniciovalogin') ?>" class="login-btn">Iniciar sesión</a>
        <h1 class="logo">VECOPO</h1>
        <a href="<?= base_url('/tercon') ?>" class="register-btn">Registrarse</a>
    </header>

    <section class="presentation">
        <div class="presentation-content">

            <h2>Automatización Inteligente para tu Hogar</h2>
            <p>La mejor solución en automatización de ventanas, cortinas y postigones.</p>

            <div class="coverletter">

                <div class="coverletter-item">
                    <i class="fas fa-window-maximize"></i>
                    <h3>Cortinas</h3>
                    <p>Automatización inteligente</p>
                </div>

                <div class="coverletter-item">
                    <i class=" fa-solid fa-table-cells-large"></i>
                    <h3>Ventanas</h3>
                    <p>Control total de tus ventanas</p>
                </div>

                <div class="coverletter-item">
                    <i class="fa-solid fa-table-cells"></i>
                    <h3>Postigones</h3>
                    <p>Control remoto completo</p>
                </div>
            </div>
        </div>
    </section>

    <section class="aboutus">
        <div class="aboutus-content">
            <h3>SOBRE NOSOTROS</h3>
            <p>En VECOPO nos dedicamos a crear soluciones inteligentes para el confort del hogar. Con tecnología de punta, buscamos simplificar la vida cotidiana mediante la automatización de ventanas, cortinas y postigones.</p>
            <div class="about-grid">
                <div class="about-item">
                    <i class="fas fa-lightbulb"></i>
                    <h4>Innovación</h4>
                    <p>Desarrollamos tecnología moderna para hogares inteligentes.</p>
                </div>
                <div class="about-item">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Seguridad</h4>
                    <p>Protegemos tu hogar con automatizaciones seguras y confiables.</p>
                </div>
                <div class="about-item">
                    <i class="fas fa-users"></i>
                    <h4>Compromiso</h4>
                    <p>Atención personalizada y soporte técnico 24/7 para nuestros clientes.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="paypal">
        <div class="dollar-rain">
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>peru</span>
            <span>peruka</span>
            <span>$</span> 
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>$</span>
            <span>$</span>
            </div>
        <div class="paypal-container">
            <div class="precio-container">
                <span class="precio-simbolo">$</span>19.99
                <div class="precio-descripcion">Plan Básico</div>
            </div>
            <div class="paypalcard">
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Control básico de dispositivos</span>
                </div>
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Programación básica</span>
                </div>
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Soporte por email</span>
                </div>
            </div>
            <div id="paypal-button-container-1"></div>
        </div>

        <div class="paypal-container">
            <div class="precio-container">
                <span class="precio-simbolo">$</span>49.99
                <div class="precio-descripcion">Plan Pro</div>
            </div>
            <div class="paypalcard">
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Control total de dispositivos</span>
                </div>
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Programación avanzada</span>
                </div>
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Soporte 24/7</span>
                </div>
            </div>
            <div id="paypal-button-container-2"></div>
        </div>

        <div class="paypal-container">
            <div class="precio-container">
                <span class="precio-simbolo">$</span>99.99
                <div class="precio-descripcion">Plan Enterprise</div>
            </div>
            <div class="paypalcard">
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Control total de dispositivos</span>
                </div>
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Programación avanzada</span>
                </div>
                <div class="paypalcard-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Soporte 24/7 + Asistente dedicado</span>
                </div>
            </div>
            <div id="paypal-button-container-3"></div>
        </div>
    </section>

    <footer>
        <div class="copyright">
            <p>&copy; 2025 VECOPO. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Configuración para el Plan Básico
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '19.99'
                        },
                        description: 'Plan Básico VECOPO'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('¡Pago completado! Gracias ' + details.payer.name.given_name);
                    window.location.href = '<?= base_url('/iniciovalogin') ?>'; // Redirige al inicio de sesión después del pago
                });
            },
            onError: function(err) {
                alert('Ocurrió un error durante el proceso de pago');
                console.error(err);
            },
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'pill',
                label: 'pay'
            }
        }).render('#paypal-button-container-1');

        // Configuración para el Plan Pro
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '49.99'
                        },
                        description: 'Plan Pro VECOPO'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('¡Pago completado! Gracias ' + details.payer.name.given_name);
                    window.location.href = '<?= base_url('/iniciovalogin') ?>'; // Redirige al inicio de sesión después del pago
                });
            },
            onError: function(err) {
                alert('Ocurrió un error durante el proceso de pago');
                console.error(err);
            },
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'pill',
                label: 'pay'
            }
        }).render('#paypal-button-container-2');

        // Configuración para el Plan Enterprise
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '99.99'
                        },
                        description: 'Plan Enterprise VECOPO'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('¡Pago completado! Gracias ' + details.payer.name.given_name);
                    window.location.href = '<?= base_url('/iniciovalogin') ?>'; // Redirige al inicio de sesión después del pago
                });
            },
            onError: function(err) {
                alert('Ocurrió un error durante el proceso de pago');
                console.error(err);
            },
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'pill',
                label: 'pay'
            }
        }).render('#paypal-button-container-3');
    </script>
</body>
</html>