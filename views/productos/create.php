<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el formulario de productos -->
<style>
    .page-header {
        background: linear-gradient(135deg, #36b9cc 0%, #1a8a98 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .page-title {
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
    }
    .page-title i {
        font-size: 2rem;
        margin-right: 15px;
    }
    .btn-volver {
        background: white;
        color: #36b9cc;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .btn-volver:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        background: #f8f9fc;
        color: #1a8a98;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 30px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        background: linear-gradient(135deg, #f8f9fc 0%, #e8eaef 100%);
        border-bottom: none;
        padding: 20px;
        border-radius: 10px 10px 0 0 !important;
    }
    .card-body {
        padding: 30px;
    }
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e3e6f0;
    }
    .form-section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #36b9cc;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .form-section-title i {
        margin-right: 10px;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 10px;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #bce0fd;
        box-shadow: 0 0 0 0.2rem rgba(54, 185, 204, 0.25);
    }
    .input-group-text {
        border-radius: 10px 0 0 10px;
        background-color: #f8f9fc;
        border: 1px solid #d1d3e2;
        color: #5a5c69;
    }
    .btn-guardar {
        background: linear-gradient(135deg, #36b9cc 0%, #1a8a98 100%);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(54, 185, 204, 0.3);
    }
    .btn-guardar:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(54, 185, 204, 0.4);
    }
    .btn-guardar:active {
        transform: translateY(0);
    }
    .btn-guardar i {
        margin-right: 8px;
    }
    .alert {
        border: none;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 25px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .alert-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #be3c30 100%);
        color: white;
    }
    .alert .close {
        color: white;
        opacity: 0.8;
    }
    .alert .close:hover {
        opacity: 1;
    }
    .form-requirements {
        font-size: 0.8rem;
        color: #858796;
        margin-top: 5px;
    }
    .is-invalid {
        border-color: #e74a3b !important;
    }
    .invalid-feedback {
        color: #e74a3b;
        font-size: 0.8rem;
        margin-top: 5px;
    }
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Encabezado de página con gradiente -->
<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-plus-circle"></i> Nuevo Producto
    </h1>
    <a href="<?php echo BASE_URL; ?>Producto" class="btn btn-volver">
        <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
    </a>
</div>

<!-- Alertas de notificación -->
<?php if (isset($errores['campos_obligatorios']) || isset($errores['codigo_existente']) || isset($errores['error_creacion'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <?php 
            if (isset($errores['campos_obligatorios'])) echo $errores['campos_obligatorios'];
            else if (isset($errores['codigo_existente'])) echo $errores['codigo_existente'];
            else if (isset($errores['error_creacion'])) echo $errores['error_creacion'];
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<!-- Formulario de creación de producto -->
<div class="card animated-row">
    <div class="card-header">
        <h6 class="font-weight-bold text-info m-0">
            <i class="fas fa-box-open mr-2"></i> Información del Producto
        </h6>
    </div>
    <div class="card-body">
        <form id="formCrearProducto" action="<?php echo BASE_URL; ?>Producto/store" method="POST">
            
            <!-- Sección: Información Básica -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle"></i> Información Básica
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo">Código del Producto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese el código del producto" required>
                                <div class="invalid-feedback">El código del producto es obligatorio</div>
                            </div>
                            <small class="form-requirements">El código debe ser único y alfanumérico</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion">Descripción del Producto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                </div>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripción del producto" required>
                                <div class="invalid-feedback">La descripción del producto es obligatoria</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sección: Información de Precios y Stock -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-dollar-sign"></i> Precios y Existencias
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio">Precio del Producto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input type="number" step="0.01" min="0" class="form-control" id="precio" name="precio" placeholder="0.00" required>
                                <div class="invalid-feedback">El precio del producto es obligatorio</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="existencia">Stock Inicial</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                </div>
                                <input type="number" min="0" class="form-control" id="existencia" name="existencia" placeholder="0" required>
                                <div class="invalid-feedback">El stock es obligatorio</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="text-center">
                <button type="submit" class="btn btn-guardar" id="btnGuardar">
                    <i class="fas fa-save"></i> Guardar Producto
                </button>
            </div>
            
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Animaciones para elementos de la página
        $(".card").css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        }).delay(300).animate({
            'opacity': 1,
            'transform': 'translateY(0)'
        }, 500);
        
        // Validación del formulario
        $('#formCrearProducto').submit(function(e) {
            let valid = true;
            
            // Validar código
            if ($('#codigo').val().trim() === '') {
                $('#codigo').addClass('is-invalid');
                valid = false;
            } else {
                $('#codigo').removeClass('is-invalid');
            }
            
            // Validar descripción
            if ($('#descripcion').val().trim() === '') {
                $('#descripcion').addClass('is-invalid');
                valid = false;
            } else {
                $('#descripcion').removeClass('is-invalid');
            }
            
            // Validar precio
            if ($('#precio').val() === '' || $('#precio').val() < 0) {
                $('#precio').addClass('is-invalid');
                valid = false;
            } else {
                $('#precio').removeClass('is-invalid');
            }
            
            // Validar existencia
            if ($('#existencia').val() === '' || $('#existencia').val() < 0) {
                $('#existencia').addClass('is-invalid');
                valid = false;
            } else {
                $('#existencia').removeClass('is-invalid');
            }
            
            // Si no es válido, prevenir el envío
            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error de validación',
                    text: 'Por favor complete todos los campos correctamente',
                    icon: 'error',
                    confirmButtonColor: '#36b9cc'
                });
            } else {
                // Si es válido, mostrar un spinner de carga
                $('#btnGuardar').html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                $('#btnGuardar').attr('disabled', true);
            }
        });
        
        // Validación en tiempo real
        $('#codigo, #descripcion, #precio, #existencia').on('input', function() {
            if ($(this).val().trim() !== '') {
                $(this).removeClass('is-invalid');
            }
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 