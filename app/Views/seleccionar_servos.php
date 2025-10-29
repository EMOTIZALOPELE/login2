<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Servomotores</title>
    <style>
        :root {
            --primary-color: #00f2fe;
            --dark-bg: #0a192f;
            --card-bg: rgba(16, 32, 61, 0.85);
        }
        body {
            background: var(--dark-bg);
            color: white;
            font-family: 'Roboto', sans-serif;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 15px;
        }
        .servo-option {
            border: 2px solid #444;
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .servo-option.selected {
            border-color: var(--primary-color);
            background: rgba(0, 242, 254, 0.1);
        }
        .servo-option.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .btn-continuar {
            background: var(--primary-color);
            color: var(--dark-bg);
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 1rem;
        }
        .btn-continuar:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Configurar tus Servomotores</h1>
        <p><strong>Plan:</strong> <?= $plan_nombre ?></p>
        <p><strong>Servomotores incluidos:</strong> <?= $cant_servos ?></p>
        
        <?php if ($plan_tipo == 'enterprise'): ?>
            <div class="alert alert-info">
                <strong>Plan Enterprise:</strong> Incluye 1 ventana, 1 cortina y 1 postigón (configuración fija)
            </div>
        <?php elseif ($plan_tipo == 'intermedio'): ?>
            <div class="alert alert-info">
                <strong>Plan Intermedio:</strong> Selecciona 2 servomotores diferentes (ej: ventana + cortina, ventana + postigón, etc.)
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <strong>Plan Básico:</strong> Selecciona 1 servomotor (ventana, cortina o postigón)
            </div>
        <?php endif; ?>
        
        <form id="formServos" action="<?= base_url('guardar-configuracion-servos') ?>" method="POST">

            <!-- 🔥 CAMPOS OCULTOS ESENCIALES PARA EL CONTROLADOR -->
            <?php if (isset($dispositivo_id)): ?>
                <input type="hidden" name="dispositivo_id" value="<?= $dispositivo_id ?>">
            <?php endif; ?>
            
            <?php if (isset($pago_id)): ?>
                <input type="hidden" name="pago_id" value="<?= $pago_id ?>">
            <?php endif; ?>

            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
            
            <h3>Selecciona tus servomotores:</h3>
            
            <?php if ($plan_tipo == 'enterprise'): ?>
                <!-- Plan Enterprise - Pre-seleccionado y fijo -->
                <div class="servo-option selected" data-type="ventana">
                    <strong>Ventana</strong> (incluida)
                </div>
                <div class="servo-option selected" data-type="cortina">
                    <strong>Cortina</strong> (incluida)
                </div>
                <div class="servo-option selected" data-type="postigon">
                    <strong>Postigón</strong> (incluida)
                </div>
                <input type="hidden" name="servos[]" value="ventana">
                <input type="hidden" name="servos[]" value="cortina">
                <input type="hidden" name="servos[]" value="postigon">
            <?php else: ?>
                <!-- Planes Básico e Intermedio - El usuario selecciona -->
                <div class="servo-option" data-type="ventana">
                    <strong>Ventana</strong>
                    <p>Control automático de ventanas</p>
                </div>
                <div class="servo-option" data-type="cortina">
                    <strong>Cortina</strong>
                    <p>Control automático de cortinas</p>
                </div>
                <div class="servo-option" data-type="postigon">
                    <strong>Postigón</strong>
                    <p>Control automático de postigones</p>
                </div>
            <?php endif; ?>
            
            <button type="submit" class="btn-continuar" id="btnContinuar" 
                    <?= $plan_tipo == 'enterprise' ? '' : 'disabled' ?>>
                Continuar a Configuración
            </button>
        </form>
    </div>

    <script>
        const planTipo = '<?= $plan_tipo ?>';
        const cantServos = <?= $cant_servos ?>;
        const servosSeleccionados = new Set();
        
        <?php if ($plan_tipo != 'enterprise'): ?>
        document.querySelectorAll('.servo-option').forEach(option => {
            option.addEventListener('click', function() {
                const tipo = this.dataset.type;
                
                if (this.classList.contains('selected')) {
                    // Deseleccionar
                    this.classList.remove('selected');
                    servosSeleccionados.delete(tipo);
                } else {
                    // Verificar límites según el plan
                    if (servosSeleccionados.size >= cantServos) {
                        // 🔥 CAMBIO: Usar console.warn en lugar de alert()
                        console.warn(`Límite alcanzado: Plan ${planTipo.toUpperCase()} solo permite ${cantServos} servomotor(es).`);
                        return;
                    }
                    
                    // Seleccionar
                    this.classList.add('selected');
                    servosSeleccionados.add(tipo);
                }
                
                // Actualizar inputs hidden
                actualizarInputsHidden();
                validarBoton();
            });
        });
        
        function actualizarInputsHidden() {
            // Remover inputs existentes
            document.querySelectorAll('input[name="servos[]"]').forEach(input => input.remove());
            
            // Agregar nuevos inputs
            const form = document.getElementById('formServos');
            servosSeleccionados.forEach(tipo => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'servos[]';
                input.value = tipo;
                form.appendChild(input);
            });
        }
        
        function validarBoton() {
            const btn = document.getElementById('btnContinuar');
            btn.disabled = servosSeleccionados.size !== cantServos;
        }
        <?php endif; ?>
    </script>
</body>
</html>
