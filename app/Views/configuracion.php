<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Horarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 2rem;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card {
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: none;
            padding: 1rem;
        }
        .card-body {
            padding: 1.5rem;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 0.75rem 1.5rem;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 0.75rem 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Configuración de Horarios para: <?= esc($diseno['nombre']) ?></h2>
        
        <?php if (session()->has('mensaje')): ?>
            <div class="alert alert-success">
                <?= session('mensaje') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('horarios/guardar') ?>" method="post">
            <input type="hidden" name="diseno_id" value="<?= $diseno['id_diseno'] ?>">
            
            <?php 
            // Asegurar que los valores estén en minúsculas y sin espacios
            $ventana = strtolower(trim($diseno['ventana']));
            $cortina = strtolower(trim($diseno['cortina']));
            $postigon = strtolower(trim($diseno['postigon']));
            ?>

            <?php if ($ventana === 'si'): ?>
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Ventana</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ventana_apertura" class="form-label">Hora de Apertura:</label>
                            <input type="time" class="form-control" id="ventana_apertura" name="ventana_apertura" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ventana_cierre" class="form-label">Hora de Cierre:</label>
                            <input type="time" class="form-control" id="ventana_cierre" name="ventana_cierre" required>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($cortina === 'si'): ?>
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Cortina</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cortina_apertura" class="form-label">Hora de Apertura:</label>
                            <input type="time" class="form-control" id="cortina_apertura" name="cortina_apertura" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cortina_cierre" class="form-label">Hora de Cierre:</label>
                            <input type="time" class="form-control" id="cortina_cierre" name="cortina_cierre" required>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($postigon === 'si'): ?>
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Postigo</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="postigon_apertura" class="form-label">Hora de Apertura:</label>
                            <input type="time" class="form-control" id="postigon_apertura" name="postigon_apertura" required>
                        </div>
                        <div class="col-md-6">
                            <label for="postigon_cierre" class="form-label">Hora de Cierre:</label>
                            <input type="time" class="form-control" id="postigon_cierre" name="postigon_cierre" required>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Guardar Horarios</button>
                <a href="<?= base_url('irainicio') ?>" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>