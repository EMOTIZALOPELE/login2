
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Formulario Login</title>
  <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.bodyprototipo {
    background-image: url('<?= base_url('img/fondo.jpg') ?>');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    font-family: arial;
}
.form-login {
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
.password-container img{
    margin-right: -500px;
    padding-left: 15px;
    width: 40px;
    cursor: pointer;
    transform: translate(840%, -215%);
}
.form-login h1 {
    margin-top: 0px;
    text-align: center;
    height: 45px;
    margin-bottom: 20px;
    border-bottom: 1px solid;
    font-size: 30px;
}
.controls {
    width: 100%;
    border: 1px solid #017bab;
    margin-bottom: 15px;
    padding: 11px 10px;
    background: #252322;
    font-size: 14px;
    font-weight: bold;
}
.buttons {
    width: 100%;
    height: 40px;
    background: #1f53c5;
    border: none;
    color: white;
    margin-bottom: 16px;
}

.form-login p {
    height: 40px;
    text-align: center;
    border-bottom: 1px solid;
}
.ccn {
   
    text-align: center;
    border-bottom: 1px solid;

}
.form-login a {
    color: white;
    text-decoration: none;
    font-size: 14px;
}
.form-login a:hover {
    text-decoration: underline;
}
</style>
</head>
<body class="bodyprototipo">
  
  <section class="form-login">
    <h1>Accede a tu cuenta</h1>
    <?php if (session()->get('error')): ?>
        <div>
            <p style="color: red;"><?= session()->get('error') ?></p>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/inicioo') ?>" method="post">
    <input class="controls" type="text" name="nombre" id="nombre" placeholder="Ingrese su Nombre" value=""> 
    <input class="controls" type="email" name="email" id="email" required="" placeholder="Ingrese su Email">
    <div class="password-container">
    <input class="controls" type="password" name="password" id="password" required="" placeholder="Ingrese su Contraseña">
    <img src="https://static.thenounproject.com/png/1035969-200.png" id="eyeicon"></div>
    <button class="buttons" type="submit" name="">Entrar</button>
    <div style="text-align: center;">
      <a class="ccn"href="<?= base_url('/forgotpassword') ?>">¿Olvidaste tu contraseña?</a></br>
      <a class="ccn" href="<?= base_url('/tercon') ?>">Crear cuenta nueva</a>
      </div>
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
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>

