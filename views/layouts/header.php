<?php
// Verificar si el usuario está autenticado
if (empty($_SESSION['active'])) {
    header('location: ' . BASE_URL . 'Auth');
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
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/img/favicon.png">
    
    <!-- Google Fonts - Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" crossorigin="anonymous" />
    
    <!-- Custom Admin CSS -->
    <link href="<?php echo BASE_URL; ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- jQuery UI CSS -->
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Autocomplete CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/autocomplete.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    
    <!-- Custom Styles -->
    <link href="<?php echo BASE_URL; ?>assets/css/styles.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
    <!-- FontAwesome JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/all.min.js" crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Chart.js -->
    <script src="<?php echo BASE_URL; ?>assets/js/chart.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
    
    <!-- Estilos para gráficos -->
    <style>
        .chart-area {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .chart-pie {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        @media (max-width: 768px) {
            .chart-area, .chart-pie {
                height: 250px;
            }
        }
    </style>
    
    <!-- Estilos personalizados para navbar y sidebar -->
    <style>
        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light-bg: #f8f9fc;
            --dark-bg: #5a5c69;
            --dark-blue: #3a3b45;
            --white: #fff;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--light-bg);
        }
        
        /* Navbar Styling */
        .sb-topnav {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 0.5rem 1rem;
            z-index: 1040;
        }
        
        .sb-topnav .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--white);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            letter-spacing: 1px;
        }
        
        .sb-topnav .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.8rem;
        }
        
        #sidebarToggle {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.1);
        }
        
        #sidebarToggle:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .navbar-nav .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .navbar-nav .nav-item .nav-link:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-nav .nav-item .nav-link i {
            margin-right: 0.5rem;
        }

        /* User dropdown */
        .dropdown-user-info {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }
        
        .dropdown-user-info:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .dropdown-user-info .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            margin-right: 0.5rem;
        }
        
        .dropdown-user-info .user-name {
            color: var(--white);
            font-weight: 600;
            margin-right: 0.5rem;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            animation: dropdown-animation 0.3s ease;
        }
        
        @keyframes dropdown-animation {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            color: var(--dark-blue);
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-bg);
            color: var(--primary);
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
            color: var(--primary);
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e3e6f0;
        }
        
        /* Sidebar Styling */
        #layoutSidenav_nav {
            width: 250px;
            transition: all 0.3s;
        }
        
        .sb-sidenav {
            padding-top: 1rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background: var(--white);
        }
        
        .sb-sidenav .sb-sidenav-menu {
            padding: 0 1rem;
        }
        
        .sb-sidenav .nav {
            display: flex;
            flex-direction: column;
        }
        
        .sb-sidenav .nav-link {
            color: var(--dark-blue);
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .sb-sidenav .nav-link:hover {
            background-color: var(--light-bg);
            color: var(--primary);
        }
        
        .sb-sidenav .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(78, 115, 223, 0.15);
        }
        
        .sb-sidenav .sb-nav-link-icon {
            margin-right: 0.5rem;
            font-size: 1.25rem;
            width: 25px;
            color: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidenav-footer {
            background-color: var(--light-bg);
            padding: 1rem;
            margin-top: auto;
            font-size: 0.9rem;
            color: var(--secondary);
            text-align: center;
        }
        
        /* Contenido principal */
        #layoutSidenav_content {
            padding-left: 250px;
            transition: all 0.3s;
        }
        
        .sb-sidenav-toggled #layoutSidenav_content {
            padding-left: 0;
        }
        
        .sb-sidenav-toggled #layoutSidenav_nav {
            transform: translateX(-250px);
        }
        
        main {
            padding: 1.5rem;
        }
        
        .container-fluid {
            padding: 0 1.5rem;
        }
        
        @media (max-width: 768px) {
            #layoutSidenav_content {
                padding-left: 0;
            }
            
            #layoutSidenav_nav {
                transform: translateX(-250px);
            }
            
            .sb-sidenav-toggled #layoutSidenav_nav {
                transform: translateX(0);
            }
        }
    </style>
    
    <!-- Custom styles for this page -->
    <?php if (isset($data['current_page']) && $data['current_page'] === 'dashboard'): ?>
    <link href="<?php echo BASE_URL; ?>assets/css/dashboard.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body class="sb-nav-fixed">
    <!-- Top Navigation Bar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <!-- Navbar Brand -->
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>Dashboard">
            <i class="fas fa-chart-line"></i> SysVenta
        </a>
        
        <!-- Sidebar Toggle -->
        <button class="btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Navbar Search -->
        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!-- Placeholder for future search functionality -->
        </div>
        
        <!-- Navbar User Information -->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-user-info" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name d-none d-md-inline"><?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario'; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>Usuario/profile">
                        <i class="fas fa-user-circle"></i> Perfil
                    </a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>Configuracion">
                        <i class="fas fa-cog"></i> Configuración
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>Auth/logout">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <!-- Sidebar Navigation -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                    <br>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'dashboard' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <?php if (isset($_SESSION['permisos']['nueva_venta']) && $_SESSION['permisos']['nueva_venta'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'nueva_venta' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Venta/create">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Nueva venta
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['clientes']) && $_SESSION['permisos']['clientes'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'clientes' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Cliente">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Clientes
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['ventas']) && $_SESSION['permisos']['ventas'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'ventas' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Venta">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Ventas
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['caja']) && $_SESSION['permisos']['caja'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'caja' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Caja">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                            Caja
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['compras']) && $_SESSION['permisos']['compras'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'compras' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Compra">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                            Compras
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['proveedores']) && $_SESSION['permisos']['proveedores'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'proveedores' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Proveedor">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck-loading"></i></div>
                            Proveedores
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['productos']) && $_SESSION['permisos']['productos'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'productos' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Producto">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Productos
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['usuarios']) && $_SESSION['permisos']['usuarios'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'usuarios' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Usuario">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                            Usuarios
                        </a>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos']['configuracion']) && $_SESSION['permisos']['configuracion'] == 1): ?>
                        <a class="nav-link <?php echo isset($data['current_page']) && $data['current_page'] === 'configuracion' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>Configuracion">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                            Configuración
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Sidenav Footer -->
                <div class="sidenav-footer">
                    <div class="small">Conectado como:</div>
                    <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario'; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-2"> 