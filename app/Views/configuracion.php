<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Configurar Dispositivos Inteligentes</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES Y ESTILOS GLOBALES --- */
        :root {
            --primary-color: #00f2fe; --secondary-color: #4facfe; --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85); --text-primary: #ffffff; --text-secondary: #8892b0;
            --accent-color: #64ffda; --danger-color: #ff4d4d; --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
            --button-bg: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            --button-hover-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
            --close-button-bg: #ff4d4d;
        }
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            -webkit-tap-highlight-color: transparent; 
        }
        body { 
            background-color: var(--dark-bg); 
            color: var(--text-primary); 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: flex-start; 
            padding: 2rem; 
        }

        #hourly_forecast_block {
            min-width: 0;
        }

        /* --- CARD PRINCIPAL Y LAYOUT GRID --- */
        .config-card {
            background: var(--card-bg); 
            padding: 2.5rem; 
            border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1); 
            
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%; 
            max-width: 1280px;
            animation: fadeIn 0.8s ease-out; 
            text-align: center;
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr;
            grid-template-areas:
                "header"
                "search"
                "alerts"
                "description"
                "form-content";
            -webkit-transform: translateZ(0); /* Para compatibilidad */
            transform: translateZ(0);       /* Fuerza la aceleración por GPU */
        }
        .config-card h1 {
            font-family: 'Orbitron', sans-serif; 
            color: var(--primary-color);
            font-size: 2rem; 
            margin-bottom: 0;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
            grid-area: header;
        }
        .config-card p {
            grid-area: description;
            margin-bottom: 0;
            color: var(--text-secondary);
        }

        /* --- NUEVO ESTILO PARA EL BUSCADOR --- */
        .location-search-container {
            grid-area: search;
            position: relative;
            margin-bottom: 1rem;
        }

        .location-search {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--input-border);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .location-search:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25);
        }

        .location-search input {
            flex: 1;
            background: transparent;
            border: none;
            color: var(--text-primary);
            padding: 0.5rem;
            font-size: 1rem;
            outline: none;
        }

        .location-search button {
            background: var(--button-bg);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            color: var(--dark-bg);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .location-search button:hover {
            transform: scale(1.05);
            box-shadow: var(--button-hover-shadow);
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--card-bg);
            border: 1px solid var(--input-border);
            border-top: none;
            border-radius: 0 0 10px 10px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-suggestions.active {
            display: block;
        }

        .suggestion-item {
            padding: 0.8rem 1rem;
            cursor: pointer;
            transition: background 0.2s ease;
            text-align: left;
        }

        .suggestion-item:hover {
            background: rgba(100, 255, 218, 0.1);
        }

        .suggestion-item .city-name {
            font-weight: 500;
            color: var(--text-primary);
        }

        .suggestion-item .province-name {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-left: 0.5rem;
        }

        /* --- FORMULARIO COMO GRID ANIDADO --- */
        .config-card form {
            grid-area: form-content;
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(4, 1fr);
            grid-template-areas:
                "ventana cortina postigon clima_actual"
                "pronostico pronostico pronostico pronostico"
                "buttons buttons buttons buttons";
        }

        /* --- ESTILOS PARA LAS ALERTAS --- */
        .alert {
            grid-area: alerts;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 500;
            margin-bottom: 0;
        }
        .alert.success {
            background-color: var(--success-color);
            color: var(--dark-bg);
        }
        .alert.danger {
            background-color: var(--danger-color);
            color: var(--text-primary);
        }

        /* --- BLOQUES DE CONTENIDO Y ÁREAS DEL GRID --- */
        .content-block {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--input-border);
            text-align: left;
        }
        #hourly_forecast_block { grid-area: pronostico; }
        #ventana_block { grid-area: ventana; }
        #cortina_block { grid-area: cortina; }
        #postigon_block { grid-area: postigon; }
        #current_weather_block { grid-area: clima_actual; }
        .button-row { grid-area: buttons; }

        /* ... (el resto de tus estilos como .form-group, .weather-info, etc. que no afectan al layout principal) */
        .content-block h2, .content-block h3 {font-family: 'Orbitron', sans-serif;color: var(--accent-color);font-size: 1.5rem;margin-bottom: 1rem;text-shadow: 0 0 8px rgba(100, 255, 218, 0.2);}.content-block h3 { font-size: 1.3rem; }.form-group { margin-bottom: 1.5rem; text-align: left; }.form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-weight: 500; font-size: 0.95rem; }.form-control-time, .form-control-input {background: rgba(255, 255, 255, 0.05); border: 1px solid var(--input-border);color: var(--text-primary); border-radius: 10px; padding: 0.8rem 1rem;width: 100%; font-size: 1rem; appearance: none; -webkit-appearance: none;}.form-control-time:focus, .form-control-input:focus {background: rgba(255, 255, 255, 0.1); border-color: var(--primary-color);box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25); outline: none;}.form-control-time::-webkit-calendar-picker-indicator { filter: invert(1); }.checkbox-group { display: flex; align-items: center; margin-top: 5px; }.checkbox-group label { margin-bottom: 0; margin-left: 5px; }.weather-info { display: flex; align-items: center; justify-content: flex-start; margin-bottom: 0.8rem; gap: 1rem; }.weather-info i { font-size: 1.5rem; color: var(--primary-color); width: 30px; text-align: center; }.weather-info p { font-size: 1rem; color: var(--text-primary); margin: 0; display: flex; align-items: baseline; flex-grow: 1; }.weather-info p span { font-weight: 600; color: var(--accent-color); margin-left: 5px; }#current_weather_block h2 { margin-bottom: 0.5rem; }#weather_city_name { margin-bottom: 1rem; background: rgba(255,255,255,0.05); padding: 0.5rem; border-radius: 8px; border: 1px solid var(--input-border); text-align: center; color: var(--text-primary); }#hourly_forecast_block { background: transparent; padding: 1.5rem; border: none; border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); }#hourly_forecast_block h2 { display: none; }#weather_summary_container { text-align: left; margin-bottom: 1.5rem; padding: 0; background: none; border: none; }#weather_summary_container p { font-size: 1.1rem; font-weight: 500; color: #ffffff; margin: 0; background: none; text-align: left; padding: 0; border: none; }.hourly-forecast-container { width: 100%; overflow-x: auto; padding-bottom: 15px; margin-top: 10px; }.hourly-forecast-grid { display: flex; align-items: flex-end; gap: 15px; padding-bottom: 15px; position: relative; justify-content: center; }.hourly-forecast-item { display: flex; flex-direction: column; align-items: center; justify-content: space-between; min-width: 65px; text-align: center; color: #ffffff; font-size: 1rem; }.hourly-time { font-size: 0.8rem; font-weight: 500; margin-bottom: 10px; color: #ffffff; }.hourly-icon i { font-size: 1.8rem; margin-bottom: 15px; }.hourly-temp { font-size: 1.1rem; font-weight: 600; color: #ffffff; }.hourly-pop { display: flex; align-items: center; font-size: 0.8rem; margin-top: 10px; color: #64b5f6; }.hourly-pop i { font-size: 0.9rem; margin-right: 3px; }.temperature-line { position: absolute; bottom: 60px; left: 0; width: 100%; height: 1px; background: transparent; }.icon-sun { color: #f39c12; } .icon-cloud-sun { color: #f1c40f; } .icon-cloud { color: #bdc3c7; } .icon-rain { color: #3498db; } .icon-storm { color: #95a5a6; } .icon-snow { color: #ffffff; } .icon-fog { color: #ecf0f1; }.hourly-forecast-container::-webkit-scrollbar { height: 5px; }.hourly-forecast-container::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.1); border-radius: 5px; }.hourly-forecast-container::-webkit-scrollbar-thumb { background-color: #ffffff; border-radius: 5px; }.button-row {margin-top: 0; width: 100%; text-align: center;display: flex; justify-content: center; gap: 1rem;}.btn-submit, .btn-back {padding: 0.8rem 2rem; font-size: 1.1rem; font-weight: 500;border-radius: 50px; border: none; cursor: pointer; transition: all 0.3s ease;display: inline-block; text-decoration: none;}.btn-submit { background: var(--button-bg); color: var(--dark-bg); box-shadow: 0 5px 15px rgba(0, 242, 254, 0.2); }.btn-submit:hover { transform: translateY(-3px); box-shadow: var(--button-hover-shadow); }.btn-back { background: rgba(255, 255, 255, 0.1); color: var(--text-primary); border: 1px solid var(--input-border); }.btn-back:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1); }@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* --- ESTILOS PARA LOS CHECKBOXES DE DÍAS --- */
        .days-checkbox-group {
            display: flex;
            justify-content: space-between;
            margin: 1rem 0;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid var(--input-border);
        }
        .day-checkbox {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .day-checkbox label {
            font-size: 0.8rem;
            margin-top: 5px;
            color: var(--text-secondary);
        }
        .day-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent-color);
