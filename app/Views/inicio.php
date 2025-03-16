<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            height: 80px;
            margin-top: 10px;
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
        .container_botones {
            max-width: 1000px;
            height: 100%;
            margin: auto;
            display: flex;  
            justify-content: space-between;
        }
        .botonesmenulateral{
            display: flex;
            margin-left: 900px;
            align-items:center; 
        }
        .botonesmenulateral ul {
           display: flex;
           justify-content: space-around; /* Espaciado igual entre los botones */            gap: 20px; /* Espacio entre botones */
           gap: 20px; /* Espaciado fijo entre botones */
        }
            
        .botonesmenulateral ul li {
            list-style: none;
        }

        .botonesmenulateral ul li a{
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
            .botonesmenulateral ul li a:hover {
                transform: translateY(-5px) scale(1.05); /* Levanta y agranda el botón */
                background: rgba(255, 255, 255, 0.2); /* Fondo semitransparente */
                box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
                border-radius: 15px; /* Aumenta el redondeo para mayor suavidad */
        }
        #selected {
            background: #123123;
            padding: 15px 30px;
            border-radius: 50px;
        }
        /* Contenido principal */
        .content {
            margin-left: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            width: calc(100% - 250px);
        }
        /* Todo esto es el style de las cards*/
        .horarios-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            }
        .horario-card {
            background:rgb(231, 230, 235);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            margin-left: -1700px;
            margin-top: -520px; 
            text-align: center;
            display: block;
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
            /* Aca termina*/   

        /*TODO RESPONSIVE*/
        @media screen and (max-width:1000px){
            header{
                padding: 40px;
            }
        }
    </style>
</head>
<body>

    <header>

        <div class="container_botones">    
            <nav class="botonesmenulateral">
                <ul>
                    <li><a id="selected">Inicio</a></li>
                    <li><a href="<?= base_url('configuracion') ?>">Configuración</a></li>
                    <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                    <li><a href="<?= base_url('logout') ?>">salir</a></li>
                </ul>
            </nav>
        </div>
    </header>
        <!-- Contenido principal -->
        <div class="content">
                <div class="horarios-container">
                    <?php foreach ($horarios as $horario): ?>
                        <div class="horario-card">
                            <h3>Horario de <?= session()->get('nombre'); ?></h3>
                            <p><strong>Ventana Apertura:</strong> <?= esc($horario['ventana_apertura']); ?></p>
                            <p><strong>Ventana Cierre:</strong> <?= esc($horario['ventana_cierre']); ?></p>
                            <p><strong>Cortina Apertura:</strong> <?= esc($horario['cortina_apertura']); ?></p>
                            <p><strong>Cortina Cierre:</strong> <?= esc($horario['cortina_cierre']); ?></p>
                            <p><strong>Postigón Apertura:</strong> <?= esc($horario['postigon_apertura']); ?></p>
                            <p><strong>Postigón Cierre:</strong> <?= esc($horario['postigon_cierre']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
        </div>
    


    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.botonesmenulateral').classList.toggle('show');
        });
    </script>
</body>
</html>
