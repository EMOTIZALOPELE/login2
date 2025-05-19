<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>Inicio</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Reset de estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header{
            width: 100%;
            height: 70px;
            position: fixed;
            top: 0; /* Aseguramos que el header fijo esté arriba */
            left: 0;
            z-index: 1000; /* Z-index alto para que esté por encima de todo */
            background:rgba(34, 31, 31, 0.8); /* Fondo semi-transparente */
            backdrop-filter: blur(5px); /* Efecto de desenfoque */
            box-shadow: 0 2px 5px rgba(0,0,0,0.5); /* Sombra */
        }

        body {
            background: url(<?= base_url("img/fondo4.jpg") ?>) no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            min-height: 100vh; /* Usamos min-height para que el contenido determine la altura */
            padding-top: 85px; /* Añadimos padding superior para el header fijo */
            overflow-x: hidden; /* Evita scroll horizontal */
        }

        /* Eliminamos estilos conflictivos del body que centran todo */
        /* display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; */


        /* Menú lateral */
        .container__menu{
            max-width: 1800px;
            height: 100%;
            width: 100%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            /* background:rgba(34, 31, 31, 0.51); /* Ya definido en header */
        }
        .menu{
            display: flex;
            align-items: center;
        }
        .menu ul{
            display: flex;
            justify-content: space-around; /* Espaciado igual entre los botones */
            gap: 1px; /* Espaciado fijo entre botones */
        }

        .menu ul li{
            list-style: none;
            margin-left: 20px;
        }

        .menu ul li a{
            text-decoration: none;
            font-size: 16px;
            color:rgb(255, 255, 255);
            text-transform: uppercase;
            text-align: center;
            cursor: pointer;
            transition: all 0.5s ease-in-out;
            padding: 15px 20px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            display: inline-block; /* Para evitar problemas de tamaño */
        }
        .menu ul li a:hover {
            transform: translateY(-5px) scale(1.05); /* Levanta y agranda el botón */
            background: rgba(255, 255, 255, 0.2); /* Fondo semitransparente */
            box-shadow: -1px 1px 25px rgba(255, 255, 255, 0.4);
            border-radius: 15px; /* Aumenta el redondeo para mayor suavidad */
        }

        #selected{
            background: #F6615D;
            padding: 10px 40px;
            border-radius: 50px;
        }

        /* Contenido principal */
        .container__card {
             /* Eliminamos estilos conflictivos que centran el contenedor */
             /* display: flex;
             flex-wrap: wrap;
             justify-content: space-around;
             gap: 5px;
             padding: 20px; */
             width: 100%; /* Ocupa todo el ancho */
             padding: 20px; /* Padding interno */
             margin-top: 5px; /* Espacio para el header fijo */
        }

        .horarios-container {
            display: flex;
            flex-wrap: wrap; /* Permite que las tarjetas se acomoden solas */
            gap: 20px; /* Aumentamos el gap para mejor separación */
            justify-content: center; /* Centra las tarjetas horizontalmente */
             align-items: flex-start; /* Alinea las tarjetas en la parte superior */
             height: auto; /* La altura se ajusta al contenido */
        }

        .horario-card {
            /* margin-top: 40px; /* Eliminamos el margen superior, ya usamos gap */
            background:rgb(231, 230, 235);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: calc(33.33% - 20px); /* Ajustamos el ancho considerando el nuevo gap */
            max-width: 300px; /* No crece más de 300px */
            text-align: center;
            transition: all 0.5s ease-in-out;
        }
        .horario-card:hover {
            transform: scale(1.03); /* Reducimos un poco la escala al pasar el mouse */
            border-radius: 8px; /* Mantenemos el borde redondeado más sutil */
        }
        .horario-card h3 {
            background: #1f53c5;
            color: white;
            font-size: 20px;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            margin: -25px -25px 15px -25px;
        }
        .horario-card p {
            font-size: 16px;
            color:rgb(8, 16, 34);
            margin: 10px 1px 10px 10px;
            text-align: left;
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .config-button{ /* Aplicamos estilos similares a ambos botones */
            display: flex;
            gap: 10px;
            justify-content: center; /* Centra el texto dentro del botón */
            margin-top: 15px;
            padding: 10px 20px;
            background: #1f53c5;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            border: none; /* Quitamos el borde por defecto del botón */
            cursor: pointer; /* Indicamos que es clickeable */
            flex-grow: 1; /* Permite que los botones crezcan para llenar el espacio */
        }

        .config-button:hover, .change-name-button:hover {
            background: #163a94;
            transform: scale(1.05);
        }

        .delete-button {
            width: 100%;
            display: block;
            margin-top: 20px;
            padding: 10px;
            background:rgb(197, 31, 31);
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            border: none; /* Quitamos el borde por defecto del botón */
            cursor: pointer; /* Indicamos que es clickeable */
        }

        .delete-button:hover {
            background-color:rgb(197, 31, 31);
            transform: scale(1.05);
        }

        .button-container {
            display: flex; /* Usa flexbox para alinear los botones en fila */
            gap: 10px; /* Espacio entre los botones */
             justify-content: space-between; /* Espacia los botones */
        }

        .add-name-button,
        .save-name-button {
            display: block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #1f53c5;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .add-name-button:hover,
        .save-name-button:hover {
            background-color: #0056b3;
        }

        .name-form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        /* Estilos para los modales (Bootstrap ya maneja la mayoría) */
        .modal-content {
            background-color: #fefefe; /* Fondo blanco para el modal */
            color: #333; /* Texto oscuro */
        }
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
        .modal-body input[type="text"] {
            width: 100%; /* Input ocupa todo el ancho */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Estilos específicos para el modal de éxito */
        #successModal .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,.5);
        }
         #successModal .modal-header {
             background-color: #28a745; /* Verde para éxito */
             color: white;
             border-top-left-radius: 10px;
             border-top-right-radius: 10px;
             padding: 15px;
         }
         #successModal .modal-header .close {
             color: white;
         }
         #successModal .modal-body {
             padding: 20px;
             text-align: center; /* Centra el texto del mensaje */
             font-size: 1.1rem;
         }
         #successModal .modal-footer {
             justify-content: center; /* Centra el botón en el footer */
             padding: 10px;
         }
         #successModal .modal-footer .btn {
             padding: 8px 20px;
             border-radius: 5px;
         }

        /*Método Responsive*/
        @media screen and (max-width:1200px){
            header{
                padding: 10px 20px; /* Ajuste de padding */
            }
             .horario-card {
                 width: calc(50% - 20px); /* Dos tarjetas por fila */
             }
        }

        .horario-card {
                 width: calc(50% - 20px); /* Dos tarjetas por fila */
             }

        /* Animaciones (si las necesitas) */
        /* @keyframes fadeIn { ... } */
        /* @keyframes slideIn { ... } */

    </style>