<<<<<<< HEAD
        }

        /* --- CLASES PARA CONTROLAR VISIBILIDAD DINÁMICA --- */
        .servo-block {
            transition: all 0.3s ease;
        }
        .servo-block.hidden {
            display: none;
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }

        /* --- MEDIA QUERIES PARA RESPONSIVIDAD --- */

        /* Vista de Tablet (hasta 1200px) */
        @media (max-width: 1200px) {
            .config-card form {
                grid-template-columns: repeat(2, 1fr);
                grid-template-areas:
                    "ventana cortina"
                    "postigon clima_actual"
                    "pronostico pronostico"
                    "buttons buttons";
            }
            
            /* Ajustes dinámicos para tablet */
            .config-card.form-1-servo form {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "ventana"
                    "clima_actual"
                    "pronostico"
                    "buttons";
            }
            
            .config-card.form-2-servos form {
                grid-template-columns: repeat(2, 1fr);
                grid-template-areas:
                    "ventana cortina"
                    "clima_actual clima_actual"
                    "pronostico pronostico"
                    "buttons buttons";
            }
        }

        /* Vista de Móvil (hasta 768px) */
        @media (max-width: 768px) {
            body { 
                padding: 1.5rem;
            }
            .config-card {
                padding: 1.5rem;
            }
            .config-card form {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "ventana"
                    "cortina"
                    "postigon"
                    "clima_actual"
                    "pronostico"
                    "buttons";
            }
            .config-card h1 { font-size: 1.8rem; }
            .btn-submit, .btn-back { font-size: 1rem; padding: 0.8rem 1.5rem; width: 100%; }
            .content-block { padding: 1rem; }
            .content-block h2, .content-block h3 { font-size: 1.3rem; }
            .button-row {
                flex-direction: column;
                gap: 1rem; 
            }
            .days-checkbox-group {
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
            }
            .day-checkbox {
                flex: 0 0 calc(100% / 4 - 10px);
            }
<<<<<<< HEAD
            
            /* Ajustes dinámicos para móvil */
            .config-card.form-1-servo form,
            .config-card.form-2-servos form {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "ventana"
                    "clima_actual"
                    "pronostico"
                    "buttons";
            }
=======
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
        }

        /* Vista para Móviles Pequeños (hasta 480px) */
        @media (max-width: 480px) {
            body { padding: 0.5rem; }
            .config-card { padding: 1rem; }
            .config-card h1 { font-size: 1.6rem; }
            .content-block h2, .content-block h3 { font-size: 1.2rem; }
            .btn-submit, .btn-back { font-size: 0.9rem; }
            .day-checkbox {
                flex: 0 0 calc(100% / 3 - 10px);
            }
        }
    </style>
</head>
<body>
    <div class="config-card <?= $layout_class ?? '' ?>">
        <h1>Configurar Dispositivos Inteligentes</h1>
        
        <!-- Buscador de ubicaciones -->
        <div class="location-search-container">
            <div class="location-search">
                <input type="text" id="city-search" placeholder="Ver datos de clima de..." autocomplete="off">
                <button id="search-button" title="Buscar">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="search-suggestions" id="search-suggestions"></div>
        </div>
        
        <p>Control y configuración de los horarios y condicionantes para los dispositivos.</p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

<<<<<<< HEAD
        <form method="POST" action="<?= site_url('/configuracion/guardar') ?>" >
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

           <input type="hidden" name="dispositivo_id" value="<?= $dispositivo_id ?? '' ?>">

            <!-- Bloque Ventana -->
            <div class="content-block servo-block <?= !in_array('ventana', $servos_disponibles) ? 'hidden' : '' ?>" id="ventana_block">
=======
<<<<<<< HEAD
        <form method="POST" action="<?= site_url('/configuracion/guardar') ?>" >
