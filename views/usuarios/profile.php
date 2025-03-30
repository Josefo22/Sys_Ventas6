<?php require_once 'views/layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $pageTitle; ?></h1>
    <a href="<?php echo BASE_URL; ?>Dashboard" class="btn btn-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Dashboard
    </a>
</div>

<?php if (isset($_GET['success'])) { ?>
    <?php if ($_GET['success'] == 1) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Contraseña actualizada correctamente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
<?php } ?>

<?php if (isset($_GET['error'])) { ?>
    <?php if ($_GET['error'] == 1) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Todos los campos son obligatorios
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['error'] == 2) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Las contraseñas no coinciden
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['error'] == 3) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            La contraseña actual es incorrecta
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['error'] == 4) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Error al actualizar la contraseña
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
<?php } ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Datos del Usuario</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nombre completo:</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext"><?php echo $usuario['nombre']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Correo electrónico:</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext"><?php echo $usuario['correo']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Usuario:</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext"><?php echo $usuario['usuario']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Cambiar Contraseña</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>Usuario/changePassword" method="POST">
                    <div class="form-group">
                        <label for="clave_actual">Contraseña actual</label>
                        <input type="password" class="form-control" id="clave_actual" name="clave_actual" required>
                    </div>
                    <div class="form-group">
                        <label for="clave_nueva">Nueva contraseña</label>
                        <input type="password" class="form-control" id="clave_nueva" name="clave_nueva" required>
                    </div>
                    <div class="form-group">
                        <label for="clave_confirmar">Confirmar nueva contraseña</label>
                        <input type="password" class="form-control" id="clave_confirmar" name="clave_confirmar" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>