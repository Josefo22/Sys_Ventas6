<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el formulario de edición de proveedores -->
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
    .btn-back {
        background: white;
        color: #4e73df;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .btn-back:hover {
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
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: none;
        padding: 20px;
        border-radius: 10px 10px 0 0 !important;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #4e73df;
        display: flex;
        align-items: center;
    }
    .card-header h5 i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    .card-body {
        padding: 25px;
    }
    .form-group label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    .form-group label i {
        margin-right: 8px;
        color: #4e73df;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #d1d3e2;
        transition: all 0.2s;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #bac8f3;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.25);
    }
    .text-danger {
        color: #e74a3b !important;
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
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .form-section {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        border-left: 4px solid #4e73df;
    }
    .provider-info {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: flex;
        align-items: center;
    }
    .provider-icon {
        font-size: 2rem;
        margin-right: 15px;
        opacity: 0.8;
    }
    .provider-name {
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
    }
    .provider-id {
        opacity: 0.8;
        font-size: 0.9rem;
        margin: 0;
    }
    .btn-actions {
        display: flex;
        gap: 10px;
    }
    .btn-cancel {
        background: #e74a3b;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(231, 74, 59, 0.25);
    }
</style>

<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-edit"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Proveedor" class="btn btn-back">
        <i class="fas fa-arrow-left mr-2"></i> Volver
    </a>
</div>

<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php } ?>

<div class="provider-info animated-row">
    <div class="provider-icon">
        <i class="fas fa-building"></i>
    </div>
    <div>
        <p class="provider-name"><?php echo $proveedor['nombre']; ?></p>
        <p class="provider-id">Código: <?php echo $proveedor['idproveedor']; ?></p>
    </div>
</div>

<div class="card animated-row">
    <div class="card-header">
        <h5><i class="fas fa-pen"></i> Editar información del proveedor</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo BASE_URL; ?>Proveedor/update" method="POST" id="formProveedor">
            <input type="hidden" name="id" value="<?php echo $proveedor['idproveedor']; ?>">
            
            <div class="form-section">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label for="nombre"><i class="fas fa-building"></i> Nombre de la Empresa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $proveedor['nombre']; ?>" placeholder="Ingrese el nombre del proveedor" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $proveedor['telefono']; ?>" placeholder="Ingrese el teléfono de contacto">
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="direccion"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $proveedor['direccion']; ?>" placeholder="Ingrese la dirección">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-end">
                <div class="col-md-8 text-right btn-actions">
                    <a href="<?php echo BASE_URL; ?>Proveedor" class="btn btn-cancel">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Validación del formulario
        $('#formProveedor').submit(function(e) {
            var nombre = $('#nombre').val().trim();
            
            if (nombre === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'El nombre del proveedor es obligatorio',
                    confirmButtonColor: '#4e73df'
                });
                $('#nombre').focus();
                return false;
            }
            
            // Mostrar mensaje de confirmación
            Swal.fire({
                title: '¿Está seguro?',
                text: "¿Desea guardar los cambios realizados?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar mensaje de carga
                    Swal.fire({
                        title: 'Actualizando...',
                        html: 'Procesando cambios',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar formulario
                    this.submit();
                } else {
                    e.preventDefault();
                }
            });
            
            return false;
        });
        
        // Animaciones para elementos de la página
        $(".form-section").css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        }).delay(300).animate({
            'opacity': 1,
            'transform': 'translateY(0)'
        }, 500);
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 