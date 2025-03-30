<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el formulario de usuarios -->
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
    .btn-guardar {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    .btn-guardar:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(78, 115, 223, 0.4);
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
    .password-strength {
        height: 5px;
        border-radius: 5px;
        margin-top: 8px;
        transition: all 0.3s ease;
    }
    .strength-weak {
        background: linear-gradient(90deg, #e74a3b 0%, #f5a589 100%);
        width: 33%;
    }
    .strength-medium {
        background: linear-gradient(90deg, #f6c23e 0%, #f8d880 100%);
        width: 66%;
    }
    .strength-strong {
        background: linear-gradient(90deg, #1cc88a 0%, #91e9c1 100%);
        width: 100%;
    }
    .password-message {
        font-size: 0.75rem;
        margin-top: 5px;
    }
    .select2-container--default .select2-selection--single {
        height: 46px;
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        padding: 8px 15px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #4e73df;
    }
</style>

<!-- Encabezado de página con gradiente -->
<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-user-plus"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Usuario" class="btn btn-volver">
        <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
    </a>
</div>

<!-- Alertas de notificación -->
<?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <?php 
            if ($_GET['error'] == 1) echo "Todos los campos son obligatorios";
            else if ($_GET['error'] == 2) echo "Error al crear el usuario";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<!-- Formulario de creación de usuario -->
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card animated-row">
            <div class="card-header">
                <h6 class="font-weight-bold text-primary m-0">
                    <i class="fas fa-user-edit mr-2"></i> Información del Usuario
                </h6>
            </div>
            <div class="card-body">
                <form id="formCrearUsuario" action="<?php echo BASE_URL; ?>Usuario/store" method="POST">
                    
                    <!-- Sección: Información Personal -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-id-card"></i> Información Personal
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre Completo</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre completo" required>
                                        <div class="invalid-feedback">El nombre completo es obligatorio</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="correo">Correo Electrónico</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo electrónico" required>
                                        <div class="invalid-feedback">El correo electrónico es obligatorio y debe tener un formato válido</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección: Credenciales de Acceso -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-lock"></i> Credenciales de Acceso
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Nombre de Usuario</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese el nombre de usuario" required>
                                        <div class="invalid-feedback">El nombre de usuario es obligatorio</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clave">Contraseña</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese la contraseña" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">La contraseña es obligatoria</div>
                                    </div>
                                    <div class="password-strength" id="passwordStrength"></div>
                                    <div class="password-message" id="passwordMessage"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección: Permisos y Acceso -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-user-shield"></i> Permisos y Acceso
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_rol">Rol de Usuario</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        </div>
                                        <select class="form-control select2" id="id_rol" name="id_rol" required>
                                            <option value="">Seleccione un rol</option>
                                            <?php foreach ($roles as $rol): ?>
                                                <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">El rol de usuario es obligatorio</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-guardar" id="btnGuardar">
                            <i class="fas fa-save"></i> Guardar Usuario
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
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
        
        // Inicializar Select2
        $('.select2').select2({
            placeholder: "Seleccione un rol",
            allowClear: true
        });
        
        // Mostrar/ocultar contraseña
        $('#togglePassword').on('click', function() {
            const passwordField = $('#clave');
            const passwordType = passwordField.attr('type');
            const newType = passwordType === 'password' ? 'text' : 'password';
            passwordField.attr('type', newType);
            
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
        
        // Verificar fortaleza de contraseña
        $('#clave').on('input', function() {
            const password = $(this).val();
            const passwordStrength = $('#passwordStrength');
            const passwordMessage = $('#passwordMessage');
            
            if (password.length === 0) {
                passwordStrength.removeClass('strength-weak strength-medium strength-strong').css('width', '0');
                passwordMessage.text('');
                return;
            }
            
            // Evaluar fortaleza
            let strength = 0;
            
            // Longitud mínima
            if (password.length >= 8) strength += 1;
            
            // Contiene números y letras
            if (/\d/.test(password) && /[a-zA-Z]/.test(password)) strength += 1;
            
            // Contiene caracteres especiales
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
            
            // Actualizar indicador
            passwordStrength.removeClass('strength-weak strength-medium strength-strong');
            
            if (strength === 1) {
                passwordStrength.addClass('strength-weak');
                passwordMessage.text('Contraseña débil').css('color', '#e74a3b');
            } else if (strength === 2) {
                passwordStrength.addClass('strength-medium');
                passwordMessage.text('Contraseña media').css('color', '#f6c23e');
            } else if (strength === 3) {
                passwordStrength.addClass('strength-strong');
                passwordMessage.text('Contraseña fuerte').css('color', '#1cc88a');
            }
        });
        
        // Validación del formulario
        $('#formCrearUsuario').submit(function(e) {
            let valid = true;
            
            // Validar nombre
            if ($('#nombre').val().trim() === '') {
                $('#nombre').addClass('is-invalid');
                valid = false;
            } else {
                $('#nombre').removeClass('is-invalid');
            }
            
            // Validar correo
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if ($('#correo').val().trim() === '' || !emailRegex.test($('#correo').val())) {
                $('#correo').addClass('is-invalid');
                valid = false;
            } else {
                $('#correo').removeClass('is-invalid');
            }
            
            // Validar usuario
            if ($('#usuario').val().trim() === '') {
                $('#usuario').addClass('is-invalid');
                valid = false;
            } else {
                $('#usuario').removeClass('is-invalid');
            }
            
            // Validar contraseña
            if ($('#clave').val().trim() === '') {
                $('#clave').addClass('is-invalid');
                valid = false;
            } else {
                $('#clave').removeClass('is-invalid');
            }
            
            // Validar rol
            if ($('#id_rol').val() === '') {
                $('#id_rol').next('.select2-container').css('border', '1px solid #e74a3b');
                valid = false;
            } else {
                $('#id_rol').next('.select2-container').css('border', 'none');
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
                // Si es válido, mostrar un spinner de carga
                $('#btnGuardar').html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                $('#btnGuardar').attr('disabled', true);
            }
        });
        
        // Validación en tiempo real
        $('#nombre, #correo, #usuario, #clave').on('input', function() {
            if ($(this).val().trim() !== '') {
                $(this).removeClass('is-invalid');
            }
        });
        
        $('#id_rol').on('change', function() {
            if ($(this).val() !== '') {
                $(this).next('.select2-container').css('border', 'none');
            }
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 