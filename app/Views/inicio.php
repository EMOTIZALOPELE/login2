<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>Inicio</title>
    <style>
        /* Reset de estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header{
            width: 100%;
            height: 70px;
            margin-top: 15px;
            position: fixed;
            z-index: 1;
        }

        body {
            background: url(<?= base_url("img/fondo4.jpg") ?>) no-repeat center center fixed;
            background-size: cover;        
            font-family: Arial, sans-serif;        
            height: 100vh;
        }
        /* Menú lateral */
        .container__menu{
            max-width: 1800px;
            height: 100%;
            width: 100%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            background:rgba(34, 31, 31, 0.51);
            
        }       
        .menu{
            display: flex;
            align-items: center;
        }
        .menu ul{
            display: flex;
           justify-content: space-around; /* Espaciado igual entre los botones */           
           gap: 1px; /* Espaciado fijo entre botones */
        }
            
        .menu ul li{
            list-style: none;
            margin-left: 20px;
        }

        .menu ul li a{
          text-decoration: none;
          font-size: 16px;
          color:rgb(255, 255, 255);
          text-transform: uppercase;
          text-align: center;
          cursor: pointer;
          transition: all 0.5s ease-in-out;
          padding: 15px 20px; /* Espaciado interno */
          border-radius: 10px; /* Bordes redondeados */
          display: inline-block; /* Para evitar problemas de tamaño */
      }
        .menu ul li a:hover {
                transform: translateY(-5px) scale(1.05); /* Levanta y agranda el botón */
                background: rgba(255, 255, 255, 0.2); /* Fondo semitransparente */
                box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
                border-radius: 15px; /* Aumenta el redondeo para mayor suavidad */
        }
      
        #selected{
            background: #F6615D;
            padding: 10px 40px;
            border-radius: 50px;
        }
        
        
        .menu nav img{
            display: none;
        }

        .menu #btn_menu{
            display: none;
        }
                 
        /* Contenido principal */
        .container__card {
            display: flex;
            flex-wrap: wrap; /* Permite que las tarjetas se acomoden solas */
            gap: 5px; /* Espaciado entre tarjetas */
            padding: 20px;
            justify-content: space-around; /* Alinea las tarjetas a la izquierda */
        }
        /* Todo esto es el style de las cards*/
        .horarios-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
            height: 100vh;
            }
        .horario-card {
            background:rgb(231, 230, 235);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: calc(33.33% - 10px);
            max-width: 300px; /* No crece más de 300px */
            text-align: center;
            transition: all 0.5s ease-in-out;
            }
            .horario-card:hover {
            transform: scale(1.05);
            border radius: 5px;
        }
        .horario-card h3 {
            background: #1f53c5;
            color: white;
            font-size: 20px;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            margin: -25px -25px 15px -25px;
            }
        .horario-card p {
            font-size: 16px;
            color:rgb(8, 16, 34);
            margin: 10px 0;
            text-align: left;
            padding: 5px;
            border-bottom: 1px solid #ddd;

            }
        .config-button {
            display: block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #1f53c5;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            }

        .config-button:hover {
            background: #163a94;
            transform: scale(1.05);
            }

        .delete-button {
            width: 100%;
            display: block;
            margin-top: 20px;
            padding: 10px;
            background:rgb(197, 31, 31);
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            }

            .delete-button:hover {
                background-color:rgb(197, 31, 31);
                transform: scale(1.05);
            }

        .button-container {
            display: flex;
            gap: 10px;
        }

        .add-name-button,
        .save-name-button {
            display: block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #1f53c5;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .add-name-button:hover,
        .save-name-button:hover {
            background-color: #0056b3;
        }

        .name-form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        
            /* Aca termina*/   

        /*Haciendo la página Responsive*/

        @media screen and (max-width:1200px){

            header{
                padding: 40px;
            }

        }
        

        @media screen and (max-width: 550px){
        
            .menu nav{
                position: fixed;
                top: 0;
                right: -250px;
                background:rgba(10, 10, 12, 0.76);
                width: 250px;
                height: 100vh;
                padding: 40px;
                z-index: 1;
                transition: all 300ms;
            }

            .menu ul{
                flex-direction: column;
                margin-top: 40px;
            }

            .menu ul li{
                margin-top: 30px;
                margin-left: 0;
            }

            .menu ul li a{
                color: #bebebe;
            }

            #selected{
                background: none;
                padding: 1px;
                border-radius: none;
                color: #F6615D;
            }

            .menu nav img{
                display: block;
                width: 60px;
            }

            #back_menu{
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                display: none;
            }

            .menu #btn_menu{
                display: flex;
                align-items: center;
                justify-content: center;
                width: 50px;
                height: 50px;
                background: rgba(255, 255, 255, 0.1);
                font-size: 24px;
                border-radius: 50px;
                cursor: pointer;
                transition: all 300ms;
            }


            .menu #btn_menu:hover{
                background: rgba(255, 255, 255, 0.2);
            }
        }
        @media screen and (max-width: 550px) {
            .horarios-container {
                flex-direction: column; /* Acomoda las tarjetas en columna */
                align-items: center; /* Centra las tarjetas */
            }
         
            .horario-card {
                width: 80%; /* Ocuparán el 80% del ancho en celulares */
                max-width: 300px; /* Se limita a 400px máximo */
            }
        }

    </style>
