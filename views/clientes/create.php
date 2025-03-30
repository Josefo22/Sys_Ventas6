<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos adicionales para el módulo de clientes -->
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .page-title {
        color: #4e73df;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        transform: scale(1.05);
    }
    .alert {
        border-radius: 10px;
        border: none;
    }
    .alert-danger {
        background-color: #e74a3b20;
        color: #e74a3b;
        border-left: 5px solid #e74a3b;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #bac8f3;
    }
    .input-icon {
        position: relative;
    }
    .input-icon i {
        position: absolute;
        left: 15px;
        top: 15px;
        color: #d1d3e2;
        font-size: 1rem;
    }
    .input-icon .form-control {
        padding-left: 40px;
    }
    label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }
    .required-label::after {
        content: "*";
        color: #e74a3b;
        margin-left: 5px;
    }
    .form-text {
        color: #858796;
        font-size: 0.8rem;
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: none;
        padding: 20px;
    }
    .card-header h6 {
        font-size: 1rem;
        font-weight: 700;
        color: #4e73df;
    }
    .btn-secondary {
        background-color: #858796;
        border-color: #858796;
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background-color: #717384;
        border-color: #717384;
        transform: scale(1.05);
    }
    .float-icon {
        animation: floating 3s ease infinite;
        opacity: 0.8;
        font-size: 8rem;
        color: rgba(78, 115, 223, 0.1);
        position: absolute;
        right: -20px;
        bottom: -20px;
        z-index: 0;
    }
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 page-title">
        <i class="fas fa-user-plus mr-2"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Cliente" class="btn btn-primary btn-sm">
        <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
    </a>
</div>

<?php if (isset($_GET['error'])) { ?>
    <?php if ($_GET['error'] == 1) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> Todos los campos son obligatorios
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['error'] == 2) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> Ya existe un cliente con esa cédula
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['error'] == 3) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> Error al crear el cliente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
<?php } ?>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-edit mr-2"></i> Información del Cliente
                </h6>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>Cliente/store" method="POST" id="clienteForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="required-label">Nombre completo</label>
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <small class="form-text">Ingrese el nombre completo del cliente</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono" class="required-label">Teléfono</label>
                                <div class="input-icon">
                                    <i class="fas fa-phone"></i>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                                <small class="form-text">Ingrese el teléfono del cliente</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion" class="required-label">Dirección</label>
                                <div class="input-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                                <small class="form-text">Ingrese la dirección completa del cliente</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cedula" class="required-label">Cédula</label>
                                <div class="input-icon">
                                    <i class="fas fa-id-card"></i>
                                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                                </div>
                                <small class="form-text">Ingrese el número de cédula del cliente</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary px-5 py-2">
                            <i class="fas fa-save mr-2"></i> Guardar Cliente
                        </button>
                        <a href="<?php echo BASE_URL; ?>Cliente" class="btn btn-secondary px-5 py-2 ml-2">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-none d-lg-block">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i> Información
                </h6>
            </div>
            <div class="card-body position-relative">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x text-primary opacity-50"></i>
                </div>
                <p>
                    <strong>¿Qué es un cliente?</strong><br>
                    Un cliente es una persona o entidad que compra bienes o servicios de su empresa.
                </p>
                <p>
                    <strong>Datos importantes:</strong>
                </p>
                <ul>
                    <li>Los campos marcados con <span class="text-danger">*</span> son obligatorios.</li>
                    <li>La cédula debe ser única para cada cliente.</li>
                    <li>Asegúrese de ingresar un número de teléfono válido.</li>
                </ul>
                <div class="float-icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Validación del formulario
        $('#clienteForm').submit(function(e) {
            // Validar que no haya campos vacíos
            let valid = true;
            $(this).find('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Todos los campos marcados son obligatorios',
                    confirmButtonColor: '#4e73df'
                });
            }
        });
        
        // Animación de entrada para el formulario
        $('.card').css('opacity', 0).animate({
            opacity: 1
        }, 500);
        
        // Máscaras para los campos
        $('#telefono').mask('(000) 000-0000', {placeholder: '(___) ___-____'});
        $('#cedula').mask('000-0000000-0', {placeholder: '___-_______-_'});
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 