=======
        <form method="POST" action="<?= site_url('configuracion/guardar') ?>" >
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
           <input type="hidden" name="dispositivo_id" value="<?= $dispositivo_id ?? '' ?>">

            <div class="content-block" id="ventana_block">
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                <h2>Horarios de <?= esc($servos['ventana']['nombre_servo'] ?? 'Ventana') ?></h2>
                <div class="form-group">
                    <label for="ventana_apertura">Apertura:</label>
                    <input type="time" id="ventana_apertura" name="open_hour_ventana" class="form-control-time" value="<?= esc($horarios['ventana']['apertura'] ?? '08:00') ?>">
                </div>
                <div class="form-group">
                    <label for="ventana_cierre">Cierre:</label>
                    <input type="time" id="ventana_cierre" name="close_hour_ventana" class="form-control-time" value="<?= esc($horarios['ventana']['cierre'] ?? '18:00') ?>">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                </div>
                
                <div class="form-group">
                    <label>Días activos para <?= esc($servos['ventana']['nombre_servo'] ?? 'Ventana') ?></label>
                    <div class="days-checkbox-group">
                        <?php
                        $diasVentana = $dias_servos['ventana'] ?? [];
                        foreach ($todos_dias as $dia) {
                            $checked = in_array($dia['ID'], $diasVentana) ? 'checked' : '';
                        ?>
                            <div class="day-checkbox">
                                <input type="checkbox" id="ventana_<?= $dia['ID'] ?>" name="ventana_days[]" value="<?= $dia['ID'] ?>" <?= $checked ?>>
                                <label for="ventana_<?= $dia['ID'] ?>"><?= substr($dia['DIA_semana'], 0, 1) ?></label>
                            </div>
                        <?php } ?>
                    </div>
<<<<<<< HEAD
                </div>
                
=======
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
                </div>
                
                <div class="form-group">
    <label>Días activos para <?= esc($servos['ventana']['nombre_servo'] ?? 'Ventana') ?></label>
    <div class="days-checkbox-group">
        <?php
        $diasVentana = $dias_servos['ventana'] ?? [];
        foreach ($todos_dias as $dia) {
            $checked = in_array($dia['ID'], $diasVentana) ? 'checked' : '';
        ?>
            <div class="day-checkbox">
                <input type="checkbox" id="ventana_<?= $dia['ID'] ?>" name="ventana_days[]" value="<?= $dia['ID'] ?>" <?= $checked ?>>
                <label for="ventana_<?= $dia['ID'] ?>"><?= substr($dia['DIA_semana'], 0, 1) ?></label>
            </div>
        <?php } ?>
    </div>
</div>
                
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                <h3>Condicionantes</h3>
                <div class="form-group">
                    <label for="min_temp_ventana">Temp. Mínima (°C):</label>
                    <input type="number" id="min_temp_ventana" name="min_temp_ventana" class="form-control-input" step="0.1" value="<?= esc($condicionantes['ventana']['temp_min'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="max_temp_ventana">Temp. Máxima (°C):</label>
                    <input type="number" id="max_temp_ventana" name="max_temp_ventana" class="form-control-input" step="0.1" value="<?= esc($condicionantes['ventana']['temp_max'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="max_wind_speed_ventana">Viento Máx. (m/s):</label>
                    <input type="number" id="max_wind_speed_ventana" name="max_wind_speed_ventana" class="form-control-input" step="0.1" value="<?= esc($condicionantes['ventana']['velocidad_viento_max'] ?? '') ?>">
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="allow_rain_ventana" name="allow_rain_ventana" value="1" <?= (isset($condicionantes['ventana']['permitir_lluvia']) && $condicionantes['ventana']['permitir_lluvia'] == 1) ? 'checked' : '' ?>>
                    <label for="allow_rain_ventana">Permitir con Lluvia</label>
                </div>
            </div>

<<<<<<< HEAD
            <!-- Bloque Cortina -->
            <div class="content-block servo-block <?= !in_array('cortina', $servos_disponibles) ? 'hidden' : '' ?>" id="cortina_block">
=======
            <div class="content-block" id="cortina_block">
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                <h2>Horarios de <?= esc($servos['cortina']['nombre_servo'] ?? 'Cortina') ?></h2>
                <div class="form-group">
                    <label for="cortina_apertura">Apertura:</label>
                    <input type="time" id="cortina_apertura" name="open_hour_cortina" class="form-control-time" value="<?= esc($horarios['cortina']['apertura'] ?? '07:00') ?>">
                </div>
                <div class="form-group">
                    <label for="cortina_cierre">Cierre:</label>
                    <input type="time" id="cortina_cierre" name="close_hour_cortina" class="form-control-time" value="<?= esc($horarios['cortina']['cierre'] ?? '20:00') ?>">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                </div>
                
                <div class="form-group">
                    <label>Días activos para <?= esc($servos['cortina']['nombre_servo'] ?? 'Cortina') ?></label>
                    <div class="days-checkbox-group">
                        <?php
                        $diasCortina = $dias_servos['cortina'] ?? [];
                        foreach ($todos_dias as $dia) {
                            $checked = in_array($dia['ID'], $diasCortina) ? 'checked' : '';
                        ?>
                            <div class="day-checkbox">
                                <input type="checkbox" id="cortina_<?= $dia['ID'] ?>" name="cortina_days[]" value="<?= $dia['ID'] ?>" <?= $checked ?>>
                                <label for="cortina_<?= $dia['ID'] ?>"><?= substr($dia['DIA_semana'], 0, 1) ?></label>
                            </div>
                        <?php } ?>
                    </div>
<<<<<<< HEAD
                </div>
                
=======
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
                </div>
                
                <div class="form-group">
    <label>Días activos para <?= esc($servos['cortina']['nombre_servo'] ?? 'Cortina') ?></label>
    <div class="days-checkbox-group">
        <?php
        $diasCortina = $dias_servos['cortina'] ?? [];
        foreach ($todos_dias as $dia) {
            $checked = in_array($dia['ID'], $diasCortina) ? 'checked' : '';
        ?>
            <div class="day-checkbox">
                <input type="checkbox" id="cortina_<?= $dia['ID'] ?>" name="cortina_days[]" value="<?= $dia['ID'] ?>" <?= $checked ?>>
                <label for="cortina_<?= $dia['ID'] ?>"><?= substr($dia['DIA_semana'], 0, 1) ?></label>
            </div>
        <?php } ?>
    </div>
</div>
                
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                <h3>Condicionantes</h3>
                <div class="form-group">
                    <label for="min_temp_cortina">Temp. Mínima (°C):</label>
                    <input type="number" id="min_temp_cortina" name="min_temp_cortina" class="form-control-input" step="0.1" value="<?= esc($condicionantes['cortina']['temp_min'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="max_temp_cortina">Temp. Máxima (°C):</label>
                    <input type="number" id="max_temp_cortina" name="max_temp_cortina" class="form-control-input" step="0.1" value="<?= esc($condicionantes['cortina']['temp_max'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="max_wind_speed_cortina">Viento Máx. (m/s):</label>
                    <input type="number" id="max_wind_speed_cortina" name="max_wind_speed_cortina" class="form-control-input" step="0.1" value="<?= esc($condicionantes['cortina']['velocidad_viento_max'] ?? '') ?>">
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="allow_rain_cortina" name="allow_rain_cortina" value="1" <?= (isset($condicionantes['cortina']['permitir_lluvia']) && $condicionantes['cortina']['permitir_lluvia'] == 1) ? 'checked' : '' ?>>
                    <label for="allow_rain_cortina">Permitir con Lluvia</label>
                </div>
            </div>

