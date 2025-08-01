<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Dispositivos Inteligentes</title>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe; --secondary-color: #4facfe; --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85); --text-primary: #ffffff; --text-secondary: #8892b0;
            --accent-color: #64ffda; --danger-color: #ff4d4d; --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
            --button-bg: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            --button-hover-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
            --close-button-bg: #ff4d4d;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        body { background-color: var(--dark-bg); color: var(--text-primary); min-height: 100vh; display: flex; justify-content: center; align-items: flex-start; padding: 2rem; }
        .config-card {
            background: var(--card-bg); padding: 2.5rem; border-radius: 20px;
            border: 1px solid rgba(100, 255, 218, 0.1); backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%; max-width: 1280px;
            animation: fadeIn 0.8s ease-out; text-align: center;

            /* Usamos Grid para la estructura principal del card */
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columnas de igual ancho */
            gap: 1.5rem; /* Espacio entre los elementos del grid */
            
            /* MODIFICACIÓN AQUÍ: Se eliminó el bloque de Condicionantes Generales */
            grid-template-areas:
                "header header header header"
                "description description description description"
                "ventana cortina postigon clima_actual" /* Horarios y Clima Actual en una fila */
                "pronostico pronostico pronostico pronostico" /* Pronóstico en una fila completa */
                "buttons buttons buttons buttons";
        }
        .config-card h1 {
            font-family: 'Orbitron', sans-serif; color: var(--primary-color);
            font-size: 2rem; margin-bottom: 0;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.3);
            grid-area: header;
        }
        .config-card p {
            grid-area: description;
            margin-bottom: 0;
            color: var(--text-secondary);
        }

        /* Estilo general para todos los bloques de contenido */
        .content-block {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--input-border);
            text-align: left;
        }
        .content-block h2, .content-block h3 {
            font-family: 'Orbitron', sans-serif;
            color: var(--accent-color);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 0 8px rgba(100, 255, 218, 0.2);
        }
        .content-block h3 { font-size: 1.3rem; }

        /* Asignación de áreas de Grid */
        #hourly_forecast_block { grid-area: pronostico; }
        #ventana_block { grid-area: ventana; }
        #cortina_block { grid-area: cortina; }
        #postigon_block { grid-area: postigon; }
        #current_weather_block { grid-area: clima_actual; }
        .button-row { grid-area: buttons; }

        /* Estilos de elementos internos */
        .form-group { margin-bottom: 1.5rem; text-align: left; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-weight: 500; font-size: 0.95rem; }
        .form-control-time, .form-control-input {
            background: rgba(255, 255, 255, 0.05); border: 1px solid var(--input-border);
            color: var(--text-primary); border-radius: 10px; padding: 0.8rem 1rem;
            width: 100%; font-size: 1rem; appearance: none; -webkit-appearance: none;
        }
        .form-control-time:focus, .form-control-input:focus {
            background: rgba(255, 255, 255, 0.1); border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25); outline: none;
        }
        .form-control-time::-webkit-calendar-picker-indicator { filter: invert(1); }
        
        .checkbox-group { display: flex; align-items: center; margin-top: 5px; }
        .checkbox-group label { margin-bottom: 0; margin-left: 5px; }

        .weather-detail { margin-bottom: 0.5rem; font-size: 0.95rem; }
        .weather-detail strong { color: var(--accent-color); }
        .weather-icon { font-size: 2rem; margin-right: 10px; vertical-align: middle; }

        .forecast-items { display: flex; overflow-x: auto; padding-bottom: 10px; gap: 1rem; }
        .forecast-item {
            flex: 0 0 auto;
            background: rgba(255, 255, 255, 0.05); border: 1px solid var(--input-border);
            border-radius: 10px; padding: 10px 15px; text-align: center;
            min-width: 100px;
        }
        .forecast-item div { font-size: 0.9rem; margin-bottom: 3px; }
        .forecast-item .hour { font-weight: bold; color: var(--accent-color); }
        .forecast-item .temp { font-size: 1.1rem; color: var(--text-primary); }
        .forecast-item .desc { font-size: 0.8rem; color: var(--text-secondary); }

        /* Botones de acción */
        .button-row {
            margin-top: 0;
            width: 100%; text-align: center;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        .btn-submit, .btn-back {
            padding: 0.8rem 2rem; font-size: 1.1rem; font-weight: 500;
            border-radius: 50px; border: none; cursor: pointer; transition: all 0.3s ease;
            display: inline-block; text-decoration: none;
        }
        .btn-submit { background: var(--button-bg); color: var(--dark-bg); box-shadow: 0 5px 15px rgba(0, 242, 254, 0.2); }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: var(--button-hover-shadow); }
        .btn-back { background: rgba(255, 255, 255, 0.1); color: var(--text-primary); border: 1px solid var(--input-border); }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1); }
        
        /* Mensajes de Alerta/Éxito */
        .alert, .success {
            background: rgba(255, 77, 77, 0.2); border: 1px solid var(--danger-color); color: var(--danger-color);
            padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;
            grid-column: 1 / -1;
            width: auto;
        }
        .success { background: rgba(0, 255, 157, 0.2); border: 1px solid var(--success-color); color: var(--success-color); }
        
        /* Animación */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Media Queries para Responsividad */
        @media (max-width: 1200px) { /* Para pantallas más pequeñas, apilar en 2 columnas */
            .config-card {
                grid-template-columns: repeat(2, 1fr);
                grid-template-areas:
                    "header header"
                    "description description"
                    "ventana cortina"
                    "postigon clima_actual"
                    "pronostico pronostico"
                    "buttons buttons";
            }
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .config-card {
                padding: 1.5rem; max-width: 95%;
                grid-template-columns: 1fr; /* Una sola columna para todo */
                grid-template-areas:
                    "header"
                    "description"
                    "ventana"
                    "cortina"
                    "postigon"
                    "clima_actual"
                    "pronostico"
                    "buttons";
            }
            .config-card h1 { font-size: 1.8rem; }
            .btn-submit, .btn-back { font-size: 1rem; padding: 0.7rem 1.5rem; }
            .content-block h2, .content-block h3 { font-size: 1.3rem; }
            .content-block { padding: 1rem; }
            .button-row { flex-direction: column; gap: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="config-card">
        <h1>Configurar Dispositivos Inteligentes</h1>
        <p>Control y configuración de los horarios y condicionantes para los dispositivos.</p>

        <?php /*
        if (isset($error)): ?>
            <div class="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if (isset($mensaje)): ?>
            <div class="success">
                <?= $mensaje ?>
            </div>
        <?php endif; */?>

        <form action="/savesettings" method="POST" style="display: contents;">
            <input type="hidden" name="idhorario" value="">
            <input type="hidden" name="diseno_id" value="">
            
            <div class="content-block" id="ventana_block">
                <h2>Horarios de Ventana</h2>
                <div class="form-group">
                    <label for="ventana_apertura">Apertura:</label>
                    <input type="time" id="ventana_apertura" name="open_hour_ventana" class="form-control-time" value="08:00">
                </div>
                <div class="form-group">
                    <label for="ventana_cierre">Cierre:</label>
                    <input type="time" id="ventana_cierre" name="close_hour_ventana" class="form-control-time" value="18:00">
                </div>
                
                <h3>Condicionantes</h3>
                <div class="form-group">
                    <label for="min_temp_ventana">Temp. Mínima (°C):</label>
                    <input type="number" id="min_temp_ventana" name="min_temp_ventana" class="form-control-input" step="0.1" value="10.0">
                </div>
                <div class="form-group">
                    <label for="max_temp_ventana">Temp. Máxima (°C):</label>
                    <input type="number" id="max_temp_ventana" name="max_temp_ventana" class="form-control-input" step="0.1" value="30.0">
                </div>
                <div class="form-group">
                    <label for="max_wind_speed_ventana">Viento Máx. (m/s):</label>
                    <input type="number" id="max_wind_speed_ventana" name="max_wind_speed_ventana" class="form-control-input" step="0.1" value="20.0">
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="allow_rain_ventana" name="allow_rain_ventana" value="1">
                    <label for="allow_rain_ventana">Permitir con Lluvia</label>
                </div>
            </div>

            <div class="content-block" id="cortina_block">
                <h2>Horarios de Cortina</h2>
                <div class="form-group">
                    <label for="cortina_apertura">Apertura:</label>
                    <input type="time" id="cortina_apertura" name="open_hour_cortina" class="form-control-time" value="07:00">
                </div>
                <div class="form-group">
                    <label for="cortina_cierre">Cierre:</label>
                    <input type="time" id="cortina_cierre" name="close_hour_cortina" class="form-control-time" value="20:00">
                </div>
                
                <h3>Condicionantes</h3>
                <div class="form-group">
                    <label for="min_temp_cortina">Temp. Mínima (°C):</label>
                    <input type="number" id="min_temp_cortina" name="min_temp_cortina" class="form-control-input" step="0.1" value="10.0">
                </div>
                <div class="form-group">
                    <label for="max_temp_cortina">Temp. Máxima (°C):</label>
                    <input type="number" id="max_temp_cortina" name="max_temp_cortina" class="form-control-input" step="0.1" value="30.0">
                </div>
                <div class="form-group">
                    <label for="max_wind_speed_cortina">Viento Máx. (m/s):</label>
                    <input type="number" id="max_wind_speed_cortina" name="max_wind_speed_cortina" class="form-control-input" step="0.1" value="20.0">
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="allow_rain_cortina" name="allow_rain_cortina" value="1">
                    <label for="allow_rain_cortina">Permitir con Lluvia</label>
                </div>
            </div>

            <div class="content-block" id="postigon_block">
                <h2>Horarios de Postigón</h2>
                <div class="form-group">
                    <label for="postigon_apertura">Apertura:</label>
                    <input type="time" id="postigon_apertura" name="open_hour_postigon" class="form-control-time" value="07:30">
                </div>
                <div class="form-group">
                    <label for="postigon_cierre">Cierre:</label>
                    <input type="time" id="postigon_cierre" name="close_hour_postigon" class="form-control-time" value="19:30">
                </div>
                
                <h3>Condicionantes</h3>
                <div class="form-group">
                    <label for="min_temp_postigon">Temp. Mínima (°C):</label>
                    <input type="number" id="min_temp_postigon" name="min_temp_postigon" class="form-control-input" step="0.1" value="10.0">
                </div>
                <div class="form-group">
                    <label for="max_temp_postigon">Temp. Máxima (°C):</label>
                    <input type="number" id="max_temp_postigon" name="max_temp_postigon" class="form-control-input" step="0.1" value="30.0">
                </div>
                <div class="form-group">
                    <label for="max_wind_speed_postigon">Viento Máx. (m/s):</label>
                    <input type="number" id="max_wind_speed_postigon" name="max_wind_speed_postigon" class="form-control-input" step="0.1" value="20.0">
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="allow_rain_postigon" name="allow_rain_postigon" value="1">
                    <label for="allow_rain_postigon">Permitir con Lluvia</label>
                </div>
            </div>

            <div class="content-block" id="current_weather_block">
                <h2>Clima Actual</h2>
                <div class="form-group">
                    <label for="city_setting">Ciudad del Clima:</label>
                    <input type="text" id="city_setting" name="city" class="form-control-input" value="Rio Tercero,AR">
                </div>
                <div class="weather-detail"><i class="fas fa-thermometer-half weather-icon"></i> <strong>Temp:</strong> <span id="current_temp">--</span>°C</div>
                <div class="weather-detail"><i class="fas fa-wind weather-icon"></i> <strong>Viento:</strong> <span id="current_wind">--</span> m/s</div>
                <div class="weather-detail"><i class="fas fa-tint weather-icon"></i> <strong>Humedad:</strong> <span id="current_humidity">--</span>%</div>
                <div class="weather-detail"><i class="fas fa-cloud-sun weather-icon"></i> <strong>Clima:</strong> <span id="current_weather_desc">--</span></div>
                <div class="weather-detail"><i class="fas fa-clock weather-icon"></i> <strong>Últ. Actualización:</strong> <span id="last_update">-- min.</span></div>
                <div class="weather-detail"><i class="fas fa-city weather-icon"></i> <strong>Ciudad:</strong> <span id="current_city">--</span></div>
            </div>

            <div class="content-block" id="hourly_forecast_block">
                <h2>Pronóstico (Próx. 12h)</h2>
                <div class="forecast-items" id="hourly_forecast_container">
                    <div class="forecast-item">
                        <div class="hour">--:--</div>
                        <div class="temp">--°C</div>
                        <div class="desc">Cargando...</div>
                    </div>
                </div>
            </div>
            
            <div class="button-row">
                <button type="submit" class="btn-submit">Guardar Configuración</button>
                <a href="/irainicio" class="btn-back">Volver al inicio</a>
            </div>
        </form>
    </div>

    <script>
        // Función para obtener y mostrar los datos del clima y el pronóstico
        async function updateWeatherAndForecast() {
            try {
                const response = await fetch('/get_weather_data'); // Endpoint que tu ESP32 debe servir
                const data = await response.json();

                // Actualizar Clima Actual
                document.getElementById('current_temp').textContent = data.currentTemperature ? data.currentTemperature.toFixed(1) : '--';
                document.getElementById('current_wind').textContent = data.currentWindSpeed ? data.currentWindSpeed.toFixed(1) : '--';
                document.getElementById('current_humidity').textContent = data.currentHumidity ? data.currentHumidity.toFixed(0) : '--';
                document.getElementById('current_weather_desc').textContent = data.currentWeatherDescription || '--';
                document.getElementById('current_city').textContent = data.city || '--';
                if (data.lastWeatherCheck) {
                    const lastUpdateMinutes = Math.floor((Date.now() - data.lastWeatherCheck) / (1000 * 60));
                    document.getElementById('last_update').textContent = `${lastUpdateMinutes} min.`;
                } else {
                    document.getElementById('last_update').textContent = '-- min.';
                }
                
                // Actualizar input de ciudad con el valor actual
                document.getElementById('city_setting').value = data.city || 'Rio Tercero,AR';

                // Actualizar condicionantes para cada dispositivo
                document.getElementById('min_temp_ventana').value = data.min_temp_ventana !== undefined ? data.min_temp_ventana.toFixed(1) : '10.0';
                document.getElementById('max_temp_ventana').value = data.max_temp_ventana !== undefined ? data.max_temp_ventana.toFixed(1) : '30.0';
                document.getElementById('max_wind_speed_ventana').value = data.max_wind_speed_ventana !== undefined ? data.max_wind_speed_ventana.toFixed(1) : '20.0';
                document.getElementById('allow_rain_ventana').checked = data.allow_rain_ventana || false;
                
                document.getElementById('min_temp_cortina').value = data.min_temp_cortina !== undefined ? data.min_temp_cortina.toFixed(1) : '10.0';
                document.getElementById('max_temp_cortina').value = data.max_temp_cortina !== undefined ? data.max_temp_cortina.toFixed(1) : '30.0';
                document.getElementById('max_wind_speed_cortina').value = data.max_wind_speed_cortina !== undefined ? data.max_wind_speed_cortina.toFixed(1) : '20.0';
                document.getElementById('allow_rain_cortina').checked = data.allow_rain_cortina || false;
                
                document.getElementById('min_temp_postigon').value = data.min_temp_postigon !== undefined ? data.min_temp_postigon.toFixed(1) : '10.0';
                document.getElementById('max_temp_postigon').value = data.max_temp_postigon !== undefined ? data.max_temp_postigon.toFixed(1) : '30.0';
                document.getElementById('max_wind_speed_postigon').value = data.max_wind_speed_postigon !== undefined ? data.max_wind_speed_postigon.toFixed(1) : '20.0';
                document.getElementById('allow_rain_postigon').checked = data.allow_rain_postigon || false;

                // Actualizar Horarios de Ventana, Cortina, Postigón
                document.getElementById('ventana_apertura').value = data.open_hour_ventana || '08:00';
                document.getElementById('ventana_cierre').value = data.close_hour_ventana || '18:00';
                document.getElementById('cortina_apertura').value = data.open_hour_cortina || '07:00';
                document.getElementById('cortina_cierre').value = data.close_hour_cortina || '20:00';
                document.getElementById('postigon_apertura').value = data.open_hour_postigon || '07:30';
                document.getElementById('postigon_cierre').value = data.close_hour_postigon || '19:30';

                // Actualizar Pronóstico por Horas
                const forecastContainer = document.getElementById('hourly_forecast_container');
                forecastContainer.innerHTML = ''; // Limpiar pronósticos anteriores
                if (data.hourly_forecast && data.hourly_forecast.length > 0) {
                    const maxForecastItems = 12; // Mostrar hasta 12 ítems del pronóstico
                    for (let i = 0; i < Math.min(data.hourly_forecast.length, maxForecastItems); i++) {
                        const item = data.hourly_forecast[i];
                        const forecastItemDiv = document.createElement('div');
                        forecastItemDiv.classList.add('forecast-item');
                        forecastItemDiv.innerHTML = `
                            <div class="hour">${item.time}</div>
                            <div class="temp">${item.temp}°C</div>
                            <div class="desc">${item.desc}</div>
                        `;
                        forecastContainer.appendChild(forecastItemDiv);
                    }
                } else {
                    forecastContainer.innerHTML = '<div class="forecast-item"><div class="desc">No hay pronóstico disponible.</div></div>';
                }

            } catch (error) {
                console.error('Error al obtener datos del clima y pronóstico:', error);
                // Mostrar un mensaje de error en la UI si es necesario
                document.getElementById('hourly_forecast_container').innerHTML = '<div class="forecast-item"><div class="desc">Error cargando pronóstico.</div></div>';
                document.getElementById('current_temp').textContent = '--';
                document.getElementById('current_wind').textContent = '--';
                document.getElementById('current_humidity').textContent = '--';
                document.getElementById('current_weather_desc').textContent = 'Error';
                document.getElementById('current_city').textContent = '--';
                document.getElementById('last_update').textContent = '-- min.';
            }
        }

        // Cargar los datos al cargar la página
        window.addEventListener('load', updateWeatherAndForecast);
        // Actualizar cada 60 segundos (puedes ajustar el intervalo)
        setInterval(updateWeatherAndForecast, 60000); 
    </script>
</body>
</html>