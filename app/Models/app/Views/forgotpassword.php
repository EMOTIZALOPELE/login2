<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - VECOPO</title>
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
        
        .logo-header {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 242, 254, 0.3);
            margin-bottom: 2rem;
        }

        .form-container {
            background: var(--card-bg);
            padding: 2.5rem 3rem;
            border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.8s ease-out;
        }

        .form-container h1 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
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
        
        .action-button {
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
            margin-top: 1rem;
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }
        
        .secondary-link-container {
            text-align: center;
            margin-top: 1.5rem;
        }

        .secondary-link-container a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .secondary-link-container a:hover {
            color: var(--primary-color);
            text-shadow: 0 0 5px var(--primary-color);
        }
        
        /* Estilos para mensajes flash */
        .alert-custom {
            padding: 0.9rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            border: 1px solid transparent;
        }
        .alert-custom-danger {
            background-color: rgba(255, 77, 77, 0.1); 
            border-color: var(--danger-color);
            color: #f8d7da;
        }
        .alert-custom-success {
            background-color: rgba(0, 255, 157, 0.1); 
            border-color: var(--success-color);
            color: #d4edda;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 576px) {
            .form-container {
                padding: 2rem 1.5rem;
            }
            .form-container h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    

    <section class="form-container">
        <h1>Recuperar Contraseña</h1>

        <?php if (session()->get('error')): ?>
            <div class="alert-custom alert-custom-danger">
                <?= session()->get('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->get('success')): ?>
            <div class="alert-custom alert-custom-success">
                <?= session()->get('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/forgotpassword1') ?>" method="post">
            <div class="form-group">
                <input class="form-control-custom" type="email" name="email" placeholder="Ingrese su correo electrónico" required>
            </div>
            <button class="action-button" type="submit">Enviar enlace de recuperación</button>
        </form>

        <div class="secondary-link-container">
            <a href="<?= base_url('/iniciovalogin') ?>">Volver a Iniciar Sesión</a>
        </div>
    </section>

</body>
</html>