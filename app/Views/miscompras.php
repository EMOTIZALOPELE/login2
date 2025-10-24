<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Compra - VECOPO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00b4d8;
            --primary-dark: #1f53c5;
            --secondary: #2c3e50;
            --dark: #1a1a1a;
            --light: rgba(255, 255, 255, 0.9);
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
        }
        
        body {
            background: linear-gradient(135deg, var(--dark) 0%, var(--secondary) 100%);
            color: white;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding-top: 40px;
        }
        
        .container-fluid {
            max-width: 1400px;
        }
        
        .card-custom {
            background: var(--card-bg);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }
        
        .card-header-custom {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary));
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            border-bottom: 1px solid var(--card-border);
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.3);
            border-color: var(--primary);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--light);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary));
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(31, 83, 197, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(31, 83, 197, 0.6);
        }

        .btn-comprar {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            margin-top: 20px;
        }
        
        .btn-comprar:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
            background: linear-gradient(45deg, #218838, #1e9e8a);
            color: white;
            text-decoration: none;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border-radius: 3px;
        }
        
        .purchase-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .purchase-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(5px);
        }
        
        .purchase-id {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
        }
        
        .purchase-date {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }
        
        .purchase-amount {
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-completed {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .status-pending {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
        }
        
        .no-purchases {
            text-align: center;
            padding: 40px 20px;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .no-purchases i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.3);
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        
        .step-indicator:before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary));
            box-shadow: 0 0 0 5px rgba(0, 180, 216, 0.2);
        }
        
        .step-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .step.active .step-label {
            color: var(--primary);
            font-weight: 500;
        }
        
        @media (max-width: 992px) {
            .purchase-history {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>

    <?php
    $title = 'Mis Compras - VECOPO';
    ?>
    <?= $this->include('partials/header') ?>

    <div class="container-fluid" style="padding-top: 2rem;">
        <div class="row justify-content-center">
            <!-- Formulario de validación de compra -->
            <div class="col-lg-7 col-md-12 mb-4">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h3 class="text-center mb-0"><i class="fas fa-shipping-fast me-2"></i>Validar Compra y Envío</h3>
                        <p class="text-center mb-0 mt-2">Ingresa el Order ID que recibiste al pagar y completa tus datos de envío.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="step-indicator">
                            
                            
                        </div>
                        
                        <form id="envioForm">
                            <div class="form-group">
                                <label for="order_id" class="form-label"><i class="fas fa-receipt me-2"></i><strong>Order ID de PayPal</strong></label>
                                <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Ej: 2XD69434WB4945849" required>
                                <small class="form-text text-muted mt-2"><i class="fas fa-info-circle me-1"></i>Este código apareció al finalizar tu pago. Lo puedes encontrar en tu email de confirmación.</small>
                            </div>
                            
                            <div class="section-title mt-5">Datos del Receptor</div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="form-label"><i class="fas fa-phone me-2"></i>Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>

                            <div class="section-title mt-4">Dirección de Envío</div>
                            <div class="form-group">
                                <label for="pais" class="form-label"><i class="fas fa-globe-americas me-2"></i>País</label>
                                <input type="text" class="form-control" id="pais" name="pais" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="provincia" class="form-label">Provincia / Estado</label>
                                    <input type="text" class="form-control" id="provincia" name="provincia" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="ciudad" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 form-group">
                                    <label for="calle" class="form-label">Calle</label>
                                    <input type="text" class="form-control" id="calle" name="calle" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="numero_calle" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero_calle" name="numero_calle" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="piso" class="form-label">Piso (Opcional)</label>
                                    <input type="text" class="form-control" id="piso" name="piso">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="depto" class="form-label">Depto (Opcional)</label>
                                    <input type="text" class="form-control" id="depto" name="depto">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="codigopostal" class="form-label">Código Postal</label>
                                    <input type="text" class="form-control" id="codigopostal" name="codigopostal" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary mt-4">
                                <i class="fas fa-check-circle me-2"></i>Validar y Guardar Dirección
                            </button>
                        </form>
                        
                        <div id="mensaje" class="mt-4" style="display: none;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Historial de compras -->
            <div class="col-lg-5 col-md-12">
                <div class="card-custom h-100">
                    <div class="card-header-custom">
                        <h3 class="text-center mb-0"><i class="fas fa-history me-2"></i>Mi Historial de Compras</h3>
                    </div>
                    <div class="card-body p-4">
                        <div id="purchase-history-container">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Cargando...</span>
                                </div>
                                <p class="mt-2">Cargando historial de compras...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Cargar historial de compras al cargar la página
            loadPurchaseHistory();
            
            $('#envioForm').on('submit', function(e) {
                e.preventDefault(); // Evita el envío tradicional del formulario

                // Limpiamos mensajes anteriores
                $('#mensaje').hide().removeClass('alert-success alert-danger');

                // Recolectamos los datos del formulario
                let formData = {
                    order_id: $('#order_id').val(),
                    nombre: $('#nombre').val(),
                    apellido: $('#apellido').val(),
                    telefono: $('#telefono').val(),
                    pais: $('#pais').val(),
                    provincia: $('#provincia').val(),
                    ciudad: $('#ciudad').val(),
                    calle: $('#calle').val(),
                    numero_calle: $('#numero_calle').val(),
                    piso: $('#piso').val(),
                    depto: $('#depto').val(),
                    codigopostal: $('#codigopostal').val()
                };

                // Enviamos por FETCH a nuestro controlador
                fetch('<?= base_url("/guardar-direccion") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Éxito
                        $('#mensaje').text(data.message)
                                .addClass('alert alert-success')
                                .show();
                        // Limpiar formulario
                        $('#envioForm')[0].reset();
                        // Recargar historial de compras
                        loadPurchaseHistory();
                    } else {
                        // Error controlado por nosotros
                        throw new Error(data.error || 'Error desconocido');
                    }
                })
                .catch(error => {
                    // Error (de red o arrojado por nosotros)
                    $('#mensaje').text(error.message)
                                .addClass('alert alert-danger')
                                .show();
                });
            });
            
            // Función para cargar el historial de compras
            function loadPurchaseHistory() {
                console.log('Cargando historial de compras...');
                
                fetch('<?= base_url("/api/mis-compras") ?>', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin' // Importante para enviar cookies de sesión
                })
                .then(response => {
                    console.log('Respuesta recibida:', response.status, response.statusText);
                    
                    if (!response.ok) {
                        // Si la respuesta no es exitosa, intentamos leer el mensaje de error
                        return response.json().then(errorData => {
                            throw new Error(errorData.error || `Error ${response.status}: ${response.statusText}`);
                        }).catch(() => {
                            throw new Error(`Error ${response.status}: ${response.statusText}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);
                    
                    if (data.success) {
                        displayPurchaseHistory(data.compras);
                    } else {
                        throw new Error(data.error || 'Error en los datos recibidos');
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    $('#purchase-history-container').html(`
                        <div class="no-purchases">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h5>Error al cargar compras</h5>
                            <p>${error.message}</p>
                            <small>Verifica tu conexión o intenta más tarde</small>
                        </div>
                    `);
                });
            }

            
            // Función para mostrar el historial de compras
            function displayPurchaseHistory(purchases) {
            const container = $('#purchase-history-container');
            
            console.log('Mostrando compras:', purchases);
            
            if (!purchases || purchases.length === 0) {
                container.html(`
                    <div class="no-purchases">
                        <i class="fas fa-shopping-bag"></i>
                        <h5>Aún no tienes compras</h5>
                        <p>Una vez que realices una compra, aparecerá aquí.</p>
                        <small class="text-muted">Las compras se vinculan automáticamente a tu cuenta</small>
                        <div class="mt-4">
                            <a href="<?= base_url('/pantalla') ?>" class="btn btn-comprar">
                                <i class="fas fa-shopping-cart me-2"></i>Realizar mi primera compra
                            </a>
                        </div>
                    </div>
                `);
                return;
            }
            
            let html = '';
            purchases.forEach(purchase => {
                const date = new Date(purchase.fecha);
                const formattedDate = date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                // Formatear monto
                const montoFormateado = parseFloat(purchase.monto).toFixed(2);
                
                html += `
                    <div class="purchase-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="purchase-id">${purchase.order_id}</div>
                            <span class="status-badge status-completed">Completado</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="purchase-date">${formattedDate}</div>
                                <div class="mt-1">
                                    <small><i class="fas fa-user me-1"></i>${purchase.nombre || 'No especificado'}</small>
                                </div>
                                <div class="mt-1">
                                    <small><i class="fas fa-map-marker-alt me-1"></i>${purchase.pais || 'No especificado'}</small>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="purchase-amount">${purchase.moneda} ${montoFormateado}</div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.html(html);
                    }
        });
    </script>

</body>
</html>