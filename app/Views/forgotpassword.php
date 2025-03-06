<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Recuperar Contraseña</title>
</head>
<body class="bodyforgot">
    <section class="form-forgot">
    <h1>Recuperar Contraseña</h1>

    <?php if (session()->get('error')): ?>
        <p style="color: red;"><?= session()->get('error') ?></p>
    <?php endif; ?>

    <?php if (session()->get('success')): ?>
        <p style="color: green;"><?= session()->get('success') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('/forgotpassword1') ?>" method="post">
        <input class="controlsforgot" type="email" name="email" class="controlsforgot" placeholder="Ingrese su correo electrónico" required>
        <button class="botonsforgot" type="submit" >Enviar enlace de recuperación</button>
        <center><a class="ccn" href="<?= base_url('/iniciovalogin') ?>">Acceder</a></center>
    </form>
    </section>
</body>
</html>