</head>
<body>

    <header>
        <div class="container__menu">
            <div class="logo">
                <img src="" alt="">
            </div>
            <div class="menu">
                <i class="fas fa-bars" id="btn_menu"></i>
                <div id="back_menu"></div>
                <nav id="nav">
                    <img src="" alt="">
                    <ul>
                        <li><a href="<?= base_url('/inicio') ?>" id="selected">Inicio</a></li>
                        <li><a href="<?= base_url('addtarjeta') ?>">Añadir Tarjeta</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                        <li><a href="<?= base_url('logout') ?>">salir</a></li>
                         <li><a href="<?= base_url('/masivo') ?>">SERVO</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container__card">
        <div class="horarios-container">
            <?php foreach ($horarios as $horario): ?>
                <div class="horario-card">
                    <h3 data-idhorario="<?= esc($horario['idhorario']); ?>">
                        <span class="card-title"><?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                            ? esc($horario['nombre_tarjeta'])
                            : 'Horario de ' . session()->get('nombre'); ?></span>
                    </h3>

                    <p><strong>Ventana Apertura:</strong> <?= esc($horario['ventana_apertura']); ?></p>
                    <p><strong>Ventana Cierre:</strong> <?= esc($horario['ventana_cierre']); ?></p>
                    <p><strong>Cortina Apertura:</strong> <?= esc($horario['cortina_apertura']); ?></p>
                    <p><strong>Cortina Cierre:</strong> <?= esc($horario['cortina_cierre']); ?></p>
                    <p><strong>Postigón Apertura:</strong> <?= esc($horario['postigon_apertura']); ?></p>
                    <p><strong>Postigón Cierre:</strong> <?= esc($horario['postigon_cierre']); ?></p>

                    <form action="<?= site_url('configurar/' . esc($horario['idhorario'])) ?>" method="POST" style="display: inline-block; flex-grow: 1;">
                            <button type="submit" class="config-button">Configurar</button>
                    </form>
                    
                    <div class="button-container">
                        <button type="button" class="config-button"
                                 data-toggle="modal" data-target="#changeNameModal"
                                 data-idhorario="<?= esc($horario['idhorario']); ?>"
                                 data-current-name="<?= isset($horario['nombre_tarjeta']) && !empty($horario['nombre_tarjeta'])
                                     ? esc($horario['nombre_tarjeta'])
                                     : 'Horario de ' . session()->get('nombre'); ?>">
                             Cambiar Nombre
                         </button>
                    </div>
                    
                    <form action="<?= site_url('borrar_tarjeta/' . esc($horario['idhorario'])) ?>" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarjeta?');">
                        <button type="submit" class="delete-button">Eliminar</button>
                    </form>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal fade" id="changeNameModal" tabindex="-1" role="dialog" aria-labelledby="changeNameModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeNameModalLabel">Cambiar Nombre de Tarjeta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newCardName" class="form-control" placeholder="Nuevo nombre de la tarjeta">
                    <input type="hidden" id="cardIdToChange"> </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveNewNameBtn">Guardar Nombre</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="successModalBody">
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Script para el menú desplegable en móvil
        document.getElementById('btn_menu').addEventListener('click', function() {
            document.getElementById('nav').classList.toggle('show');
            document.getElementById('back_menu').style.display = 'block';
        });

        document.getElementById('back_menu').addEventListener('click', function() {
            document.getElementById('nav').classList.remove('show');
            document.getElementById('back_menu').style.display = 'none';
        });

        // Script para los modales
        $(document).ready(function() {
            // Cuando se abre el modal de cambiar nombre, llenamos el campo de texto y guardamos el ID
            $('#changeNameModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Botón que activó el modal
                const cardId = button.data('idhorario'); // Extrae info de los data-* attributes
                const currentName = button.data('current-name');

                const modal = $(this);
                modal.find('.modal-body #newCardName').val(currentName); // Llena el input con el nombre actual
                modal.find('.modal-body #cardIdToChange').val(cardId); // Guarda el ID en el campo oculto
            });

            // Cuando se hace clic en el botón "Guardar Nombre" dentro del modal de cambiar nombre
            $('#saveNewNameBtn').on('click', function() {
                const cardId = $('#cardIdToChange').val(); // Obtiene el ID del campo oculto
                const newName = $('#newCardName').val(); // Obtiene el nuevo nombre del input

                if (!newName.trim()) {
                    alert('El nombre de la tarjeta no puede estar vacío.');
                    return;
                }

                // Realiza la llamada AJAX a tu controlador de CodeIgniter
                $.ajax({
                    url: '<?= base_url('actualizar_nombre_tarjeta') ?>', // Asegúrate de que esta ruta esté configurada en Routes.php
                    method: 'POST',
                    data: {
                        idhorario: cardId,
                        nombre_tarjeta: newName
                    },
                    dataType: 'json', // Esperamos una respuesta JSON
                    success: function(response) {
                        if (response.success) {
                            // Si la actualización fue exitosa
                            // Cierra el modal de cambiar nombre
                            $('#changeNameModal').modal('hide');

                            // Muestra el modal de éxito con el mensaje del servidor
                            $('#successModalBody').text(response.message);
                            $('#successModal').modal('show');

                            // Actualiza el nombre en la tarjeta sin recargar la página
                            $(`.horario-card h3[data-idhorario="${cardId}"] .card-title`).text(newName);
                            // Actualiza el data-attribute del botón para futuras ediciones
                            $(`.change-name-button[data-idhorario="${cardId}"]`).data('current-name', newName);

                        } else {
                            // Si hubo un error reportado por el servidor
                            // Cierra el modal de cambiar nombre
                            $('#changeNameModal').modal('hide');
                            // Muestra una alerta con el error
                            alert('Error al actualizar el nombre: ' + (response.message || 'Error desconocido'));
                        }
                    },
                    error: function(xhr, status, error) {
                        // Maneja errores de la petición AJAX
                        console.error('Error AJAX:', status, error, xhr.responseText);
                         // Cierra el modal de cambiar nombre
                        $('#changeNameModal').modal('hide');
                        // Muestra una alerta genérica de error de comunicación
                        alert('Ocurrió un error al comunicarse con el servidor.');
                    }
                });
            });
        });
    </script>

</body>
</html>
