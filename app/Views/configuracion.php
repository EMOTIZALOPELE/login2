<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Ventanas, Cortinas y Postigones</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
        }

        /* Contenedor principal */
        .container {
            margin: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }

        /* Estilos del menú superior */
        .menu {
            width: 100%;
            background-color: #333;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between; /* Separar Perfil y Cerrar Sesión */
            align-items: center;
        }

        .menu ul li {
            margin: 0 10px; /* Espaciado entre elementos */
        }

        .menu ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
        }

        .menu ul li a:hover {
            background-color: #575757;
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

    <!-- Menú superior -->
    <nav class="menu">
        <ul>
            <li><a href="irainicio">Perfil</a></li>
            <li><a href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <!-- Contenedor principal -->
    <div class="container">
        <h2>Configuración de Horarios</h2>

        <form action="<?= base_url('guardar_horarios') ?>" method="post">
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
        const esp32_ip = 'http://192.168.2.145'; // Reemplaza con la IP de tu ESP32

        function controlServo(accion) {
            fetch(`${esp32_ip}/${accion}`)
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => alert("Se produjo un error al comunicarse con el ESP32."));
        }
    </script>

</body>
</html>
