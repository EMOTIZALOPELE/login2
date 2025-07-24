<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait; // Para manejar respuestas JSON fácilmente
use CodeIgniter\HTTP\Client; // Para hacer solicitudes HTTP

class WeatherController extends Controller
{
    use ResponseTrait; // Habilita el método $this->respond() para respuestas JSON

    protected $openWeatherApiKey;
    protected $openWeatherBaseUrl = 'https://api.openweathermap.org/data/2.5/';
    protected $openWeatherLat;
    protected $openWeatherLon;
    protected $openWeatherUnits;
    protected $openWeatherLang = 'es'; // Lenguaje para la descripción del clima

    public function __construct()
    {
        $this->openWeatherApiKey = getenv('OPENWEATHER_API_KEY');
        $this->openWeatherLat = getenv('OPENWEATHER_LAT');
        $this->openWeatherLon = getenv('OPENWEATHER_LON');
        $this->openWeatherUnits = getenv('OPENWEATHER_UNITS');

        // Asegúrate de que las variables de entorno se carguen correctamente
        if (empty($this->openWeatherApiKey) || $this->openWeatherApiKey === '0d132a7baaa02ea9cfc60077249f0254') {
            log_message('error', 'OpenWeatherMap API Key no configurada o es el valor por defecto.');
            // En un entorno de producción, podrías lanzar una excepción o manejarlo de otra forma
        }
    }

    public function getCurrentWeather()
    {
        // Validar que la API Key esté configurada
        if (empty($this->openWeatherApiKey) || $this->openWeatherApiKey === '0d132a7baaa02ea9cfc60077249f0254') {
            return $this->failServerError('OpenWeatherMap API Key no configurada. Por favor, añádela a tu archivo .env');
        }

        // Usar el sistema de caché de CodeIgniter para evitar llamadas excesivas
        $cacheKey = "weather_current_{$this->openWeatherLat}_{$this->openWeatherLon}_{$this->openWeatherUnits}_{$this->openWeatherLang}";
        $weatherData = cache($cacheKey);

        if ($weatherData === null) {
            $client = \Config\Services::curlrequest(); // O new Client();

            try {
                $response = $client->get($this->openWeatherBaseUrl . 'weather', [
                    'query' => [
                        'lat' => $this->openWeatherLat,
                        'lon' => $this->openWeatherLon,
                        'appid' => $this->openWeatherApiKey,
                        'units' => $this->openWeatherUnits,
                        'lang' => $this->openWeatherLang,
                    ],
                    'verify' => false // Deshabilitar verificación SSL temporalmente si tienes problemas con DDNS o certificados self-signed. ¡No recomendado en producción!
                ]);

                if (!$response->isOK()) {
                    log_message('error', 'Error HTTP de OpenWeatherMap: ' . $response->getStatusCode() . ' - ' . $response->getBody());
                    return $this->failServerError('No se pudieron obtener los datos del clima de OpenWeatherMap. Codigo: ' . $response->getStatusCode());
                }

                $weatherData = $response->getBody();
                $weatherData = json_decode($weatherData, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    log_message('error', 'Error al decodificar JSON de OpenWeatherMap: ' . json_last_error_msg());
                    return $this->failServerError('Error al procesar la respuesta de OpenWeatherMap.');
                }

                // Cachear la respuesta por 10 minutos
                cache()->save($cacheKey, $weatherData, 60 * 10);

            } catch (\Exception $e) {
                log_message('error', "Error inesperado al obtener datos del clima: " . $e->getMessage());
                return $this->failServerError('Ocurrió un error inesperado al obtener el clima.');
            }
        }


        // Formatear los datos para enviar solo lo necesario al frontend
        $formattedData = [
            'currentTemperature' => round($weatherData['main']['temp']),
            'currentWindSpeed' => round($weatherData['wind']['speed']),
            'currentHumidity' => $weatherData['main']['humidity'],
            'currentWeatherDescription' => ucfirst($weatherData['weather'][0]['description']),
            'city' => $weatherData['name'],
            'lastWeatherCheck' => time() * 1000, // Timestamp en milisegundos para JS
            'icon' => $weatherData['weather'][0]['icon'],
        ];

        return $this->respond($formattedData);
    }

    public function getForecastWeather()
    {
        if (empty($this->openWeatherApiKey) || $this->openWeatherApiKey === '0d132a7baaa02ea9cfc60077249f0254') {
            return $this->failServerError('OpenWeatherMap API Key no configurada. Por favor, añádela a tu archivo .env');
        }

        $cacheKey = "weather_forecast_{$this->openWeatherLat}_{$this->openWeatherLon}_{$this->openWeatherUnits}_{$this->openWeatherLang}";
        $forecastData = cache($cacheKey);

        if ($forecastData === null) {
            $client = \Config\Services::curlrequest(); // O new Client();

            try {
                // Usar 'forecast' para 5 días / 3 horas
                $response = $client->get($this->openWeatherBaseUrl . 'forecast', [
                    'query' => [
                        'lat' => $this->openWeatherLat,
                        'lon' => $this->openWeatherLon,
                        'appid' => $this->openWeatherApiKey,
                        'units' => $this->openWeatherUnits,
                        'lang' => $this->openWeatherLang,
                    ],
                    'verify' => false
                ]);

                if (!$response->isOK()) {
                    log_message('error', 'Error HTTP de OpenWeatherMap (pronóstico): ' . $response->getStatusCode() . ' - ' . $response->getBody());
                    return $this->failServerError('No se pudieron obtener los datos de pronóstico del clima. Codigo: ' . $response->getStatusCode());
                }

                $forecastData = $response->getBody();
                $forecastData = json_decode($forecastData, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    log_message('error', 'Error al decodificar JSON de pronóstico: ' . json_last_error_msg());
                    return $this->failServerError('Error al procesar la respuesta de pronóstico de OpenWeatherMap.');
                }

                // Cachear la respuesta por 1 hora
                cache()->save($cacheKey, $forecastData, 60 * 60);

            } catch (\Exception $e) {
                log_message('error', "Error inesperado al obtener pronóstico del clima: " . $e->getMessage());
                return $this->failServerError('Ocurrió un error inesperado al obtener el pronóstico.');
            }
        }

        $hourlyForecast = [];
        // Procesar y formatear el pronóstico por horas (ej. las próximas 12 horas)
        if (isset($forecastData['list'])) {
            // Obtenemos la zona horaria del sistema o configurada en App.php
            $timezone = config('App')->appTimezone; // Asegúrate de tener esto configurado
            $now = new \DateTime('now', new \DateTimeZone($timezone));

            foreach ($forecastData['list'] as $item) {
                $itemTime = new \DateTime('@' . $item['dt'], new \DateTimeZone('UTC'));
                $itemTime->setTimezone(new \DateTimeZone($timezone)); // Convertir a tu timezone local

                // Solo considerar las próximas 12 horas desde ahora
                // Puedes ajustar esta lógica para que el pronóstico empiece desde la hora actual o la siguiente
                if ($itemTime > $now && count($hourlyForecast) < 12) {
                    $hourlyForecast[] = [
                        'time' => $itemTime->format('H:i'),
                        'temp' => round($item['main']['temp']),
                        'desc' => ucfirst($item['weather'][0]['description']),
                        'icon' => $item['weather'][0]['icon'],
                    ];
                }
            }
        }

        return $this->respond(['hourly_forecast' => $hourlyForecast]);
    }
}