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
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            grid-template-areas:
                "header header header header"
                "description description description description"
                "ventana cortina postigon clima_actual"
                "pronostico pronostico pronostico pronostico"
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

        #hourly_forecast_block { grid-area: pronostico; }
        #ventana_block { grid-area: ventana; }
        #cortina_block { grid-area: cortina; }
        #postigon_block { grid-area: postigon; }
        #current_weather_block { grid-area: clima_actual; }
        .button-row { grid-area: buttons; }

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

        /* Estilos para el bloque de clima actual (sin imágenes) */
        .weather-info {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 0.8rem;
            gap: 1rem;
        }
        .weather-info i {
            font-size: 1.5rem;
            color: var(--primary-color);
            width: 30px;
            text-align: center;
        }
        .weather-info p {
            font-size: 1rem;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: baseline;
            flex-grow: 1;
        }
        .weather-info p span {
            font-weight: 600;
            color: var(--accent-color);
            margin-left: 5px;
        }
        #current_weather_block h2 { margin-bottom: 0.5rem; }
        #weather_city_name { margin-bottom: 1rem; background: rgba(255,255,255,0.05); padding: 0.5rem; border-radius: 8px; border: 1px solid var(--input-border); text-align: center; color: var(--text-primary); }

        /* Estilos del nuevo bloque de pronóstico */
        .forecast-items {
            display: flex;
            overflow-x: auto;
            padding-bottom: 10px;
            gap: 1rem;
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .forecast-items::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }
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
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 1200px) {
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
                grid-template-columns: 1fr;
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
                <h2>Pronóstico (Próx. 12h)</h2>
                <div class="forecast-items" id="hourly_forecast_container">
                    <div class="forecast-item loading-item">
                        <div class="desc">Cargando pronóstico...</div>
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
        // ¡IMPORTANTE! Reemplaza 'TU_API_KEY_AQUI' con tu clave de OpenWeatherMap
        const APIKey = '0d132a7baaa02ea9cfc60077249f0254'; 
        const city = 'Rio Tercero,AR';

        const currentTemp = document.getElementById('current_temp');
        const currentHumidity = document.getElementById('current_humidity');
        const currentWind = document.getElementById('current_wind');
        const currentPoP = document.getElementById('pop');
        const currentWeatherDesc = document.getElementById('current_weather_desc');
        const forecastContainer = document.getElementById('hourly_forecast_container');

        function showLoadingState() {
            currentTemp.textContent = '--';
            currentHumidity.textContent = '--';
            currentWind.textContent = '--';
            currentPoP.textContent = '--';
            currentWeatherDesc.textContent = 'Cargando...';
            forecastContainer.innerHTML = '<div class="forecast-item loading-item"><div class="desc">Cargando pronóstico...</div></div>';
        }

        function showErrorState(message = 'Error') {
            currentTemp.textContent = '--';
            currentHumidity.textContent = '--';
            currentWind.textContent = '--';
            currentPoP.textContent = '--';
            currentWeatherDesc.textContent = message;
            forecastContainer.innerHTML = '<div class="forecast-item error-item"><div class="desc">No se pudo cargar el pronóstico.</div></div>';
        }

        async function updateWeather() {
            showLoadingState();

            if (APIKey === 'TU_API_KEY_AQUI' || APIKey.length < 32) {
                showErrorState('API Key no configurada.');
                return;
            }

            try {
                // Obtener datos del clima actual
                const weatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${APIKey}&lang=es`);
                const weatherData = await weatherResponse.json();

                // Obtener datos de pronóstico (para probabilidad de lluvia y pronóstico por horas)
                const forecastResponse = await fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${city}&units=metric&appid=${APIKey}&lang=es`);
                const forecastData = await forecastResponse.json();

                if (weatherData.cod !== 200 || forecastData.cod !== '200') {
                    showErrorState('Ubicación no encontrada o error en la API.');
                    return;
                }

                // Actualizar Clima Actual
                currentTemp.textContent = `${Math.round(weatherData.main.temp)}`;
                currentHumidity.textContent = `${weatherData.main.humidity}`;
                // Conversión de m/s a km/h
                currentWind.textContent = `${Math.round(weatherData.wind.speed * 3.6)}`; 
                currentWeatherDesc.textContent = weatherData.weather[0].description;
                // La probabilidad de lluvia (pop) viene del primer elemento del pronóstico
                currentPoP.textContent = `${Math.round(forecastData.list[0].pop * 100)}`; 

                // Actualizar Pronóstico por Horas
                forecastContainer.innerHTML = '';
                const maxForecastItems = 4; // Cambiar a 4 para pronóstico de 12 horas (3 horas * 4)
                for (let i = 0; i < Math.min(forecastData.list.length, maxForecastItems); i++) {
                    const item = forecastData.list[i];
                    const date = new Date(item.dt * 1000);
                    const hour = date.getHours().toString().padStart(2, '0');
                    const temp = Math.round(item.main.temp);
                    const desc = item.weather[0].description;
                    const pop = Math.round(item.pop * 100);

                    const forecastItemDiv = document.createElement('div');
                    forecastItemDiv.classList.add('forecast-item');
                    forecastItemDiv.innerHTML = `
                        <div class="hour">${hour}:00</div>
                        <div class="temp">${temp}°C</div>
                        <div class="desc">Prob: ${pop}%</div>
                    `;
                    forecastContainer.appendChild(forecastItemDiv);
                }

            } catch (error) {
                console.error('Error al obtener datos del clima y pronóstico:', error);
                showErrorState('Error de conexión o API.');
            }
        }

        window.addEventListener('load', updateWeather);
        setInterval(updateWeather, 600000); // Actualizar cada 10 minutos
    </script>
</body>
</html>