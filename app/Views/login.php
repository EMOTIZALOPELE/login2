
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

