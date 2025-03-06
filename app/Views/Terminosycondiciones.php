<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones - VECOPO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            margin: 50px auto;
            max-width: 800px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-accept {
            background-color: #28a745;
            color: #fff;
        }
        .btn-accept:hover {
            background-color: #218838;
        }
        .btn-decline {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-decline:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Términos y Condiciones</h1>
                <hr>
                <div class="card-text" style="max-height: 400px; overflow-y: auto;">
                    <p>Al acceder, instalar o utilizar los productos y servicios de <strong>VECOPO</strong>, usted acepta estar sujeto a estos términos y condiciones. Si no está de acuerdo con ellos, no debe utilizar el sistema.</p>
                    <h5>Descripción del Servicio</h5>
                    <p><strong>VECOPO</strong> es un sistema de automatización diseñado para controlar cortinas, ventanas y postigones...</p>
                    <!-- Aquí puedes agregar más contenido -->
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('/iniciovaregister') ?>"class="btn btn-accept">Aceptar</a>
                    <a href="<?= base_url('pantalla') ?>"class="btn btn-decline">Rechazar</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
