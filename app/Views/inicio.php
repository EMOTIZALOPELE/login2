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

        body {
            background: url(<?= base_url("img/fondo.jpg") ?>) no-repeat center center fixed;
            background-size: cover;        
            font-family: Arial, sans-serif;        
            height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: row; /* Por defecto en PCs */
            width: 100%;
            height: 100%;
        }

        /* Menú lateral */
        .botonesmenulateral {
            width: 250px; /* Ancho fijo para pantallas grandes */
            background-color: #333;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

        .botonesmenulateral ul {
            list-style-type: none;
        }

        .botonesmenulateral ul li {
            margin: 20px 0;
        }

        .botonesmenulateral ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
            transition: all 0.3s ease-in-out;
        }

        .botonesmenulateral ul li a:hover {
            background-color: #1f53c5;
            transform: scale(1.05);
            border radius: 5px;
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
        .menu-toggle {
               
            position: fixed; /* Fijar el botón en la pantalla */
            top: -10px; /* Espacio desde arriba */
            left: 0px; /* Espacio desde la izquierda */
            z-index: 1001; /* Asegura que esté por encima del menú */
            background: rgb(73, 76, 83);
            color: white;
            border: none;
            font-size: 30px;
            padding: 10px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 5px;
      
        }
        .menu {
            width: 20px;
            background-color:rgb(87, 84, 84);
            padding: 20px 0;
            height: 10%;
        }
        .botonesmenulateral {
            width: 200px;
            background-color:rgb(78, 73, 76);
            height: 100%;
            position: fixed;
            left: -250px;
            top: 0;
            transition: left 0.5s ease-in-out;
        }
        .botonesmenulateral.show {
            left: 0;
        }
        @media (max-width: 768px) {
            .menu {
                transform: translateX(-100%); /* Oculta el menú fuera de pantalla */
                position: absolute;
                top: 0;
                left: 0;
                width: 250px;
                height: 100%;
            }
            .menu.show {
                transform: translateX(0); /* Muestra el menú */
            }
    }

        /* Media Queries para pantallas medianas (tablets) */
        @media (max-width: 1024px) {
            .menu {
                width: 200px;
            }

            .content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
            /* Todo esto es el style de las cards*/
            .horarios-container {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
            .horario-card {
                background:rgb(231, 230, 235);
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                width: 300px;
                transform: translateX(-254px); 
                margin-top: -300px; 
                text-align: center;
                transition: transform 0.3s ease-in-out;
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
        }

        /* Media Queries para pantallas pequeñas (móviles) */
        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Cambia a apilado */
            }

            .menu {
                width: 100%;
                height: auto;
                position: relative; /* No fijo */
                padding: 10px 0;
            }

            .menu ul {
                display: flex;
                flex-direction: row; /* Menú horizontal */
                justify-content: space-around;
            }

            .menu ul li {
                margin: 0; /* Sin márgenes verticales */
            }

            .menu ul li a {
                font-size: 16px;
                padding: 10px;
            }

            .content {
                margin-left: 0;
                width: 100%;
                margin-top: 10px; /* Separación del menú */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Menú lateral (o superior en móviles) -->
            <button class="menu-toggle">☰</button>
                <nav class="botonesmenulateral">
                    <ul>
                        <li><a href="configuracion">Configuración</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseña tu sistema</a></li>
                        <li><a href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
                    </ul>
                </nav>
       
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
    </div>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.botonesmenulateral').classList.toggle('show');
        });
    </script>
</body>
</html>
