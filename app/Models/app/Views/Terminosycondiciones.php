<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones - VECOPO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85);
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
            --accent-color: #64ffda;
            --danger-color: #ff4d4d;
            --success-color: #00ff9d;
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(100, 255, 218, 0.2);
            --hr-color: rgba(100, 255, 218, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; 
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-primary);
            display: flex; 
            justify-content: center;
            align-items: center;
        }

        .terms-container-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; 
        }

        .terms-card {
            background: var(--card-bg);
            padding: 2rem 2.5rem; 
            border-radius: 20px; 
            border: 1px solid var(--input-border);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            
            width: 100%; 
            max-width: 800px; 
            
            height: 100%; 
            max-height: calc(100vh - 40px); 
            
            display: flex;
            flex-direction: column; 
            
            animation: fadeIn 0.8s ease-out;
        }

        .terms-card-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 2rem; 
            text-align: center;
            margin-bottom: 1rem; 
            padding-top: 0.5rem; 
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
            flex-shrink: 0; 
        }

        .terms-card hr {
            border: none;
            height: 1px;
            background-color: var(--hr-color);
            margin: 1rem 0;
            flex-shrink: 0; 
        }

        .terms-content-scrollable {
            flex-grow: 1; 
            overflow-y: auto; 
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            padding-right: 10px; 
        }

        .terms-content-scrollable h5 {
            font-family: 'Roboto', sans-serif; 
            font-weight: 500;
            color: var(--accent-color);
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .terms-content-scrollable p strong {
            color: var(--text-primary); 
        }

        .terms-content-scrollable::-webkit-scrollbar {
            width: 8px;
        }
        .terms-content-scrollable::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .terms-content-scrollable::-webkit-scrollbar-thumb {
            background: var(--input-border);
            border-radius: 10px;
        }
        .terms-content-scrollable::-webkit-scrollbar-thumb:hover {
            background: var(--accent-color);
        }

        .terms-actions {
            display: flex;
            justify-content: space-between; 
            padding-top: 0.5rem; 
            flex-shrink: 0; 
        }

        .btn-custom {
            padding: 0.75rem 1.8rem;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .btn-accept-custom {
            color: var(--dark-bg);
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        }
        .btn-accept-custom:hover {
            color: var(--dark-bg); 
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }

        .btn-decline-custom {
            color: var(--text-primary);
            background-color: var(--danger-color); 
        }
        .btn-decline-custom:hover {
            color: var(--text-primary);
            background-color: #c82333; 
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.3);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .terms-container-wrapper {
                padding: 10px; 
            }
            .terms-card {
                padding: 1.5rem;
                max-height: calc(100vh - 20px); 
            }
            .terms-card-title {
                font-size: 1.5rem;
            }
            .terms-content-scrollable {
                font-size: 0.9rem;
            }
            .btn-custom {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            .terms-actions {
                flex-direction: column; 
                gap: 0.75rem; 
            }
            .terms-actions .btn-custom {
                width: 100%; 
            }
        }
         @media (max-height: 600px) {
             .terms-card {
                padding: 1rem;
             }
            .terms-card-title {
                font-size: 1.3rem;
                margin-bottom: 0.5rem;
            }
            .terms-card hr {
                margin: 0.5rem 0;
            }
            .terms-content-scrollable {
                font-size: 0.85rem;
                padding-right: 5px;
            }
             .terms-content-scrollable h5 {
                font-size: 1rem;
                margin-top: 1rem;
            }
            .btn-custom {
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="terms-container-wrapper">
        <main class="terms-card">
            <h1 class="terms-card-title">Términos y Condiciones</h1>
            <hr>
            <div class="terms-content-scrollable">
                <p>Bienvenido a <strong>VECOPO</strong>. Estos términos y condiciones describen las reglas y regulaciones para el uso del sistema de automatización VECOPO.</p>
                <p>Al acceder, instalar o utilizar los productos y servicios de <strong>VECOPO</strong> (en adelante, el "Sistema"), usted (en adelante, "Usuario") acepta estar sujeto a estos términos y condiciones en su totalidad. No continúe utilizando el Sistema si no acepta todos los términos y condiciones establecidos en esta página.</p>
                
                <h5>1. Descripción del Servicio</h5>
                <p><strong>VECOPO</strong> es un sistema de automatización residencial y comercial diseñado para controlar de manera inteligente y remota elementos como cortinas, ventanas y postigones. El Sistema puede incluir hardware, software, aplicaciones móviles y servicios web asociados.</p>

                <h5>2. Cuentas de Usuario</h5>
                <p>Para acceder a ciertas funciones del Sistema, es posible que deba registrarse y crear una cuenta. Usted es responsable de mantener la confidencialidad de la información de su cuenta, incluida su contraseña, y de todas las actividades que ocurran bajo su cuenta. Acepta notificar a VECOPO inmediatamente sobre cualquier uso no autorizado de su cuenta o contraseña, o cualquier otra violación de seguridad.</p>

                <h5>3. Uso Aceptable</h5>
                <p>Usted se compromete a utilizar el Sistema únicamente para los fines previstos y de conformidad con todas las leyes y regulaciones aplicables. No utilizará el Sistema de ninguna manera que pueda dañar, deshabilitar, sobrecargar o perjudicar el Sistema o interferir con el uso y disfrute del Sistema por parte de terceros.</p>
                <p>Las actividades prohibidas incluyen, entre otras:
                    <ul>
                        <li>Ingeniería inversa, descompilación o desmontaje de cualquier componente del Sistema.</li>
                        <li>Intentar obtener acceso no autorizado a cualquier parte del Sistema, otras cuentas, sistemas informáticos o redes conectadas al Sistema.</li>
                        <li>Transmitir cualquier material que contenga virus de software u otro código informático, archivos o programas dañinos.</li>
                    </ul>
                </p>

                <h5>4. Propiedad Intelectual</h5>
                <p>El Sistema y todo su contenido original, características y funcionalidad (incluidos, entre otros, todo el software, texto, pantallas, imágenes, video y audio, y el diseño, selección y disposición de los mismos) son propiedad de VECOPO, sus licenciantes u otros proveedores de dicho material y están protegidos por leyes internacionales de derechos de autor, marcas registradas, patentes, secretos comerciales y otras leyes de propiedad intelectual o derechos de propiedad.</p>

                <h5>5. Modificaciones al Servicio y Precios</h5>
                <p>VECOPO se reserva el derecho de modificar o descontinuar, temporal o permanentemente, el Servicio (o cualquier parte del mismo) con o sin previo aviso. Los precios de todos los Servicios están sujetos a cambios con 30 días de aviso previo por nuestra parte. Dicho aviso puede proporcionarse en cualquier momento publicando los cambios en el sitio web de VECOPO o en el propio Servicio.</p>
                
                <h5>6. Limitación de Responsabilidad</h5>
                <p>En la máxima medida permitida por la ley aplicable, en ningún caso VECOPO, sus afiliados, directores, empleados, agentes, proveedores o licenciantes serán responsables de ningún daño indirecto, punitivo, incidental, especial, consecuente o ejemplar, incluidos, entre otros, daños por pérdida de beneficios, buena voluntad, uso, datos u otras pérdidas intangibles, que surjan de o estén relacionados con el uso o la imposibilidad de usar el servicio.</p>

                <h5>7. Indemnización</h5>
                <p>Usted acepta defender, indemnizar y eximir de responsabilidad a VECOPO y sus licenciatarios y licenciantes, y sus empleados, contratistas, agentes, funcionarios y directores, de y contra cualquier reclamo, daño, obligación, pérdida, responsabilidad, costo o deuda, y gastos (incluidos, entre otros, los honorarios de abogados), que resulten de o surjan de a) su uso y acceso al Servicio, por usted o cualquier persona que use su cuenta y contraseña; b) una violación de estos Términos, o c) Contenido publicado en el Servicio.</p>

                <h5>8. Modificación de los Términos</h5>
                <p>Nos reservamos el derecho, a nuestra entera discreción, de modificar o reemplazar estos Términos en cualquier momento. Si una revisión es material, intentaremos proporcionar un aviso de al menos 30 días antes de que entren en vigor los nuevos términos. Lo que constituye un cambio material se determinará a nuestra entera discreción.</p>
                <p>Al continuar accediendo o utilizando nuestro Servicio después de que esas revisiones entren en vigor, usted acepta estar sujeto a los términos revisados. Si no está de acuerdo con los nuevos términos, deje de utilizar el Servicio.</p>

                <h5>9. Contacto</h5>
                <p>Si tiene alguna pregunta sobre estos Términos, por favor contáctenos a través de [Correo Electrónico de Soporte o Formulario de Contacto].</p>
                <p><em>Última actualización: 29 de Mayo de 2025.</em></p>
            </div>
            <hr>
            <div class="terms-actions"> 
                <a href="<?= base_url('/iniciovaregister') ?>" class="btn-custom btn-accept-custom">Aceptar y Continuar</a>
                <a href="<?= base_url('pantalla') ?>" class="btn-custom btn-decline-custom">Rechazar</a>
            </div>
        </main>
    </div>
</body>
</html>