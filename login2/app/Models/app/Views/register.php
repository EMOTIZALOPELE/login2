<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>VECOPO - Crear Cuenta</title>
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
            --accent-color: #64ffda;
            --danger-color: #ff4d4d;
            --success-color: #00ff9d; /* Verde para éxito */
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(100, 255, 218, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%; /* Asegura que ocupen toda la altura del viewport */
            margin: 0;
            padding: 0;
            overflow: hidden; /* Previene el scroll en toda la página */
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-primary);
            display: flex; 
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: var(--card-bg);
            padding: 2rem 2.5rem; 
            border-radius: 20px; 
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            
            width: 100%; 
            max-width: 520px; 
            
            height: 100%; 
            
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            
            overflow: hidden; /* Previene el scroll y recorta el contenido si excede */
            
            animation: fadeIn 0.8s ease-out;
        }

        .register-container form {
            width: 100%;
        }

        .register-container h1 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 2rem; 
            text-align: center;
            margin-bottom: 1.8rem;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
        }

        .form-group {
            margin-bottom: 1.2rem; 
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .form-control-custom {
            width: 100%;
            padding: 0.9rem 1.1rem;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 10px;
            font-size: 0.95rem;
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
        
        .password-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-container .form-control-custom {
            padding-right: 45px; 
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
            /* Se eliminó la propiedad filter */
            opacity: 1; /* Opcional: el icono se vuelve completamente opaco al pasar el mouse */
        }

        .terms-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        .terms-container input[type="checkbox"] {
            margin-right: 0.75rem;
            transform: scale(1.1); 
            accent-color: var(--primary-color); 
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
        }
        .terms-container label {
            margin-bottom: 0; 
            line-height: 1.4;
        }
        .terms-container a {
            color: var(--accent-color);
            text-decoration: none;
        }
        .terms-container a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .register-button {
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
            margin-top: 0.5rem; 
        }

        .register-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }
        
        .login-link-container { 
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link-container a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .login-link-container a:hover {
            color: var(--primary-color);
            text-shadow: 0 0 5px var(--primary-color);
        }
        
        .alert-custom {
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
        }
        .alert-custom-success {
            background-color: rgba(0, 255, 157, 0.1); 
            border: 1px solid var(--success-color);
            color: var(--text-primary);
        }
        .alert-custom-errors {
            background-color: rgba(255, 77, 77, 0.1); 
            border: 1px solid var(--danger-color);
            color: var(--text-primary);
        }
        .alert-custom-errors ul {
            list-style-type: none; 
            padding-left: 0;
            margin-bottom: 0;
        }
        .alert-custom-errors ul li {
            margin-bottom: 0.3rem;
        }
        .alert-custom-errors ul li:last-child {
            margin-bottom: 0;
        }
        
        @media (max-width: 576px) { /* Para anchos de pantalla pequeños */
            .register-container {
                padding: 1.8rem 1.2rem;
                margin: 0; /* Ocupa todo el ancho en móvil */
                border-radius: 0; /* Sin bordes redondeados en móvil si es full screen */
                max-width: 100%;
            }
            .register-container h1 {
                font-size: 1.7rem;
            }
            .form-control-custom {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
            .register-button {
                padding: 0.8rem 1.2rem;
                font-size: 1rem;
            }
            .terms-container {
                font-size: 0.8rem;
            }
            .terms-container input[type="checkbox"] {
                 margin-right: 0.5rem;
            }
        }
        
        /* Ajustes adicionales para pantallas con poca altura para evitar recorte de contenido */
        @media (max-height: 700px) { 
            .register-container {
                padding-top: 1.5rem; 
                padding-bottom: 1.5rem;
            }
            .register-container h1 {
                font-size: 1.7rem;
                margin-bottom: 1.2rem;
            }
            .form-group {
                margin-bottom: 0.9rem;
            }
            .form-control-custom {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
            .register-button {
                padding: 0.8rem 1.2rem;
                font-size: 1rem;
                margin-top: 0.8rem;
            }
            .terms-container {
                font-size: 0.8rem;
                margin-bottom: 1rem;
            }
            .terms-container input[type="checkbox"] {
                transform: scale(1);
                margin-right: 0.5rem;
            }
            .login-link-container {
                margin-top: 1.2rem;
            }
            .alert-custom {
                padding: 0.7rem 1rem;
                font-size: 0.9rem;
                margin-top: 1rem;
            }
        }

        @media (max-height: 600px) { 
            .register-container {
                padding-top: 1rem;
                padding-bottom: 1rem;
                border-radius: 10px; 
            }
            .register-container h1 {
                font-size: 1.5rem;
                margin-bottom: 0.8rem;
            }
            .form-group {
                margin-bottom: 0.6rem;
            }
            .form-label {
                font-size: 0.8rem;
                margin-bottom: 0.2rem;
            }
            .form-control-custom {
                padding: 0.7rem 0.8rem;
            }
             .register-button {
                padding: 0.7rem 1rem;
            }
            .terms-container {
                margin-bottom: 0.8rem;
            }
             .login-link-container {
                margin-top: 0.8rem;
            }
        }

    </style>
</head>
<body>
    <div class=""></div>

    <main class="register-container">
        <h1>Crear Nueva Cuenta</h1>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-custom alert-custom-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert-custom alert-custom-errors">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    
        <form action="<?= base_url('register/store') ?>" method="post">
            
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre</label>
                <input class="form-control-custom" type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?= old('nombre') ?>" required>
            </div>

            <div class="form-group">
                <label for="apellido" class="form-label">Apellido</label>
                <input class="form-control-custom" type="text" name="apellido" id="apellido" placeholder="Tu apellido" value="<?= old('apellido') ?>" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input class="form-control-custom" type="email" name="email" id="email" placeholder="tu_correo@ejemplo.com" value="<?= old('email') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-input-container">
                    <input class="form-control-custom" type="password" name="password" id="password" placeholder="Crea una contraseña segura" required>
                    <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon" alt="Mostrar/Ocultar contraseña">
                </div>
            </div>

            <div class="form-group terms-container">
                <input type="checkbox" name="terms" id="terms" required>
                <label for="terms">Estoy de acuerdo con los <a href="#">Términos y Condiciones</a></label>
            </div>

            <button class="register-button" type="submit">Registrar</button>
        </form>

        <div class="login-link-container">
            <a href="<?= base_url('/iniciovalogin') ?>">¿Ya tengo Cuenta? Iniciar Sesión</a>
        </div>
    </main>

    <script>
        let eyeicon = document.getElementById("eyeicon"); 
        let password = document.getElementById("password"); 
        
        if (eyeicon && password) {
            eyeicon.onclick = function(){
                if(password.type == "password"){
                    password.type = "text";
                    eyeicon.src = "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
                } else {
                    password.type = "password";
                    eyeicon.src = "https://static.thenounproject.com/png/1035969-200.png";
                }
            }
        }
    </script>
</body>
</html>