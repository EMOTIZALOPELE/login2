<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Horarios</title>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe; --secondary-color: #4facfe; --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85); --text-primary: #ffffff; --text-secondary: #8892b0;
            --accent-color: #64ffda; --danger-color: #ff4d4d; --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
            --button-bg: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            --button-hover-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
            --close-button-bg: #ff4d4d;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        body { background-color: var(--dark-bg); color: var(--text-primary); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 2rem; }
        .config-card { background: var(--card-bg); padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(100, 255, 218, 0.1); backdrop-filter: blur(10px); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); width: 100%; max-width: 700px; animation: fadeIn 0.8s ease-out; text-align: center; }
        .config-card h1 { font-family: 'Orbitron', sans-serif; color: var(--primary-color); font-size: 2rem; margin-bottom: 1.5rem; text-shadow: 0 0 10px rgba(0, 242, 254, 0.3); }
        .form-group { margin-bottom: 1.5rem; text-align: left; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-secondary); font-weight: 500; font-size: 0.95rem; }
        .form-control-time { background: rgba(255, 255, 255, 0.05); border: 1px solid var(--input-border); color: var(--text-primary); border-radius: 10px; padding: 0.8rem 1rem; width: 100%; font-size: 1rem; appearance: none; -webkit-appearance: none; }
        .form-control-time:focus { background: rgba(255, 255, 255, 0.1); border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(0, 242, 254, 0.25); outline: none; }
        .form-control-time::-webkit-calendar-picker-indicator { filter: invert(1); } /* Para que el icono del picker sea visible */
        .btn-submit, .btn-back { padding: 0.8rem 2rem; font-size: 1.1rem; font-weight: 500; border-radius: 50px; border: none; cursor: pointer; transition: all 0.3s ease; display: inline-block; text-decoration: none; margin: 0 0.5rem; }
        .btn-submit { background: var(--button-bg); color: var(--dark-bg); box-shadow: 0 5px 15px rgba(0, 242, 254, 0.2); }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: var(--button-hover-shadow); }
        .btn-back { background: rgba(255, 255, 255, 0.1); color: var(--text-primary); border: 1px solid var(--input-border); }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1); }
        .alert { background: rgba(255, 77, 77, 0.2); border: 1px solid var(--danger-color); color: var(--danger-color); padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; }
        .success { background: rgba(0, 255, 157, 0.2); border: 1px solid var(--success-color); color: var(--success-color); padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Estilos para ocultar/mostrar elementos según diseño */
        .component-section {
            background-color: rgba(0, 0, 0, 0.2); /* Fondo m�s oscuro para cada secci�n de componente */
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border: 1px solid var(--input-border);
        }
        .component-section h2 {
            font-family: 'Orbitron', sans-serif;
            color: var(--accent-color);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 0 8px rgba(100, 255, 218, 0.2);
        }
        .component-section:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .config-card { padding: 1.5rem; max-width: 95%; }
            .config-card h1 { font-size: 1.8rem; }
            .btn-submit, .btn-back { font-size: 1rem; padding: 0.7rem 1.5rem; margin: 0 0.3rem; }
            .component-section h2 { font-size: 1.3rem; }
            .component-section { padding: 1rem; }
        }
    </style>
</head>
<body>
    <div class="config-card">
        <h1>Configurar Horarios</h1>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
            Configurando horarios para la tarjeta: <strong><?= esc($horarios['nombre_tarjeta'] ?? 'Nueva Tarjeta'); ?></strong>
        </p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="success">
                <?= session()->getFlashdata('mensaje') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('horarios/guardar') ?>" method="POST">
            <?= csrf_field() ?> <input type="hidden" name="idhorario" value="<?= esc($horarios['idhorario'] ?? ''); ?>">
            <input type="hidden" name="diseno_id" value="<?= esc($diseno['id_diseno'] ?? ''); ?>">
            
            <div class="component-section">
                <h2>Horarios de Ventana</h2>
                <div class="form-group">
                    <label for="ventana_apertura">Apertura:</label>
                    <input type="time" id="ventana_apertura" name="ventana_apertura" class="form-control-time" value="<?= esc($horarios['ventana_apertura'] ?? '07:00:00'); ?>">
                </div>
                <div class="form-group">
                    <label for="ventana_cierre">Cierre:</label>
                    <input type="time" id="ventana_cierre" name="ventana_cierre" class="form-control-time" value="<?= esc($horarios['ventana_cierre'] ?? '20:00:00'); ?>">
                </div>
            </div>

            <div class="component-section">
                <h2>Horarios de Cortina</h2>
                <div class="form-group">
                    <label for="cortina_apertura">Apertura:</label>
                    <input type="time" id="cortina_apertura" name="cortina_apertura" class="form-control-time" value="<?= esc($horarios['cortina_apertura'] ?? '07:00:00'); ?>">
                </div>
                <div class="form-group">
                    <label for="cortina_cierre">Cierre:</label>
                    <input type="time" id="cortina_cierre" name="cortina_cierre" class="form-control-time" value="<?= esc($horarios['cortina_cierre'] ?? '20:00:00'); ?>">
                </div>
            </div>

            <div class="component-section">
                <h2>Horarios de Postigón</h2>
                <div class="form-group">
                    <label for="postigon_apertura">Apertura:</label>
                    <input type="time" id="postigon_apertura" name="postigon_apertura" class="form-control-time" value="<?= esc($horarios['postigon_apertura'] ?? '07:00:00'); ?>">
                </div>
                <div class="form-group">
                    <label for="postigon_cierre">Cierre:</label>
                    <input type="time" id="postigon_cierre" name="postigon_cierre" class="form-control-time" value="<?= esc($horarios['postigon_cierre'] ?? '20:00:00'); ?>">
                </div>
            </div>
            
            <div style="margin-top: 2rem;">
                <button type="submit" class="btn-submit">Guardar Horarios</button>
                <a href="<?= base_url('/irainicio') ?>" class="btn-back">Volver al inicio</a>
            </div>
        </form>
    </div>
</body>
</html>