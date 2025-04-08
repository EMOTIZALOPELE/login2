<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Horarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            header{
                width: 100%;
                height: 70px;
                margin-top: 15px;
                position: fixed;
                z-index: 1;
            }

            body {
                background: url(<?=base_url("img/fondo4.jpg") ?>) no-repeat center center fixed;
                background-size: cover;        
                font-family: Arial, sans-serif;        
                height: 100vh;
            }
            /* Menú lateral */
            .container__menu{
                max-width: 1800px;
                height: 100%;
                width: 100%;
                margin: auto;
                display: flex;
                justify-content: space-between;
                background:rgba(34, 31, 31, 0.51);
                
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
            
            
            .menu nav img{
                display: none;
            }

            .menu #btn_menu{
                display: none;
            }

        /* Ajustes para botones del servo */
        .servo-controls {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .buttonservo {
            background-color: #3498db;
            color: white;
            padding: 15px;
            font-size: 18px;
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