<?php
// Verificar si el usuario está autenticado
if (empty($_SESSION['active'])) {
    header('location: ../');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Sistema de ventas" />
    <meta name="author" content="SysVentas" />
    <title>SysVenta - <?php echo isset($pageTitle) ? $pageTitle : 'Panel de Control'; ?></title>
    <link href="<?php echo BASE_URL; ?>assets/css/styles.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/js/jquery-ui/jquery-ui.min.css">
    <script src="<?php echo BASE_URL; ?>assets/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">SysVenta</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#nuevo_pass">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>Usuario/logout">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Venta/nueva">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Nueva venta
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Configuracion">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                            Configuración
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Cliente">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Venta">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Ventas
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Producto">
                            <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                            Productos
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Proveedor">
                          <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                            Proveedores
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Compra">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            Compra Proveedores
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Usuario">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Usuarios
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>Caja">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            Caja
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-2"><?php if (isset($alertMessage)) { ?>
                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $alertMessage; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>