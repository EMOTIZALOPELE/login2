<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>VECOPO - Control Inteligente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.8);
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
            --accent-color: #64ffda;
            --danger-color: #ff4d4d;
            --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
            /* Colores del menu de referencia */
            --menu-icon-color: #00e0ff; 
            --menu-bg-color: rgba(10, 25, 47, 0.97); 
            --menu-border-color: rgba(0, 224, 255, 0.08); 
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        .mobile-menu-panel, .mobile-menu-panel a, .mobile-menu-panel i { font-family: 'Poppins', sans-serif; }
        body { background: var(--dark-bg); color: var(--text-primary); min-height: 100vh; overflow-x: hidden; }
        header { background: rgba(10, 25, 47, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgb(255, 251, 0); width: 100%; z-index: 1000; transition: all 0.3s ease; position: sticky; top: 0; }
        .container__menu { max-width: 1800px; margin: auto; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; transition: padding 0.3s ease; position: relative; }
        .logo { 
            font-family: 'Orbitron', sans-serif; 
            font-size: 2rem; 
            font-weight: 700; 
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            text-shadow: 0 0 20px rgba(0, 242, 254, 0.3); 
            transition: font-size 0.3s ease; z-index: 1; }
        .menu-toggle { display: none; flex-direction: column; justify-content: space-around; width: 30px; height: 24px; background: transparent; border: none; cursor: pointer; padding: 0; z-index: 1011; position: relative; }
        .menu-toggle div { width: 25px; height: 3px; background: #00e0ff; border-radius: 3px; transition: all 0.3s ease-in-out; }
        .menu-toggle.active div:nth-child(1) { transform: translateY(8px) rotate(45deg); }
        .menu-toggle.active div:nth-child(2) { opacity: 0; }
        .menu-toggle.active div:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }
        .desktop-menu ul { margin: 0; display: flex; gap: 1.5rem; list-style: none; padding-left: 0; align-items: center; }
        .desktop-menu ul li a { color: var(--text-primary); text-decoration: none; font-size: 1rem; padding: 12px 18px; border-radius: 50px; transition: all 0.3s ease; position: relative; overflow: hidden; background: transparent; border: 1px solid rgba(100, 255, 218, 0.2); display: inline-block; white-space: nowrap; }
        .desktop-menu ul li a::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient( 130deg, transparent 30%, rgba(255, 77, 77, 0.35) 45%, rgba(255, 77, 77, 0.45) 50%, rgba(255, 77, 77, 0.35) 55%, transparent 70% ); transform: translateX(-101%); transition: transform 0.65s cubic-bezier(0.23, 1, 0.32, 1); pointer-events: none; }
        .desktop-menu ul li a:hover::before { transform: translateX(101%); }
        .desktop-menu #selected::before { display: none; }
        .desktop-menu ul li a:hover { background: rgba(100, 255, 218, 0.1); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2); }
        .desktop-menu #selected { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); border: none; color: var(--dark-bg); font-weight: 500; }
        .mobile-menu-panel { display: none; flex-direction: column; position: fixed; top: 0; right: 0; left: auto; width: 50vw; max-width: 300px; min-width: 250px; height: 100vh; background: var(--menu-bg-color); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); padding: 2rem 0 1rem 0; box-shadow: -5px 0px 15px rgba(0,0,0,0.4); z-index: 1010; visibility: hidden; opacity: 0; transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, visibility 0s 0.35s; }
        .mobile-menu-panel.active { visibility: visible; opacity: 1; transform: translateX(0); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, visibility 0s; display: flex; }
        .mobile-menu-panel ul { flex-direction: column; align-items: flex-start; gap: 0; width: 100%; list-style: none; padding: 0; margin: 0; height: 100%; overflow-y: auto; }
        .mobile-menu-panel ul::-webkit-scrollbar { width: 6px; }
        .mobile-menu-panel ul::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .mobile-menu-panel ul::-webkit-scrollbar-thumb { background: var(--input-border); border-radius: 10px; }
        .mobile-menu-panel ul::-webkit-scrollbar-thumb:hover { background: var(--accent-color); }
        .mobile-menu-panel ul li { width: 100%; }
        .mobile-menu-panel ul li a { font-family: 'Poppins', sans-serif; padding: 14px 25px; font-size: 1rem; display: flex; align-items: center; width: 100%; border-radius: 0; border: none; border-bottom: 1px solid var(--menu-border-color); background: transparent; text-align: left; color: var(--text-primary); transition: background-color 0.3s ease, color 0.3s ease; }
        .mobile-menu-panel ul li a i { margin-right: 15px; font-size: 1.1rem; width: 20px; text-align: center; color: var(--menu-icon-color); }
        .mobile-menu-panel ul li:first-child a { margin-top: 1rem; }
        .mobile-menu-panel ul li:last-child a { border-bottom: none; }
        .mobile-menu-panel ul li a:hover { background: rgba(0, 224, 255, 0.1); color: var(--menu-icon-color); }
        .mobile-menu-panel #selected-mobile { background: var(--menu-icon-color); color: var(--dark-bg) !important;}
        .mobile-menu-panel #selected-mobile i { color: var(--dark-bg) !important;}
        .mobile-menu-panel #selected-mobile:hover { background: var(--menu-icon-color); }
        .container__card { padding: 2rem; margin-top: 2rem; transition: padding 0.3s ease, margin-top 0.3s ease; }
        .horarios-container { display: flex; overflow-x: auto; overflow-y: hidden; padding: 1.5rem; gap: 2rem; min-height: 510px; align-items: flex-start; }
        .horarios-container::-webkit-scrollbar { height: 10px; }
        .horarios-container::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 10px; }
        .horarios-container::-webkit-scrollbar-thumb { background: var(--input-border, rgba(100, 255, 218, 0.2)); border-radius: 10px; }
        .horarios-container::-webkit-scrollbar-thumb:hover { background: var(--accent-color, #64ffda); }
        .horario-card { background: var(--card-bg); border-radius: 20px; padding: 1.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease, width 0.3s ease, height 0.3s ease; position: relative; overflow: hidden; border: 1px solid rgba(100, 255, 218, 0.1); backdrop-filter: blur(10px); width: 330px; height: 480px; flex-shrink: 0; display: flex; flex-direction: column; }
        .horario-card::before { content: ''; position: absolute; top: 0; left: -150%; width: 60%; height: 100%; background: linear-gradient( to right, rgba(100, 255, 218, 0) 0%, rgba(100, 255, 218, 0.2) 50%, rgba(100, 255, 218, 0) 100% ); transform: skewX(-25deg); transition: left 0.85s cubic-bezier(0.23, 1, 0.32, 1); z-index: 1; pointer-events: none; }
        .horario-card:hover::before { left: 150%; }
        .horario-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 10px 30px rgba(100, 255, 218, 0.2); }
        .horario-card h3 { font-family: 'Orbitron', sans-serif; font-size: 1.4rem; color: var(--primary-color); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(100, 255, 218, 0.2); flex-shrink: 0; position: relative; z-index: 2; }
        .card-scrollable-content { flex-grow: 1; overflow-y: auto; padding-right: 5px; margin-right: -5px; position: relative; z-index: 2; }
        .card-scrollable-content::-webkit-scrollbar { width: 6px; }
        .card-scrollable-content::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .card-scrollable-content::-webkit-scrollbar-thumb { background: var(--input-border, rgba(100, 255, 218, 0.2)); border-radius: 10px; }
        .card-scrollable-content::-webkit-scrollbar-thumb:hover { background: var(--accent-color, #64ffda); }
        .horario-card p { color: var(--text-secondary); margin: 0.7rem 0; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; }
        .horario-card p strong { color: var(--text-primary); min-width: 130px; font-size: 0.9rem; }
        .button-container { display: flex; gap: 0.8rem; margin-top: 1rem; }
        .config-button, .delete-button { padding: 0.6rem 1rem; font-size: 0.85rem; }
        .config-button { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: var(--dark-bg); border: none; border-radius: 50px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; flex: 1; text-align: center; text-decoration: none; display: inline-block; }
        .config-button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3); }
        .delete-button { background: var(--danger-color); color: white; border: none; border-radius: 50px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; width: 100%; margin-top: 0.8rem; }
        .card-scrollable-content form:last-child { margin-top: 0.8rem; }
        .delete-button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 77, 77, 0.3); }
       
        /* Estilos del Panel de Clima */

        .weather-toggle-button {
            background: transparent;
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 42rem; /* Espacio a la izquierda */
        }

        .weather-toggle-button:hover {
            background: rgba(100, 255, 218, 0.1);
            box-shadow: 0 0 15px rgba(100, 255, 218, 0.3);
            transform: translateY(-2px);
        }
        .weather-panel {
            position: absolute;
            top: calc(100% + 10px);
            right: 20px;
            background: var(--card-bg);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            width: 100%;
            max-width: 380px;
            z-index: 999;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.25);
            
            /* Lógica de visibilidad y animación */
            transition: transform 0.4s ease, opacity 0.4s ease, visibility 0s 0.4s;
            transform: translateY(-20px);
            opacity: 0;
            visibility: hidden;
        }

        .weather-panel.visible {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            transition: transform 0.4s ease, opacity 0.4s ease, visibility 0s 0s;
        }

        .weather-panel.collapsed {
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
        }

        .weather-panel-content { 
            font-family: 'Roboto', sans-serif; 
            font-size: 0.95rem; 
            color: var(--text-primary); 
            text-align: center; 
        }

        .weather-panel-toggle {
            position: absolute;
            left: -25px;
            top: 0;
            background: var(--card-bg);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: var(--primary-color);
            cursor: pointer;
            width: 25px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        @media (max-width: 992px) { .horario-card { width: 300px; height: 460px; } .horarios-container { gap: 1.5rem; justify-content: center; } }
        @media (max-width: 767.98px) { .container__menu { display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 1rem; } .menu-toggle { display: flex; } .logo { font-size: 1.8rem; } .desktop-menu { display: none !important; } .container__card { padding: 1rem; margin-top: 1rem; } .horarios-container { flex-direction: column; align-items: center; overflow-x: hidden; overflow-y: auto; padding: 1rem 0.5rem; gap: 1.5rem; min-height: auto; } .horarios-container::-webkit-scrollbar { display: none; } .horario-card { width: 90%; max-width: 450px; height: auto; min-height: 400px; flex-shrink: 1; margin-bottom: 1.5rem; } .horario-card h3 { font-size: 1.3rem; } .horario-card p, .horario-card p strong { font-size: 0.88rem; } .config-button, .delete-button { font-size: 0.85rem; } .weather-panel { right: 10px; max-width: 80%; } .weather-panel-content { font-size: 0.85rem; } }
        @media (max-width: 480px) { .logo { font-size: 1.6rem; } .container__menu { padding: 0.6rem 0.8rem; } .menu-toggle div { width: 22px; height: 2.5px; } .menu-toggle.active div:nth-child(1) { transform: translateY(7.5px) rotate(45deg); } .menu-toggle.active div:nth-child(3) { transform: translateY(-7.5px) rotate(-45deg); } .mobile-menu-panel.active { top: 0; padding-top: 4rem; width: 60vw; max-width: 280px; } .mobile-menu-panel.active ul li a { font-size: 0.9rem; padding: 10px 15px; } .mobile-menu-panel.active ul li a i { font-size: 1rem; margin-right: 10px; } .container__card { padding: 0.8rem 0.3rem; } .horarios-container { gap: 1rem; } .horario-card { width: 95%; min-height: 380px; padding: 1rem; } .horario-card h3 { font-size: 1.2rem; } .horario-card p, .horario-card p strong { font-size: 0.82rem; } .config-button, .delete-button { font-size: 0.8rem; padding: 0.5rem 0.8rem; } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .horario-card { animation: fadeIn 0.5s ease-out forwards; }
        .modal-content { background: var(--card-bg); border: 1px solid rgba(100, 255, 218, 0.2); border-radius: 20px; color: var(--text-primary); }
        .modal-header { border-bottom: 1px solid rgba(100, 255, 218, 0.2); padding: 1.5rem; }
        .modal-title { font-family: 'Orbitron', sans-serif; color: var(--primary-color); }
        .modal-body { padding: 1.5rem; }
        .modal-footer { border-top: 1px solid rgba(100, 255, 218, 0.2); padding: 1.5rem; }
        .form-control { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(100, 255, 218, 0.2); color: var(--text-primary); border-radius: 10px; padding: 0.8rem 1rem; }
        .form-control:focus { background: rgba(255, 255, 255, 0.1); border-color: var(--primary-color); color: var(--text-primary); box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25); }
        .btn-primary { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); border: none; border-radius: 50px; padding: 0.8rem 2rem; font-weight: 500; }
        .btn-secondary { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(100, 255, 218, 0.2); border-radius: 50px; padding: 0.8rem 2rem; font-weight: 500; }
        #codigoModal { background: rgba(10, 25, 47, 0.95); backdrop-filter: blur(10px); }
        #codigoModal > div { background: var(--card-bg); border: 1px solid rgba(100, 255, 218, 0.2); border-radius: 20px; padding: 2rem; }
        #codigoModal h3 { font-family: 'Orbitron', sans-serif; color: var(--primary-color); margin-bottom: 1.5rem; }
        #codigoModal input { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(100, 255, 218, 0.2); color: var(--text-primary); border-radius: 10px; padding: 1rem; width: 100%; margin: 1rem 0; }
        #codigoModal button { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: var(--dark-bg); border: none; padding: 0.8rem 2rem; border-radius: 50px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; margin: 0.5rem; }
        #codigoModal button:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3); }
    </style>
