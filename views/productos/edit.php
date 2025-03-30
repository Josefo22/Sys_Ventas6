<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el formulario de edición de productos -->
<style>
    .page-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
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
        color: #4e73df;
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
        color: #224abe;
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
    .product-info-header {
        background: rgba(78, 115, 223, 0.1);
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }
    .product-info-icon {
        font-size: 2rem;
        color: #4e73df;
        margin-right: 15px;
    }
    .product-info-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #4e73df;
        margin: 0;
    }
    .product-info-id {
        font-size: 0.9rem;
        color: #858796;
        margin: 0;
    }
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e3e6f0;
    }
    .form-section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #4e73df;
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
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .input-group-text {
        border-radius: 10px 0 0 10px;
        background-color: #f8f9fc;
        border: 1px solid #d1d3e2;
        color: #5a5c69;
    }
    .btn-actualizar {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    .btn-actualizar:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(78, 115, 223, 0.4);
    }
    .btn-actualizar:active {
        transform: translateY(0);
    }
    .btn-actualizar i {
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
        <i class="fas fa-edit"></i> Editar Producto
    </h1>
    <a href="<?php echo BASE_URL; ?>Producto" class="btn btn-volver">
        <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
    </a>
</div>

<!-- Alertas de notificación -->
<?php if (isset($errores['campos_obligatorios']) || isset($errores['codigo_existente']) || isset($errores['error_actualizacion'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <?php 
            if (isset($errores['campos_obligatorios'])) echo $errores['campos_obligatorios'];
            else if (isset($errores['codigo_existente'])) echo $errores['codigo_existente'];
            else if (isset($errores['error_actualizacion'])) echo $errores['error_actualizacion'];
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<!-- Formulario de edición de producto -->
<div class="card animated-row">
    <div class="card-header">
        <h6 class="font-weight-bold text-primary m-0">
            <i class="fas fa-box-open mr-2"></i> Información del Producto
        </h6>
    </div>
    <div class="card-body">
        <!-- Información del producto -->
        <div class="product-info-header">
            <div class="product-info-icon">
                <i class="fas fa-box"></i>
            </div>
            <div>
                <h4 class="product-info-title"><?php echo $producto['descripcion']; ?></h4>
                <p class="product-info-id">ID: <?php echo $producto['codproducto']; ?></p>
            </div>
        </div>
        
        <form id="formEditarProducto" action="<?php echo BASE_URL; ?>Producto/update" method="POST">
            <input type="hidden" name="codproducto" value="<?php echo $producto['codproducto']; ?>">
            
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
                                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $producto['codigo']; ?>" required>
                                <div class="invalid-feedback">El código del producto es obligatorio</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion">Descripción del Producto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                </div>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $producto['descripcion']; ?>" required>
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
                                <input type="number" step="0.01" min="0" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                                <div class="invalid-feedback">El precio del producto es obligatorio</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="existencia">Stock Actual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                </div>
                                <input type="number" min="0" class="form-control" id="existencia" name="existencia" value="<?php echo $producto['existencia']; ?>" required>
                                <div class="invalid-feedback">El stock es obligatorio</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="text-center">
                <button type="submit" class="btn btn-actualizar" id="btnActualizar">
                    <i class="fas fa-sync-alt"></i> Actualizar Producto
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
        $('#formEditarProducto').submit(function(e) {
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
                    confirmButtonColor: '#4e73df'
                });
            } else {
                // Confirmación antes de actualizar
                e.preventDefault();
                
                Swal.fire({
                    title: '¿Confirmar cambios?',
                    text: '¿Estás seguro de que deseas actualizar este producto?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4e73df',
                    cancelButtonColor: '#e74a3b',
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si es válido, mostrar un spinner de carga
                        $('#btnActualizar').html('<i class="fas fa-spinner fa-spin"></i> Actualizando...');
                        $('#btnActualizar').attr('disabled', true);
                        $('#formEditarProducto').unbind('submit').submit();
                    }
                });
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