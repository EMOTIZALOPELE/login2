<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Restablecer Contraseña</title>
</head>
<body class="bodyreset">
    <section class="form-reset">
    <h1>Restablecer Contraseña</h1>

    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= session()->get('error') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('/reset-password') ?>" method="post">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input class="controlsreset" type="password" name="password" placeholder="Nueva contraseña" required>
        <button class="botonsreset" type="submit">Restablecer Contraseña</button>
    
    </form>
    </section>
</body>
</html>
