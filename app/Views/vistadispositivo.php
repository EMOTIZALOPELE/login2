<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Dispositivos - VECOPO</title>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe; --secondary-color: #4facfe; --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.8); --text-primary: #ffffff; --text-secondary: #8892b0;
            --accent-color: #64ffda; --danger-color: #ff4d4d; --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
        }
        body { font-family: 'Roboto', sans-serif; background: var(--dark-bg); color: var(--text-primary); }
        .container-fluid { max-width: 1800px; padding: 2rem 1.5rem; }
        .page-title { font-family: 'Orbitron', sans-serif; font-size: 2.5rem; text-align: center; margin-bottom: 2rem; color: var(--primary-color); }
        .device-card { background: var(--card-bg); border: 1px solid var(--input-border); border-radius: 20px; padding: 2rem; margin-bottom: 2rem; backdrop-filter: blur(10px); }
        .device-card h3 { font-family: 'Orbitron', sans-serif; color: var(--accent-color); border-bottom: 1px solid var(--input-border); padding-bottom: 0.75rem; margin-bottom: 1.5rem; }
        .form-group label { color: var(--text-secondary); }
        .form-control { background: rgba(255, 255, 255, 0.05); border-color: var(--input-border); color: var(--text-primary); }
        .form-control:focus { background: rgba(255, 255, 255, 0.1); border-color: var(--primary-color); color: var(--text-primary); box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25); }
        .btn-custom { padding: 0.6rem 1.2rem; border-radius: 50px; font-weight: 500; transition: all 0.3s ease; border: none; }
        .btn-primary-custom { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: var(--dark-bg); }
        .btn-danger-custom { background: var(--danger-color); color: white; }
        .btn-custom:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.2); }
        .mac-address { font-family: 'monospace'; background-color: rgba(0,0,0,0.3); padding: 5px 10px; border-radius: 5px; color: var(--accent-color); }
        .section-divider { border-top: 1px solid var(--input-border); margin: 2rem 0; }
        .servo-item { background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 10px; margin-bottom: 1rem; border: 1px solid var(--input-border); }
        .servo-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .servo-info { flex-grow: 1; }
        .servo-name-display { font-family: 'Orbitron', sans-serif; color: var(--primary-color); font-size: 1.2rem; margin-bottom: 0.5rem; }
        .servo-details { color: var(--text-secondary); font-size: 0.9rem; }
        .device-info-card { background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 15px; border: 1px solid var(--input-border); margin-bottom: 1.5rem; }
        .info-label { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 0.25rem; }
        .info-value { color: var(--text-primary); font-size: 1.1rem; font-weight: 500; }
        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--input-border);
        }
        .modal-header, .modal-footer {
            border-color: var(--input-border);
        }
        .modal-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--danger-color);
        }
        .close { color: white; opacity: 0.8; }
    </style>
</head>
<body>

    <?php
