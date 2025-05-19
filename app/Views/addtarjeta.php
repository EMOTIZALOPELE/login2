<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>Configuración de Ventanas, Cortinas y Postigones</title>
    
    <!-- Agregar Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Mantener los estilos generales igual que en inicio.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header{
            width: 100%;
            height: 70px;
            position: fixed;
            z-index: 1;
        }

        body {
            background: url(<?= base_url("img/fondo4.jpg") ?>) no-repeat center center fixed;
            background-size: cover;        
            font-family: Arial, sans-serif;        
            height: 100vh;
        }

        /* Menú lateral - igual que en inicio.php */
        .container__menu{
            max-width: 1800px;
            height: 100%;
            width: 100%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            background:rgba(34, 31, 31, 0.51);
        }       

        /* Resto de estilos del menú igual que en inicio.php */
        .menu{
            display: flex;
            align-items: center;
        }

        .menu ul{
            display: flex;
            justify-content: space-around;
            gap: 1px;
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
            padding: 15px 20px;
            border-radius: 10px;
            display: inline-block;
        }

        .menu ul li a:hover {
            transform: translateY(-5px) scale(1.05);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
            border-radius: 15px;
        }

        #selected{
            background: #F6615D;
            padding: 10px 40px;
            border-radius: 50px;
        }

        /* Estilos específicos para el formulario */
        .container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-container {
            margin-top: 100px;
            background: rgb(231, 230, 235);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            transition: all 0.5s ease-in-out;
        }

        .form-container:hover {
            transform: scale(1.02);
        }

        h2 {
            background: #1f53c5;
            color: white;
            font-size: 18px;
            padding: 12px;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 15px -20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            font-size: 14px;
            margin-bottom: 3px;
        }

        input[type="time"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            width: 100%;
            margin-top: 15px;
            padding: 8px;
            font-size: 14px;
        }

        button[type="submit"]:hover {
            background: #163a94;
            transform: scale(1.05);
        }

        /* Estilos responsivos */
        @media screen and (max-width: 550px) {
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

            .container {
                padding: 10px;
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
                        <li><a href="<?= base_url('irainicio') ?>">Inicio</a></li>
                        <li><a id="selected">Añadir Tarjeta</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                        <li><a href="<?= base_url('logout') ?>">salir</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Crea un nuevo Horario</h2>
            <form action="<?= base_url('savetarjeta') ?>" method="post">
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

                <button type="submit">Crear Horario</button>
            </form>
        </div>
    </div>
</body>
</html>
