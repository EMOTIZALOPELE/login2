<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Diseño de Artículos</title>
  <script src="https://cdn.jsdelivr.net/npm/konva@8.0.3/konva.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
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

    label, select, input {
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

  <div class="contenedor">
    <form id="designForm">
      <label for="nombre">Nombre del diseño:</label>
      <input type="text" id="nombre" required>

      <label for="ventana">Ventana:</label>
      <select id="ventana">
        <option value="si">Sí</option>
        <option value="no">No</option>
      </select>

      <label for="cortina">Cortina:</label>
      <select id="cortina">
        <option value="si">Sí</option>
        <option value="no">No</option>
      </select>

      <label for="postigon">Postigón:</label>
      <select id="postigon">
        <option value="si">Sí</option>
        <option value="no">No</option>
      </select>

      <button type="submit">Guardar Diseño</button>
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
      const ventana = document.getElementById('ventana').value;
      const cortina = document.getElementById('cortina').value;
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
      e.preventDefault();
      alert('Diseño guardado: ' + document.getElementById('nombre').value);
    });
  </script>
</body>
</html>
