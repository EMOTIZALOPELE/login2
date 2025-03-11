<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseño de Artículos</title>
    <script src="https://cdn.jsdelivr.net/npm/konva@8.0.3/konva.min.js"></script>
</head>
<body>
    <h1>Diseña tu Ventana, Cortina y Postigón</h1>

    <!-- Formulario para ingresar el nombre y opciones SI/NO -->
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

    <!-- Área de diseño de los artículos -->
    <div id="container"></div>

    <script>
        // Crear la etapa de Konva
        var stage = new Konva.Stage({
            container: 'container',
            width: 600,
            height: 400,
        });

        var layer = new Konva.Layer();
        stage.add(layer);

        // Función para crear los artículos de acuerdo a la selección
        function crearArticulos() {
            var ventana = document.getElementById('ventana').value;
            var cortina = document.getElementById('cortina').value;
            var postigon = document.getElementById('postigon').value;

            // Limpiar la capa
            layer.destroyChildren();

            // Crear "ventana" si está seleccionada
            if (ventana === 'si') {
                var ventanaRect = new Konva.Rect({
                    x: 50,
                    y: 50,
                    width: 200,
                    height: 150,
                    fill: 'lightblue',
                    stroke: 'black',
                    strokeWidth: 2
                });
                layer.add(ventanaRect);
            }

            // Crear "cortina" si está seleccionada
            if (cortina === 'si') {
                var cortinaRect = new Konva.Rect({
                    x: 60,
                    y: 60,
                    width: 180,
                    height: 120,
                    fill: 'lightgray',
                    stroke: 'black',
                    strokeWidth: 2
                });
                layer.add(cortinaRect);
            }

            // Crear "postigón" si está seleccionado
            if (postigon === 'si') {
                var postigonRect = new Konva.Rect({
                    x: 300,
                    y: 50,
                    width: 200,
                    height: 150,
                    fill: 'brown',
                    stroke: 'black',
                    strokeWidth: 2
                });
                layer.add(postigonRect);
            }

            // Redibujar la capa
            layer.draw();
        }

        // Llamar a la función para crear los artículos al cargar la página
        crearArticulos();

        // Actualizar la vista cuando el usuario cambia las opciones
        document.getElementById('ventana').addEventListener('change', crearArticulos);
        document.getElementById('cortina').addEventListener('change', crearArticulos);
        document.getElementById('postigon').addEventListener('change', crearArticulos);

        // Guardar los datos al hacer submit
        document.getElementById('designForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var Nombreventana = document.getElementById('Nombreventana').value;
            var ventana = document.getElementById('ventana').value;
            var cortina = document.getElementById('cortina').value;
            var postigon = document.getElementById('postigon').value;

            // Aquí puedes enviar estos datos al servidor o guardarlos localmente
            console.log({
                Nombreventana: Nombreventana,
                ventana: ventana,
                cortina: cortina,
                postigon: postigon
            });

            // Enviar a la base de datos en el futuro con AJAX
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
                if (data.status === 'success') {
                    alert('Diseño guardado correctamente');
                } else {
                    alert('Hubo un error al guardar el diseño');
                }
            });
        });
    </script>
</body>
aaa
</html>
