<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
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
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #1f53c5, #00b4d8);
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
            transform: translateY(-5px) scale(1.05); /* Levanta y agranda el botón */              box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
            border-radius: 15px; /* Aumenta el redondeo para mayor suavidad */
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
            min-height: 95vh;
            display: flex;
            width: 100vw; /* Ancho total de la ventana */
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
            min-height: 90vh;
            display: flex; /* Convierte en contenedor flex */
            justify-content: center; /* Centra horizontalmente los ítems en fila */
            align-items: center; /* Centra verticalmente los ítems en fila */
            width: 100vw;
            padding: 60px;
            background: rgba(231, 221, 221, 0.25);
            border-radius: 0;
            backdrop-filter: blur(5px);
            text-align: center; /* Esto ya no será necesario para centrar los ítems flex */
            color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            flex-wrap: wrap; /* Agrega esto si quieres que los elementos salten de línea en pantallas pequeñas */
            gap: 40px; /* Agrega espacio entre los elementos */
}
        .paypal-container {
            background: rgba(112, 110, 110, 0.88);
            padding: 30px;
            border-radius: 15px;
            height: 450px;
            width: 350px; /* Ancho similar */
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 60px;
            text-align: center;
            border: none; /* Eliminamos el borde */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Sombra similar */
        }

        .paypal-container:hover {
            transform: translateY(-5px) scale(1.05); /* Levanta y agranda el botón */

            box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
            border-radius: 15px; /* Aumenta el redondeo para mayor suavidad */
        }

        .precio-container {
            background: linear-gradient(45deg, #1f53c5, #00b4d8);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 4px 15px rgba(31, 83, 197, 0.4);
        }

        .precio-descripcion {
            font-size: 1rem;
            margin-top: 10px;
            color: rgba(255, 255, 255, 0.9);
        }

        .paypalcard {
   
            margin-top: 0px;
            text-align: left;
        }

        .paypalcard-item {
            
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.9);
        }

        .paypalcard-item i {
            margin-right: 10px;
            color: #00b4d8;
        }

        .copyright {
            margin-top: 20px;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            position: relative;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            header {
                padding: 15px;
            }

            .logo {
                font-size: 2rem;
            }

            .presentation {
                width: 700px;
            }


            .presentation h2 {
                font-size: 2.5rem;
            }

            .presentation p {
                font-size: 1.1rem;
            }

            .aboutus{
                width: 700px;
            }
            .coverletter-item {
                width: 100%;
                max-width: 300px;
            }

            .copyright {
                width: 700px;
            }
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
        <div class="paypal-container">
            <div class="precio-container">
                $19.99
                <div class="precio-descripcion">Plan Premium - Acceso Completo</div>
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
            <div id="paypal-button-container"></div>
        </div>
        
        <div class="paypal-container">
                <div class="precio-container">
                    $50.00
                    <div class="precio-descripcion">Plan Premium - Acceso Completo</div>
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
            <div id="paypal-button-container"></div>
        </div>

        <div class="paypal-container">
                <div class="precio-container">
                    $100.00
                    <div class="precio-descripcion">Plan Premium - Acceso Completo</div>
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
            <div id="paypal-button-container"></div>
        </div>
    </section>
    <footer>
        <div class="copyright">
            <p>&copy; 2025 VECOPO. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '19.99'
                        },
                        description: 'Plan Premium VECOPO'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('¡Pago completado! Gracias ' + details.payer.name.given_name);
                    window.location.href = '<?= base_url('/iniciovalogin') ?>';
                });
            },
            onError: function(err) {
                alert('Ocurrió un error durante el proceso de pago');
                console.error(err);
            },
            style: {
                layout: 'vertical',
                color:  'gold',
                shape:  'pill',
                label:  'pay'
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>