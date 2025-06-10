<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Horarios - VECOPO</title>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85);
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
            --accent-color: #64ffda;
            --danger-color: #ff4d4d;
            --success-color: #00ff9d;
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(100, 255, 218, 0.2);
            --menu-icon-color: #00e0ff; 
            --menu-bg-color: rgba(17, 17, 17, 0.98);
            --menu-border-color: rgba(0, 224, 255, 0.08);
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
        
        /* --- HEADER UNIFICADO --- */
        header {
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgb(255, 251, 0); 
            width: 100%;
            z-index: 1010; 
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
        }
        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem; 
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 242, 254, 0.3);
            transition: font-size 0.3s ease; 
        }
        .menu-toggle {
            display: none; 
            flex-direction: column; cursor: pointer;
            gap: 5px; padding: 10px; z-index: 1011;
        }
        .menu-toggle div {
            width: 25px; height: 3px; background: var(--menu-icon-color);
            border-radius: 3px; transition: all 0.3s ease-in-out; 
        }
        .menu-toggle.active div:nth-child(1) { transform: translateY(8px) rotate(45deg); }
        .menu-toggle.active div:nth-child(2) { opacity: 0; }
        .menu-toggle.active div:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }
        .desktop-menu ul { margin: 0; display: flex; gap: 1.5rem; list-style: none; padding-left: 0; align-items: center; }
        .desktop-menu ul li a {
            color: var(--text-primary); text-decoration: none; font-size: 1rem; padding: 12px 18px;
            border-radius: 50px; transition: all 0.3s ease; position: relative;  
            overflow: hidden; background: transparent; border: 1px solid rgba(100, 255, 218, 0.2);
            display: inline-block; white-space: nowrap; 
        }
        #selected { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); border: none; color: var(--dark-bg); font-weight: 500; }

        /* Panel de Menú Móvil */
        .mobile-menu-panel { display: none; flex-direction: column; position: fixed; top: 0; right: 0; left: auto; width: 50vw; max-width: 300px; min-width: 250px; height: 100vh; background: var(--menu-bg-color); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); padding: 2rem 0 1rem 0; box-shadow: -5px 0px 15px rgba(0,0,0,0.4); z-index: 1009; visibility: hidden; opacity: 0; transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, visibility 0s 0.35s; }
        .mobile-menu-panel.active { visibility: visible; opacity: 1; transform: translateX(0); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, visibility 0s; display: flex; }
        .mobile-menu-panel ul { flex-direction: column; align-items: flex-start; gap: 0; width: 100%; list-style: none; padding: 0; margin: 0; height: 100%; overflow-y: auto; }
        .mobile-menu-panel ul li { width: 100%; }
        .mobile-menu-panel ul li a { padding: 14px 25px; font-size: 1rem; display: flex; align-items: center; width: 100%; border-radius: 0; border: none; border-bottom: 1px solid var(--menu-border-color); background: transparent; text-align: left; color: var(--text-primary); transition: background-color 0.3s ease, color 0.3s ease; font-family: 'Poppins', sans-serif;}
        .mobile-menu-panel ul li a i { margin-right: 15px; font-size: 1.1rem; width: 20px; text-align: center; color: var(--menu-icon-color); }
        .mobile-menu-panel ul li:first-child a { margin-top: 1rem; }
        .mobile-menu-panel ul li:last-child a { border-bottom: none; }
        .mobile-menu-panel ul li a:hover { background: rgba(0, 224, 255, 0.1); color: var(--menu-icon-color); }
        .mobile-menu-panel #selected-mobile { background: var(--menu-icon-color); color: var(--dark-bg) !important;}
        .mobile-menu-panel #selected-mobile i { color: var(--dark-bg) !important;}

        /* --- ESTILOS PARA EL CONTENEDOR Y FORMULARIO DE CONFIGURACIÓN --- */
        .config-page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            width: 100%;
        }
        .form-container {
            background: var(--card-bg);
            padding: 2.5rem 3rem;
            border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%;
            max-width: 550px; /* Ancho máximo para el formulario */
            animation: fadeIn 0.8s ease-out;
        }

        .form-container h2 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
        }
        
        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .form-control-custom {
            width: 100%;
            padding: 0.9rem 1rem;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            -webkit-appearance: none; /* Para mejor estilo en algunos navegadores */
        }
        .form-control-custom::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }
        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 242, 254, 0.25);
        }
        /* Estilos para el picker de tiempo en navegadores WebKit */
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(0.8) sepia(1) hue-rotate(130deg);
            cursor: pointer;
        }

        .action-button {
            width: 100%;
            padding: 0.9rem 1.5rem;
            font-weight: 500;
            font-size: 1.1rem;
            color: var(--dark-bg);
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            margin-top: 1.5rem; 
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* --- BLOQUE RESPONSIVE --- */
        @media (max-width: 767.98px) { 
            .container__menu {
                display: flex; 
                justify-content: space-between; 
                align-items: center;
                padding: 0.8rem 1rem; 
            }
            .menu-toggle { display: flex; }
            .logo { font-size: 1.8rem; }
            .desktop-menu { display: none !important; }
            
            .config-page-wrapper {
                padding: 1rem;
                align-items: flex-start; /* Permite que el form no esté centrado verticalmente */
                padding-top: 2rem;
            }
            .form-container {
                padding: 2rem 1.5rem;
            }
        }
        @media (max-width: 480px) { 
            .logo { font-size: 1.6rem; }
            .container__menu { padding: 0.6rem 0.8rem; } 
            
            .menu-toggle div { width: 22px; height: 2.5px; } 
            .mobile-menu-panel.active { top: 48px; }
            
            .config-page-wrapper {
                 padding: 0.5rem;
                 padding-top: 1.5rem;
            }
            .form-container {
                padding: 1.5rem 1rem;
            }
            .form-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container__menu">
            <div class="logo">VECOPO</div>
            
            <div class="menu-toggle" id="menu-toggle" role="button" aria-label="Abrir menú de navegación">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div class="desktop-menu">
                <nav>
                    <ul>
                        <li><a href="<?= base_url('irainicio') ?>">Inicio</a></li>
                        <li><a href="#" id="selected">Configurar</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                        <li><a href="<?= base_url('logout') ?>">Salir</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <nav class="mobile-menu-panel" id="navigationMenu">
             <ul>
                <li><a href="<?= base_url('irainicio') ?>"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="#" id="selected-mobile"><i class="fas fa-sliders-h"></i> Configurar</a></li>
                <li><a href="<?= base_url('pele') ?>"><i class="fas fa-palette"></i> Diseño</a></li>
                <li><a href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
            </ul>
        </nav>
    </header>

    <main class="config-page-wrapper">
        <div class="form-container">
            <h2>Configurar Horarios</h2>
            <form action="<?= base_url('savetarjeta') ?>" method="post">
                <div class="form-group">
                    <label for="ventana_apertura">Apertura de Ventanas:</label>
                    <input class="form-control-custom" type="time" id="ventana_apertura" name="ventana_apertura" value="<?= isset($horario['ventana_apertura']) ? esc($horario['ventana_apertura']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="ventana_cierre">Cierre de Ventanas:</label>
                    <input class="form-control-custom" type="time" id="ventana_cierre" name="ventana_cierre" value="<?= isset($horario['ventana_cierre']) ? esc($horario['ventana_cierre']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="cortina_apertura">Apertura de Cortinas:</label>
                    <input class="form-control-custom" type="time" id="cortina_apertura" name="cortina_apertura" value="<?= isset($horario['cortina_apertura']) ? esc($horario['cortina_apertura']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="cortina_cierre">Cierre de Cortinas:</label>
                    <input class="form-control-custom" type="time" id="cortina_cierre" name="cortina_cierre" value="<?= isset($horario['cortina_cierre']) ? esc($horario['cortina_cierre']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="postigon_apertura">Apertura de Postigones:</label>
                    <input class="form-control-custom" type="time" id="postigon_apertura" name="postigon_apertura" value="<?= isset($horario['postigon_apertura']) ? esc($horario['postigon_apertura']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="postigon_cierre">Cierre de Postigones:</label>
                    <input class="form-control-custom" type="time" id="postigon_cierre" name="postigon_cierre" value="<?= isset($horario['postigon_cierre']) ? esc($horario['postigon_cierre']) : '' ?>" required>
                </div>

                <button class="action-button" type="submit">Guardar Horarios</button>
            </form>
        </div>
    </main>
    
    <script>
        // Script para Hamburguesa
        const hamburgerToggleBtn = document.getElementById('menu-toggle');
        const mobileNavigationPanel = document.getElementById('navigationMenu');

        if (hamburgerToggleBtn && mobileNavigationPanel) {
            hamburgerToggleBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                mobileNavigationPanel.classList.toggle('active');
                // Si quieres animación X en el botón, descomenta la siguiente línea
                // y asegúrate de tener los estilos para .menu-toggle.active
                // hamburgerToggleBtn.classList.toggle('active'); 
            });

            document.addEventListener('click', (event) => {
                if (mobileNavigationPanel.classList.contains('active') && 
                    !mobileNavigationPanel.contains(event.target) && 
                    !hamburgerToggleBtn.contains(event.target)) {
                    mobileNavigationPanel.classList.remove('active');
                    // hamburgerToggleBtn.classList.remove('active');
                }
            });
        }
    </script>
    </body>
</html>