</head>
<body>
    <header>
        <div class="container__menu">
            <div class="logo">
                <span>Hola <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            </div>

            <div class="weather-panel" id="weatherPanel">
                <div class="weather-panel-content" id="weatherPanelContent">
                    Cargando información del clima...
                </div>
                <li>
                    <a href="#" id="mobileWeatherToggleButton"><i class="fas fa-cloud-sun"></i>Cerrar</a>
                </li>
            </div>

            <button class="weather-toggle-button" id="weatherToggleButton" aria-label="Mostrar/ocultar panel del clima">
                <i class="fas fa-cloud-sun"></i>
            </button>

            <div class="desktop-menu">
                <nav>
                    <ul>
                        <li><a href="<?= base_url('/inicio') ?>" id="selected">Inicio</a></li>
                        <li><a href="#" onclick="abrirModal()">Añadir Tarjeta</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                        <li><a href="<?= base_url('logout') ?>">Salir</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#servoModal"><i class="fas fa-gamepad"></i> Manual</a></li>
                    </ul>
                </nav>
            </div>

            <div class="menu-toggle" id="menu-toggle" role="button" aria-label="Abrir men de navegacin" aria-expanded="false">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <nav class="mobile-menu-panel" id="navigationMenu">
            <ul>
                <li><a href="<?= base_url('/inicio') ?>" id="selected-mobile"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="#" onclick="abrirModalYCerrarMenu()"><i class="fas fa-plus-square"></i> Añadir Tarjeta</a></li>
                <li><a href="<?= base_url('pele') ?>"><i class="fas fa-palette"></i> Diseño</a></li>
                <li><a href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
                <li><a href="#" data-toggle="modal" data-target="#servoModal">Manual</a></li>
            </ul>
        </nav>
    </header>

    <div class="container__card">
        <div class="horarios-container">
            <?php foreach ($horarios as $horario): ?>
                <div class="horario-card">
                    <h3 data-idhorario="<?= esc($horario['idhorario']); ?>">
                        <span class="card-title"><?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                            ? esc($horario['nombre_tarjeta'])
                            : 'Tu horario ' . session()->get('nombre'); ?></span>
                    </h3>
                    <div class="card-scrollable-content">
                        <p><strong>Ventana Apertura:</strong> <?= esc($horario['ventana_apertura']); ?></p>
                        <p><strong>Ventana Cierre:</strong> <?= esc($horario['ventana_cierre']); ?></p>
                        <p><strong>Cortina Apertura:</strong> <?= esc($horario['cortina_apertura']); ?></p>
                        <p><strong>Cortina Cierre:</strong> <?= esc($horario['cortina_cierre']); ?></p>
                        <p><strong>Postigón Apertura:</strong> <?= esc($horario['postigon_apertura']); ?></p>
                        <p><strong>Postigón Cierre:</strong> <?= esc($horario['postigon_cierre']); ?></p>

                        <div class="button-container">
                            <form action="<?= base_url('configuracion/' . esc($horario['idhorario'])) ?>" method="GET" style="flex: 1;">
                                <button type="submit" class="config-button">Configurar</button>
                            </form>
                            
                            <button type="button" class="config-button"
                                    data-toggle="modal" data-target="#changeNameModal"
                                    data-idhorario="<?= esc($horario['idhorario']); ?>"
                                    data-current-name="<?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                                        ? esc($horario['nombre_tarjeta'])
                                        : 'Horario de ' . session()->get('nombre'); ?>">
                                Cambiar Nombre
                            </button>
                        </div>
                        
                        <form action="<?= site_url('borrar_tarjeta/' . esc($horario['idhorario'])) ?>" method="POST" onsubmit="return confirm('Seguro que quieres eliminar esta tarjeta?');">
                            <button type="submit" class="delete-button">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal fade" id="changeNameModal" tabindex="-1" role="dialog" aria-labelledby="changeNameModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeNameModalLabel">Cambiar Nombre de Tarjeta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <h5 class="modal-title" id="successModalLabel">xito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="successModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="codigoModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(10, 25, 47, 0.95); justify-content:center; align-items:center;">
        <div>
            <h3>Aadir Nuevo Dispositivo</h3>
            <form id="reclamarForm"> 
                <input type="text" id="macInput" name="mac_address" placeholder="Ingrese la Direccin MAC del Dispositivo" required style="text-transform:uppercase;">
                <div id="macError" style="color:var(--danger-color); display:none; margin-top:10px; font-size: 0.9rem;"></div>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                    <button type="submit">Reclamar Dispositivo</button>
                    <button type="button" onclick="cerrarModal()" style="background: rgb(250, 6, 6);">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="servoModal" tabindex="-1" role="dialog" aria-labelledby="servoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="selectServoForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="servoModalLabel">Control Manual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: var(--primary-color);">&times;</span>
                    </button>
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

    <script>
        // --- INICIO SCRIPT HAMBURGUESA ---
        const hamburgerButton = document.getElementById('menu-toggle');
        const navigationMenu = document.getElementById('navigationMenu');   
        
        if (hamburgerButton && navigationMenu) {
            const navLinksInMenu = navigationMenu.querySelectorAll('a'); 

            hamburgerButton.addEventListener('click', (event) => {
                event.stopPropagation(); 
                navigationMenu.classList.toggle('active');
                hamburgerButton.classList.toggle('active'); 
                
                const isExpanded = hamburgerButton.getAttribute('aria-expanded') === 'true' || false;
                hamburgerButton.setAttribute('aria-expanded', !isExpanded);
            });

            navLinksInMenu.forEach(link => {
                link.addEventListener('click', () => {
                    if (navigationMenu.classList.contains('active')) {
                        navigationMenu.classList.remove('active');
                        hamburgerButton.classList.remove('active'); 
                        hamburgerButton.setAttribute('aria-expanded', 'false');
                    }
                });
            });

            document.addEventListener('click', (event) => {
                if (navigationMenu.classList.contains('active') && 
                    !navigationMenu.contains(event.target) && 
                    !hamburgerButton.contains(event.target)) {
                    navigationMenu.classList.remove('active');
                    hamburgerButton.classList.remove('active'); 
                    hamburgerButton.setAttribute('aria-expanded', 'false');
                }
            });
        }
        // --- FIN SCRIPT HAMBURGUESA ---

        // --- INICIO MODAL AÑADIR TARJETA ---
        function abrirModal() {
            const modal = document.getElementById('codigoModal');
            if (modal) modal.style.display = 'flex';
        }

        function cerrarModal() {
            const modal = document.getElementById('codigoModal');
            const errorDiv = document.getElementById('macError');
            const input = document.getElementById('macInput');
            if (modal) modal.style.display = 'none';
            if (errorDiv) errorDiv.style.display = 'none';
            if (input) input.value = '';
        }
        
        function abrirModalYCerrarMenu() {
            if (navigationMenu && navigationMenu.classList.contains('active')) {
                navigationMenu.classList.remove('active');
                if (hamburgerButton) { 
                    hamburgerButton.classList.remove('active'); 
                    hamburgerButton.setAttribute('aria-expanded', 'false');
                }
            }
            abrirModal(); 
        }

        const reclamarForm = document.getElementById('reclamarForm');
        if (reclamarForm) {
            reclamarForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const macInput = document.getElementById('macInput');
                const macAddress = macInput ? macInput.value.trim().toUpperCase() : ''; 
                const macError = document.getElementById('macError');
                const submitButton = reclamarForm.querySelector('button[type="submit"]');
                
                submitButton.disabled = true;
                submitButton.textContent = 'Verificando...';
                macError.style.display = 'none';

                const formData = new FormData();
                formData.append('mac_address', macAddress);

                fetch('<?= base_url('/dispositivos/reclamar') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (body.success) { 
                        alert(body.message || 'Dispositivo añadido con éxito!'); 
                        window.location.reload(); 
                    } else {
                        macError.textContent = body.messages.error || 'Ocurrió un error inesperado.';
                        macError.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error en fetch:', error);
                    macError.textContent = 'Error de conexión con el servidor. Intente nuevamente.';
                    macError.style.display = 'block';
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Reclamar Dispositivo';
                });
            });
        }
        // --- FIN MODAL AÑADIR TARJETA ---
        
        // --- INICIO MODAL CAMBIAR NOMBRE ---
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
                if (!newName.trim()) {
                    alert('El nombre de la tarjeta no puede estar vacío.');
                    return;
                }
                $.ajax({
                    url: '<?= base_url('actualizar_nombre_tarjeta') ?>',
                    method: 'POST',
                    data: {
                        idhorario: cardId,
                        nombre_tarjeta: newName,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#changeNameModal').modal('hide');
                            $('#successModalBody').text(response.message || 'Nombre actualizado con éxito.');
                            $('#successModal').modal('show');
                            $(`.horario-card h3[data-idhorario="${cardId}"] .card-title`).text(newName);
                            $(`button[data-idhorario="${cardId}"][data-target="#changeNameModal"]`).data('current-name', newName);
                        } else {
                            $('#changeNameModal').modal('hide');
                            alert('Error al actualizar el nombre: ' + (response.message || 'Error desconocido'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX:', status, error, xhr.responseText);
                        $('#changeNameModal').modal('hide');
                        alert('Ocurrió un error al comunicarse con el servidor. Detalles: ' + xhr.responseText);
                    }
                });
            });

            $('#successModal').on('hidden.bs.modal', function () { /* location.reload(); */ });
        });
        // --- FIN MODAL CAMBIAR NOMBRE ---

        // --- INICIO MODAL CONTROL MANUAL ---
        const servoModal = document.getElementById('servoModal');
        const selectServoForm = document.getElementById('selectServoForm');

        if (selectServoForm) {
            selectServoForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const tarjetaInput = document.getElementById('tarjetaInput');
                const servoError = document.getElementById('servoError');
                const submitButton = selectServoForm.querySelector('button[type="submit"]');

                submitButton.disabled = true;
                submitButton.textContent = 'Buscando...';
                servoError.style.display = 'none';

                const formData = new FormData();
                formData.append('nombre_tarjeta', tarjetaInput.value);

                fetch('<?= base_url('/servos/seleccionar') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '<?= csrf_hash() ?>' },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.messages.error || 'Error del servidor'); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.href = `<?= base_url('/masivo') ?>/${data.dispositivo_id}`;
                    } else {
                        servoError.textContent = data.messages.error || 'Error desconocido.';
                        servoError.style.display = 'block';
                    }
                })
                .catch(error => {
                    servoError.textContent = error.message;
                    servoError.style.display = 'block';
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Continuar';
                });
            });
        }
        // --- FIN MODAL CONTROL MANUAL ---

        // =================================================================
       // --- LÓGICA DEL PANEL DEL CLIMA ---
        const APIKey = '0d132a7baaa02ea9cfc60077249f0254';
        const city = 'Rio Tercero,AR';

        const weatherPanel = document.getElementById('weatherPanel');
        const weatherPanelContent = document.getElementById('weatherPanelContent');
        const weatherToggleButton = document.getElementById('weatherToggleButton');
        const mobileWeatherToggleButton = document.getElementById('mobileWeatherToggleButton');

        const weatherDescriptions = {
            'clear': 'soleado', 'clouds': 'nublado', 'rain': 'lluvioso',
            'thunderstorm': 'con tormentas', 'snow': 'nevado', 'mist': 'con neblina',
            'haze': 'con neblina', 'fog': 'con niebla', 'drizzle': 'con llovizna'
        };

        document.addEventListener('DOMContentLoaded', function() {
        
        // --- LÓGICA DEL PANEL DEL CLIMA ---
        const APIKey = '0d132a7baaa02ea9cfc60077249f0254';
        const city = 'Rio Tercero,AR';

        const weatherPanel = document.getElementById('weatherPanel');
        const weatherPanelContent = document.getElementById('weatherPanelContent');
        const weatherToggleButton = document.getElementById('weatherToggleButton');
        const mobileWeatherToggleButton = document.getElementById('mobileWeatherToggleButton');

        const weatherDescriptions = {
            'clear': 'soleado', 'clouds': 'nublado', 'rain': 'lluvioso',
            'thunderstorm': 'con tormentas', 'snow': 'nevado', 'mist': 'con neblina',
            'haze': 'con neblina', 'fog': 'con niebla', 'drizzle': 'con llovizna'
        };

        function updateWeatherPanel() {
            fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${APIKey}&lang=es`)
                .then(response => response.json())
                .then(data => {
                    if (data.cod === 200 && weatherPanelContent) {
                        const temp = Math.round(data.main.temp);
                        const mainCondition = data.weather[0].main.toLowerCase();
                        const description = weatherDescriptions[mainCondition] || data.weather[0].description.toLowerCase();
                        const weatherText = `Hola <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>, hoy es un día ${description} y la temperatura es de ${temp}°C.`;
                        weatherPanelContent.textContent = weatherText;
                    }
                })
                .catch(error => {
                    console.error('Error al obtener datos del clima:', error);
                });
        }

        function toggleWeatherPanel(event) {
            event.preventDefault();
            event.stopPropagation();
            if (weatherPanel) {
                weatherPanel.classList.toggle('visible');
            }
        }

        if (weatherToggleButton) {
            weatherToggleButton.addEventListener('click', toggleWeatherPanel);
        }
        if (mobileWeatherToggleButton) {
            mobileWeatherToggleButton.addEventListener('click', toggleWeatherPanel);
        }

        document.addEventListener('click', function(event) {
            const isClickInsidePanel = weatherPanel ? weatherPanel.contains(event.target) : false;
            const isClickOnToggleButton = weatherToggleButton ? weatherToggleButton.contains(event.target) : false;
            const isClickOnMobileToggleButton = mobileWeatherToggleButton ? mobileWeatherToggleButton.contains(event.target) : false;
            
            if (weatherPanel && weatherPanel.classList.contains('visible') && !isClickInsidePanel && !isClickOnToggleButton && !isClickOnMobileToggleButton) {
                weatherPanel.classList.remove('visible');
            }
        });

        // --- CAMBIO PARA MOSTRAR AL INICIO ---
        // Espera a que la animación de la transición pueda ejecutarse
        setTimeout(() => {
            if (weatherPanel) {
                weatherPanel.classList.add('visible');
            }
            // Y lo cierra automáticamente después de 7 segundos
            setTimeout(() => {
                if (weatherPanel) {
                    weatherPanel.classList.remove('visible');
                }
            }, 5000); // 7000 milisegundos = 7 segundos
        }, 500); // 500ms de espera antes de mostrarlo


        // Carga inicial de datos
        updateWeatherPanel();
        setInterval(updateWeatherPanel, 1800000);
    }); // Actualiza cada 30 minutos
        // --- FIN LÓGICA DEL PANEL DEL CLIMA ---

    </script>
</body>
</html>