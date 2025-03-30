<?php require_once 'views/layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $pageTitle; ?></h1>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Configuración General</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Información del Sistema</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cogs fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-primary stretched-link" href="<?php echo BASE_URL; ?>Configuracion/general">Ver detalles</a>
                <div class="small text-primary"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Roles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Gestión de Roles</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-success stretched-link" href="<?php echo BASE_URL; ?>Rol">Ver detalles</a>
                <div class="small text-success"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Permisos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Gestión de Permisos</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-key fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-warning stretched-link" href="<?php echo BASE_URL; ?>Configuracion/permisos">Ver detalles</a>
                <div class="small text-warning"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6 mt-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Asignación de Roles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Asignar Roles a Usuarios</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-info stretched-link" href="<?php echo BASE_URL; ?>Rol/asignar">Ver detalles</a>
                <div class="small text-info"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 