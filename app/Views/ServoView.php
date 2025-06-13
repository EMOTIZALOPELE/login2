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
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: var(--dark-bg); color: var(--text-primary); min-height: 100vh; }
        .main-wrapper { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; width: 100%; min-height: 100vh; }
        .control-card { background: var(--card-bg); padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(100, 255, 218, 0.1); backdrop-filter: blur(10px); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); width: 100%; max-width: 600px; animation: fadeIn 0.8s ease-out; text-align: center;}
        .control-card h1 { font-family: 'Orbitron', sans-serif; color: var(--primary-color); font-size: 2rem; margin-bottom: 1.5rem; text-shadow: 0 0 10px rgba(0, 242, 254, 0.3); }
        .servo-icon-display { font-size: 4rem; color: var(--primary-color); margin-bottom: 1.5rem; text-shadow: 0 0 15px var(--primary-color); transition: transform 0.3s ease; }
        .status-container p { font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
        .status-indicator { font-family: 'Orbitron', sans-serif; font-size: 1.2rem; padding: 0.5rem 1.5rem; border-radius: 50px; margin: 1rem 0; display: inline-block; font-weight: 500; transition: all 0.3s ease; min-width: 150px; }
        .status-abierto { background-color: var(--success-color); color: var(--dark-bg); box-shadow: 0 0 15px rgba(0, 255, 157, 0.4); }
        .status-cerrado { background-color: var(--danger-color); color: var(--text-primary); box-shadow: 0 0 15px rgba(255, 77, 77, 0.4); }
        .status-desconocido { background-color: var(--text-secondary); color: var(--dark-bg); }
        .controls-wrapper { margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-control { padding: 0.8rem 1.5rem; font-size: 1.1rem; font-weight: 500; border-radius: 50px; min-width: 180px; display: inline-flex; align-items: center; justify-content: center; gap: 10px; border: none; cursor: pointer; transition: all 0.3s ease; }
        .btn-control:hover { transform: translateY(-3px); }
        .btn-open { background: linear-gradient(45deg, var(--accent-color), var(--success-color)); color: var(--dark-bg); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2); }
        .btn-open:hover { box-shadow: 0 8px 20px rgba(100, 255, 218, 0.3); }
        .btn-close { background: linear-gradient(45deg, #ff7b7b, var(--danger-color)); color: var(--text-primary); box-shadow: 0 5px 15px rgba(255, 77, 77, 0.2); }
        .btn-close:hover { box-shadow: 0 8px 20px rgba(255, 77, 77, 0.3); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 576px) { .main-wrapper { padding: 1rem; } .control-card { padding: 1.5rem; } .control-card h1 { font-size: 1.8rem; } .controls-wrapper { flex-direction: column; align-items: center; } .btn-control { width: 100%; max-width: 280px; } }
    </style>
</head>
<body>
    <main class="main-wrapper">
        <div class="control-card">
            <i id="servoIcon" class="fas fa-door-closed servo-icon-display"></i>
            <h1 class="mb-3">Control de Servo Remoto</h1>
            <div id="infoDispositivo" style="color: var(--text-secondary);">Cargando informaci�n...</div>
            
            <div class="status-container mb-4">
                <p class="mb-2">Estado Reportado:</p>
                <span id="estado" class="status-indicator status-desconocido">
                    CARGANDO...
                </span>
            </div>
    
            <div class="controls-wrapper">
                <button class="btn-control btn-open" onclick="controlarServo('abierto')">
                    <i class="fas fa-door-open"></i> Abrir
                </button>
                <button class="btn-control btn-close" onclick="controlarServo('cerrado')">
                    <i class="fas fa-door-closed"></i> Cerrar
                </button>
            </div>
        </div>
    </main>

    <script>
        const dispositivoId = <?= $dispositivo['id'] ?? 'null' ?>;
        const URL_BASE_CI = '<?= base_url() ?>';
        
        const statusElement = document.getElementById('estado');
        const servoIcon = document.getElementById('servoIcon');
        const infoDispositivo = document.getElementById('infoDispositivo');

        if (!dispositivoId) {
            alert("Error: No se ha seleccionado ningún dispositivo.");
            window.location.href = '<?= base_url('/irainicio') ?>';
        } else {
            infoDispositivo.textContent = `Controlando Dispositivo ID: ${dispositivoId}`;
        }

        function controlarServo(comando) {
            fetch(`${URL_BASE_CI}/funcional/actualizarEstado/${dispositivoId}/${comando}`)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.message || 'Error del servidor'); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'ok') {
                        console.log('Orden enviada al servidor:', data.estado);
                        actualizarUI(data.estado);
                    } else {
                        throw new Error(data.message || 'El servidor no pudo procesar la orden.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                });
        }

        function actualizarEstadoDesdeServidor() {
            if (!dispositivoId) return;
            
            fetch(`${URL_BASE_CI}/dispositivos/estado/${dispositivoId}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.estado) {
                        actualizarUI(data.estado);
                    }
                })
                .catch(error => console.error('Error al obtener estado:', error));
        }

        function actualizarUI(estado) {
            const estadoLimpio = estado.toLowerCase().trim();
            statusElement.textContent = estado.toUpperCase();
            statusElement.className = `status-indicator status-${estadoLimpio}`;
            servoIcon.className = `fas fa-door-${estadoLimpio} servo-icon-display`;
        }

        setInterval(actualizarEstadoDesdeServidor, 3000);
        document.addEventListener('DOMContentLoaded', actualizarEstadoDesdeServidor);
    </script>
</body>
</html>
