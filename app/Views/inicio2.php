<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: white;
            
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #222;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            flex: 1;
            color: white;
        }

        .login-btn, .register-btn {
            text-decoration: none;
            color: white;
            border: 2px solid #1f53c5;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .login-btn:hover, .register-btn:hover {
            background-color: #1f53c5;
            color: white;
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            text-align: center;
            background-image: url('fondo.jpg');
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .hero-btn {
            text-decoration: none;
            background-color: #1f53c5;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .hero-btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <header>
        <a href="<?= base_url('/iniciovalogin') ?>" class="login-btn">Iniciar sesión</a>
        <h1 class="logo">VECOPO</h1>
        <a href="<?= base_url('/tercon') ?>" class="register-btn">Registrarse</a>
    </header>
    <section class="hero">
        <div class="hero-content">
            <h2>Automatización Inteligente para tu Hogar</h2>
            <p>La mejor solución en automatización de ventanas, cortinas y postigones.</p>

      
               
            </div>
        </div>
    </section>
</body>
</html>