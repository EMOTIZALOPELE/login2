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
        .menu {
            width: 250px; /* Ancho fijo para pantallas grandes */
            background-color: #333;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

        .menu ul {
            list-style-type: none;
        }

        .menu ul li {
            margin: 20px 0;
        }

        .menu ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
            transition: all 0.3s ease-in-out;
        }

        .menu ul li a:hover {
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

        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0,2);
            background: white;
        }

        table th,  table td {
            padding: 8px;
            text-align: center;
            border: 1px solid black;
            font-size: 14px;
        }

        table th {
            background-color: #1f53c5;
            color: white;
            padding: 12px;
            font-weight: bold;
        }

        .no-data {
            font-size: 16px;
            color: #7f8c8d;
            text-align: center;
            margin-top: 20px;
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

            .table-container {
                padding: 15px;
            }

            table th, table td {
                font-size: 12px;
            }
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

            .table-container {
                padding: 10px;
            }

            table th, table td {
                font-size: 12px; /* Tamaño reducido */
            }

            h2 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Menú lateral (o superior en móviles) -->
        <nav class="menu">
            <ul>
                <li><a href="configuracion">Configuración</a></li>
                <li><a href="<?= base_url('pele') ?>">Diseña tu sistema</a></li>
                <li><a href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>

            </ul>
        </nav>

        <!-- Contenido principal -->
        <div class="content">
            <div class="table-container">
                <?php if (!empty($horarios)): ?>
                    <h2>Horarios de Usuario: <?= session()->get('nombre'); ?></h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Ventana Apertura</th>
                                <th>Ventana Cierre</th>
                                <th>Cortina Apertura</th>
                                <th>Cortina Cierre</th>
                                <th>Postigón Apertura</th>
                                <th>Postigón Cierre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($horarios as $horario): ?>
                                <tr>
                                    <td><?= esc($horario['ventana_apertura']); ?></td>
                                    <td><?= esc($horario['ventana_cierre']); ?></td>
                                    <td><?= esc($horario['cortina_apertura']); ?></td>
                                    <td><?= esc($horario['cortina_cierre']); ?></td>
                                    <td><?= esc($horario['postigon_apertura']); ?></td>
                                    <td><?= esc($horario['postigon_cierre']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No se encontraron horarios para este usuario.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
