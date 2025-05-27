<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <title>VECOPO - Control Inteligente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.8);
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
            --accent-color: #64ffda;
            --danger-color: #ff4d4d;
            --success-color: #00ff9d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 242, 254, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(79, 172, 254, 0.05) 0%, transparent 20%);
        }

        /* Header Moderno */
        header {
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .container__menu {
            max-width: 1800px;
            margin: auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 242, 254, 0.3);
        }

        .menu ul {
            display: flex;
            gap: 1.5rem;
            list-style: none;
        }

        .menu ul li a {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 1rem;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background: transparent;
            border: 1px solid rgba(100, 255, 218, 0.2);
        }

        .menu ul li a:hover {
            background: rgba(100, 255, 218, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2);
        }

        #selected {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: var(--dark-bg);
            font-weight: 500;
        }

        /* Contenedor Principal */
        .container__card {
            padding: 2rem;
            margin-top: 5rem;
        }

        .horarios-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .horario-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(100, 255, 218, 0.1);
            backdrop-filter: blur(10px);
        }

        .horario-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(100, 255, 218, 0.1), transparent);
            transform: translateX(-100%);
            transition: 0.6s;
        }

        .horario-card:hover::before {
            transform: translateX(100%);
        }

        .horario-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(100, 255, 218, 0.2);
        }

        .horario-card h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(100, 255, 218, 0.2);
        }

        .horario-card p {
            color: var(--text-secondary);
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .horario-card p strong {
            color: var(--text-primary);
            min-width: 150px;
        }

        /* Botones */
        .button-container {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .config-button {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--dark-bg);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .config-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .delete-button {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .delete-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.3);
        }

        /* Modales */
        .modal-content {
            background: var(--card-bg);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 20px;
            color: var(--text-primary);
        }

        .modal-header {
            border-bottom: 1px solid rgba(100, 255, 218, 0.2);
            padding: 1.5rem;
        }

        .modal-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(100, 255, 218, 0.2);
            padding: 1.5rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.8rem 1rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 500;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 500;
        }

        /* Modal de Código */
        #codigoModal {
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
        }

        #codigoModal > div {
            background: var(--card-bg);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 20px;
            padding: 2rem;
        }

        #codigoModal h3 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        #codigoModal input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 1rem;
            width: 100%;
            margin: 1rem 0;
        }

        #codigoModal button {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--dark-bg);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }

        #codigoModal button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container__menu {
                padding: 1rem;
            }

            .menu ul {
                gap: 0.5rem;
            }

            .menu ul li a {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .horarios-container {
                grid-template-columns: 1fr;
            }

            .button-container {
                flex-direction: column;
            }
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .horario-card {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Efecto de partículas en el fondo */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            50% { opacity: 0.5; }
            100% { transform: translateY(-100vh) translateX(100px); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <header>
        <div class="container__menu">
            <div class="logo">VECOPO</div>
            <div class="menu">
                <nav id="nav">
                    <ul>
                        <li><a href="<?= base_url('/inicio') ?>" id="selected">Inicio</a></li>
                        <li><a href="#" onclick="abrirModal()">Añadir Tarjeta</a></li>
                        <li><a href="<?= base_url('pele') ?>">Diseño</a></li>
                        <li><a href="<?= base_url('logout') ?>">Salir</a></li>
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

                    <div class="button-container">
                        <form action="<?= site_url('configurar/' . esc($horario['idhorario'])) ?>" method="POST" style="flex: 1;">
                            <button type="submit" class="config-button">Configurar</button>
                        </form>
                        
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

    <!-- Modales existentes con el nuevo estilo -->
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
                    <input type="hidden" id="cardIdToChange">
                </div>
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
                <div class="modal-body" id="successModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="codigoModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(10, 25, 47, 0.95); justify-content:center; align-items:center;">
        <div>
            <h3>Ingrese el código del dispositivo</h3>
            <form id="codigoForm">
                <input type="text" id="codigoInput" name="codigo" placeholder="Código del dispositivo" required>
                <div id="codigoError" style="color:var(--danger-color); display:none;">Código inválido</div>
                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                    <button type="submit">Verificar</button>
                    <button type="button" onclick="cerrarModal()" style="background: rgba(255, 255, 255, 0.1);">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script para crear partículas en el fondo
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Inicializar partículas
        createParticles();

        // Scripts existentes
        function abrirModal() {
            document.getElementById('codigoModal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('codigoModal').style.display = 'none';
            document.getElementById('codigoError').style.display = 'none';
            document.getElementById('codigoInput').value = '';
        }

        document.getElementById('codigoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const codigo = document.getElementById('codigoInput').value;

            fetch('<?= base_url('verificar-codigo') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ codigo: codigo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '<?= base_url('addtarjeta') ?>/' + data.dispositivo_id;
                } else {
                    document.getElementById('codigoError').style.display = 'block';
                }
            });
        });

        // Script para los modales
        $(document).ready(function() {
            $('#changeNameModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const cardId = button.data('idhorario');
                const currentName = button.data('current-name');

                const modal = $(this);
                modal.find('.modal-body #newCardName').val(currentName);
                modal.find('.modal-body #cardIdToChange').val(cardId);
            });

            $('#saveNewNameBtn').on('click', function() {
                const cardId = $('#cardIdToChange').val();
                const newName = $('#newCardName').val();

                if (!newName.trim()) {
                    alert('El nombre de la tarjeta no puede estar vacío.');
                    return;
                }

                $.ajax({
                    url: '<?= base_url('actualizar_nombre_tarjeta') ?>',
                    method: 'POST',
                    data: {
                        idhorario: cardId,
                        nombre_tarjeta: newName
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#changeNameModal').modal('hide');
                            $('#successModalBody').text(response.message);
                            $('#successModal').modal('show');
                            $(`.horario-card h3[data-idhorario="${cardId}"] .card-title`).text(newName);
                            $(`.change-name-button[data-idhorario="${cardId}"]`).data('current-name', newName);
                        } else {
                            $('#changeNameModal').modal('hide');
                            alert('Error al actualizar el nombre: ' + (response.message || 'Error desconocido'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX:', status, error, xhr.responseText);
                        $('#changeNameModal').modal('hide');
                        alert('Ocurrió un error al comunicarse con el servidor.');
                    }
                });
            });
        });
    </script>
</body>
</html>