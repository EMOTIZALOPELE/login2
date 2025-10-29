<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Email - VECOPO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #0a192f;
            color: white;
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .verification-container {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            background: rgba(16, 32, 61, 0.85);
            border-radius: 15px;
            border: 1px solid rgba(100, 255, 218, 0.1);
        }
        .btn-verify {
            background: linear-gradient(45deg, #00f2fe, #4facfe);
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            color: #0a192f;
            font-weight: bold;
        }
        .alert-custom-success {
            background-color: rgba(0, 255, 157, 0.1);
            border: 1px solid #00ff9d;
            color: white;
        }
        .alert-custom-error {
            background-color: rgba(255, 77, 77, 0.1);
            border: 1px solid #ff4d4d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <h1 class="text-center mb-4">Verificación de Cuenta</h1>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-custom-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-custom-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($email)): ?>
            <p class="text-center">Ingresa el código de 6 dígitos que enviamos a: <strong><?= esc($email) ?></strong></p>
        <?php endif; ?>
        
        <form method="POST" action="<?= site_url('verify-code') ?>">
            <?= csrf_field() ?><input type="hidden" name="email" value="<?= esc($email) ?>">
            <input type="hidden" name="email" value="<?= esc($email) ?>">
            
            <div class="form-group">
                <label for="code">Código de Verificación:</label>
                <input type="text" name="code" id="code" class="form-control" maxlength="6" required 
                       placeholder="000000" style="text-align: center; font-size: 1.2rem; letter-spacing: 5px;">
                <small class="form-text text-muted">Ingresa el código de 6 dígitos que recibiste por email</small>
            </div>
            
            <button type="submit" class="btn btn-verify btn-block">Verificar Cuenta</button>
        </form>
        
        <div class="text-center mt-3">
            <small>¿No recibiste el código? 
                <a href="<?= site_url('resend-code') ?>" style="color: #64ffda;">Reenviar código</a>
            </small>
        </div>

        <div class="text-center mt-2">
            <small><a href="<?= site_url('/iniciovalogin') ?>" style="color: #8892b0;">Volver al login</a></small>
        </div>
    </div>
</body>
</html>