$title = 'Gestión de Dispositivos - VECOPO';
?>
<?= $this->include('partials/header') ?>

    <div class="container-fluid" style="padding-top: 2rem;">
        <h1 class="page-title">Gestión de Dispositivos</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (empty($dispositivos_y_tarjetas)): ?>
            <div class="text-center">
                <p style="color: var(--text-secondary);">No tienes dispositivos activos. Añade uno desde la página de inicio.</p>
            </div>
        <?php else: ?>
            <?php foreach ($dispositivos_y_tarjetas as $item): ?>
                <div class="device-card">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Información del Dispositivo (SOLO LECTURA) -->
                            <div class="device-info-card">
                                <h3><i class="fas fa-microchip"></i> Información del Dispositivo</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">MAC del Dispositivo</div>
                                        <div class="info-value mac-address"><?= esc($item['dispositivo']['codigo']) ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Nombre del Dispositivo</div>
                                        <div class="info-value"><?= esc($item['dispositivo']['nombre_dispositivo'] ?? 'Sin nombre') ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gestión de la Tarjeta Asociada -->
                            <?php if ($item['tarjeta']): ?>
                                <h3><i class="far fa-credit-card"></i> Tarjeta Asociada</h3>
                                <form action="<?= site_url('dispositivos/cambiar-nombre-tarjeta') ?>" method="POST" class="mt-4">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="tarjeta_id" value="<?= esc($item['tarjeta']['idhorario']) ?>">
                                    <div class="form-group">
                                        <label for="nombre_tarjeta_<?= esc($item['tarjeta']['idhorario']) ?>">Nombre de la Tarjeta</label>
                                        <input type="text" class="form-control" id="nombre_tarjeta_<?= esc($item['tarjeta']['idhorario']) ?>" 
                                               name="nombre_tarjeta" value="<?= esc($item['tarjeta']['nombre_tarjeta']) ?>" 
                                               placeholder="Ej: Horarios de Verano, Configuración Principal, etc." required>
                                        <small class="form-text text-muted">
                                            Este nombre identifica la configuración de horarios para el dispositivo: 
                                            <strong><?= esc($item['dispositivo']['nombre_dispositivo'] ?? 'Dispositivo ' . $item['dispositivo']['id']) ?></strong>
                                        </small>
                                    </div>
                                    <button type="submit" class="btn-custom btn-primary-custom">
                                        <i class="fas fa-save"></i> Actualizar Nombre de Tarjeta
                                    </button>
                                </form>
                            <?php else: ?>
                                <h3><i class="far fa-credit-card"></i> Tarjeta Asociada</h3>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Este dispositivo no tiene una tarjeta de horarios asociada.
                                </div>
                            <?php endif; ?>

                            <hr class="section-divider">

                            <!-- Gestión de Servos -->
                            <h3><i class="fas fa-cogs"></i> Gestión de Servos</h3>
                            <?php if (!empty($item['servos'])): ?>
                                <?php foreach ($item['servos'] as $servo): ?>
                                    <div class="servo-item">
                                        <div class="servo-header">
                                            <div class="servo-info">
                                                <div class="servo-name-display"><?= esc($servo['nombre_servo']) ?></div>
                                                <div class="servo-details">
                                                    Tipo: <?= esc(strtoupper($servo['tipo_elemento'])) ?> | 
                                                    Pin: <?= esc($servo['pin_gpio']) ?> | 
                                                    Estado: <?= esc($servo['estado_actual']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="<?= site_url('dispositivos/cambiar-nombre-servo') ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="servo_id" value="<?= esc($servo['id']) ?>">
                                            <div class="form-group">
                                                <label for="nombre_servo_<?= esc($servo['id']) ?>">Nombre Personalizado</label>
                                                <input type="text" class="form-control" id="nombre_servo_<?= esc($servo['id']) ?>" 
                                                       name="nombre_servo" value="<?= esc($servo['nombre_servo']) ?>" 
                                                       placeholder="Ej: Ventana Principal, Cortina Dormitorio, etc." required>
                                            </div>
                                            <button type="submit" class="btn-custom btn-primary-custom">
                                                <i class="fas fa-edit"></i> Actualizar Nombre
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color: var(--text-secondary);">No hay servos configurados para este dispositivo.</p>
                            <?php endif; ?>
                        </div>

                        <div class="col-lg-6 mt-5 mt-lg-0">
                            <!-- Sección de Eliminación -->
                            <div class="device-info-card">
                                <h3 style="color: var(--danger-color);">
                                    <i class="fas fa-exclamation-triangle"></i> Zona de Peligro
                                </h3>
                                <h4 style="color: var(--danger-color);">Eliminar Dispositivo</h4>
                                <p style="color: var(--text-secondary);">
                                    Esta acción eliminará permanentemente el dispositivo, todos sus servos y la tarjeta de horarios asociada.
                                </p>
                                <p style="color: var(--accent-color); font-size: 0.9rem;">
                                    <i class="fas fa-info-circle"></i> El dispositivo quedará disponible para que otro usuario lo pueda reclamar.
                                </p>
                                <button type="button" class="btn-custom btn-danger-custom" 
                                        data-toggle="modal" 
                                        data-target="#confirmDeleteModal"
                                        data-form-action="<?= site_url('dispositivos/eliminar/' . esc($item['dispositivo']['id'])) ?>"
                                        data-card-name="<?= esc($item['tarjeta'] ? $item['tarjeta']['nombre_tarjeta'] : 'ninguna') ?>"
                                        data-device-name="<?= esc($item['dispositivo']['nombre_dispositivo'] ?? 'Dispositivo ' . $item['dispositivo']['id']) ?>">
                                    <i class="fas fa-trash-alt"></i> Eliminar Dispositivo
                                </button>
                            </div>

                            <!-- Información Adicional del Dispositivo -->
                            <div class="device-info-card mt-4">
                                <h3><i class="fas fa-info-circle"></i> Información Adicional</h3>
                                <div class="info-label">Estado del Dispositivo</div>
                                <div class="info-value">
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                
                                <div class="info-label mt-3">Servos Configurados</div>
                                <div class="info-value"><?= count($item['servos']) ?> servo(s)</div>
                                
                                <div class="info-label mt-3">Tarjeta de Horarios</div>
                                <div class="info-value">
                                    <?php if ($item['tarjeta']): ?>
                                        <span class="badge badge-primary">Configurada</span> - 
                                        <small><?= esc($item['tarjeta']['nombre_tarjeta']) ?></small>
                                    <?php else: ?>
                                        <span class="badge badge-warning">No configurada</span>
                                    <?php endif; ?>
                                </div>

                                <div class="info-label mt-3">ID de Tarjeta</div>
                                <div class="info-value">
                                    <small class="text-muted"><?= $item['tarjeta'] ? esc($item['tarjeta']['idhorario']) : 'N/A' ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar el dispositivo "<span id="deviceNameToDelete" class="font-weight-bold"></span>"?</p>
                    <p class="font-weight-bold" style="color: var(--danger-color);">
                        Atención: Esta acción también eliminará permanentemente la tarjeta de horarios llamada "<span id="cardNameToDelete" class="font-weight-bold"></span>" y liberará la MAC.
                    </p>
                    <p>Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="deleteDeviceForm" action="" method="POST" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger">Sí, Eliminar Todo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Script para manejar el modal de confirmación de borrado
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var formAction = button.data('form-action');
            var cardName = button.data('card-name');
            var deviceName = button.data('device-name');

            var modal = $(this);
            modal.find('.modal-body #cardNameToDelete').text(cardName);
            modal.find('.modal-body #deviceNameToDelete').text(deviceName);
            modal.find('#deleteDeviceForm').attr('action', formAction);
        });

        // Debug: Mostrar información de cada formulario
        $('form[action*="cambiar-nombre-tarjeta"]').each(function(index) {
            var tarjetaId = $(this).find('input[name="tarjeta_id"]').val();
            var nombreTarjeta = $(this).find('input[name="nombre_tarjeta"]').val();
            console.log('Formulario ' + index + ': tarjeta_id=' + tarjetaId + ', nombre=' + nombreTarjeta);
        });

        // Validación del formulario de nombre de tarjeta
        $('form[action*="cambiar-nombre-tarjeta"]').on('submit', function(e) {
            var nombreTarjeta = $(this).find('input[name="nombre_tarjeta"]').val().trim();
            var tarjetaId = $(this).find('input[name="tarjeta_id"]').val();
            
            if (!nombreTarjeta) {
                e.preventDefault();
                alert('Por favor, ingresa un nombre para la tarjeta.');
                return false;
            }
            
            console.log('Enviando formulario - tarjeta_id:', tarjetaId, 'nombre:', nombreTarjeta);
            return true;
        });
    });
    </script>
</body>
</html>