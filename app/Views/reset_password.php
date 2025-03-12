<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Restablecer Contraseña</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.bodyreset{
    background-image: url('<?= base_url ('img/fondo.jpg') ?>');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
}
.form-reset {
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
.form-reset h1 {
    margin-top: 0px;
    text-align: center;
    height: 45px;
    margin-bottom: 20px;
    border-bottom: 1px solid;
    font-size: 30px;
}
.controlsreset{
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
.form-reset a {
    color: white;
    text-decoration: none;
}
.form-reset a:hover {
    color: rgb(255, 255, 255);
    text-decoration: underline;
}
.form-reset .botonsreset {
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
