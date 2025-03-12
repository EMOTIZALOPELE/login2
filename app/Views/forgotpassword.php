<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Recuperar Contraseña</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.bodyforgot{
    background-image: url('fondo.jpg');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
}
.form-forgot {
    width: 450px;
    background-color: #24303c;
    padding: 30px ;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 10px;
    font-family: 'calibri';
    font-size: 18px;
    color: white;
    box-shadow: 7px 13px 37px #0a0dca;
}
.form-forgot h1 {
    margin-top: 0px;
    text-align: center;
    height: 45px;
    margin-bottom: 20px;
    border-bottom: 1px solid;
    font-size: 30px;
}
.controlsforgot {
    width: 100%;
    background-color: #24303c;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 16px;
    border: 1px solid #1f53c5;
    font-family: 'calibri';
    font-size: 18px;
    color: white;
}
.form-forgot a {
    color: white;
    text-decoration: none;
}
.form-forgot a:hover {
    color: rgb(255, 255, 255);
    text-decoration: underline;
}
.form-forgot .botonsforgot {
    width: 100%;
    background: #1f53c5;
    border: none;
    padding: 12px;
    color: white;
    margin: 16px 0;
    font-size: 16px;
}
    </style>
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