</head>
<body>

    <header>


    <div class="container__menu">
        <div class="logo">
            <img src="images/logo-magtimus-v2.3-1.png" alt="">
        </div>
        <div class="menu">
            <i class="fas fa-bars" id="btn_menu"></i>
            <div id="back_menu"></div>
            <nav id="nav">
                <img src="images/logo-magtimus-v2.3-1.png" alt="">
                <ul>
                    <li><a id="selected">Inicio</a></li>
                    <li><a href="<?= base_url('addtarjeta') ?>">Añadir Tarjeta</a></li>
                    <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                    <li><a href="<?= base_url('logout') ?>">salir</a></li>
                </ul>
            </nav>
        </div>
    </div>
  
    </header>
        <!-- Contenido principal -->
        <div class="containter__card">
                <div class="horarios-container">
                    <?php foreach ($horarios as $horario): ?>
                        <div class="horario-card">
                        <h3><?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta']) 
                            ? esc($horario['nombre_tarjeta']) 
                            : 'Horario de ' . session()->get('nombre'); ?></h3>

                            <p><strong>Ventana Apertura:</strong> <?= esc($horario['ventana_apertura']); ?></p>
                            <p><strong>Ventana Cierre:</strong> <?= esc($horario['ventana_cierre']); ?></p>
                            <p><strong>Cortina Apertura:</strong> <?= esc($horario['cortina_apertura']); ?></p>
                            <p><strong>Cortina Cierre:</strong> <?= esc($horario['cortina_cierre']); ?></p>
                            <p><strong>Postigón Apertura:</strong> <?= esc($horario['postigon_apertura']); ?></p>
                            <p><strong>Postigón Cierre:</strong> <?= esc($horario['postigon_cierre']); ?></p>

                            <div class="button-container">
                                <form action="<?= site_url('configurar/' . esc($horario['idhorario'])) ?>" method="POST">
                                    <button type="submit" class="config-button">Configurar</button>
                                </form>

                                    <button class="add-name-button" onclick="toggleNameForm('form-<?= $horario['idhorario'] ?>')">Añadir Nombre</button>

                                <form action="<?= site_url('add_name/' . esc($horario['idhorario'])) ?>" method="POST" class="name-form" id="form-<?= $horario['idhorario'] ?>" style="display: none;">
                                    <input type="text" name="nombre_tarjeta" placeholder="Nuevo nombre" required>
                                    <button type="submit" class="save-name-button">Guardar</button>
                                </form>                   
                            </div> 
                            
                            <!-- Botón de eliminar tarjeta -->
                                <form action="<?= site_url('borrar_tarjeta/' . esc($horario['idhorario'])) ?>" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarjeta?');">
                                    <button type="submit" class="delete-button">Eliminar</button>
                                </form>
                         
                    </div>
                    <?php endforeach; ?>
                </div>
        </div>
    


    <script>
        document.getElementById("btn_menu").addEventListener("click", mostrar_menu);

        document.getElementById("back_menu").addEventListener("click", ocultar_menu);

        nav = document.getElementById("nav");
        background_menu = document.getElementById("back_menu");

        function mostrar_menu(){

            nav.style.right = "0px";
            background_menu.style.display = "block";
        }

        function ocultar_menu(){

            nav.style.right = "-250px";
            background_menu.style.display = "none";
        }
    </script>
    <script>
    function toggleNameForm(formId) {
        const form = document.getElementById(formId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>
</body>
</html>
