<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>VECOPO - Control Inteligente</title>
    
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #00f2fe; --secondary-color: #4facfe; --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.8); --text-primary: #ffffff; --text-secondary: #8892b0;
            --accent-color: #64ffda; --danger-color: #ff4d4d; --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2); --menu-icon-color: #00e0ff; 
            --menu-bg-color: rgba(10, 25, 47, 0.97); --menu-border-color: rgba(0, 224, 255, 0.08); 
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background: var(--dark-bg); color: var(--text-primary); min-height: 100vh; overflow-x: hidden; }
        header { background: rgba(10, 25, 47, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgb(255, 251, 0); width: 100%; z-index: 1000; position: sticky; top: 0; }
        .container__menu { max-width: 1800px; margin: auto; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; position: relative; }
        .logo { font-family: 'Orbitron', sans-serif; font-size: 1.8rem; font-weight: 700; background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 20px rgba(0, 242, 254, 0.3); flex-shrink: 0; }
        .header-controls { display: flex; align-items: center; gap: 1rem; margin-left: auto; }
        .desktop-menu ul { margin: 0; display: flex; gap: 1rem; list-style: none; padding-left: 0; align-items: center; }
        .desktop-menu ul li a { color: var(--text-primary); text-decoration: none; font-size: 1rem; padding: 10px 16px; border-radius: 50px; transition: all 0.3s ease; border: 1px solid var(--input-border); white-space: nowrap; }
        .desktop-menu ul li a:hover { background: rgba(100, 255, 218, 0.1); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(100, 255, 218, 0.15); }
        .desktop-menu #selected { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); border-color: transparent; color: var(--dark-bg); font-weight: 600; }
        .menu-toggle { display: none; }
        .mobile-menu-panel { display: none; }
        .container__card { padding: 2rem 1.5rem; max-width: 1800px; margin: 0 auto; }
        .horarios-container { display: flex; overflow-x: auto; padding: 1.5rem 0.5rem; gap: 2rem; min-height: 510px; align-items: flex-start; }
        .horario-card { background: var(--card-bg); border-radius: 20px; padding: 1.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease; border: 1px solid var(--input-border); backdrop-filter: blur(10px); flex-basis: 330px; flex-shrink: 0; height: 480px; display: flex; flex-direction: column; animation: fadeIn 0.5s ease-out forwards; }
        .horario-card:hover { transform: translateY(-10px); box-shadow: 0 10px 30px rgba(100, 255, 218, 0.2); }
        .horario-card h3 { font-family: 'Orbitron', sans-serif; font-size: 1.4rem; color: var(--primary-color); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--input-border); flex-shrink: 0; }
        .card-scrollable-content { flex-grow: 1; overflow-y: auto; padding-right: 10px; }
        .horario-card p { color: var(--text-secondary); margin: 0.8rem 0; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .horario-card p strong { color: var(--text-primary); font-weight: 500; }
        .button-container { margin-top: auto; padding-top: 1rem; display: flex; gap: 0.8rem; }
        .card-scrollable-content form { margin-top: 0.8rem; }
        .config-button, .delete-button { padding: 0.7rem 1rem; font-size: 0.9rem; border-radius: 50px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; text-align: center; text-decoration: none !important; border: none; display: block; width: 100%; }
        .config-button { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: var(--dark-bg) !important; }
        .delete-button { background: var(--danger-color); color: white !important; }
        .config-button:hover, .delete-button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.25); }
        .delete-button:hover { box-shadow: 0 5px 15px rgba(255, 77, 77, 0.3); }
        form > button { width: 100%; }
        .button-container form { flex: 1; }
        .weather-toggle-button { background: transparent; border: 1px solid var(--input-border); color: var(--primary-color); border-radius: 50%; width: 44px; height: 44px; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .weather-toggle-button:hover { background: rgba(100, 255, 218, 0.1); box-shadow: 0 0 15px rgba(100, 255, 218, 0.3); transform: scale(1.05); }
        .weather-panel { position: absolute; top: calc(100% + 10px); right: 1.5rem; background: var(--card-bg); border: 1px solid var(--input-border); border-radius: 15px; padding: 1rem 1.5rem; width: 90%; max-width: 380px; z-index: 1001; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3); backdrop-filter: blur(10px); transition: transform 0.4s ease, opacity 0.4s ease; transform: translateY(10px) scale(0.95); opacity: 0; visibility: hidden; }
        .weather-panel.visible { transform: translateY(0) scale(1); opacity: 1; visibility: visible; }
        .weather-panel-content { text-align: center; }
        .modal-content { background: var(--card-bg); border: 1px solid var(--input-border); border-radius: 20px; color: var(--text-primary); }
        .modal-header, .modal-footer { border-color: var(--input-border); }
        .modal-title { font-family: 'Orbitron', sans-serif; color: var(--primary-color); }
        .form-control { background: rgba(255, 255, 255, 0.05); border-color: var(--input-border); color: var(--text-primary); }
        .form-control:focus { background: rgba(255, 255, 255, 0.1); border-color: var(--primary-color); color: var(--text-primary); box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25); }
        .btn-primary { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); border: none; font-weight: 500; }
        .btn-secondary { background: rgba(255, 255, 255, 0.1); border-color: var(--input-border); }
        .close { color: white; opacity: 0.8; }
        #codigoModal { background: rgba(10, 25, 47, 0.95); backdrop-filter: blur(10px); display: none; }
        #codigoModal > div { background: var(--card-bg); border: 1px solid var(--input-border); border-radius: 20px; padding: 2rem; width: 90%; max-width: 500px; }
        #codigoModal h3 { font-family: 'Orbitron', sans-serif; color: var(--primary-color); }
        #codigoModal input { background: rgba(255,255,255,0.05); border: 1px solid var(--input-border); color: var(--text-primary); border-radius: 10px; padding: 1rem; width: 100%; margin: 1rem 0; }
        #codigoModal .modal-footer { padding-top: 1rem; margin-top: 1rem; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 992px) {
            .desktop-menu { display: none; }
            .menu-toggle { display: flex; flex-direction: column; justify-content: space-around; width: 30px; height: 24px; background: transparent; border: none; cursor: pointer; padding: 0; z-index: 1011; }
            .menu-toggle div { width: 25px; height: 3px; background: var(--menu-icon-color); border-radius: 3px; transition: all 0.3s ease-in-out; transform-origin: center; }
            .menu-toggle.active div:nth-child(1) { transform: translateY(8px) rotate(45deg); }
            .menu-toggle.active div:nth-child(2) { opacity: 0; }
            .menu-toggle.active div:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }
            .mobile-menu-panel { display: flex; flex-direction: column; position: fixed; top: 0; right: 0; width: 280px; max-width: 80%; height: 100vh; background: var(--menu-bg-color); backdrop-filter: blur(15px); padding-top: 6rem; box-shadow: -5px 0px 25px rgba(0,0,0,0.5); z-index: 1010; transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1); }
            .mobile-menu-panel.active { transform: translateX(0); }
            .mobile-menu-panel ul { list-style: none; padding: 0; margin: 0; }
            .mobile-menu-panel ul li a { font-family: 'Poppins', sans-serif; padding: 1rem 1.5rem; font-size: 1.1rem; display: flex; align-items: center; gap: 1rem; color: var(--text-primary); text-decoration: none; transition: background-color 0.3s, color 0.3s; border-bottom: 1px solid var(--menu-border-color); }
            .mobile-menu-panel ul li a i { color: var(--menu-icon-color); }
            .mobile-menu-panel ul li a:hover { background: rgba(0, 224, 255, 0.1); }
            .mobile-menu-panel #selected-mobile { background: var(--menu-icon-color); color: var(--dark-bg) !important; }
            .mobile-menu-panel #selected-mobile i { color: var(--dark-bg) !important; }
            .horarios-container { justify-content: flex-start; }
            .horario-card { flex-basis: 300px; }
        }
        @media (max-width: 768px) {
            .container__menu, .container__card { padding-left: 1rem; padding-right: 1rem; }
            .logo { font-size: 1.6rem; }
            .horarios-container { flex-direction: column; align-items: center; overflow-x: hidden; overflow-y: auto; padding: 1rem 0; min-height: auto; max-height: calc(100vh - 80px); }
            .horario-card { flex-shrink: 1; width: 100%; max-width: 400px; height: auto; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container__menu">
            <div class="logo">VECOPO</div>
            <div class="header-controls">
                <button class="weather-toggle-button" id="weatherToggleButton" aria-label="Mostrar/ocultar panel del clima">
                    <i class="fas fa-cloud-sun"></i>
                </button>
                <div class="desktop-menu">
                    <nav>
                        <ul>
                            <li><a href="<?= base_url('/inicio') ?>" id="selected">Inicio</a></li>
                            <li><a href="#" onclick="abrirModal()">Añadir Tarjeta</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#servoModal"><i class="fas fa-gamepad"></i> Manual</a></li>
                            <li><a href="<?= base_url('dispositivos') ?>"><i class="fas fa-user-cog"></i> Dispositivos</a></li> 
<<<<<<< HEAD
                            <li><a href="<?= base_url('mis-compras') ?>"><i class="fas fa-shopping-bag"></i> Mis Compras</a></li>
=======
<<<<<<< HEAD
                            <li><a href="<?= base_url('mis-compras') ?>"><i class="fas fa-shopping-bag"></i> Mis Compras</a></li>
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                            <li><a href="<?= base_url('logout') ?>">Salir</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menú de navegación" aria-expanded="false">
                <div></div>
                <div></div>
                <div></div>
            </button>
            <div class="weather-panel" id="weatherPanel">
                <div class="weather-panel-content" id="weatherPanelContent">Cargando clima...</div>
            </div>
        </div>
        <nav class="mobile-menu-panel" id="navigationMenu">
            <ul>
                <li><a href="<?= base_url('/inicio') ?>" id="selected-mobile"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="#" onclick="abrirModalYCerrarMenu()"><i class="fas fa-plus-square"></i> Añadir Tarjeta</a></li>
                <li><a href="#" data-toggle="modal" data-target="#servoModal"><i class="fas fa-gamepad"></i> Manual</a></li>
                <li><a href="<?= base_url('dispositivos') ?>"><i class="fas fa-user-cog"></i> Dispositivos</a></li>
                <li><a href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
            </ul>
        </nav>
    </header>

    <main class="container__card">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95

        <?php // ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert" style="background-color: var(--success-color); color: var(--dark-bg); border: none; border-radius: 10px; margin-bottom: 1.5rem;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert" style="background-color: var(--danger-color); color: var(--text-primary); border: none; border-radius: 10px; margin-bottom: 1.5rem;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php // ?>


<<<<<<< HEAD
=======
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        <div class="horarios-container">
            <?php foreach ($horarios as $horario): ?>
                <div class="horario-card">
                    
                    <?php // ?>
                    <h3 data-idhorario="<?= esc($horario['idhorario']); ?>">
                        <span class="card-title">
                            <?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                                ? esc($horario['nombre_tarjeta'])
                                : 'Tu horario ' . session()->get('nombre'); ?>
                        </span>
                    </h3>
                    <div class="card-scrollable-content">
                        
                        <?php if (isset($horario['servos']) && !empty($horario['servos'])): ?>
                            <?php foreach ($horario['servos'] as $servo): ?>
                                <p><strong><?= esc(ucfirst($servo['nombre_servo'] ?? 'Servo')) ?> Apertura:</strong> <span><?= esc($servo['horario_apertura']); ?></span></p>
                                <p><strong><?= esc(ucfirst($servo['nombre_servo'] ?? 'Servo')) ?> Cierre:</strong> <span><?= esc($servo['horario_cierre']); ?></span></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay horarios de servo configurados para este dispositivo.</p>
                        <?php endif; ?>

                        <div class="button-container">
<<<<<<< HEAD
                            <button type="button" class="config-button" 
                                    data-dispositivo-id="<?= esc($horario['dispositivo_id'] ?? $horario['idhorario']) ?>">
                                Configurar
                            </button>
                            
                            <button type="button" class="config-button"
                                    data-toggle="modal" data-target="#changeNameModal"
                                    data-idhorario="<?= esc($horario['idhorario']); ?>"
=======
<<<<<<< HEAD
                            
                            <?php // ?>
                            <form action="<?= base_url('configuracion/' . esc($horario['dispositivo_id'])) ?>" method="GET">
=======
                            <form action="<?= base_url('configuracion/' . esc($horario['idhorario'])) ?>" method="GET">
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
                                <button type="submit" class="config-button">Configurar</button>
                            </form>
                            <button type="button" class="config-button"
                                    data-toggle="modal" data-target="#changeNameModal"
                                    
                                    <?php // ?>
                                    data-idhorario="<?= esc($horario['idhorario']); ?>"
                                    
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                                    data-current-name="<?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                                        ? esc($horario['nombre_tarjeta'])
                                        : 'Horario de ' . session()->get('nombre'); ?>">
                                Cambiar Nombre
                            </button>
                        </div>
<<<<<<< HEAD
                        
                        <?php // ?>
                        <form action="<?= site_url('borrar_tarjeta/' . esc($horario['idhorario'])) ?>" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarjeta?');">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

=======
<<<<<<< HEAD
                        
                        <?php // ?>
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
                        <form action="<?= site_url('borrar_tarjeta/' . esc($horario['idhorario'])) ?>" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarjeta?');">
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                            <button type="submit" class="delete-button">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    
    <div class="modal fade" id="changeNameModal" tabindex="-1" role="dialog" aria-labelledby="changeNameModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeNameModalLabel">Cambiar Nombre de Tarjeta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newCardName" class="form-control" placeholder="Nuevo nombre de la tarjeta">
                    <input type="hidden" id="cardIdToChange">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveNewNameBtn">Guardar Nombre</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="successModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="codigoModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(10, 25, 47, 0.95); justify-content:center; align-items:center; z-index: 1050;">
        <div>
            <h3>Añadir Nuevo Dispositivo</h3>
            <form id="reclamarForm"> 
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                <input type="text" id="macInput" name="mac_address" placeholder="Ingrese la Dirección MAC del Dispositivo" required>
                <div id="macError" style="color:var(--danger-color); display:none; margin-top:10px; font-size: 0.9rem;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Reclamar Dispositivo</button>
                </div>
            </form>
        </div>
    </div>
     <div class="modal fade" id="servoModal" tabindex="-1" role="dialog" aria-labelledby="servoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="selectServoForm">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="servoModalLabel">Control Manual</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: var(--primary-color);">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3" style="color: var(--text-secondary);">Escribe el nombre de la tarjeta que deseas controlar manualmente.</p>
                        <input type="text" id="tarjetaInput" name="nombre_tarjeta" class="form-control" placeholder="Nombre de la tarjeta" required>
                        <div id="servoError" style="color:var(--danger-color); display:none; margin-top:15px; font-size: 0.9rem;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="background: rgba(255,0,0,0.1); padding: 10px; margin: 10px; border-radius: 5px; display: none;">
        <h4>DEBUG Info:</h4>
        <?php foreach ($horarios as $index => $horario): ?>
            <p>Tarjeta <?= $index + 1 ?>: 
                ID Horario: <?= $horario['idhorario'] ?>, 
                Dispositivo ID: <?= $horario['dispositivo_id'] ?? 'No tiene' ?>
            </p>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Guardamos los nombres válidos de las tarjetas desde PHP en un array de JavaScript
        const validCardNames = [
            <?php foreach ($horarios as $horario): ?>
                "<?= esc($horario['nombre_tarjeta'], 'js') ?>",
            <?php endforeach; ?>
        ];
    </script>
<<<<<<< HEAD

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            }
        });

