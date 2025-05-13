<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Ventanas, Cortinas y Postigones</title>
    <style>
        /* Estilos generales */
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

        /* Ajustes para botones del servo */
        .servo-controls {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .buttonservo {
            background-color: #3498db;
            color: white;
            padding: 15px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .buttonservo:hover {
            background-color: #2980b9;
        }

        /* Estilos responsivos */
        @media (min-width: 768px) {
            .container {
                margin: 20px auto;
                max-width: 600px;
            }

            .menu ul {
                justify-content: space-between;
            }

            .menu ul li {
                margin-left: 20px;
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
                        <li><a href="irainicio">Perfil</a></li>
                        <li><a id="selected">Añadir Tarjeta</a></li>
                        <li><a href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    <!-- Contenedor principal -->
    <div class="container">
        <h2>Configuración de Horarios</h2>

        <form action="<?= base_url('guardar_horarios') ?>" method="post">
            <input type="hidden" name="idhorario" value="<?= isset($horario['idhorario']) ? esc($horario['idhorario']) : '' ?>">
            <div class="form-group">
                <label for="ventana_apertura">Apertura de Ventanas:</label>
                <input type="time" id="ventana_apertura" name="ventana_apertura" value="<?= isset($horario['ventana_apertura']) ? esc($horario['ventana_apertura']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="ventana_cierre">Cierre de Ventanas:</label>
                <input type="time" id="ventana_cierre" name="ventana_cierre" value="<?= isset($horario['ventana_cierre']) ? esc($horario['ventana_cierre']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="cortina_apertura">Apertura de Cortinas:</label>
                <input type="time" id="cortina_apertura" name="cortina_apertura" value="<?= isset($horario['cortina_apertura']) ? esc($horario['cortina_apertura']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="cortina_cierre">Cierre de Cortinas:</label>
                <input type="time" id="cortina_cierre" name="cortina_cierre" value="<?= isset($horario['cortina_cierre']) ? esc($horario['cortina_cierre']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="postigon_apertura">Apertura de Postigones:</label>
                <input type="time" id="postigon_apertura" name="postigon_apertura" value="<?= isset($horario['postigon_apertura']) ? esc($horario['postigon_apertura']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="postigon_cierre">Cierre de Postigones:</label>
                <input type="time" id="postigon_cierre" name="postigon_cierre" value="<?= isset($horario['postigon_cierre']) ? esc($horario['postigon_cierre']) : '' ?>" required>
            </div>

            <button type="submit">Guardar Horarios</button>
        </form>

        <h2>Control del Servo</h2>
        <div class="servo-controls">
            <button class="buttonservo" onclick="controlServo('servoOpen')">Abrir Servo</button>
            <button class="buttonservo" onclick="controlServo('servoClose')">Cerrar Servo</button>
        </div>

    </div>

    <script>
        const esp32_ip = 'http://192.168.2.50'; // Reemplaza con la IP de tu ESP32

        function controlServo(accion) {
            fetch(`${esp32_ip}/${accion}`)
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => alert("Se produjo un error al comunicarse con el ESP32."));
        }
    </script>

</body>
</html>
