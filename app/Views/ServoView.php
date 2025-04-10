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
      fetch(`/funcional/actualizarEstado/${estado}`)
        .then(response => response.json())
        .then(data => {
          if (data.status === 'ok') {
            document.getElementById('estado').textContent = data.estado;
          }
        });
    }

    setInterval(() => {
      fetch('/funcional/obtenerUltimoEstado')
        .then(res => res.json())
        .then(data => {
          document.getElementById('estado').textContent = data.estado;
        });
    }, 3000); // actualiza cada 3 segundos
  </script>
</body>
</html>