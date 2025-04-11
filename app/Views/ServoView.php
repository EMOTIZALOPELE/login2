<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control de Servo</title>
</head>
<body>
  <h1>Control de Servo</h1>
  <p>Estado actual: <strong id="estado"><?= $ultimo_estado['estado'] ?? 'DESCONOCIDO' ?></strong></p>
  <button onclick="cambiarEstado('abierto')">Abrir</button>
  <button onclick="cambiarEstado('cerrado')">Cerrar</button>

  <script>
    function cambiarEstado(estado) {
      // Enviar estado al servidor CodeIgniter
      fetch(`/login2/public/funcional/actualizarEstado/${estado}`)
      .then(response => response.json())
      .then(data => {
        if (data.status === 'ok') {
          document.getElementById('estado').textContent = data.estado;
          // También enviar comando al ESP32
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
          document.getElementById('estado').textContent = data.estado;
        });
    }, 3000); // actualiza cada 3 segundos
  </script>
</body>
</html>