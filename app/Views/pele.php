<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diseño de Artículos</title>
    <script src="https://cdn.jsdelivr.net/npm/konva@8.0.3/konva.min.js"></script>
</head>
<body>
    <h1>Diseña tu Ventana, Cortina y Postigón</h1>

    <form id="designForm">
        <label for="Nombreventana">Nombre de tu diseño:</label>
        <input type="text" id="Nombreventana" required>
        <br>
        <label for="ventana">Ventana:</label>
        <select id="ventana">
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>
        <br>
        <label for="cortina">Cortina:</label>
        <select id="cortina">
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>
        <br>
        <label for="postigon">Postigón:</label>
        <select id="postigon">
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>
        <br>
        <button type="submit">Guardar Diseño</button>
    </form>

    <div id="container"></div>

    <script>
        var stage = new Konva.Stage({
            container: 'container',
            width: 600,
            height: 500,
        });

        var layer = new Konva.Layer();
        stage.add(layer);

        function cargarImagen(src, callback) {
            const image = new Image();
            image.onload = function () {
                callback(image);
            };
            image.src = src;
        }

        function crearArticulos() {
            var nombre = document.getElementById('Nombreventana').value;
            var ventana = document.getElementById('ventana').value;
            var cortina = document.getElementById('cortina').value;
            var postigon = document.getElementById('postigon').value;

            layer.destroyChildren(); // limpiar antes de dibujar

            // Mostrar nombre arriba
            var nombreTexto = new Konva.Text({
                x: 50,
                y: 10,
                text: nombre,
                fontSize: 24,
                fontFamily: 'Calibri',
                fill: 'black'
            });
            layer.add(nombreTexto);

            let yBase = 60;

            // Cargar y mostrar imágenes superpuestas
            if (ventana === 'si') {
                cargarImagen('https://i.imgur.com/WKc1ckx.png', function (img) {
                    var ventanaImg = new Konva.Image({
                        image: img,
                        x: 150,
                        y: yBase,
                        width: 300,
                        height: 200,
                    });
                    layer.add(ventanaImg);
                    layer.draw();
                });
            }

            if (cortina === 'si') {
                cargarImagen('https://i.imgur.com/K4VahGk.png', function (img) {
                    var cortinaImg = new Konva.Image({
                        image: img,
                        x: 150,
                        y: yBase,
                        width: 300,
                        height: 200,
                    });
                    layer.add(cortinaImg);
                    layer.draw();
                });
            }

            if (postigon === 'si') {
                cargarImagen('https://i.imgur.com/F7IGIhR.png', function (img) {
                    var postigonImg = new Konva.Image({
                        image: img,
                        x: 150,
                        y: yBase,
                        width: 300,
                        height: 200,
                    });
                    layer.add(postigonImg);
                    layer.draw();
                });
            }
        }

        // Al cargar la página
        crearArticulos();

        // Cuando cambian las opciones
        document.getElementById('ventana').addEventListener('change', crearArticulos);
        document.getElementById('cortina').addEventListener('change', crearArticulos);
        document.getElementById('postigon').addEventListener('change', crearArticulos);
        document.getElementById('Nombreventana').addEventListener('input', crearArticulos);

        // Envío del formulario
        document.getElementById('designForm').addEventListener('submit', function (event) {
            event.preventDefault();
            var Nombreventana = document.getElementById('Nombreventana').value;
            var ventana = document.getElementById('ventana').value;
            var cortina = document.getElementById('cortina').value;
            var postigon = document.getElementById('postigon').value;

            fetch('/design/saveDesign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    Nombreventana: Nombreventana,
                    ventana: ventana,
                    cortina: cortina,
                    postigon: postigon
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.status === 'success' ? 'Diseño guardado correctamente' : 'Error al guardar');
            });
        });
    </script>
</body>
</html>