<<<<<<< HEAD
            <!-- Bloque Postigón -->
            <div class="content-block servo-block <?= !in_array('postigon', $servos_disponibles) ? 'hidden' : '' ?>" id="postigon_block">
=======
            <div class="content-block" id="postigon_block">
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                <h2>Horarios de <?= esc($servos['postigon']['nombre_servo'] ?? 'Postigón') ?></h2>
                <div class="form-group">
                    <label for="postigon_apertura">Apertura:</label>
                    <input type="time" id="postigon_apertura" name="open_hour_postigon" class="form-control-time" value="<?= esc($horarios['postigon']['apertura'] ?? '07:30') ?>">
                </div>
                <div class="form-group">
                    <label for="postigon_cierre">Cierre:</label>
                    <input type="time" id="postigon_cierre" name="close_hour_postigon" class="form-control-time" value="<?= esc($horarios['postigon']['cierre'] ?? '19:30') ?>">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                </div>
                
                <div class="form-group">
                    <label>Días activos para <?= esc($servos['postigon']['nombre_servo'] ?? 'Postigón') ?></label>
                    <div class="days-checkbox-group">
                        <?php
                        $diasPostigon = $dias_servos['postigon'] ?? [];
                        foreach ($todos_dias as $dia) {
                            $checked = in_array($dia['ID'], $diasPostigon) ? 'checked' : '';
                        ?>
                            <div class="day-checkbox">
                                <input type="checkbox" id="postigon_<?= $dia['ID'] ?>" name="postigon_days[]" value="<?= $dia['ID'] ?>" <?= $checked ?>>
                                <label for="postigon_<?= $dia['ID'] ?>"><?= substr($dia['DIA_semana'], 0, 1) ?></label>
                            </div>
                        <?php } ?>
                    </div>
<<<<<<< HEAD
                </div>
                
=======
=======
>>>>>>> 5713a74aeae9c8278a7179ddb883ccac5ba353c4
                </div>
                
                <div class="form-group">
    <label>Días activos para <?= esc($servos['postigon']['nombre_servo'] ?? 'Postigón') ?></label>
    <div class="days-checkbox-group">
        <?php
        $diasPostigon = $dias_servos['postigon'] ?? [];
        foreach ($todos_dias as $dia) {
            $checked = in_array($dia['ID'], $diasPostigon) ? 'checked' : '';
        ?>
            <div class="day-checkbox">
                <input type="checkbox" id="postigon_<?= $dia['ID'] ?>" name="postigon_days[]" value="<?= $dia['ID'] ?>" <?= $checked ?>>
                <label for="postigon_<?= $dia['ID'] ?>"><?= substr($dia['DIA_semana'], 0, 1) ?></label>
            </div>
        <?php } ?>
    </div>
</div>
                
