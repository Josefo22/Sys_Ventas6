<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el módulo de compras -->
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
    .btn-add {
        background: white;
        color: #4e73df;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .btn-add:hover {
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
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: none;
        padding: 20px;
        border-radius: 10px 10px 0 0 !important;
    }
    .card-body {
        padding: 25px;
    }
    .card-stats {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    .stat-card {
        flex: 1;
        min-width: 200px;
        margin: 0 10px 20px;
        padding: 25px;
        border-radius: 10px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .stat-card-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .stat-card-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    .stat-card-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    }
    .stat-card-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .stat-card-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
    }
    .stat-card-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 3rem;
        opacity: 0.2;
    }
    .alert {
        border: none;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 25px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .alert-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        color: white;
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
    .table {
        margin-bottom: 0;
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
    .table td {
        vertical-align: middle;
        padding: 15px;
    }
    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.3s;
        margin: 0 3px;
    }
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .btn-info {
        background: #36b9cc;
        border-color: #36b9cc;
    }
    .badge {
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .total-text {
        font-weight: 700;
        color: #1cc88a;
    }
    .date-text {
        color: #5a5c69;
        font-weight: 500;
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
    .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
        color: #5a5c69 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #eaecf4;
        border: 1px solid #eaecf4;
    }
    .dataTables_length select {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1px solid #d1d3e2;
    }
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Encabezado de página con gradiente -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-truck-loading"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Compra/create" class="btn btn-add">
        <i class="fas fa-plus mr-2"></i> Nueva Compra
    </a>
</div>

<!-- Tarjetas de estadísticas -->
<div class="card-stats">
    <div class="stat-card stat-card-primary">
        <div class="stat-card-value" id="total-compras">0</div>
        <div class="stat-card-title">Compras Totales</div>
        <div class="stat-card-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-value" id="total-monto">$0.00</div>
        <div class="stat-card-title">Total Invertido</div>
        <div class="stat-card-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
    </div>
    <div class="stat-card stat-card-info">
        <div class="stat-card-value" id="promedio-compra">$0.00</div>
        <div class="stat-card-title">Promedio por Compra</div>
        <div class="stat-card-icon">
            <i class="fas fa-calculator"></i>
        </div>
    </div>
</div>

<!-- Alertas de notificación -->
<?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
    <div class="alert alert-success alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-check-circle mr-2"></i> Compra registrada correctamente
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> Ha ocurrido un error en la operación
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<!-- Tabla de compras -->
<div class="card animated-row">
    <div class="card-header">
        <h6 class="font-weight-bold text-primary m-0">
            <i class="fas fa-list mr-2"></i> Historial de Compras
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($compras)) : ?>
                        <?php foreach ($compras as $compra) : ?>
                            <tr>
                                <td>
                                    <span class="badge badge-primary">
                                        <?php echo isset($compra['id']) ? $compra['id'] : ''; ?>
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-building text-primary mr-2"></i>
                                    <?php echo isset($compra['proveedor']) ? $compra['proveedor'] : ''; ?>
                                </td>
                                <td>
                                    <i class="fas fa-user text-info mr-2"></i>
                                    <?php echo isset($compra['usuario']) ? $compra['usuario'] : ''; ?>
                                </td>
                                <td class="date-text">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    <?php echo isset($compra['fecha']) ? date('d/m/Y', strtotime($compra['fecha'])) : ''; ?>
                                </td>
                                <td class="total-text">
                                    $<?php echo isset($compra['total']) ? number_format($compra['total'], 2) : '0.00'; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo BASE_URL; ?>Compra/ver/<?php echo isset($compra['id']) ? $compra['id'] : ''; ?>" class="btn btn-info btn-action" data-toggle="tooltip" title="Ver detalles">
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

<script>
    $(document).ready(function() {
        // Inicializar DataTables
        var table = $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
            },
            order: [[0, 'desc']],
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    title: 'Historial de Compras'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    title: 'Historial de Compras'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    title: 'Historial de Compras'
                }
            ]
        });
        
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Calcular estadísticas
        var totalCompras = <?php echo !empty($compras) ? count($compras) : 0; ?>;
        var totalMonto = 0;
        
        <?php if (!empty($compras)) : ?>
            <?php foreach ($compras as $compra) : ?>
                totalMonto += <?php echo isset($compra['total']) ? floatval($compra['total']) : 0; ?>;
            <?php endforeach; ?>
        <?php endif; ?>
        
        var promedioCompra = totalCompras > 0 ? totalMonto / totalCompras : 0;
        
        // Actualizar los valores de las tarjetas de estadísticas
        $('#total-compras').text(totalCompras);
        $('#total-monto').text('$' + totalMonto.toFixed(2));
        $('#promedio-compra').text('$' + promedioCompra.toFixed(2));
        
        // Animaciones para elementos de la página
        $(".stat-card").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            }).delay(100 * index).animate({
                'opacity': 1,
                'transform': 'translateY(0)'
            }, 500);
        });
        
        // Animación de conteo para los números
        $('.stat-card-value').each(function () {
            var $this = $(this);
            var countTo = $this.text();
            
            if (countTo.indexOf('$') !== -1) {
                countTo = parseFloat(countTo.replace('$', ''));
                
                $({ countNum: 0 }).animate({
                    countNum: countTo
                }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function() {
                        $this.text('$' + this.countNum.toFixed(2));
                    }
                });
            } else {
                $({ countNum: 0 }).animate({
                    countNum: parseInt(countTo)
                }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    }
                });
            }
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 