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

    <div class="container-fluid">
        <a href="<?= base_url('irainicio') ?>" style="text-decoration: none; color: var(--accent-color); margin-bottom: 2rem; display: inline-block;"><i class="fas fa-arrow-left"></i> Volver a Inicio</a>
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
                            <h3><i class="fas fa-microchip"></i> Dispositivo</h3>
                            <p><strong>MAC del Dispositivo:</strong> <span class="mac-address"><?= esc($item['dispositivo']['codigo']) ?></span></p>
                            <form action="<?= site_url('dispositivos/cambiar-nombre-dispositivo') ?>" method="POST" class="mt-4">
                                <?= csrf_field() ?>
                                <input type="hidden" name="dispositivo_id" value="<?= esc($item['dispositivo']['id']) ?>">
                                <div class="form-group">
                                    <label for="nombre_dispositivo_<?= esc($item['dispositivo']['id']) ?>">Nombre del Dispositivo</label>
                                    <input type="text" class="form-control" id="nombre_dispositivo_<?= esc($item['dispositivo']['id']) ?>" name="nombre_dispositivo" value="<?= esc($item['dispositivo']['nombre_dispositivo']) ?>" placeholder="Ej: Domo Principal">
                                </div>
                                <button type="submit" class="btn-custom btn-primary-custom">Cambiar Nombre del Dispositivo</button>
                            </form>

                            <hr class="section-divider">

                            <h4 style="color: var(--danger-color);">Eliminar Dispositivo</h4>
                            <p style="color: var(--text-secondary);">Esta acción eliminará permanentemente el dispositivo y su tarjeta de horarios asociada.</p>
                            <button type="button" class="btn-custom btn-danger-custom" 
                                    data-toggle="modal" 
                                    data-target="#confirmDeleteModal"
                                    data-form-action="<?= site_url('dispositivos/eliminar/' . esc($item['dispositivo']['id'])) ?>"
                                    data-card-name="<?= esc($item['tarjeta'] ? $item['tarjeta']['nombre_tarjeta'] : 'ninguna') ?>">
                                Eliminar Dispositivo
                            </button>
                        </div>

                        <div class="col-lg-6 mt-5 mt-lg-0">
                            <?php if ($item['tarjeta']): ?>
                                <h3><i class="far fa-credit-card"></i> Tarjeta Asociada</h3>
                                <form action="<?= site_url('dispositivos/cambiar-nombre-tarjeta') ?>" method="POST" class="mt-4">
                                     <?= csrf_field() ?>
                                     <input type="hidden" name="tarjeta_id" value="<?= esc($item['tarjeta']['idhorario']) ?>">
                                    <div class="form-group">
                                        <label for="nombre_tarjeta_<?= esc($item['tarjeta']['idhorario']) ?>">Nombre de la Tarjeta</label>
                                        <input type="text" class="form-control" id="nombre_tarjeta_<?= esc($item['tarjeta']['idhorario']) ?>" name="nombre_tarjeta" value="<?= esc($item['tarjeta']['nombre_tarjeta']) ?>" placeholder="Ej: Horarios de Verano">
                                    </div>
                                    <button type="submit" class="btn-custom btn-primary-custom">Cambiar Nombre de Tarjeta</button>
                                </form>
                            <?php else: ?>
                                <h3><i class="far fa-credit-card"></i> Tarjeta Asociada</h3>
                                <p style="color: var(--text-secondary);">Este dispositivo no tiene una tarjeta de horarios asociada.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

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
                    <p>¿Estás seguro de que quieres eliminar este dispositivo?</p>
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
            var button = $(event.relatedTarget); // Botón que activó el modal
            var formAction = button.data('form-action'); // Extraer la URL del data-attribute
            var cardName = button.data('card-name'); // Extraer el nombre de la tarjeta

            var modal = $(this);
            // Actualizar el contenido del modal
            modal.find('.modal-body #cardNameToDelete').text(cardName);
            // Actualizar la action del formulario dentro del modal
            modal.find('#deleteDeviceForm').attr('action', formAction);
        });
    });
    </script>
</body>
</html>