<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Diseño de Artículos</title>
  <script src="https://cdn.jsdelivr.net/npm/konva@8.0.3/konva.min.js"></script>
  <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
  <style>
    body {
      background: url(<?= base_url("img/fondo4.jpg") ?>) no-repeat center center fixed;
      background-size: cover;        
            font-family: Arial, sans-serif;        
            height: 100vh;

    }

    h1 {
      text-align: center;
      margin-top: 20px;
      font-size: 32px;
    }

    .contenedor {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 40px;
    }

    form {
      flex: 1;
      max-width: 400px;
      padding-right: 40px;
    }
   
    label{
      display: block;
      color: white;
      text-decoration: none;
      font-size: 14px;
      width: 100%;
      font-size: 18px;
      margin-bottom: 15px;
    }
    select, input {
      display: block;
      width: 100%;
      font-size: 18px;
      margin-bottom: 15px;
    }
    button {
      font-size: 18px;
      padding: 10px 20px;
      cursor: pointer;
    }

    #container {
      flex: 2;
      border: 1px solid #ccc;
      width: 800px;
      height: 600px;
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>

  <h1>Diseña tu Artículo</h1>
  <li><a href="irainicio">Volver</a></li>
  <a href="<?= base_url('configuracion') ?>" class="config-button">Configuración</a>
  <div class="contenedor">
  <form id="designForm" method="post" action="<?= base_url('diseno/guardar') ?>">
  <label for="nombre">Nombre del diseño:</label>
  <input type="text" id="nombre" name="nombre" required>

  <label for="cortina">Cortina:</label>
  <select id="cortina" name="cortina">
    <option value="si">Sí</option>
    <option value="no">No</option>
  </select>

  <label for="ventana">Ventana:</label>
  <select id="ventana" name="ventana">
    <option value="si">Sí</option>
    <option value="no">No</option>
  </select>

  <label for="postigon">Postigón:</label>
  <select id="postigon" name="postigon">
    <option value="si">Sí</option>
    <option value="no">No</option>
  </select>

  <input class="botons" type="submit" value="Cargar al inicio">
</form>

    <div id="container"></div>
  </div>

  <script>
    const stage = new Konva.Stage({
      container: 'container',
      width: 800,
      height: 600,
    });

    const layer = new Konva.Layer();
    stage.add(layer);

    function cargarImagen(src, callback) {
      const img = new Image();
      img.onload = () => callback(img);
      img.onerror = () => console.error('Error al cargar: ' + src);
      img.src = src;
    }

    function mostrarDiseño() {
      const nombre = document.getElementById('nombre').value;
      const cortina = document.getElementById('cortina').value;
      const ventana = document.getElementById('ventana').value;
      const postigon = document.getElementById('postigon').value;

      layer.destroyChildren(); // limpiar canvas

      const texto = new Konva.Text({
        x: 20,
        y: 10,
        text: nombre,
        fontSize: 28,
        fill: 'black',
      });
      layer.add(texto);

      const yBase = 80;
      const xBase = 100;
      const ancho = 600;
      const alto = 400;

      const cargarTodo = () => {
        let promesas = [];

        if (postigon === 'si') {
          promesas.push(new Promise(resolve => {
            cargarImagen('img/postigon.png', function (img) {
              const imagen = new Konva.Image({
                opacity: 1,
                image: img, x: xBase, y: yBase, width: ancho, height: alto
              });
              layer.add(imagen);
              resolve();
            });
          }));
        }

        if (ventana === 'si') {
          promesas.push(new Promise(resolve => {
            cargarImagen('img/ventana.png', function (img) {
              const imagen = new Konva.Image({
                opacity: 0.8,
                image: img, x: xBase, y: yBase, width: ancho, height: alto
              });
              layer.add(imagen);
              resolve();
            });
          }));
        }

        if (cortina === 'si') {
          promesas.push(new Promise(resolve => {
            cargarImagen('img/cortina.png', function (img) {
              const imagen = new Konva.Image({
                opacity: 0.6,
                image: img, x: xBase, y: yBase, width: ancho, height: alto
              });
              layer.add(imagen);
              resolve();
            });
          }));
        }

        Promise.all(promesas).then(() => {
          layer.draw();
        });
      };

      cargarTodo();
    }

    document.querySelectorAll('select, input').forEach(el => {
      el.addEventListener('change', mostrarDiseño);
    });

    mostrarDiseño();

    document.getElementById('designForm').addEventListener('submit', function (e) {
      alert('Diseño guardado: ' + document.getElementById('nombre').value);
    });
  </script>
</body>
</html>
