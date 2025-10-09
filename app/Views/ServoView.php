<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Servo - VECOPO</title>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe; --secondary-color: #4facfe; --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85); --text-primary: #ffffff; --text-secondary: #8892b0;
            --accent-color: #64ffda; --danger-color: #ff4d4d; --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: var(--dark-bg); color: var(--text-primary); min-height: 100vh; }
        .main-wrapper { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; width: 100%; min-height: 100vh; }
        .control-card { background: var(--card-bg); padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(100, 255, 218, 0.1); backdrop-filter: blur(10px); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); width: 100%; max-width: 800px; animation: fadeIn 0.8s ease-out; text-align: center; margin-bottom: 20px;}
        .control-card h1 { font-family: 'Orbitron', sans-serif; color: var(--primary-color); font-size: 2rem; margin-bottom: 1.5rem; text-shadow: 0 0 10px rgba(0, 242, 254, 0.3); }
        .device-info { color: var(--text-secondary); margin-bottom: 2rem; }

        /* Estilos para cada servo individual */
        .servo-item {
            background: rgba(16, 32, 61, 0.6); /* Un poco más claro que el fondo de la tarjeta */
            border: 1px solid var(--input-border);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .servo-item:last-child { margin-bottom: 0; }

        .servo-header { display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; width: 100%; }
        .servo-icon-display { font-size: 3rem; color: var(--primary-color); text-shadow: 0 0 10px var(--primary-color); margin-right: 1rem; }
        .servo-name { font-family: 'Orbitron', sans-serif; font-size: 1.6rem; color: var(--primary-color); margin-bottom: 0.5rem;}
        .servo-details { font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1rem; }

        .status-indicator { font-family: 'Orbitron', sans-serif; font-size: 1.1rem; padding: 0.4rem 1.2rem; border-radius: 50px; margin: 1rem 0; display: inline-block; font-weight: 500; transition: all 0.3s ease; min-width: 120px; }
        .status-abierto { background-color: var(--success-color); color: var(--dark-bg); box-shadow: 0 0 10px rgba(0, 255, 157, 0.4); }
        .status-cerrado { background-color: var(--danger-color); color: var(--text-primary); box-shadow: 0 0 10px rgba(255, 77, 77, 0.4); }
        .status-desconocido { background-color: var(--text-secondary); color: var(--dark-bg); }

        .controls-wrapper { margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; width: 100%; }
        .btn-control { padding: 0.8rem 1.5rem; font-size: 1rem; font-weight: 500; border-radius: 50px; min-width: 150px; display: inline-flex; align-items: center; justify-content: center; gap: 10px; border: none; cursor: pointer; transition: all 0.3s ease; }
        .btn-control:hover { transform: translateY(-3px); }
        .btn-open { background: linear-gradient(45deg, var(--accent-color), var(--success-color)); color: var(--dark-bg); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2); }
        .btn-open:hover { box-shadow: 0 8px 20px rgba(100, 255, 218, 0.3); }
        .btn-close { background: linear-gradient(45deg, #ff7b7b, var(--danger-color)); color: var(--text-primary); box-shadow: 0 5px 15px rgba(255, 77, 77, 0.2); }
        .btn-close:hover { box-shadow: 0 8px 20px rgba(255, 77, 77, 0.3); }
        .btn-config {
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            color: var(--dark-bg);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2);
        }
        .btn-config:hover {
            box-shadow: 0 8px 20px rgba(100, 255, 218, 0.3);
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .control-card { padding: 1.5rem; max-width: 95%; }
            .control-card h1 { font-size: 1.8rem; }
            .servo-item { padding: 1rem; }
            .servo-header { flex-direction: column; text-align: center; }
            .servo-icon-display { margin-right: 0; margin-bottom: 0.5rem; }
            .servo-name { font-size: 1.4rem; }
            .controls-wrapper { flex-direction: column; align-items: center; }
            .btn-control { width: 100%; max-width: 250px; }
        }
        @media (max-width: 480px) {
            .main-wrapper { padding: 1rem; }
            .control-card { padding: 1rem; }
            .control-card h1 { font-size: 1.5rem; }
            .servo-icon-display { font-size: 2.5rem; }
            .servo-name { font-size: 1.2rem; }
            .servo-details { font-size: 0.8rem; }
            .status-indicator { font-size: 0.9rem; padding: 0.3rem 0.8rem; min-width: 100px; }
            .btn-control { font-size: 0.9rem; padding: 0.6rem 1.2rem; }
        }
    </style>
</head>
<body>
    <main class="main-wrapper">
        <div class="control-card">
            <h1>Control de Servos - VECOPO</h1>
            <div class="device-info">
                <p>Dispositivo VECOPO ID: <?= $dispositivo['id'] ?? 'N/A' ?></p>
                <p>MAC: <?= strtoupper($dispositivo['codigo'] ?? 'N/A') ?></p>
            </div>

            <div id="servosContainer">
                <?php if (!empty($servos_asociados)): ?>
                    <?php foreach ($servos_asociados as $servo): ?>
                        <div class="servo-item" data-servo-id="<?= esc($servo['id']); ?>">
                            <div class="servo-header">
                                <i id="servoIcon-<?= esc($servo['id']); ?>" class="fas fa-door-closed servo-icon-display"></i>
                                <div style="text-align: left;">
                                    <h2 class="servo-name"><?= esc($servo['nombre_servo']); ?></h2>
                                    <p class="servo-details">Tipo: <?= esc(strtoupper($servo['tipo_elemento'])); ?> | Pin: <?= esc($servo['pin_gpio']); ?></p>
                                    <p class="servo-details">Modo: <span id="modo-<?= esc($servo['id']); ?>"><?= esc(strtoupper($servo['modo_operacion'] ?? 'N/A')); ?></span></p>
                                </div>
                            </div>

                            <div class="status-container">
                                <p>Estado Actual:</p>
                                <span id="estado-<?= esc($servo['id']); ?>" class="status-indicator status-desconocido">
                                    CARGANDO...
                                </span>
                            </div>

                            <div class="controls-wrapper">
                                <button type="button" class="btn-control btn-open"
                                    data-servo-id="<?= esc($servo['id']); ?>"
                                    data-comando-url="<?= site_url('funcional/actualizarEstado/' . esc($servo['id']) . '/abierto'); ?>">
                                    <i class="fas fa-door-open"></i> Abrir
                                </button>
                                <button type="button" class="btn-control btn-close"
                                    data-servo-id="<?= esc($servo['id']); ?>"
                                    data-comando-url="<?= site_url('funcional/actualizarEstado/' . esc($servo['id']) . '/cerrado'); ?>">
                                    <i class="fas fa-door-close"></i> Cerrar
                                </button>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-secondary);">No hay servos configurados para este dispositivo. Por favor, añada servos desde la configuración.</p>
                <?php endif; ?>
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <button class="btn-control btn-config" onclick="history.back()">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // --- CONFIGURACIÓN INICIAL ---
            const dispositivoMac = `<?= esc($dispositivo['codigo'] ?? '') ?>`;
            const URL_BASE_CI = '<?= base_url() ?>';
            // Se toma el token CSRF una sola vez para reutilizarlo.
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Configuración global para que TODAS las peticiones AJAX de jQuery incluyan el token CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Almacenar referencias a elementos de la UI para mayor eficiencia
            const servoElements = {};
            document.querySelectorAll('.servo-item').forEach(item => {
                const servoId = item.dataset.servoId;
                servoElements[servoId] = {
                    statusElement: document.getElementById(`estado-${servoId}`),
                    iconElement: document.getElementById(`servoIcon-${servoId}`),
                    modeElement: document.getElementById(`modo-${servoId}`)
                };
            });

            // --- NUEVA LÓGICA DE CONTROL MANUAL (MÁS SIMPLE) ---
            
            // Asignar un único evento de clic a todos los botones de control que no sean para volver atrás.
            $('.controls-wrapper .btn-control').on('click', function(e) {
                // Evitar cualquier comportamiento por defecto del botón.
                e.preventDefault();
                
                const button = $(this);
                // Tomamos la URL para la acción directamente del atributo 'data-comando-url' del botón.
                const comandoUrl = button.data('comando-url');

                if (!comandoUrl) {
                    console.error('El botón no tiene un atributo data-comando-url.');
                    return;
                }

                // Deshabilitar el botón para evitar clics múltiples mientras se procesa la petición.
                button.prop('disabled', true).fadeTo(200, 0.5);

                // Llamada AJAX directa para actualizar el estado.
                $.ajax({
                    url: comandoUrl, // La URL ya contiene el servo_id y el estado deseado ('abierto' o 'cerrado').
                    method: 'GET',   // El método que espera tu controlador 'actualizarEstado'.
                    dataType: 'json' // Esperamos una respuesta en formato JSON.
                }).done(function(response) {
                    // Si el servidor responde que todo fue bien...
                    if (response.status === 'ok') {
                        // Actualizamos la interfaz de usuario inmediatamente para darle feedback al usuario.
                        actualizarUI(response.servo_id, response.estado, response.modo);
                        console.log(`Servo ${response.servo_id} puesto en modo MANUAL. Expira en: ${response.expira}`);
                    } else {
                        // Si el servidor responde con un error, lo mostramos.
                        alert('Error al ejecutar la acción: ' + (response.message || 'Error desconocido.'));
                    }
                }).fail(function(jqXHR) {
                    // Si la petición AJAX falla por completo (ej: error de red, error 500 del servidor).
                    console.error("AJAX Error:", jqXHR.status, jqXHR.responseText);
                    alert('La petición falló. Revisa la consola (F12) para más detalles.');
                }).always(function() {
                    // Se ejecuta siempre, tanto si la petición tuvo éxito como si falló.
                    // Volver a habilitar el botón después de que la petición haya terminado.
                    button.prop('disabled', false).fadeTo(200, 1.0);
                });
            });

            // --- FUNCIONES PARA ACTUALIZAR LA UI (SIN CAMBIOS) ---
            function actualizarEstadoDesdeServidor() {
                if (!dispositivoMac) return;
                fetch(`${URL_BASE_CI}/dispositivos/estado/${dispositivoMac}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.servos && Array.isArray(data.servos)) {
                            data.servos.forEach(servoData => {
                                if (servoElements[servoData.id]) {
                                    actualizarUI(servoData.id, servoData.estado, servoData.modo);
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error al obtener estado de servos:', error));
            }

            function actualizarUI(servoId, estado, modoOperacion) {
                const elements = servoElements[servoId];
                if (!elements) return;
                const estadoLimpio = (estado || '').toLowerCase().trim();
                elements.statusElement.textContent = estado ? estado.toUpperCase() : 'N/A';
                elements.statusElement.className = `status-indicator status-${estadoLimpio || 'desconocido'}`;
                if (estadoLimpio === 'abierto') {
                    elements.iconElement.className = `fas fa-door-open servo-icon-display`;
                } else if (estadoLimpio === 'cerrado') {
                    elements.iconElement.className = `fas fa-door-closed servo-icon-display`;
                }
                if (elements.modeElement && modoOperacion) {
                    elements.modeElement.textContent = modoOperacion.toUpperCase();
                }
            }
            
            // Polling para mantener la UI actualizada automáticamente cada 10 segundos.
            setInterval(actualizarEstadoDesdeServidor, 10000);
            // Llamada inicial para cargar el estado en cuanto la página esté lista.
            actualizarEstadoDesdeServidor();
        });
    </script>

</body>
</html>