>>>>>>> 3c34e82b0f649c57139357adfb0935563a96df95
                <h3>Condicionantes</h3>
                <div class="form-group">
                    <label for="min_temp_postigon">Temp. Mínima (°C):</label>
                    <input type="number" id="min_temp_postigon" name="min_temp_postigon" class="form-control-input" step="0.1" value="<?= esc($condicionantes['postigon']['temp_min'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="max_temp_postigon">Temp. Máxima (°C):</label>
                    <input type="number" id="max_temp_postigon" name="max_temp_postigon" class="form-control-input" step="0.1" value="<?= esc($condicionantes['postigon']['temp_max'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="max_wind_speed_postigon">Viento Máx. (m/s):</label>
                    <input type="number" id="max_wind_speed_postigon" name="max_wind_speed_postigon" class="form-control-input" step="0.1" value="<?= esc($condicionantes['postigon']['velocidad_viento_max'] ?? '') ?>">
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="allow_rain_postigon" name="allow_rain_postigon" value="1" <?= (isset($condicionantes['postigon']['permitir_lluvia']) && $condicionantes['postigon']['permitir_lluvia'] == 1) ? 'checked' : '' ?>>
                    <label for="allow_rain_postigon">Permitir con Lluvia</label>
                </div>
            </div>
            
            <div class="content-block" id="current_weather_block">
                <h2>Clima Actual</h2>
                <p id="weather_city_name">Río Tercero, Córdoba</p>
                <div class="weather-info">
                    <i class="fa-solid fa-temperature-three-quarters"></i>
                    <p>Temp: <span id="current_temp">--</span>°C</p>
                </div>
                <div class="weather-info">
                    <i class="fa-solid fa-wind"></i>
                    <p>Viento: <span id="current_wind">--</span> Km/h</p>
                </div>
                <div class="weather-info">
                    <i class="fa-solid fa-droplet"></i>
                    <p>Humedad: <span id="current_humidity">--</span>%</p>
                </div>
                <div class="weather-info">
                    <i class="fa-solid fa-cloud-showers-heavy"></i>
                    <p>Prob. Lluvia: <span id="pop">--</span>%</p>
                </div>
                <div class="weather-info">
                    <i class="fa-solid fa-cloud-sun"></i>
                    <p>Clima: <span id="current_weather_desc">--</span></p>
                </div>
            </div>
            
            <div class="content-block" id="hourly_forecast_block">
                <div id="weather_summary_container">
                    <p id="weather_summary"></p>
                </div>
                <div class="hourly-forecast-container">
                    <div class="hourly-forecast-grid" id="hourly_forecast_grid">
                        </div>
                </div>
            </div>
            
            <div class="button-row">
                <button type="submit" class="btn-submit">Guardar Configuración</button>
                <a href="<?= site_url("irainicio") ?>" class="btn-back">Volver al inicio</a>
            </div>

        </form>
    </div>

    <script>
        const APIKey = '0d132a7baaa02ea9cfc60077249f0254'; 
        let currentCity = localStorage.getItem('selectedCity') || 'Río Tercero,AR';
        const currentTemp = document.getElementById('current_temp');
        const currentHumidity = document.getElementById('current_humidity');
        const currentWind = document.getElementById('current_wind');
        const currentPoP = document.getElementById('pop');
        const currentWeatherDesc = document.getElementById('current_weather_desc');
        const weatherSummary = document.getElementById('weather_summary');
        const forecastGrid = document.getElementById('hourly_forecast_grid');
        const cityNameElement = document.getElementById('weather_city_name');
        const citySearchInput = document.getElementById('city-search');
        const searchButton = document.getElementById('search-button');
        const searchSuggestions = document.getElementById('search-suggestions');

        // Base de datos de ciudades de Córdoba con coordenadas aproximadas
        const cordobaCities = [
            // Departamento Capital
            {name: "Córdoba", department: "Capital", lat: -31.4201, lon: -64.1888},
            
            // Departamento Calamuchita
            {name: "Amboy", department: "Calamuchita", lat: -32.1750, lon: -64.5833},
            {name: "Calmayo", department: "Calamuchita", lat: -32.0500, lon: -64.5500},
            {name: "Cañada de los Sauces", department: "Calamuchita", lat: -32.05, lon: -64.65},
            {name: "Embalse", department: "Calamuchita", lat: -32.1833, lon: -64.4167},
            {name: "La Cumbrecita", department: "Calamuchita", lat: -31.9000, lon: -64.7833},
            {name: "La Cruz", department: "Calamuchita", lat: -32.3000, lon: -64.5000},
            {name: "La Lagunilla", department: "Calamuchita", lat: -32.55, lon: -64.55},
            {name: "Las Caleras", department: "Calamuchita", lat: -31.35, lon: -64.35},
            {name: "Las Rabonas", department: "Calamuchita", lat: -31.87, lon: -65.03},
            {name: "Los Reartes", department: "Calamuchita", lat: -31.9167, lon: -64.5833},
            {name: "Los Cóndores", department: "Calamuchita", lat: -32.32, lon: -64.28},
            {name: "Lutti", department: "Calamuchita", lat: -32.25, lon: -64.70},
            {name: "San Agustín", department: "Calamuchita", lat: -31.9833, lon: -64.3667},
            {name: "San Ignacio", department: "Calamuchita", lat: -32.17, lon: -64.52},
            {name: "San Roque", department: "Calamuchita", lat: -31.3667, lon: -64.4667},
            {name: "Santa Rosa de Calamuchita", department: "Calamuchita", lat: -32.0667, lon: -64.5500},
            {name: "Segunda Usina", department: "Calamuchita", lat: -32.03, lon: -64.50},
            {name: "Villa del Dique", department: "Calamuchita", lat: -32.1667, lon: -64.4500},
            {name: "Villa General Belgrano", department: "Calamuchita", lat: -31.9667, lon: -64.5667},
            {name: "Villa Rumipal", department: "Calamuchita", lat: -32.1833, lon: -64.4833},
            {name: "Villa Yacanto", department: "Calamuchita", lat: -32.1167, lon: -64.7667},
            
            // Departamento Colón
            {name: "Agua de Oro", department: "Colón", lat: -31.0667, lon: -64.3000},
            {name: "Colonia Caroya", department: "Colón", lat: -31.0167, lon: -64.0667},
            {name: "Colonia Tirolesa", department: "Colón", lat: -31.2333, lon: -64.0833},
            {name: "Cosquín", department: "Colón", lat: -31.2500, lon: -64.4667},
            {name: "Huerta Grande", department: "Colón", lat: -31.0833, lon: -64.4833},
            {name: "La Calera", department: "Colón", lat: -31.3500, lon: -64.3500},
            {name: "La Granja", department: "Colón", lat: -31.0167, lon: -64.2667},
            {name: "Jesús María", department: "Colón", lat: -30.9833, lon: -64.1000},
            {name: "Mendiolaza", department: "Colón", lat: -31.2667, lon: -64.3000},
            {name: "Río Ceballos", department: "Colón", lat: -31.1667, lon: -64.3167},
            {name: "Saldán", department: "Colón", lat: -31.3167, lon: -64.3000},
            {name: "Salsipuedes", department: "Colón", lat: -31.1333, lon: -64.3000},
            {name: "Unquillo", department: "Colón", lat: -31.2333, lon: -64.3167},
            {name: "Villa Allende", department: "Colón", lat: -31.3000, lon: -64.3000},
            
            // Departamento Punilla
            {name: "Bialet Massé", department: "Punilla", lat: -31.3167, lon: -64.4667},
            {name: "Capilla del Monte", department: "Punilla", lat: -30.8667, lon: -64.5333},
            {name: "Casa Grande", department: "Punilla", lat: -31.1667, lon: -64.4667},
            {name: "Charbonier", department: "Punilla", lat: -31.4167, lon: -64.5333},
            {name: "Cuesta Blanca", department: "Punilla", lat: -31.4833, lon: -64.5667},
            {name: "La Cumbre", department: "Punilla", lat: -30.9833, lon: -64.5000},
            {name: "La Falda", department: "Punilla", lat: -31.0833, lon: -64.5000},
            {name: "Los Cocos", department: "Punilla", lat: -30.9333, lon: -64.5000},
            {name: "San Antonio de Arredondo", department: "Punilla", lat: -31.4833, lon: -64.5833},
            {name: "San Esteban", department: "Punilla", lat: -31.4000, lon: -64.5167},
            {name: "Santa María de Punilla", department: "Punilla", lat: -31.2667, lon: -64.4667},
            {name: "Tala Huasi", department: "Punilla", lat: -31.1167, lon: -64.5000},
            {name: "Valle Hermoso", department: "Punilla", lat: -31.1167, lon: -64.4833},
            {name: "Villa Carlos Paz", department: "Punilla", lat: -31.4000, lon: -64.5167},
            {name: "Villa Giardino", department: "Punilla", lat: -31.0333, lon: -64.4833},
            
            // Departamento Santa María
            {name: "Alta Gracia", department: "Santa María", lat: -31.6667, lon: -64.4333},
            {name: "Anisacate", department: "Santa María", lat: -31.7167, lon: -64.4167},
            {name: "Bouwer", department: "Santa María", lat: -31.5500, lon: -64.1833},
            {name: "Despeñaderos", department: "Santa María", lat: -31.8167, lon: -64.3000},
            {name: "Falda del Carmen", department: "Santa María", lat: -31.5833, lon: -64.4500},
            {name: "La Bolsa", department: "Santa María", lat: -31.7167, lon: -64.3000},
            {name: "La Paisanita", department: "Santa María", lat: -31.6333, lon: -64.4333},
            {name: "La Rancherita", department: "Santa María", lat: -31.6833, lon: -64.4333},
            {name: "Los Aromos", department: "Santa María", lat: -31.6333, lon: -64.3000},
            {name: "Los Cedros", department: "Santa María", lat: -31.5667, lon: -64.3000},
            {name: "Lozada", department: "Santa María", lat: -31.6333, lon: -64.1333},
            {name: "Malagueño", department: "Santa María", lat: -31.4667, lon: -64.3500},
            {name: "Monte Ralo", department: "Santa María", lat: -31.9667, lon: -64.2667},
            {name: "Potrero de Garay", department: "Santa María", lat: -31.8167, lon: -64.5500},
            {name: "Rafael García", department: "Santa María", lat: -31.6667, lon: -64.2167},
            {name: "San Clemente", department: "Santa María", lat: -31.7167, lon: -64.6333},
            {name: "San Nicolás", department: "Santa María", lat: -31.5000, lon: -64.2333},
            {name: "Villa Ciudad de América", department: "Santa María", lat: -31.9833, lon: -64.5000},
            {name: "Villa del Prado", department: "Santa María", lat: -31.7333, lon: -64.4667},
            {name: "Villa La Bolsa", department: "Santa María", lat: -31.7167, lon: -64.3000},
            {name: "Villa Los Aromos", department: "Santa María", lat: -31.6333, lon: -64.3000},
            {name: "Villa Parque Santa Ana", department: "Santa María", lat: -31.5167, lon: -64.3167},
            {name: "Villa San Isidro", department: "Santa María", lat: -31.6333, lon: -64.3667},
            {name: "Villa Sierras de Oro", department: "Santa María", lat: -31.5667, lon: -64.2000},
            
            // Departamento Tercero Arriba
            {name: "Río Tercero", department: "Tercero Arriba", lat: -32.1833, lon: -64.1000},
            {name: "Tancacha", department: "Tercero Arriba", lat: -32.2333, lon: -63.9833},
            {name: "Las Perdices", department: "Tercero Arriba", lat: -32.7000, lon: -63.7000},
            {name: "Pampayasta", department: "Tercero Arriba", lat: -32.2833, lon: -63.6333},
            {name: "Villa Ascasubi", department: "Tercero Arriba", lat: -32.1667, lon: -63.8833},
            {name: "Villa del Rosario", department: "Tercero Arriba", lat: -31.5500, lon: -63.5333},
            
            // Otras localidades importantes
            {name: "Achiras", department: "Río Cuarto", lat: -33.1833, lon: -64.9833},
            {name: "Adelia María", department: "Río Cuarto", lat: -33.6333, lon: -64.0167},
            {name: "Alcira Gigena", department: "Río Cuarto", lat: -32.4000, lon: -64.3333},
            {name: "Alejandro Roca", department: "Juárez Celman", lat: -33.3500, lon: -63.7167},
            {name: "Arias", department: "Marcos Juárez", lat: -33.6333, lon: -62.4000},
            {name: "Arroyito", department: "San Justo", lat: -31.4167, lon: -63.0500},
            {name: "Bell Ville", department: "Unión", lat: -32.6167, lon: -62.6833},
            {name: "Berrotarán", department: "Río Cuarto", lat: -32.4500, lon: -64.3833},
            {name: "Brinkmann", department: "San Justo", lat: -30.8667, lon: -62.0333},
            {name: "Camilo Aldao", department: "Marcos Juárez", lat: -33.1333, lon: -62.1000},
            {name: "Canals", department: "Unión", lat: -33.5667, lon: -62.8833},
            {name: "Carnerillo", department: "Río Cuarto", lat: -32.9167, lon: -64.0167},
            {name: "Charras", department: "General Roca", lat: -33.0167, lon: -64.0333},
            {name: "Chazón", department: "Río Cuarto", lat: -33.0833, lon: -63.2833},
            {name: "Corral de Bustos", department: "Marcos Juárez", lat: -33.2833, lon: -62.2000},
            {name: "Cruz Alta", department: "Marcos Juárez", lat: -33.0167, lon: -61.8000},
            {name: "Dalmacio Vélez Sarsfield", department: "Río Cuarto", lat: -32.6167, lon: -63.5833},
            {name: "Etruria", department: "San Justo", lat: -32.9333, lon: -63.2500},
            {name: "General Baldissera", department: "Marcos Juárez", lat: -33.1167, lon: -62.3000},
            {name: "General Cabrera", department: "Río Cuarto", lat: -32.8167, lon: -63.8667},
            {name: "General Deheza", department: "Río Cuarto", lat: -32.7667, lon: -63.7833},
            {name: "Hernando", department: "Tercero Arriba", lat: -32.4333, lon: -63.7333},
            {name: "James Craik", department: "Tercero Arriba", lat: -32.1667, lon: -63.4667},
            {name: "Jovita", department: "General Roca", lat: -34.5000, lon: -63.9333},
            {name: "Laboulaye", department: "General Roca", lat: -34.1167, lon: -63.3833},
            {name: "Laguna Larga", department: "Río Segundo", lat: -31.7667, lon: -63.8000},
            {name: "Las Acequias", department: "Río Cuarto", lat: -33.2833, lon: -63.9833},
            {name: "Las Higueras", department: "Río Cuarto", lat: -33.1000, lon: -64.2833},
            {name: "Las Varas", department: "San Justo", lat: -31.8000, lon: -62.6167},
            {name: "Leones", department: "Marcos Juárez", lat: -32.6667, lon: -62.3000},
            {name: "Marcos Juárez", department: "Marcos Juárez", lat: -32.7000, lon: -62.1000},
            {name: "Mattaldi", department: "Río Cuarto", lat: -34.4833, lon: -64.1667},
            {name: "Morteros", department: "San Justo", lat: -30.7167, lon: -62.0000},
            {name: "Oliva", department: "Tercero Arriba", lat: -32.0500, lon: -63.5667},
            {name: "Pascanas", department: "Unión", lat: -33.2500, lon: -63.0333},
            {name: "Pilar", department: "Río Segundo", lat: -31.6833, lon: -63.8833},
            {name: "Río Segundo", department: "Río Segundo", lat: -31.6500, lon: -63.9167},
            {name: "Sacanta", department: "San Justo", lat: -31.6667, lon: -63.0500},
            {name: "San Francisco", department: "San Justo", lat: -31.4333, lon: -62.0833},
            {name: "Santa Eufemia", department: "General Roca", lat: -33.1667, lon: -63.2833},
            {name: "Saturnino María Laspiur", department: "San Justo", lat: -31.7000, lon: -62.4833},
            {name: "Sampacho", department: "Río Cuarto", lat: -33.3833, lon: -64.7167},
            {name: "Ticino", department: "General San Martín", lat: -32.7000, lon: -63.4333},
            {name: "Tío Pujio", department: "General San Martín", lat: -32.2833, lon: -63.3500},
            {name: "Ucacha", department: "Juárez Celman", lat: -33.0333, lon: -63.5163},
            {name: "Vicuña Mackenna", department: "Río Cuarto", lat: -33.9167, lon: -64.3833},
            {name: "Villa Huidobro", department: "General Roca", lat: -34.8333, lon: -64.5833},
            {name: "Villa María", department: "General San Martín", lat: -32.4167, lon: -63.2500},
            {name: "Villa Nueva", department: "General San Martín", lat: -32.4333, lon: -63.2333},
            {name: "Wenceslao Escalante", department: "Río Cuarto", lat: -33.1667, lon: -63.1833},

            // Localidades adicionales sugeridas (verificadas y agregadas)
            {name: "Almafuerte", department: "Tercero Arriba", lat: -32.1925, lon: -64.2556},
            {name: "Corralito", department: "Tercero Arriba", lat: -32.0236, lon: -64.1922},
            {name: "Río Cuarto", department: "Río Cuarto", lat: -33.1307, lon: -64.3499},
            {name: "Holmberg", department: "Río Cuarto", lat: -33.1167, lon: -64.4333},
            {name: "La Carolina", department: "Río Cuarto", lat: -32.9833, lon: -64.0000},
            {name: "Las Higueras", department: "Río Cuarto", lat: -33.1500, lon: -64.2833},
            {name: "James Craik", department: "Tercero Arriba", lat: -32.1667, lon: -63.4667},
            {name: "Hernando", department: "Tercero Arriba", lat: -32.4333, lon: -63.7333},
            {name: "Oliva", department: "Tercero Arriba", lat: -32.4333, lon: -62.7167},
            {name: "El Churcal", department: "Calamuchita", lat: -32.2000, lon: -64.5000},
            {name: "Mina Clavero", department: "San Alberto", lat: -31.7214, lon: -65.0062},
            {name: "Villa Cura Brochero", department: "San Alberto", lat: -31.7058, lon: -65.0179},
            {name: "Villa de Soto", department: "Punilla", lat: -30.8000, lon: -64.3167},
            {name: "Villa del Totoral", department: "Totoral", lat: -30.8167, lon: -63.7167},
            {name: "José de la Quintana", department: "Santa María", lat: -31.3000, lon: -64.2000},
            {name: "Malvinas Argentinas", department: "Capital", lat: -31.4333, lon: -64.4667},
            {name: "Sinsacate", department: "Totoral", lat: -30.9500, lon: -64.0833},
            {name: "Cruz del Eje", department: "Cruz del Eje", lat: -30.7264, lon: -64.8039},
            {name: "Deán Funes", department: "Ischilín", lat: -30.4242, lon: -64.3498},
            {name: "La Carlota", department: "Juárez Celman", lat: -33.4198, lon: -63.2977},
            {name: "La Para", department: "Río Primero", lat: -31.8833, lon: -63.0000},
            {name: "Oncativo", department: "Río Segundo", lat: -31.9135, lon: -63.6819},
            {name: "Villa de las Rosas", department: "San Javier", lat: -31.9500, lon: -65.0500},
            {name: "Villa General Belgrano", department: "Calamuchita", lat: -31.9667, lon: -64.5667}, // Ya estaba, pero confirmado
            {name: "Villa Sarmiento", department: "Río Cuarto", lat: -33.0167, lon: -64.2667},
            {name: "Villa del Rosario", department: "Río Segundo", lat: -31.5500, lon: -63.5333}, // Corregido departamento a Río Segundo (era Tercero Arriba en original, pero es Río Segundo)
            {name: "Tío Pujio", department: "General San Martín", lat: -32.2833, lon: -63.3500} // Confirmado en General San Martín
        ];

        // Función para mostrar sugerencias de búsqueda
        function showSuggestions(input) {
            searchSuggestions.innerHTML = '';
            
            if (input.length < 2) {
                searchSuggestions.classList.remove('active');
                return;
            }
            
            const filteredCities = cordobaCities.filter(city => 
                city.name.toLowerCase().includes(input.toLowerCase())
            );
            
            if (filteredCities.length > 0) {
                searchSuggestions.classList.add('active');
                
                filteredCities.forEach(city => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'suggestion-item';
                    suggestionItem.innerHTML = `
                        <span class="city-name">${city.name}</span>
                        <span class="province-name">${city.department}</span>
                    `;
                    
                    suggestionItem.addEventListener('click', () => {
                        citySearchInput.value = city.name;
                        searchSuggestions.classList.remove('active');
                        searchCity(city.name);
                    });
                    
                    searchSuggestions.appendChild(suggestionItem);
                });
            } else {
                searchSuggestions.classList.remove('active');
            }
        }

        // Función para buscar una ciudad
        function searchCity(cityName) {
            const city = cordobaCities.find(c => c.name.toLowerCase() === cityName.toLowerCase());
            if (city) {
                const searchQuery = `${city.name},AR`;
                currentCity = searchQuery;
                localStorage.setItem('selectedCity', searchQuery);
                cityNameElement.textContent = city.name;
                getWeatherData(city);
            }
        }

        // Función para obtener datos meteorológicos
        async function getWeatherData(city = null) {
            showLoadingState();
            if (APIKey === 'TU_API_KEY_AQUI' || APIKey.length < 32) {
                showErrorState('API Key no configurada.');
                return;
            }
            try {
                let lat, lon, cityName;
                
                // Si se proporciona un objeto ciudad con coordenadas, usarlas directamente
                if (city && city.lat && city.lon) {
                    lat = city.lat;
                    lon = city.lon;
                    cityName = city.name;
                } else {
                    // Obtener coordenadas de la ciudad por nombre
                    const geoUrl = `https://api.openweathermap.org/geo/1.0/direct?q=${currentCity}&limit=1&appid=${APIKey}`;
                    const geoResponse = await fetch(geoUrl);
                    const geoData = await geoResponse.json();
                    
                    if (geoData.length === 0) {
                        // Si no se encuentra la ciudad, buscar una alternativa cercana
                        const fallbackCity = findFallbackCity(currentCity);
                        if (fallbackCity) {
                            return getWeatherData(fallbackCity);
                        }
                        throw new Error('Ciudad no encontrada');
                    }
                    
                    lat = geoData[0].lat;
                    lon = geoData[0].lon;
                    cityName = geoData[0].name;
                }
                
                // Obtener clima actual y pronóstico
                const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${APIKey}`;
                const oneCallUrl = `https://api.openweathermap.org/data/3.0/onecall?lat=${lat}&lon=${lon}&exclude=minutely,daily,alerts&units=metric&appid=${APIKey}&lang=es`;
                
                const [weatherResponse, oneCallResponse] = await Promise.all([
                    fetch(weatherUrl),
                    fetch(oneCallUrl)
                ]);
                
                // Verificar si las respuestas son exitosas
                if (!weatherResponse.ok || !oneCallResponse.ok) {
                    throw new Error('Error en la respuesta de la API');
                }
                
                const weatherData = await weatherResponse.json();
                const oneCallData = await oneCallResponse.json();
                
                // Actualizar UI con datos del clima
                updateWeatherUI(weatherData, oneCallData, cityName);
                
            } catch (error) {
                console.error('Error al obtener datos meteorológicos:', error);
                showErrorState('Error de conexión');
            }
        }

        // Función para encontrar una ciudad alternativa cercana
        function findFallbackCity(cityName) {
            const city = cordobaCities.find(c => c.name.toLowerCase() === cityName.split(',')[0].toLowerCase());
            
            if (city && city.lat && city.lon) {
                return city;
            }
            
            // Si no tiene coordenadas, buscar la ciudad más cercana en la misma región
            const department = city?.department || '';
            const alternativeCity = cordobaCities.find(c => 
                c.department === department && c.lat && c.lon
            );
            
            return alternativeCity || {name: "Córdoba", lat: -31.4201, lon: -64.1888};
        }

        // Función para mostrar interfaz de error
        function showErrorState(message = 'Error') {
            currentTemp.textContent = '--';
            currentHumidity.textContent = '--';
            currentWind.textContent = '--';
            currentPoP.textContent = '--';
            currentWeatherDesc.textContent = message;
            weatherSummary.textContent = 'Error al cargar los datos meteorológicos';
            forecastGrid.innerHTML = '';
        }

        // Función para mostrar estado de carga
        function showLoadingState() {
            currentTemp.textContent = '--';
            currentHumidity.textContent = '--';
            currentWind.textContent = '--';
            currentPoP.textContent = '--';
            currentWeatherDesc.textContent = 'Cargando...';
            weatherSummary.textContent = '';
            forecastGrid.innerHTML = '';
        }

        // Función para actualizar la UI con datos meteorológicos
        function updateWeatherUI(weatherData, oneCallData, cityName = null) {
            if (cityName) {
                cityNameElement.textContent = cityName;
            }
            
            // Actualizar clima actual
            currentTemp.textContent = Math.round(weatherData.main.temp);
            currentHumidity.textContent = weatherData.main.humidity;
            currentWind.textContent = Math.round(weatherData.wind.speed * 3.6); // Convertir m/s a km/h
            currentPoP.textContent = oneCallData.hourly && oneCallData.hourly[0] ? Math.round(oneCallData.hourly[0].pop * 100) : 0;
            currentWeatherDesc.textContent = weatherData.weather[0].description;
            
            // Obtener la hora actual
            const now = new Date();
            const currentHour = now.getHours();
            
            // Obtener datos de las próximas 12 horas
            const hourlyData = oneCallData.hourly;
            const next12Hours = hourlyData.slice(0, 12);
            
            // Calcular temperaturas mínima y máxima para las próximas 12 horas
            const temps = next12Hours.map(h => h.temp);
            const minTemp = Math.min(...temps);
            const maxTemp = Math.max(...temps);
            
            forecastGrid.innerHTML = '';
            
            // Mostrar las próximas 12 horas
            next12Hours.forEach((hour, index) => {
                // Calcular la hora correspondiente
                const hourIndex = (currentHour + index) % 24;
                const hourFormatted = formatHour(hourIndex);
                
                const iconClass = getWeatherIcon(hour.weather[0].icon);
                const iconColorClass = getWeatherIconColor(hour.weather[0].icon);
                
                const forecastItem = document.createElement('div');
                forecastItem.className = 'hourly-forecast-item';
                forecastItem.innerHTML = `
                    <div class="hourly-time">${hourFormatted}</div>
                    <div class="hourly-icon"><i class="${iconClass} ${iconColorClass}"></i></div>
                    <div class="hourly-temp">${Math.round(hour.temp)}°</div>
                    <div class="hourly-pop"><i class="fas fa-umbrella"></i> ${Math.round(hour.pop * 100)}%</div>
                `;
                forecastGrid.appendChild(forecastItem);
            });
            
            // Actualizar resumen del clima
            const summary = `Pronóstico para las próximas 12 horas en ${cityNameElement.textContent}: Temperaturas entre ${Math.round(minTemp)}°C y ${Math.round(maxTemp)}°C.`;
            weatherSummary.textContent = summary;
        }

        // Función para mapear iconos de OpenWeatherMap a FontAwesome
        function getWeatherIcon(iconCode) {
            const dayNightCode = iconCode.slice(0, 2);
            switch (dayNightCode) {
                case '01': return 'fas fa-sun';
                case '02': return 'fas fa-cloud-sun';
                case '03': return 'fas fa-cloud';
                case '04': return 'fas fa-cloud';
                case '09': return 'fas fa-cloud-showers-heavy';
                case '10': return 'fas fa-cloud-sun-rain';
                case '11': return 'fas fa-bolt';
                case '13': return 'fas fa-snowflake';
                case '50': return 'fas fa-smog';
                default: return 'fas fa-cloud';
            }
        }

        // Función para obtener la clase de color del icono
        function getWeatherIconColor(iconCode) {
            const dayNightCode = iconCode.slice(0, 2);
            switch (dayNightCode) {
                case '01': return 'icon-sun';
                case '02': return 'icon-cloud-sun';
                case '03': return 'icon-cloud';
                case '04': return 'icon-cloud';
                case '09': return 'icon-rain';
                case '10': return 'icon-rain';
                case '11': return 'icon-storm';
                case '13': return 'icon-snow';
                case '50': return 'icon-fog';
                default: return 'icon-cloud';
            }
        }

        // Función para formatear la hora
        function formatHour(hour) {
            return (hour < 10 ? "0" + hour : hour) + ":00";
        }

        // Inicializar la aplicación
        document.addEventListener('DOMContentLoaded', () => {
            // Cargar ciudad guardada o usar Río Tercero por defecto
            const savedCity = localStorage.getItem('selectedCity');
            if (savedCity) {
                currentCity = savedCity;
                cityNameElement.textContent = savedCity.split(',')[0];
                
                // Buscar la ciudad en nuestra base de datos para obtener coordenadas si es necesario
                const city = cordobaCities.find(c => c.name.toLowerCase() === savedCity.split(',')[0].toLowerCase());
                getWeatherData(city || null);
            } else {
                getWeatherData();
            }
            
            // Event listeners para el buscador
            citySearchInput.addEventListener('input', () => {
                showSuggestions(citySearchInput.value);
            });
            
            searchButton.addEventListener('click', () => {
                if (citySearchInput.value.trim()) {
                    searchCity(citySearchInput.value.trim());
                }
            });
            
            citySearchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && citySearchInput.value.trim()) {
                    e.preventDefault();
                    searchCity(citySearchInput.value.trim());
                }
            });
            
            // Cerrar sugerencias al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!citySearchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                    searchSuggestions.classList.remove('active');
                }
            });
            
            // Actualizar cada 10 minutos
            setInterval(() => {
                const city = cordobaCities.find(c => c.name.toLowerCase() === currentCity.split(',')[0].toLowerCase());
                getWeatherData(city || null);
            }, 600000);
        });
    </script>
</body>
</html>