<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diseño de Artículos</title>
    <script src="https://cdn.jsdelivr.net/npm/konva@8.0.3/konva.min.js"></script>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: white;
            height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #222;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            flex: 1;
            color: white;
        }

        .config-button, .back-btn {
            text-decoration: none;
            color: white;
            border: 2px solid #1f53c5;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .config-button:hover, .back-btn:hover {
            background-color: #1f53c5;
            color: white;
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
            background: #333;
            padding: 20px;
            border-radius: 10px;
        }

        label {
            display: block;
            color: white;
            font-size: 18px;
            margin-bottom: 10px;
        }

        select, input {
            display: block;
            width: 100%;
            font-size: 18px;
            margin-bottom: 15px;
            padding: 8px;
            border-radius: 5px;
            border: none;
        }

        button {
            font-size: 18px;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #1f53c5;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #333;
        }

        #container {
            flex: 2;
            border: 1px solid #ccc;
            width: 800px;
            height: 600px;
            background-color: #444;
            position: relative;
        }
    </style>
</head>
<body>

    <header>
        <a href="irainicio" class="back-btn">Volver</a>
        <h1 class="logo">VECOPO</h1>
        <a href="<?= base_url('/configuracion') ?>" class="config-button">Configuración</a>
    </header>

    <div class="contenedor">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('mensaje')): ?>
            <div class="alert alert-success">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <form id="designForm" method="post" action="<?= base_url('diseno/guardar') ?>" onsubmit="return validarFormulario()">
            <label for="nombre">Nombre del diseño:</label>
            <input type="text" id="nombre" name="nombre" required minlength="3" value="<?= old('nombre') ?>">

            <label for="cortina">Cortina:</label>
            <select id="cortina" name="cortina" onchange="mostrarDiseño()" required>
                <option value="si" <?= old('cortina') === 'si' ? 'selected' : '' ?>>Sí</option>
                <option value="no" <?= old('cortina') === 'no' ? 'selected' : '' ?>>No</option>
            </select>

            <label for="ventana">Ventana:</label>
            <select id="ventana" name="ventana" onchange="mostrarDiseño()" required>
                <option value="si" <?= old('ventana') === 'si' ? 'selected' : '' ?>>Sí</option>
                <option value="no" <?= old('ventana') === 'no' ? 'selected' : '' ?>>No</option>
            </select>

            <label for="postigon">Postigón:</label>
            <select id="postigon" name="postigon" onchange="mostrarDiseño()" required>
                <option value="si" <?= old('postigon') === 'si' ? 'selected' : '' ?>>Sí</option>
                <option value="no" <?= old('postigon') === 'no' ? 'selected' : '' ?>>No</option>
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
            img.onerror = () => {
                console.error('Error al cargar: ' + src);
                // Crear una imagen de relleno si falla la carga
                const canvas = document.createElement('canvas');
                canvas.width = 100;
                canvas.height = 100;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ff0000';
                ctx.fillRect(0, 0, 100, 100);
                ctx.fillStyle = '#ffffff';
                ctx.font = '12px Arial';
                ctx.fillText('Imagen no encontrada', 10, 50);
                const fallbackImg = new Image();
                fallbackImg.onload = () => callback(fallbackImg);
                fallbackImg.src = canvas.toDataURL();
            };
            img.src = src;
        }

        function mostrarDiseño() {
            const nombre = document.getElementById('nombre').value;
            const cortina = document.getElementById('cortina').value;
            const ventana = document.getElementById('ventana').value;
            const postigon = document.getElementById('postigon').value;

            layer.destroyChildren();

            const texto = new Konva.Text({
                x: 20,
                y: 10,
                text: nombre || "Nuevo Diseño",
                fontSize: 28,
                fill: 'white',
            });
            layer.add(texto);

            const yBase = 80;
            const xBase = 100;
            const ancho = 600;
            const alto = 400;

            // Fondo blanco para el área de diseño
            const fondo = new Konva.Rect({
                x: xBase,
                y: yBase,
                width: ancho,
                height: alto,
                fill: 'white',
                stroke: '#888',
                strokeWidth: 1
            });
            layer.add(fondo);

            const cargarTodo = () => {
                let promesas = [];

                if (postigon === 'si') {
                    promesas.push(new Promise(resolve => {
                        cargarImagen('img/postigon.png', function (img) {
                            const imagen = new Konva.Image({
                                image: img, 
                                x: xBase, 
                                y: yBase, 
                                width: ancho, 
                                height: alto,
                                opacity: 1  // Máxima visibilidad para el postigón
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
                                image: img, 
                                x: xBase, 
                                y: yBase, 
                                width: ancho, 
                                height: alto,
                                opacity: 0.9  // Alta visibilidad para la ventana
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
                                image: img, 
                                x: xBase, 
                                y: yBase, 
                                width: ancho, 
                                height: alto,
                                opacity: 0.85  // Visibilidad alta pero permite ver lo que hay detrás
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

        // Mostrar diseño inicial al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar eventos para cambios en tiempo real
            document.getElementById('nombre').addEventListener('input', mostrarDiseño);
            mostrarDiseño();
        });

        function validarFormulario() {
            const nombre = document.getElementById('nombre').value.trim();
            if (nombre.length < 3) {
                alert('El nombre debe tener al menos 3 caracteres');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>