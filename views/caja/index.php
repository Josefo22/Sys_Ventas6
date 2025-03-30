<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos adicionales para el módulo de caja -->
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .page-title {
        color: #4e73df;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        transform: scale(1.05);
    }
    .table thead th {
        background-color: #4e73df !important;
        color: white;
        border: none !important;
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(78, 115, 223, 0.05);
    }
    .date-selector {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 20px;
    }
    .dashboard-card {
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        color: white;
        padding: 20px;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .stats-card {
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .stats-card-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .stats-card-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    .stats-card-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    }
    .stats-card-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #be3c30 100%);
    }
    .stats-card-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    }
    .stats-card-secondary {
        background: linear-gradient(135deg, #5a5c69 0%, #373840 100%);
    }
    .stats-card-icon {
        font-size: 3rem;
        opacity: 0.4;
    }
    .stats-card-value {
        font-size: 2rem;
        font-weight: 700;
    }
    .stats-card-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        opacity: 0.8;
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: none;
        padding: 20px;
    }
    .card-header h6 {
        color: #4e73df;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }
    .card-header h6 i {
        margin-right: 10px;
        font-size: 1.1rem;
    }
    .card-body {
        padding: 20px;
    }
    .btn-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s;
    }
    .btn-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .price-text {
        font-weight: 700;
        color: #1cc88a;
    }
    .expense-text {
        font-weight: 700;
        color: #e74a3b;
    }
    .date-text {
        color: #5a5c69;
    }
    .tab-content {
        padding-top: 20px;
    }
    .nav-tabs {
        border-bottom: none;
    }
    .nav-tabs .nav-link {
        border: none;
        border-radius: 30px;
        padding: 10px 20px;
        font-weight: 600;
        color: #5a5c69;
        margin-right: 10px;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fc;
    }
    .nav-tabs .nav-link.active {
        background-color: #4e73df;
        color: white;
    }
    .balance-positive {
        color: #1cc88a;
    }
    .balance-negative {
        color: #e74a3b;
    }
    .chart-container {
        height: 300px;
    }
    .badge-primary {
        background-color: #4e73df;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    .badge-danger {
        background-color: #e74a3b;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 30px;
        padding: 5px 15px;
        border: 1px solid #d1d3e2;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #bac8f3;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #4e73df;
        color: white !important;
        border: none;
        border-radius: 5px;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 page-title">
        <i class="fas fa-cash-register mr-2"></i> <?php echo $pageTitle; ?>
    </h1>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card date-selector">
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>Caja" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="fecha" class="mr-2 font-weight-bold"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Seleccionar fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter mr-2"></i> Filtrar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stats-card stats-card-secondary">
            <div>
                <div class="stats-card-title">Balance del Día</div>
                <div class="stats-card-value <?php echo $balance >= 0 ? 'balance-positive' : 'balance-negative'; ?>">
                    $<?php echo number_format(abs($balance), 2); ?>
                    <?php echo $balance >= 0 ? '(+)' : '(-)'; ?>
                </div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-balance-scale"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-xl-6 col-md-12 mb-4">
        <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-chart-bar mr-2"></i>Estadísticas de Ventas</h5>
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="stats-card stats-card-primary">
                    <div>
                        <div class="stats-card-title">Total Ventas</div>
                        <div class="stats-card-value">$<?php echo number_format($totalVentas, 2); ?></div>
                    </div>
                    <div class="stats-card-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="stats-card stats-card-success">
                    <div>
                        <div class="stats-card-title">Número de Ventas</div>
                        <div class="stats-card-value"><?php echo $numeroVentas; ?></div>
                    </div>
                    <div class="stats-card-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="stats-card stats-card-info">
                    <div>
                        <div class="stats-card-title">Promedio por Venta</div>
                        <div class="stats-card-value">
                            $<?php echo $numeroVentas > 0 ? number_format($totalVentas / $numeroVentas, 2) : '0.00'; ?>
                        </div>
                    </div>
                    <div class="stats-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-md-12 mb-4">
        <h5 class="text-danger font-weight-bold mb-3"><i class="fas fa-shopping-cart mr-2"></i>Estadísticas de Compras</h5>
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="stats-card stats-card-danger">
                    <div>
                        <div class="stats-card-title">Total Compras</div>
                        <div class="stats-card-value">$<?php echo number_format($totalCompras, 2); ?></div>
                    </div>
                    <div class="stats-card-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="stats-card stats-card-warning">
                    <div>
                        <div class="stats-card-title">Número de Compras</div>
                        <div class="stats-card-value"><?php echo $numeroCompras; ?></div>
                    </div>
                    <div class="stats-card-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="stats-card stats-card-secondary">
                    <div>
                        <div class="stats-card-title">Promedio por Compra</div>
                        <div class="stats-card-value">
                            $<?php echo $numeroCompras > 0 ? number_format($totalCompras / $numeroCompras, 2) : '0.00'; ?>
                        </div>
                    </div>
                    <div class="stats-card-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-trophy mr-2"></i> Productos Más Vendidos del Día
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($productosMasVendidos)) : ?>
                                <?php foreach ($productosMasVendidos as $producto) : ?>
                                    <tr>
                                        <td>
                                            <i class="fas fa-box text-primary mr-2"></i>
                                            <?php echo isset($producto['descripcion']) ? $producto['descripcion'] : ''; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">
                                                <?php echo isset($producto['total_vendido']) ? $producto['total_vendido'] : ''; ?>
                                            </span>
                                        </td>
                                        <td class="text-right price-text">
                                            $<?php echo isset($producto['total_ingresos']) ? number_format($producto['total_ingresos'], 2) : '0.00'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay productos vendidos</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-shopping-basket mr-2"></i> Productos Más Comprados del Día
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($productosMasComprados)) : ?>
                                <?php foreach ($productosMasComprados as $producto) : ?>
                                    <tr>
                                        <td>
                                            <i class="fas fa-box text-danger mr-2"></i>
                                            <?php echo isset($producto['descripcion']) ? $producto['descripcion'] : ''; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-danger">
                                                <?php echo isset($producto['total_comprado']) ? $producto['total_comprado'] : ''; ?>
                                            </span>
                                        </td>
                                        <td class="text-right expense-text">
                                            $<?php echo isset($producto['total_gastos']) ? number_format($producto['total_gastos'], 2) : '0.00'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay productos comprados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pestañas para Ventas y Compras -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ventas-tab" data-toggle="tab" href="#ventas" role="tab" aria-controls="ventas" aria-selected="true">
                    <i class="fas fa-shopping-cart mr-2"></i> Ventas del Día
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="compras-tab" data-toggle="tab" href="#compras" role="tab" aria-controls="compras" aria-selected="false">
                    <i class="fas fa-truck mr-2"></i> Compras del Día
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <!-- Tabla de Ventas -->
            <div class="tab-pane fade show active" id="ventas" role="tabpanel" aria-labelledby="ventas-tab">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Hora</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ventas)) : ?>
                                <?php foreach ($ventas as $venta) : ?>
                                    <tr>
                                        <td><?php echo isset($venta['id']) ? $venta['id'] : ''; ?></td>
                                        <td>
                                            <i class="fas fa-user text-primary mr-2"></i>
                                            <?php echo isset($venta['cliente']) ? $venta['cliente'] : ''; ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-user-tie text-primary mr-2"></i>
                                            <?php echo isset($venta['vendedor']) ? $venta['vendedor'] : ''; ?>
                                        </td>
                                        <td class="date-text">
                                            <i class="fas fa-clock text-primary mr-2"></i>
                                            <?php echo isset($venta['fecha']) ? date('H:i:s', strtotime($venta['fecha'])) : ''; ?>
                                        </td>
                                        <td class="text-right price-text">
                                            <i class="fas fa-dollar-sign text-success mr-2"></i>
                                            $<?php echo isset($venta['total']) ? number_format($venta['total'], 2) : '0.00'; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo BASE_URL; ?>Venta/ver/<?php echo isset($venta['id']) ? $venta['id'] : ''; ?>" class="btn btn-info btn-icon" data-toggle="tooltip" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>Venta/pdf/<?php echo isset($venta['id']) ? $venta['id'] : ''; ?>" class="btn btn-danger btn-icon" data-toggle="tooltip" title="Generar PDF" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay ventas registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Tabla de Compras -->
            <div class="tab-pane fade" id="compras" role="tabpanel" aria-labelledby="compras-tab">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Hora</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($compras)) : ?>
                                <?php foreach ($compras as $compra) : ?>
                                    <tr>
                                        <td><?php echo isset($compra['id']) ? $compra['id'] : ''; ?></td>
                                        <td>
                                            <i class="fas fa-industry text-danger mr-2"></i>
                                            <?php echo isset($compra['proveedor']) ? $compra['proveedor'] : ''; ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-user-tie text-danger mr-2"></i>
                                            <?php echo isset($compra['usuario']) ? $compra['usuario'] : ''; ?>
                                        </td>
                                        <td class="date-text">
                                            <i class="fas fa-clock text-danger mr-2"></i>
                                            <?php echo isset($compra['fecha']) ? date('H:i:s', strtotime($compra['fecha'])) : ''; ?>
                                        </td>
                                        <td class="text-right expense-text">
                                            <i class="fas fa-dollar-sign text-danger mr-2"></i>
                                            $<?php echo isset($compra['total']) ? number_format($compra['total'], 2) : '0.00'; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo BASE_URL; ?>Compra/ver/<?php echo isset($compra['id']) ? $compra['id'] : ''; ?>" class="btn btn-info btn-icon" data-toggle="tooltip" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay compras registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar DataTables
        $('.dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
            },
            order: [[0, 'desc']],
            responsive: true
        });
        
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Animación de entrada para las filas de las tablas
        $("tbody tr").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateX(-20px)'
            });
            
            $(this).animate({
                'opacity': 1,
                'transform': 'translateX(0)'
            }, 100 + (index * 50));
        });
        
        // Animación de entrada para las tarjetas de estadísticas
        $(".stats-card").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });
            
            $(this).animate({
                'opacity': 1,
                'transform': 'translateY(0)'
            }, 200 + (index * 100));
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 