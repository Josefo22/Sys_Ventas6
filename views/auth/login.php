<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Sistema de ventas" />
    <meta name="author" content="SysVentas" />
    <title>SysVenta - Iniciar Sesión</title>
    <link href="<?php echo BASE_URL; ?>assets/css/styles.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL; ?>assets/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Iniciar Sesión</h3>
                                </div>
                                <div class="card-body">
                                    <?php if (isset($_GET['error'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> 
                                        <?php if ($_GET['error'] == 1): ?>
                                            Usuario o contraseña incorrectos.
                                        <?php elseif ($_GET['error'] == 2): ?>
                                            Todos los campos son obligatorios.
                                        <?php else: ?>
                                            Ha ocurrido un error. Inténtelo nuevamente.
                                        <?php endif; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <form action="<?php echo BASE_URL; ?>Auth/login" method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="usuario">Usuario</label>
                                            <input class="form-control py-4" id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="clave">Contraseña</label>
                                            <input class="form-control py-4" id="clave" name="clave" type="password" placeholder="Ingrese su contraseña" />
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" id="rememberMe" type="checkbox" />
                                                <label class="custom-control-label" for="rememberMe">Recordarme</label>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="<?php echo BASE_URL; ?>Auth/recover">¿Olvidó su contraseña?</a>
                                            <button type="submit" class="btn btn-primary">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; SysVentas <?php echo date('Y'); ?></div>
                        <div>
                            <a href="#">Política de privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?php echo BASE_URL; ?>assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/scripts.js"></script>
</body>
</html> 