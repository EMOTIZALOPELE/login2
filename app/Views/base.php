<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'VECOPO' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap y fuentes globales -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0a192f; color: #fff; font-family: 'Roboto', sans-serif; }
        .alert { margin: 16px auto; max-width: 480px; }
        .main-content, .login-container, .register-container, .form-container { background: rgba(16,32,61,0.85); padding: 2rem; border-radius: 18px; box-shadow: 0 8px 32px 0 rgba(0,0,0,0.37); margin: 32px auto; max-width: 480px; }
        .form-label { color: #8892b0; }
        .logo-header { font-family: 'Orbitron', sans-serif; font-size: 2.5rem; font-weight: 700; color: #00f2fe; text-align: center; margin-bottom: 2rem; }
        .btn { border-radius: 8px; }
    </style>
</head>
<body>
    <div class="logo-header">VECOPO</div>
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif; ?>
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</body>
</html>