=======
    
    <script>
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerButton = document.getElementById('menu-toggle');
        const navigationMenu = document.getElementById('navigationMenu');
        if (hamburgerButton && navigationMenu) {
            hamburgerButton.addEventListener('click', (event) => {
                event.stopPropagation(); 
                navigationMenu.classList.toggle('active');
                hamburgerButton.classList.toggle('active');
            });
            document.addEventListener('click', (event) => {
                if (navigationMenu.classList.contains('active') && !navigationMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
                    navigationMenu.classList.remove('active');
                    hamburgerButton.classList.remove('active');
                }
            });
        }
        window.abrirModal = function() { document.getElementById('codigoModal').style.display = 'flex'; }
        window.cerrarModal = function() { document.getElementById('codigoModal').style.display = 'none'; }
        window.abrirModalYCerrarMenu = function() {
            if (navigationMenu && navigationMenu.classList.contains('active')) {
                navigationMenu.classList.remove('active');
                hamburgerButton.classList.remove('active');
            }
            abrirModal();
        }
        const APIKey = '0d132a7baaa02ea9cfc60077249f0254'; 
        const city = 'Rio Tercero,AR';
        const weatherPanel = document.getElementById('weatherPanel');
        const weatherPanelContent = document.getElementById('weatherPanelContent');
        const weatherToggleButton = document.getElementById('weatherToggleButton');
        function updateWeatherPanel() {
            fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${APIKey}&lang=es`)
            .then(response => response.json())
            .then(data => {
                if (data.cod === 200 && weatherPanelContent) {
                    const temp = Math.round(data.main.temp);
                    const description = data.weather[0].description;
                    const capitalizedDescription = description.charAt(0).toUpperCase() + description.slice(1);
                    const weatherText = `Hola, hoy en ${data.name} el día está ${capitalizedDescription} con ${temp}°C.`;
                    weatherPanelContent.textContent = weatherText;
                }
            }).catch(error => console.error('Error al obtener datos del clima:', error));
        }
        function toggleWeatherPanel(event) {
            event.stopPropagation();
            if (weatherPanel) weatherPanel.classList.toggle('visible');
        }
        if (weatherToggleButton) { weatherToggleButton.addEventListener('click', toggleWeatherPanel); }
        document.addEventListener('click', function(event) {
            if (weatherPanel && weatherPanel.classList.contains('visible') && !weatherPanel.contains(event.target) && !weatherToggleButton.contains(event.target)) {
                weatherPanel.classList.remove('visible');
            }
        });
        setTimeout(() => {
            if (weatherPanel) weatherPanel.classList.add('visible');
            setTimeout(() => { if (weatherPanel) weatherPanel.classList.remove('visible'); }, 5000);
        }, 500);
        updateWeatherPanel();
        setInterval(updateWeatherPanel, 1800000);
    });

    $(document).ready(function() {
        $('#changeNameModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const cardId = button.data('idhorario');
            const currentName = button.data('current-name');
            const modal = $(this);
            modal.find('.modal-body #newCardName').val(currentName);
            modal.find('.modal-body #cardIdToChange').val(cardId);
        });

        $('#saveNewNameBtn').on('click', function() {
            const cardId = $('#cardIdToChange').val();
            const newName = $('#newCardName').val();
            if (!newName.trim()) { alert('El nombre no puede estar vacío.'); return; }
            $.ajax({
                url: '<?= base_url('actualizar_nombre_tarjeta') ?>', method: 'POST',
                data: { idhorario: cardId, nombre_tarjeta: newName, '<?= csrf_token() ?>': '<?= csrf_hash() ?>' },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#changeNameModal').modal('hide');
                        $('#successModalBody').text(response.message || 'Nombre actualizado.');
                        $('#successModal').modal('show');
                        $(`.horario-card h3[data-idhorario="${cardId}"] .card-title`).text(newName);
                    } else { alert('Error: ' + (response.message || 'Desconocido')); }
                },
                error: function(xhr) { alert('Error de comunicación con el servidor.'); }
            });
        });
        
        $('#selectServoForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const button = form.find('button[type="submit"]');
            const errorDiv = $('#servoError');
            const enteredName = $('#tarjetaInput').val().trim();

            if (!validCardNames.includes(enteredName)) {
                errorDiv.text('El nombre de la tarjeta no existe o es incorrecto.').show();
                return;
            }
            
            button.prop('disabled', true).text('Verificando...');
            errorDiv.hide();
            
            $.ajax({
                url: '<?= base_url('/servos/seleccionar') ?>', method: 'POST',
                data: form.serialize(), dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = `<?= base_url('/masivo') ?>/${response.dispositivo_id}`;
                    } else {
                        errorDiv.text(response.messages.error || 'Error desconocido.').show();
                    }
                },
                error: function() { errorDiv.text('Error de conexión.').show(); },
                complete: function() { button.prop('disabled', false).text('Continuar'); }
            });
        });

        $('#reclamarForm').on('submit', function(e){
            
            e.preventDefault();
            const form = $(this);
            const button = form.find('button[type="submit"]');
            const errorDiv = $('#macError');
            button.prop('disabled', true).text('Verificando...');
            errorDiv.hide();
            $.ajax({
                
                url: '<?= base_url('/dispositivos/reclamar') ?>', method: 'POST',
                data: form.serialize(), dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message || 'Dispositivo añadido con éxito!');
                        window.location.reload();
                    } else {
                        errorDiv.text(response.messages.error || 'Ocurrió un error.').show();
                    }
                },
                error: function() { errorDiv.text('Error de conexión.').show(); },
                complete: function() { button.prop('disabled', false).text('Reclamar Dispositivo'); }
            });
        });

        console.log('=== DEBUG CONFIGURAR ===');
        console.log('Botones con data-dispositivo-id:', $('.config-button[data-dispositivo-id]').length);
        $('.config-button[data-dispositivo-id]').each(function(i) {
            console.log('Botón ' + i + ':', $(this).data('dispositivo-id'));
        });

        // ✅ NUEVO CÓDIGO - CON redirect_url
        $(document).on('click', '.config-button[data-dispositivo-id]', function() {
            const dispositivoId = $(this).data('dispositivo-id');
            const button = $(this);
            
            console.log('Dispositivo ID clickeado:', dispositivoId);
            
            button.prop('disabled', true).text('Verificando...');
            
            $.ajax({
                url: '<?= base_url('verificar-servos-configurados') ?>',
                method: 'POST',
                data: { 
                    dispositivo_id: dispositivoId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    
                    // 🔥 CAMBIO: Usar redirect_url si existe
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    } else if (response.configurado) {
                        window.location.href = '<?= base_url('configuracion') ?>/' + dispositivoId;
                    } else if (response.pago_id) {
                        window.location.href = '<?= base_url('seleccionar-servos') ?>/' + response.pago_id;
                    } else if (response.error) {
                        alert('Error: ' + response.error);
                        button.prop('disabled', false).text('Configurar');
                    } else {
                        alert('Error desconocido. Intenta nuevamente.');
                        button.prop('disabled', false).text('Configurar');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    alert('Error de conexión. Intenta nuevamente.');
                    button.prop('disabled', false).text('Configurar');
                }
            });
        });
            });
    </script>
</body>
</html>