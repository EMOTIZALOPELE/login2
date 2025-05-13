<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Registro</title>
    <style>
        .form-register {
    width: 450px;
    background-color: #24303c;
    padding: 10px 15px 10px 15px ;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 10px;
    font-family: 'calibri';
    color: white;
    box-shadow: 7px 13px 37px #0a0dca;

}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.body1 {
    background-image: url('<?= base_url('img/fondo.jpg') ?>');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
}
.form-register h1 {
    margin-top: 0px;
    text-align: center;
    height: 45px;
    margin-bottom: 20px;
    border-bottom: 1px solid;
    font-size: 30px;
    top: 30%;
    left: 30%;
    transform: translate(0%, -20%);
}
.controls {
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
.form-register p {
    height: 40px;
    text-align: center;
    font-size: 18px;
    line-height: 40px;
}
.form-register a {
    color: white;
    text-decoration: none;
}
.form-register a:hover {
    color: rgb(255, 255, 255);
    text-decoration: underline;
}
.form-register .botons {
    width: 100%;
    background: #1f53c5;
    border: none;
    padding: 12px;
    color: white;
    margin: 16px 0;
    font-size: 16px;
}
.password-container img{
    margin-right: -500px;
    padding-left: 15px;
    width: 40px;
    cursor: pointer;
    transform: translate(840%, -215%);
}
    </style>
</head>
<body class="body1">
    <section class="form-register">
    <h1>Formulario Registro</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
   
    <form action="<?= base_url('register/store') ?>" method="post">
       
        <input class="controls" type="text" name="nombre" id="nombre" placeholder="Ingrese su Nombre" value="<?= old('nombre') ?>">

        <input class="controls" type="text" name="apellido" id="apellido" placeholder="Ingrese su Apellido" value="<?= old('apellido') ?>">

        <input class="controls" type="email" name="email" id="correo" placeholder="Ingrese su Correo" value="<?= old('email') ?>">
        <div class="password-container">
        <input class="controls" type="password" name="password" id="password" required="" placeholder="Ingrese su Contraseña">
        <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon"></div>

        <p>Estoy de acuerdo con <a href="#">Terminos y Condiciones</a></p>

        <input class="botons" type="submit" value="Registrar">
    </form>
    <p><a href="<?= base_url('/iniciovalogin') ?>">¿Ya tengo Cuenta?</a></p>
    </section>
    <script>let eyeicon = document.getElementById("eyeicon"); 
    let password= document.getElementById("password"); 
     eyeicon.onclick = function(){
        if(password.type == "password"){
            password.type = "text";
            eyeicon.src= "https://icons.veryicon.com/png/o/miscellaneous/myfont/eye-open-4.png";
        }
        else{
            password.type = "password";
            eyeicon.src= "https://static.thenounproject.com/png/1035969-200.png";
        }
     }
     </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
