<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Sistema de ventas" />
    <meta name="author" content="SysVentas" />
    <title>SysVenta - Recuperar Contraseña</title>
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
                                    <h3 class="text-center font-weight-light my-4">Recuperar Contraseña</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3 text-muted">Ingrese su correo electrónico y le enviaremos instrucciones para restablecer su contraseña.</div>
                                    <form action="<?php echo BASE_URL; ?>Auth/processRecover" method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="email">Correo electrónico</label>
                                            <input class="form-control py-4" id="email" name="email" type="email" placeholder="Ingrese su correo electrónico" />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="<?php echo BASE_URL; ?>Auth">Volver al login</a>
                                            <button type="submit" class="btn btn-primary">Enviar</button>
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