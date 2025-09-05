<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Configurar Dispositivos Inteligentes</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES Y ESTILOS GLOBALES --- */
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
        "alerts"
        "description"
        "form-content";
        /* --- LÍNEAS AÑADIDAS PARA CORREGIR EL BUG DE RENDERIZADO --- */
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
    <div class="config-card">
        <h1>Configurar Dispositivos Inteligentes</h1>
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

        <form method="POST" action="<?= site_url('configuracion/guardar') ?>" >
           <input type="hidden" name="dispositivo_id" value="<?= $dispositivo_id ?? '' ?>">

            <div class="content-block" id="ventana_block">
                <h2>Horarios de Ventana</h2>
                <div class="form-group">
                    <label for="ventana_apertura">Apertura:</label>
                    <input type="time" id="ventana_apertura" name="open_hour_ventana" class="form-control-time" value="<?= esc($horarios['ventana']['apertura'] ?? '08:00') ?>">
                </div>
                <div class="form-group">
                    <label for="ventana_cierre">Cierre:</label>
                    <input type="time" id="ventana_cierre" name="close_hour_ventana" class="form-control-time" value="<?= esc($horarios['ventana']['cierre'] ?? '18:00') ?>">
                </div>
                
                <div class="form-group">
    <label>Días activos para Ventana</label>
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

            <div class="content-block" id="cortina_block">
                <h2>Horarios de Cortina</h2>
                <div class="form-group">
                    <label for="cortina_apertura">Apertura:</label>
                    <input type="time" id="cortina_apertura" name="open_hour_cortina" class="form-control-time" value="<?= esc($horarios['cortina']['apertura'] ?? '07:00') ?>">
                </div>
                <div class="form-group">
                    <label for="cortina_cierre">Cierre:</label>
                    <input type="time" id="cortina_cierre" name="close_hour_cortina" class="form-control-time" value="<?= esc($horarios['cortina']['cierre'] ?? '20:00') ?>">
                </div>
                
                <div class="form-group">
    <label>Días activos para Cortina</label>
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

            <div class="content-block" id="postigon_block">
                <h2>Horarios de Postigón</h2>
                <div class="form-group">
                    <label for="postigon_apertura">Apertura:</label>
                    <input type="time" id="postigon_apertura" name="open_hour_postigon" class="form-control-time" value="<?= esc($horarios['postigon']['apertura'] ?? '07:30') ?>">
                </div>
                <div class="form-group">
                    <label for="postigon_cierre">Cierre:</label>
                    <input type="time" id="postigon_cierre" name="close_hour_postigon" class="form-control-time" value="<?= esc($horarios['postigon']['cierre'] ?? '19:30') ?>">
                </div>
                
                <div class="form-group">
    <label>Días activos para Postigón</label>
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
                <p id="weather_city_name">Río Tercero,AR</p>
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
        const city = 'Rio Tercero,AR';
        const currentTemp = document.getElementById('current_temp');
        const currentHumidity = document.getElementById('current_humidity');
        const currentWind = document.getElementById('current_wind');
        const currentPoP = document.getElementById('pop');
        const currentWeatherDesc = document.getElementById('current_weather_desc');
        const weatherSummary = document.getElementById('weather_summary');
        const forecastGrid = document.getElementById('hourly_forecast_grid');
        const cityNameElement = document.getElementById('weather_city_name');

        function getWeatherIcon(weatherCode) {
            const dayNightCode = weatherCode.slice(0, 2);
            switch (dayNightCode) {
                case '01': return 'fa-solid fa-sun';
                case '02': return 'fa-solid fa-cloud-sun';
                case '03': return 'fa-solid fa-cloud';
                case '04': return 'fa-solid fa-cloud';
                case '09': return 'fa-solid fa-cloud-showers-heavy';
                case '10': return 'fa-solid fa-cloud-sun-rain';
                case '11': return 'fa-solid fa-bolt';
                case '13': return 'fa-solid fa-snowflake';
                case '50': return 'fa-solid fa-smog';
                default: return 'fa-solid fa-cloud';
            }
        }
        function getWeatherIconColor(weatherCode) {
            const dayNightCode = weatherCode.slice(0, 2);
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
        function showLoadingState() {
            currentTemp.textContent = '--';
            currentHumidity.textContent = '--';
            currentWind.textContent = '--';
            currentPoP.textContent = '--';
            currentWeatherDesc.textContent = 'Cargando...';
            weatherSummary.textContent = '';
            forecastGrid.innerHTML = '';
        }
        function showErrorState(message = 'Error') {
            currentTemp.textContent = '--';
            currentHumidity.textContent = '--';
            currentWind.textContent = '--';
            currentPoP.textContent = '--';
            currentWeatherDesc.textContent = message;
            weatherSummary.textContent = 'Error al cargar los datos meteorológicos';
            forecastGrid.innerHTML = '';
        }
        function formatHour(hour) {
            return (hour < 10 ? "0" + hour : hour) + ":00";
        }
        function normalizeTemperature(temp, min, max) {
            const range = max - min;
            const normalized = range === 0 ? 0.5 : (temp - min) / range;
            return (1 - normalized) * 100;
        }
        async function updateWeather() {
            showLoadingState();
            if (APIKey === 'TU_API_KEY_AQUI' || APIKey.length < 32) {
                showErrorState('API Key no configurada.');
                return;
            }
            try {
                const geoResponse = await fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${city}&limit=1&appid=${APIKey}`);
                const geoData = await geoResponse.json();
                if (!geoData || geoData.length === 0) {
                    showErrorState('Ubicación no encontrada.');
                    return;
                }
                const { lat, lon } = geoData[0];
                cityNameElement.textContent = `${geoData[0].name},${geoData[0].country}`;
                const weatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${APIKey}&lang=es`);
                const weatherData = await weatherResponse.json();
                const oneCallResponse = await fetch(`https://api.openweathermap.org/data/3.0/onecall?lat=${lat}&lon=${lon}&exclude=minutely,daily,alerts&units=metric&appid=${APIKey}&lang=es`);
                const oneCallData = await oneCallResponse.json();
                if (weatherData.cod !== 200 || oneCallData.cod === '400') {
                    showErrorState('Error en datos meteorológicos.');
                    return;
                }
                currentTemp.textContent = Math.round(weatherData.main.temp);
                currentHumidity.textContent = weatherData.main.humidity;
                currentWind.textContent = Math.round(weatherData.wind.speed * 3.6);
                currentPoP.textContent = oneCallData.hourly && oneCallData.hourly[0] ? Math.round(oneCallData.hourly[0].pop * 100) : 0;
                currentWeatherDesc.textContent = weatherData.weather[0].description;
                const hourlyData = oneCallData.hourly.slice(0, 24);
                const temps = hourlyData.map(h => h.temp);
                const minTemp = Math.min(...temps);
                const maxTemp = Math.max(...temps);
                const currentHour = new Date().getHours();
                const next24Hours = hourlyData.slice(0, 24);
                forecastGrid.innerHTML = '';
                next24Hours.forEach((hour, index) => {
                    const hourIndex = (currentHour + index) % 24;
                    const hourFormatted = formatHour(hourIndex);
                    const iconClass = getWeatherIcon(hour.weather[0].icon);
                    const iconColorClass = getWeatherIconColor(hour.weather[0].icon);
                    const normalizedHeight = normalizeTemperature(hour.temp, minTemp, maxTemp);
                    const forecastItem = document.createElement('div');
                    forecastItem.className = 'hourly-forecast-item';
                    forecastItem.innerHTML = `
                        <div class="hourly-time">${hourFormatted}</div>
                        <div class="hourly-icon ${iconColorClass}"><i class="${iconClass}"></i></div>
                        <div class="hourly-temp">${Math.round(hour.temp)}°</div>
                        <div class="hourly-pop"><i class="fa-solid fa-umbrella"></i> ${Math.round(hour.pop * 100)}%</div>
                    `;
                    forecastGrid.appendChild(forecastItem);
                });
                const summary = `Pronóstico para las próximas 24 horas: Temperaturas entre ${Math.round(minTemp)}°C y ${Math.round(maxTemp)}°C.`;
                weatherSummary.textContent = summary;
            } catch (error) {
                console.error('Error al obtener datos meteorológicos:', error);
                showErrorState('Error de conexión');
            }
        }
        updateWeather();
        setInterval(updateWeather, 600000);
    </script>
</body>
</html>