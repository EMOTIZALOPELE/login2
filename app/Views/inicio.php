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
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden; 
        }

        header {
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgb(255, 251, 0); 
            width: 100%;
            z-index: 1000; 
            transition: all 0.3s ease;
            position: sticky; 
            top: 0;
        }

        .container__menu {
            max-width: 1800px;
            margin: auto;
            padding: 1rem 2rem; 
            display: flex;
            justify-content: space-between; 
            align-items: center;
            transition: padding 0.3s ease; 
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem; 
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 242, 254, 0.3);
            transition: font-size 0.3s ease; 
        }
        
        /* ESTILOS PARA EL BOTÓN HAMBURGUESA (COPIADOS "TAL CUAL" DE VECOPO Tesina) */
        .menu-toggle {
            display: none; /* Se mostrará vía media query */
            flex-direction: column;
            cursor: pointer;
            gap: 5px; 
            padding: 10px; 
            z-index: 1011; /* Encima del panel de menú si el panel es 1009 y header 1000 */
        }
        .menu-toggle div { 
            width: 25px; 
            height: 3px; 
            background: #00e0ff; /* Color exacto de VECOPO Tesina */
            border-radius: 3px; 
            transition: all 0.3s ease-in-out; 
        }
        /* Si se quisiera la animación a X, se añadirían aquí los estilos para .menu-toggle.active div */
        /* Por ahora, "tal cual" significa sin la X animada por CSS desde este bloque */


        /* Menú de navegación de escritorio */
        .menu { 
            /* Este div con ID #navigationMenu es el panel desplegable en móvil */
        }
        .menu ul { /* Estilos para el UL en desktop */
            margin: 0; 
            display: flex;
            gap: 1.5rem;
            list-style: none;
            padding-left: 0; 
            align-items: center; 
        }

        .menu ul li a {
            color: var(--text-primary); text-decoration: none; font-size: 1rem; padding: 12px 18px;
            border-radius: 50px; transition: all 0.3s ease; position: relative;  
            overflow: hidden; background: transparent; border: 1px solid rgba(100, 255, 218, 0.2);
            display: inline-block; white-space: nowrap; 
        }
        .menu ul li a::before { /* Efecto brillo rojo botones escritorio */
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient( 130deg, transparent 30%, rgba(255, 77, 77, 0.35) 45%, rgba(255, 77, 77, 0.45) 50%, rgba(255, 77, 77, 0.35) 55%, transparent 70% );
            transform: translateX(-101%); 
            transition: transform 0.65s cubic-bezier(0.23, 1, 0.32, 1); 
            pointer-events: none; 
        }
        .menu ul li a:hover::before { transform: translateX(101%); }
        #selected::before { display: none; }
        .menu ul li a:hover {
            background: rgba(100, 255, 218, 0.1); 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2); 
        }
        #selected { 
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none; color: var(--dark-bg); font-weight: 500;
        }
    
        /* --- ESTILOS DEL CONTENIDO PRINCIPAL (TARJETAS) --- */
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

        /* --- INICIO BLOQUE RESPONSIVE --- */
        @media (max-width: 992px) { 
            .horario-card { width: 300px; height: 460px; }
            .horarios-container { gap: 1.5rem; justify-content: center; }
        }

        @media (max-width: 767.98px) { 
            .container__menu {
                display: flex; 
                justify-content: space-between; 
                align-items: center;
                padding: 0.8rem 1rem; 
            }
            .menu-toggle { /* Mostrar el botón hamburguesa copiado */
                display: flex; 
                /* z-index: 1001; ya está en la definición global de .menu-toggle */
            }
            .logo {
                font-size: 1.8rem; 
            }
            
            /* Ocultar el menú de navegación de escritorio original (el ul horizontal) */
            .container__menu > .menu > nav { 
                 display: none;
            }
            
            /* Panel de menú desplegable (el div.menu con id #navigationMenu) */
            #navigationMenu { 
                display: none; 
                position: fixed; 
                top: 55px; /* Ajustar según altura real del header en móvil */
                left: 0;
                width: 100%;
                background: rgba(17, 17, 17, 0.98); 
                backdrop-filter: blur(8px); 
                -webkit-backdrop-filter: blur(8px);
                padding: 0; /* Quitamos padding aquí para que los li lo manejen */
                z-index: 1000; /* Mismo que el header, la hamburguesa debe estar encima */
                
                visibility: hidden; 
                opacity: 0;
                transform: translateY(-20px); 
                transition: transform 0.3s ease, opacity 0.3s ease, visibility 0s 0.3s;
            }
            #navigationMenu.active { 
                visibility: visible;
                opacity: 1;
                transform: translateY(0); 
                transition: transform 0.3s ease, opacity 0.3s ease, visibility 0s;
                display: block; 
            }
            #navigationMenu ul { /* Estilos para la lista dentro del panel desplegable */
                flex-direction: column; 
                align-items: flex-start; /* ALINEADO A LA IZQUIERDA */
                gap: 0;                  
                width: 100%;
                list-style: none;        
                padding-left: 0;         
                margin: 0;               
            }
            #navigationMenu ul li {
                width: 100%;             
            }
            #navigationMenu ul li a {
                padding: 15px 20px;      /* Padding para los items, especialmente izquierdo */
                font-size: 1rem; 
                display: block; 
                width: 100%;
                border-radius: 0;        
                border: none;            
                border-bottom: 1px solid rgba(100, 255, 218, 0.08); 
                background: transparent; 
                text-align: left;        /* Texto alineado a la izquierda */
                color: var(--text-primary); 
                transition: background-color 0.3s ease;
            }
            #navigationMenu ul li:last-child a {
                border-bottom: none; 
            }
            #navigationMenu ul li a:hover { 
                background: rgba(100, 255, 218, 0.15);
                color: var(--primary-color); 
                transform: translateY(0); 
                box-shadow: none; 
            }
            #navigationMenu ul li a::before { /* Sin brillo rojo en menú desplegable */
                display: none; 
            }
            #navigationMenu #selected { 
                 background: var(--primary-color); 
                 color: var(--dark-bg) !important;
            }
            #navigationMenu #selected:hover {
                background: var(--primary-color); 
            }

            /* Adaptación de las tarjetas para scroll vertical */
            .container__card { padding: 1rem; margin-top: 1rem; }
            .horarios-container { flex-direction: column; align-items: center; overflow-x: hidden; overflow-y: auto; padding: 1rem 0.5rem; gap: 1.5rem; min-height: auto; }
            .horarios-container::-webkit-scrollbar { display: none; }
            .horario-card { width: 90%; max-width: 450px; height: auto; min-height: 400px; flex-shrink: 1; margin-bottom: 1.5rem; }
            .horario-card h3 { font-size: 1.3rem; }
            .horario-card p, .horario-card p strong { font-size: 0.88rem; }
            .config-button, .delete-button { font-size: 0.85rem; }
        }

        @media (max-width: 480px) { 
            .logo { font-size: 1.6rem; }
            .container__menu { padding: 0.6rem 1rem; } 
            
            .menu-toggle div { width: 22px; height: 2.5px; } 
            
            #navigationMenu.active { top: 48px; /* Ajustar si la altura del header cambia mucho */ }
            #navigationMenu.active ul li a { font-size: 0.9rem; padding: 12px 15px; }
            
            .container__card { padding: 0.8rem 0.3rem; }
            .horarios-container { gap: 1rem; }
            .horario-card { width: 95%; min-height: 380px; padding: 1rem; }
            .horario-card h3 { font-size: 1.2rem; }
            .horario-card p, .horario-card p strong { font-size: 0.82rem; }
            .config-button, .delete-button { font-size: 0.8rem; padding: 0.5rem 0.8rem; }
        }
        /* --- FIN BLOQUE RESPONSIVE --- */

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .horario-card { animation: fadeIn 0.5s ease-out forwards; }
        
        /* Estilos de Modales */
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
            <div class="logo">VECOPO</div>
            
            <div class="menu-toggle" id="menu-toggle" role="button" aria-label="Abrir menú de navegación" aria-expanded="false">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div class="menu" id="navigationMenu">
                <nav id="nav">
                    <ul>
                        <li><a href="<?= base_url('/inicio') ?>" id="selected">Inicio</a></li>
                        <li><a href="#" onclick="abrirModalYCerrarMenu()">Añadir Tarjeta</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                        <li><a href="<?= base_url('logout') ?>">Salir</a></li>
                        <li><a href="#" onclick="abrirServoModal()">SERVO</a></li> 
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container__card">
        <div class="horarios-container">
            <?php foreach ($horarios as $horario): ?>
                <div class="horario-card">
                    <h3 data-idhorario="<?= esc($horario['idhorario']); ?>">
                        <span class="card-title"><?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                            ? esc($horario['nombre_tarjeta'])
                            : 'Horario de ' . session()->get('nombre'); ?></span>
                    </h3>
                    <div class="card-scrollable-content">
                        <p><strong>Ventana Apertura:</strong> <?= esc($horario['ventana_apertura']); ?></p>
                        <p><strong>Ventana Cierre:</strong> <?= esc($horario['ventana_cierre']); ?></p>
                        <p><strong>Cortina Apertura:</strong> <?= esc($horario['cortina_apertura']); ?></p>
                        <p><strong>Cortina Cierre:</strong> <?= esc($horario['cortina_cierre']); ?></p>
                        <p><strong>Postigón Apertura:</strong> <?= esc($horario['postigon_apertura']); ?></p>
                        <p><strong>Postigón Cierre:</strong> <?= esc($horario['postigon_cierre']); ?></p>

                        <div class="button-container">
                            <form action="<?= site_url('configurar/' . esc($horario['idhorario'])) ?>" method="POST" style="flex: 1;">
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
                        
                        <form action="<?= site_url('borrar_tarjeta/' . esc($horario['idhorario'])) ?>" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarjeta?');">
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
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
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
            <h3>Añadir Nuevo Dispositivo</h3>
            <form id="reclamarForm"> 
                <input type="text" id="macInput" name="mac_address" placeholder="Ingrese la Dirección MAC del Dispositivo" required style="text-transform:uppercase;">
                <div id="macError" style="color:var(--danger-color); display:none; margin-top:10px; font-size: 0.9rem;"></div>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                    <button type="submit">Reclamar Dispositivo</button>
                    <button type="button" onclick="cerrarModal()" style="background: rgb(250, 6, 6);">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="servoModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(10, 25, 47, 0.95); justify-content:center; align-items:center;">
        <div>
            <h3>¿Qué servo deseas mover?</h3>
            <form id="selectServoForm"> 
                <input type="text" id="tarjetaInput" name="nombre_tarjeta" placeholder="Escribe el nombre de la tarjeta" required>
                <div id="servoError" style="color:var(--danger-color); display:none; margin-top:10px; font-size: 0.9rem;"></div>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                    <button type="submit">Continuar</button>
                    <button type="button" onclick="cerrarServoModal()" style="background: rgb(250, 6, 6);">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script para Hamburguesa
        const hamburgerButton = document.getElementById('menu-toggle'); // CORREGIDO: ID del botón hamburguesa
        const navigationMenu = document.getElementById('navigationMenu');   // ID del panel de menú
        
        if (hamburgerButton && navigationMenu) {
            const navLinksInMenu = navigationMenu.querySelectorAll('a'); 

            hamburgerButton.addEventListener('click', (event) => {
                event.stopPropagation(); 
                navigationMenu.classList.toggle('active');
                // La clase 'active' en el botón hamburguesa para la X se maneja en CSS si se define
                // Para que la X funcione con el CSS de VECOPO Tesina (que no tiene X animada),
                // esta línea podría quitarse o el CSS de .menu-toggle.active debería añadirse.
                // Por ahora, para ser "tal cual" el CSS de Tesina, no se anima a X por JS.
                // Si quieres la X, necesitas los estilos .menu-toggle.active div {} y descomentar la siguiente línea:
                // hamburgerButton.classList.toggle('active'); 
                
                const isExpanded = hamburgerButton.getAttribute('aria-expanded') === 'true' || false;
                hamburgerButton.setAttribute('aria-expanded', !isExpanded);
            });

            navLinksInMenu.forEach(link => {
                link.addEventListener('click', () => {
                    if (navigationMenu.classList.contains('active')) {
                        navigationMenu.classList.remove('active');
                        // hamburgerButton.classList.remove('active'); 
                        hamburgerButton.setAttribute('aria-expanded', 'false');
                    }
                });
            });

            document.addEventListener('click', (event) => {
                if (navigationMenu.classList.contains('active') && 
                    !navigationMenu.contains(event.target) && 
                    !hamburgerButton.contains(event.target)) {
                    navigationMenu.classList.remove('active');
                    // hamburgerButton.classList.remove('active'); 
                    hamburgerButton.setAttribute('aria-expanded', 'false');
                }
            });
        }

        function abrirModalYCerrarMenu() {
            if (navigationMenu && navigationMenu.classList.contains('active')) {
                navigationMenu.classList.remove('active');
                if (hamburgerButton) { 
                    // hamburgerButton.classList.remove('active'); 
                    hamburgerButton.setAttribute('aria-expanded', 'false');
                }
            }
            abrirModal(); 
        }

        // --- El resto de tu JavaScript existente ---
        function abrirModal() { 
            const modal = document.getElementById('codigoModal');
            if (modal) modal.style.display = 'flex';
        }
        function cerrarModal() {
            const modal = document.getElementById('codigoModal');
            const errorDiv = document.getElementById('codigoError');
            const input = document.getElementById('codigoInput');
            if (modal) modal.style.display = 'none';
            if (errorDiv) errorDiv.style.display = 'none';
            if (input) input.value = '';
        }

        // Reemplaza tu script existente para el modal con este
        const reclamarForm = document.getElementById('reclamarForm');
        if (reclamarForm) {
            reclamarForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const macInput = document.getElementById('macInput');
                const macAddress = macInput ? macInput.value.trim().toUpperCase() : ''; // Convierte a mayúsculas para consistencia
                const macError = document.getElementById('macError');
                const submitButton = reclamarForm.querySelector('button[type="submit"]');
                
                submitButton.disabled = true;
                submitButton.textContent = 'Verificando...';
                macError.style.display = 'none';

                // Usamos FormData para enviar los datos, es compatible con el método getPost() de CodeIgniter
                const formData = new FormData();
                formData.append('mac_address', macAddress);
                // Si tienes protección CSRF en CodeIgniter, la siguiente línea sería necesaria
                // formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= base_url('/dispositivos/reclamar') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData
                })
                .then(response => {
                    // Siempre intentamos leer el JSON, incluso si la respuesta es un error (404, 409, etc.)
                    return response.json().then(data => ({ 
                        status: response.status, 
                        body: data 
                    }));
                })
                .then(({ status, body }) => {
                    if (body.success) { // El controlador devuelve 'success' => true
                        alert(body.message || '¡Dispositivo añadido con éxito!'); 
                        window.location.reload(); // Recarga la página para ver la nueva tarjeta
                    } else {
                        // Muestra el mensaje de error específico que viene del controlador
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
                    // Volver a habilitar el botón sin importar el resultado
                    submitButton.disabled = false;
                    submitButton.textContent = 'Reclamar Dispositivo';
                });
            });
        }
        
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

        // --- LÓGICA PARA EL NUEVO MODAL DE SELECCIÓN DE SERVO ---

        const servoModal = document.getElementById('servoModal');
        const selectServoForm = document.getElementById('selectServoForm');

        function abrirServoModal() {
            if (servoModal) servoModal.style.display = 'flex';
        }

        function cerrarServoModal() {
            if (servoModal) servoModal.style.display = 'none';
        }

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
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Éxito: redirigimos a una página de control que usa el ID del dispositivo
                        // Por ahora, vamos a redirigir a tu vista 'ServoView' (/masivo) y guardaremos
                        // el ID del dispositivo en el navegador para que esa página lo use.
                        sessionStorage.setItem('selected_device_id', data.dispositivo_id);
                        window.location.href = '<?= base_url('/masivo') ?>';
                    } else {
                        servoError.textContent = data.messages.error || 'Error desconocido.';
                        servoError.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    servoError.textContent = 'Error de conexión.';
                    servoError.style.display = 'block';
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Continuar';
                });
            });
        }
    </script>
</body>
</html>