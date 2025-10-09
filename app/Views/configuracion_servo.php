<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Servo - VECOPO</title>
    <script src="https://kit.fontawesome.com/6f93a4b68f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00f2fe;
            --secondary-color: #4facfe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85);
            --text-primary: #ffffff;
            --text-secondary: #8892b0;
            --accent-color: #64ffda;
            --danger-color: #ff4d4d;
            --success-color: #00ff9d;
            --input-border: rgba(100, 255, 218, 0.2);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: var(--dark-bg); color: var(--text-primary); min-height: 100vh; }
        .main-wrapper { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; width: 100%; min-height: 100vh; }
        .config-card { background: var(--card-bg); padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(100, 255, 218, 0.1); backdrop-filter: blur(10px); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); width: 100%; max-width: 800px; animation: fadeIn 0.8s ease-out; }
        .config-card h1 { font-family: 'Orbitron', sans-serif; color: var(--primary-color); font-size: 2rem; margin-bottom: 1.5rem; text-shadow: 0 0 10px rgba(0, 242, 254, 0.3); }
        .servo-info { color: var(--text-secondary); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-primary); font-weight: 500; }
        .form-control { width: 100%; padding: 0.8rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--input-border); border-radius: 10px; color: var(--text-primary); font-size: 1rem; }
        .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(0, 242, 254, 0.2); }
        .btn-container { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn { padding: 0.8rem 2rem; border: none; border-radius: 50px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; }
        .btn-primary { background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)); color: var(--dark-bg); }
        .btn-secondary { background: rgba(255, 255, 255, 0.1); color: var(--text-primary); border: 1px solid var(--input-border); }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) {
            .config-card { padding: 1.5rem; }
            .config-card h1 { font-size: 1.8rem; }
            .btn { padding: 0.7rem 1.5rem; }
        }
    </style>
</head>
<body>
    <main class="main-wrapper">
        <div class="config-card">
            <h1>Configuración de Servo</h1>
            <div class="servo-info">
                <p>Servo: <?= esc($servo['nombre_servo']); ?></p>
                <p>Tipo: <?= esc(strtoupper($servo['tipo_elemento'])); ?></p>
                <p>Pin: <?= esc($servo['pin_gpio']); ?></p>
            </div>

            <form action="<?= site_url('servo/actualizar_configuracion/' . esc($servo['id'])) ?>" method="POST">
                <div class="form-group">
                    <label for="horario_apertura">Horario de Apertura</label>
                    <input type="time" id="horario_apertura" name="horario_apertura" class="form-control" 
                           value="<?= esc($servo['horario_apertura']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="horario_cierre">Horario de Cierre</label>
                    <input type="time" id="horario_cierre" name="horario_cierre" class="form-control" 
                           value="<?= esc($servo['horario_cierre']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="modo_operacion">Modo de Operación</label>
                    <select id="modo_operacion" name="modo_operacion" class="form-control" required>
                        <option value="AUTOMATICO" <?= $servo['modo_operacion'] === 'AUTOMATICO' ? 'selected' : ''; ?>>Automático</option>
                        <option value="MANUAL" <?= $servo['modo_operacion'] === 'MANUAL' ? 'selected' : ''; ?>>Manual</option>
                    </select>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                    <a href="<?= site_url('servo/estado/' . esc($servo['dispositivo_id'])) ?>" class="btn btn-secondary"></a>
                    <button type="submit" class="btn btn-secondary">Guardar Configuración</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html> 