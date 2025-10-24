<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>VECOPO - Accede a tu cuenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85); /* Un poco más opaco para legibilidad del form */
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
            --accent-color: #64ffda;
            --danger-color: #ff4d4d; /* Rojo para errores */
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(100, 255, 218, 0.2);
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
            flex-direction: column; /* Para alinear header (si se añade) y login form */
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
            padding: 20px;
        }

        /* Estilo para el contenedor del formulario de login */
        .login-container {
            background: var(--card-bg);
            padding: 2.5rem 3rem;
            border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%;
            max-width: 480px; /* Ancho máximo para el formulario */
            animation: fadeIn 0.8s ease-out;
        }

        .login-container h1 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .form-control-custom {
            width: 100%;
            padding: 1rem 1.2rem;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control-custom::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }

        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25);
        }
        
        /* Contenedor para el input de contraseña y el icono */
        .password-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-container .form-control-custom {
            padding-right: 45px; /* Espacio para el icono */
        }

        #eyeicon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px; 
            height: auto;
        }

        #eyeicon:hover {
        }


        .login-button {
            width: 100%;
            padding: 0.9rem 1.5rem;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            color: var(--dark-bg);
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            margin-top: 1rem; /* Espacio antes del botón */
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }
        
        .login-links {
            text-align: center;
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column; /* Apila los enlaces verticalmente */
            gap: 0.8rem; /* Añade espacio entre los enlaces */
        }

        .login-links .main-actions, .login-links .secondary-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem; /* Espacio entre links en la misma línea */
        }

        .login-links a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .login-links a:hover {
            color: var(--primary-color);
            text-shadow: 0 0 5px var(--primary-color);
        }
        
        .login-links span { /* Para el separador "|" */
            color: var(--text-secondary);
        }

        /* Estilo para mensajes de error de Bootstrap (adaptado) */
        .alert-custom-danger {
            background-color: rgba(255, 77, 77, 0.1); /* Fondo semitransparente rojo */
            border: 1px solid var(--danger-color);
            color: var(--text-primary); /* Texto blanco o claro */
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
        }
        .alert-custom-danger strong { /* Si se usa <strong> en el mensaje */
            color: var(--danger-color);
        }
        
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                padding: 2rem 1.5rem;
                margin: 1rem; /* Añade un poco de margen en pantallas muy pequeñas */
            }
            .login-container h1 {
                font-size: 1.8rem;
            }
            .form-control-custom {
                padding: 0.9rem 1rem;
                font-size: 0.95rem;
            }
            .login-button {
                padding: 0.8rem 1.2rem;
                font-size: 1rem;
            }
             .login-links .main-actions, .login-links .secondary-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            .login-links span {
                display: none; /* Ocultar separador en móvil */
            }
        }

    </style>
</head>
<body>
    <div class=""></div> <main class="login-container">
        <h1>Accede a tu cuenta</h1>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-custom-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <div class="form-group">
                <label for="identifier" class="form-label">Email o Usuario</label>
                <input class="form-control-custom" type="text" name="identifier" id="identifier" 
                       placeholder="Tu email o nombre de usuario" 
                       value="<?= old('identifier') ?>" required> 
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-input-container">
                    <input class="form-control-custom" type="password" name="password" id="password" 
                           placeholder="Tu contraseña" required>
                    <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon" alt="Mostrar/Ocultar contraseña">
                </div>
            </div>
            
            <div class="form-group form-check text-left my-3">
                 <input type="checkbox" name="remember_me" class="form-check-input" id="rememberMeCheck">
                 <label class="form-check-label" for="rememberMeCheck" style="color: var(--text-secondary);">
                    Mantenerme conectado
                 </label>
            </div>

            <button class="login-button" type="submit">Entrar</button>
            
            <div class="login-links">
                <div class="main-actions">
                    <a href="<?= base_url('/forgotpassword') ?>">¿Olvidaste tu contraseña?</a>
                    <span>|</span>
                    <a href="<?= base_url('/tercon') ?>">Crear cuenta nueva</a>
                </div>
                <div class="secondary-actions">
                     <a href="<?= base_url('/modifypass') ?>">¿Quieres cambiar tu contraseña?</a>
                     <span>|</span>
                     <a href="<?= base_url('/modifyname') ?>">¿Quieres cambiar tu nombre?</a>
                </div>
            </div>
        </form>
    </main>

    <script>
        // Script para mostrar/ocultar contraseña (usando Font Awesome)
        let eyeicon = document.getElementById("eyeicon"); 
        let password = document.getElementById("password"); 
        
        if (eyeicon && password) {
            eyeicon.onclick = function(){
                if(password.type === "password"){
                    password.type = "text";
                    eyeicon.classList.remove('fa-eye');
                    eyeicon.classList.add('fa-eye-slash');
                } else {
                    password.type = "password";
                    eyeicon.classList.remove('fa-eye-slash');
                    eyeicon.classList.add('fa-eye');
                }
            }
        }
        
        // ** NUEVO SCRIPT DE REDIRECCIÓN **
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Lee la URL guardada cuando el usuario fue forzado al login
            const redirectUrl = sessionStorage.getItem('redirect_after_login');
            const redirectField = document.getElementById('redirectUrlField');

            // 2. Si existe una URL de retorno, la inyecta en el campo oculto del formulario
            if (redirectUrl && redirectField) {
                redirectField.value = redirectUrl;
                
                // Opcional: Eliminar la clave para evitar que se use en futuros logins normales
                // No lo quitamos inmediatamente, ya que si el login falla, la URL debe seguir ahí.
                // Lo limpiaremos en el servidor o al cargar la página de destino.
            }
        });
    </script>
    
    </body>
</html>