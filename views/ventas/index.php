<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos adicionales para el módulo de ventas -->
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
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
    .btn-action {
        border-radius: 50%;
        width: 35px;
        height: 35px;
        padding: 0;
        line-height: 35px;
        text-align: center;
        margin: 0 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s;
    }
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .btn-info {
        background-color: #36b9cc;
        border-color: #36b9cc;
    }
    .btn-info:hover {
        background-color: #2c9faf;
        border-color: #2c9faf;
    }
    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }
    .btn-danger:hover {
        background-color: #be3c30;
        border-color: #be3c30;
    }
    .alert {
        border-radius: 10px;
        border: none;
    }
    .alert-success {
        background-color: #1cc88a20;
        color: #1cc88a;
        border-left: 5px solid #1cc88a;
    }
    .alert-danger {
        background-color: #e74a3b20;
        color: #e74a3b;
        border-left: 5px solid #e74a3b;
    }
    .sales-icon {
        font-size: 1.2rem;
        margin-right: 8px;
        vertical-align: middle;
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: none;
        padding: 20px;
    }
    .stats-card {
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    .stats-card-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
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
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter input {
        margin-bottom: 20px;
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
    .price-text {
        font-weight: 700;
        color: #1cc88a;
    }
    .date-text {
        color: #5a5c69;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 page-title">
        <i class="fas fa-shopping-cart sales-icon"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Venta/create" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-2"></i> Nueva Venta
    </a>
</div>

<?php 
// Calcular estadísticas de ventas
$totalVentas = count($ventas);
$sumTotal = 0;
$hoy = date('Y-m-d');
$ventasHoy = 0;

foreach ($ventas as $venta) {
    $sumTotal += isset($venta['total']) ? floatval($venta['total']) : 0;
    
    if (isset($venta['fecha']) && date('Y-m-d', strtotime($venta['fecha'])) == $hoy) {
        $ventasHoy++;
    }
}

// Calcular promedio si hay ventas
$promedio = $totalVentas > 0 ? $sumTotal / $totalVentas : 0;
?>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card stats-card-primary">
            <div>
                <div class="stats-card-title">Total Ventas</div>
                <div class="stats-card-value"><?php echo $totalVentas; ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card stats-card-success">
            <div>
                <div class="stats-card-title">Monto Total</div>
                <div class="stats-card-value">$<?php echo number_format($sumTotal, 2); ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card stats-card-info">
            <div>
                <div class="stats-card-title">Promedio</div>
                <div class="stats-card-value">$<?php echo number_format($promedio, 2); ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stats-card stats-card-warning">
            <div>
                <div class="stats-card-title">Ventas Hoy</div>
                <div class="stats-card-value"><?php echo $ventasHoy; ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i> Venta registrada correctamente
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> Ha ocurrido un error en la operación
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i> Listado de Ventas
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta) { ?>
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
                                        <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                        <?php echo isset($venta['fecha']) ? date('d/m/Y', strtotime($venta['fecha'])) : ''; ?>
                                    </td>
                                    <td class="price-text">
                                        <i class="fas fa-dollar-sign text-success mr-2"></i>
                                        <?php echo isset($venta['total']) ? number_format($venta['total'], 2) : '0.00'; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo BASE_URL; ?>Venta/ver/<?php echo isset($venta['id']) ? $venta['id'] : ''; ?>" class="btn btn-info btn-action" data-toggle="tooltip" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>Venta/pdf/<?php echo isset($venta['id']) ? $venta['id'] : ''; ?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Generar PDF" target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Inicializar DataTables con opciones avanzadas
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
            },
            order: [[0, 'desc']],
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                    className: 'btn btn-success btn-sm mr-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    className: 'btn btn-danger btn-sm mr-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-2"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });
        
        // Animación de entrada para las filas de la tabla
        $("tbody tr").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateX(-20px)'
            });
            
            $(this).animate({
                'opacity': 1,
                'transform': 'translateX(0)'
            }, 300 + (index * 100));
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 