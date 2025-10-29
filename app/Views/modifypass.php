<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>VECOPO - Cambiar Contraseña</title>
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
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(100, 255, 218, 0.2);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-container {
            background: var(--card-bg);
            padding: 2.5rem 3rem;
            border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%;
            max-width: 480px;
        }
        .login-container h1 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-group { margin-bottom: 1.5rem; position: relative; }
        .form-label { display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-secondary); }
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
        .form-control-custom::placeholder { color: var(--text-secondary); opacity: 0.7; }
        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25);
        }
        .password-input-container { position: relative; display: flex; align-items: center; }
        .password-input-container .form-control-custom { padding-right: 45px; }
        .eye-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px;
            height: auto;
        }
        .login-button {
            width: 100%;
            padding: 0.9rem 1.5rem;
            font-weight: 500;
            font-size: 1.1rem;
            color: var(--dark-bg);
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        .login-button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3); }
        .login-links { text-align: center; margin-top: 1.5rem; }
        .login-links a { color: var(--accent-color); text-decoration: none; font-size: 0.9rem; transition: color 0.3s ease; }
        .login-links a:hover { color: var(--primary-color); }
        .alert-custom-danger {
            background-color: rgba(255, 77, 77, 0.1);
            border: 1px solid var(--danger-color);
            color: var(--text-primary);
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        /* ESTILO AÑADIDO PARA EL MENSAJE DE ÉXITO */
        .alert-custom-success {
            background-color: rgba(100, 255, 218, 0.1); 
            border: 1px solid var(--accent-color); 
            color: var(--text-primary);
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <main class="login-container">
        <h1>Cambiar Contraseña</h1>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-custom-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-custom-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('update-password') ?>" method="post">
<<<<<<< HEAD
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
            <div class="form-group">
                <label for="identifier" class="form-label">Email o Usuario</label>
                <input class="form-control-custom" type="text" name="identifier" id="identifier" 
                       placeholder="Tu email o nombre de usuario" 
                       value="<?= old('identifier') ?>" required> 
            </div>
            
            <div class="form-group">
                <label for="current_password" class="form-label">Contraseña Actual</label>
                <div class="password-input-container">
                    <input class="form-control-custom" type="password" name="current_password" id="current_password" 
                           placeholder="Tu contraseña actual" required>
                    <img src="https://static.thenounproject.com/png/1035969-200.png" class="eye-icon" alt="Mostrar/Ocultar contraseña">
                </div>
            </div>

            <div class="form-group">
                <label for="new_password" class="form-label">Nueva Contraseña</label>
                <div class="password-input-container">
                    <input class="form-control-custom" type="password" name="new_password" id="new_password" 
                           placeholder="Escribe tu nueva contraseña" required>
                    <img src="https://static.thenounproject.com/png/1035969-200.png" class="eye-icon" alt="Mostrar/Ocultar contraseña">
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_new_password" class="form-label">Confirmar Nueva Contraseña</label>
                <div class="password-input-container">
                    <input class="form-control-custom" type="password" name="confirm_new_password" id="confirm_new_password" 
                           placeholder="Confirma tu nueva contraseña" required>
                    <img src="https://static.thenounproject.com/png/1035969-200.png" class="eye-icon" alt="Mostrar/Ocultar contraseña">
                </div>
            </div>
            
            <button class="login-button" type="submit">Actualizar Contraseña</button>
            
            <div class="login-links">
                <a href="<?= base_url('/iniciovalogin') ?>">Volver al inicio de sesión</a>
            </div>
        </form>
    </main>

    <script>
        document.querySelectorAll('.eye-icon').forEach(icon => {
            icon.onclick = function() {
                let passwordInput = this.previousElementSibling;
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    this.src = "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
                } else {
                    passwordInput.type = "password";
                    this.src = "https://static.thenounproject.com/png/1035969-200.png";
                }
            }
        });
    </script>
    
</body>
</html>