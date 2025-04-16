<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control de Servo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      padding: 2rem;
    }
    .servo-container {
      max-width: 600px;
      margin: 0 auto;
      background: white;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0, 255, 179, 0.1)
    }
    .status-indicator {
      font-size: 1.2rem;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      margin: 1rem 0;
    }
    .status-abierto {
      background-color: #4CAF50;
      color: white;
    }
    .status-cerrado {
      background-color: #f44336;
      color: white;
    }
    .btn-control {
      padding: 1rem 2rem;
      font-size: 1.1rem;
      border-radius: 25px;
      margin: 0.5rem;
      
      color: black !important;
      opacity: 1;
      min-width: 160px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      border: none;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .btn-control:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-open {
      background-color: #67c23a;
    }
    .btn-close {
      background-color: #ff7b7b;
    }
    .servo-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="servo-container text-center">
    <i class="fas fa-door-closed servo-icon"></i>
    <h1 class="mb-4">Control de Servo</h1>
    
    <div class="status-container mb-4">
      <p class="mb-2">Estado actual:</p>
      <span id="estado" class="status-indicator">
        <?= $ultimo_estado['estado'] ?? 'DESCONOCIDO' ?>
      </span>
    </div>

    <div class="controls">
      <button class="btn btn-control btn-open" onclick="cambiarEstado('abierto')">
        <i class="fas fa-door-open"></i> Abrir
      </button>
      <button class="btn btn-control btn-close" onclick="cambiarEstado('cerrado')">
        <i class="fas fa-door-closed"></i> Cerrar
      </button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function cambiarEstado(estado) {
      const statusElement = document.getElementById('estado');
      statusElement.className = `status-indicator status-${estado}`;
      
      fetch(`/login2/public/funcional/actualizarEstado/${estado}`)
        .then(response => response.json())
        .then(data => {
          if (data.status === 'ok') {
            statusElement.textContent = data.estado;
            statusElement.className = `status-indicator status-${data.estado.toLowerCase()}`;
            
            fetch(`http://10.81.11.241/servo${estado === 'abierto' ? 'Open' : 'Close'}`)
              .then(response => {
                if (!response.ok) {
                  console.error('Error al comunicar con ESP32');
                }
              });
          }
        })
        .catch(error => console.error('Error:', error));
    }

    setInterval(() => {
      fetch('/login2/public/funcional/obtenerUltimoEstado')
        .then(res => res.json())
        .then(data => {
          const statusElement = document.getElementById('estado');
          statusElement.textContent = data.estado;
          statusElement.className = `status-indicator status-${data.estado.toLowerCase()}`;
        });
    }, 6000);
  </script>
</body>
</html>