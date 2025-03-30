<?php require_once 'views/layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Control</h1>
</div>

<div class="row">
    <?php if (isset($_SESSION['permisos']['clientes']) && $_SESSION['permisos']['clientes'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Clientes</div>
                        <div class="dashboard-value"><?php echo $clientes; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Cliente">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['productos']) && $_SESSION['permisos']['productos'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Productos</div>
                        <div class="dashboard-value"><?php echo $productos; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fab fa-product-hunt dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Producto">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['ventas']) && $_SESSION['permisos']['ventas'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Ventas</div>
                        <div class="dashboard-value"><?php echo $ventas; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Venta">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['caja']) && $_SESSION['permisos']['caja'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Caja</div>
                        <div class="dashboard-value">
                            <i class="fas fa-cash-register"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Caja">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['compras']) && $_SESSION['permisos']['compras'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Compras</div>
                        <div class="dashboard-value">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Compra">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['proveedores']) && $_SESSION['permisos']['proveedores'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Proveedores</div>
                        <div class="dashboard-value">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-people-carry dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Proveedor">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['usuarios']) && $_SESSION['permisos']['usuarios'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Usuarios</div>
                        <div class="dashboard-value"><?php echo $usuarios; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Usuario">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['permisos']['configuracion']) && $_SESSION['permisos']['configuracion'] == 1): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="dashboard-title">Configuración</div>
                        <div class="dashboard-value">
                            <i class="fas fa-cogs"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cog dashboard-icon"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo BASE_URL; ?>Configuracion">Ver detalles</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Gráficos de Ventas -->
<div class="row">
    <!-- Gráfico de Ventas por Mes -->
    <div class="col-xl-6">
        <div class="card shadow mb-4 chart-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Ventas por Mes (Último Año)</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLinkVentasMes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLinkVentasMes">
                        <div class="dropdown-header">Opciones:</div>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>Venta">Ver todas las ventas</a>
                        <a class="dropdown-item" href="#" id="downloadVentasMesChart">Descargar gráfico</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" id="refreshVentasMesChart">Actualizar datos</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="ventasPorMesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Ventas por Día -->
    <div class="col-xl-6">
        <div class="card shadow mb-4 chart-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Ventas por Día (Última Semana)</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLinkVentasDia" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLinkVentasDia">
                        <div class="dropdown-header">Opciones:</div>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>Venta">Ver todas las ventas</a>
                        <a class="dropdown-item" href="#" id="downloadVentasDiaChart">Descargar gráfico</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" id="refreshVentasDiaChart">Actualizar datos</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="ventasPorDiaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gráfico de Productos Más Vendidos -->
    <div class="col-xl-6">
        <div class="card shadow mb-4 chart-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Productos Más Vendidos</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLinkProductos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLinkProductos">
                        <div class="dropdown-header">Opciones:</div>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>Producto">Ver todos los productos</a>
                        <a class="dropdown-item" href="#" id="downloadProductosChart">Descargar gráfico</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" id="refreshProductosChart">Actualizar datos</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="productosMasVendidosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Ventas por Producto -->
    <div class="col-xl-6">
        <div class="card shadow mb-4 chart-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Ventas por Producto</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLinkCategorias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLinkCategorias">
                        <div class="dropdown-header">Opciones:</div>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>Venta">Ver todas las ventas</a>
                        <a class="dropdown-item" href="#" id="downloadCategoriasChart">Descargar gráfico</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" id="refreshCategoriasChart">Actualizar datos</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="ventasPorCategoriaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configurar gráficos
    configureCharts();
    
    // Manejar descargas de gráficos
    setupChartDownloads();
});

function configureCharts() {
    // Ventas por Mes
    const ctxVentasMes = document.getElementById('ventasPorMesChart').getContext('2d');
    window.ventasPorMesChart = new Chart(ctxVentasMes, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($meses); ?>,
            datasets: [{
                label: 'Ventas Mensuales',
                data: <?php echo json_encode($ventasPorMes); ?>,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Ventas por Mes'
                }
            }
        }
    });

    // Ventas por Día
    const ctxVentasDia = document.getElementById('ventasPorDiaChart').getContext('2d');
    window.ventasPorDiaChart = new Chart(ctxVentasDia, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dias); ?>,
            datasets: [{
                label: 'Ventas Diarias',
                data: <?php echo json_encode($ventasPorDia); ?>,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Ventas por Día'
                }
            }
        }
    });

    // Productos Más Vendidos
    const ctxProductos = document.getElementById('productosMasVendidosChart').getContext('2d');
    window.productosMasVendidosChart = new Chart(ctxProductos, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($nombresProductos); ?>,
            datasets: [{
                label: 'Productos Más Vendidos',
                data: <?php echo json_encode($cantidadesProductos); ?>,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Productos Más Vendidos'
                }
            }
        }
    });

    // Ventas por Categoría
    const ctxCategorias = document.getElementById('ventasPorCategoriaChart').getContext('2d');
    window.ventasPorCategoriaChart = new Chart(ctxCategorias, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($categorias); ?>,
            datasets: [{
                label: 'Ventas por Producto',
                data: <?php echo json_encode($ventasPorCategoria); ?>,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Ventas por Producto'
                }
            }
        }
    });
}

function setupChartDownloads() {
    // Función para descargar gráfico como imagen
    function downloadChart(chartId, fileName) {
        const canvas = document.getElementById(chartId);
        const link = document.createElement('a');
        link.download = fileName + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }
    
    // Configurar eventos de descarga
    document.getElementById('downloadVentasMesChart').addEventListener('click', function() {
        downloadChart('ventasPorMesChart', 'ventas_mensuales');
    });
    
    document.getElementById('downloadVentasDiaChart').addEventListener('click', function() {
        downloadChart('ventasPorDiaChart', 'ventas_diarias');
    });
    
    document.getElementById('downloadProductosChart').addEventListener('click', function() {
        downloadChart('productosMasVendidosChart', 'productos_vendidos');
    });
    
    document.getElementById('downloadCategoriasChart').addEventListener('click', function() {
        downloadChart('ventasPorCategoriaChart', 'ventas_por_producto');
    });
    
    // Eventos para actualizar datos (requeriría Ajax, se podría implementar después)
    document.getElementById('refreshVentasMesChart').addEventListener('click', function(e) {
        e.preventDefault();
        // Aquí iría la lógica para actualizar datos vía Ajax
        Toast.fire({
            icon: 'info',
            title: 'Actualizando datos...'
        });
    });
    
    // Crear un objeto Toast usando SweetAlert2 si está disponible
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}
</script>

<!-- Incluir los archivos CSS y JS personalizados -->
<link href="<?php echo BASE_URL; ?>assets/css/dashboard.css" rel="stylesheet">
<script src="<?php echo BASE_URL; ?>assets/js/dashboard.js" defer></script>

<?php require_once 'views/layouts/footer.php'; ?>