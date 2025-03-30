<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el módulo de productos -->
<style>
    .page-header {
        background: linear-gradient(135deg, #36b9cc 0%, #1a8a98 100%);
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
        color: #36b9cc;
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
        color: #1a8a98;
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
    .stat-card-info {
        background: linear-gradient(135deg, #36b9cc 0%, #1a8a98 100%);
    }
    .stat-card-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    .stat-card-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
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
        background-color: #36b9cc !important;
        color: white;
        border: none !important;
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(54, 185, 204, 0.05);
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
    .btn-edit {
        background: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    .btn-deactivate {
        background: #e74a3b;
        border-color: #e74a3b;
        color: white;
    }
    .btn-activate {
        background: #1cc88a;
        border-color: #1cc88a;
        color: white;
    }
    .badge {
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-success {
        background: #1cc88a;
    }
    .badge-danger {
        background: #e74a3b;
    }
    .badge-info {
        background: #36b9cc;
    }
    .badge-warning {
        background: #f6c23e;
        color: #fff;
    }
    .product-code {
        font-weight: 600;
        color: #4e73df;
    }
    .product-name {
        font-weight: 600;
        color: #3a3b45;
        display: flex;
        align-items: center;
    }
    .product-icon {
        margin-right: 10px;
        color: #36b9cc;
    }
    .price-tag {
        font-weight: 700;
        color: #1cc88a;
        display: inline-block;
        padding: 5px 10px;
        background: rgba(28, 200, 138, 0.1);
        border-radius: 20px;
    }
    .stock-indicator {
        display: flex;
        align-items: center;
    }
    .stock-icon {
        margin-right: 8px;
    }
    .stock-low {
        color: #e74a3b;
    }
    .stock-medium {
        color: #f6c23e;
    }
    .stock-high {
        color: #1cc88a;
    }
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 30px;
        padding: 5px 15px;
        border: 1px solid #d1d3e2;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(54, 185, 204, 0.25);
        border-color: #97e1ea;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #36b9cc;
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
</style>

<!-- Encabezado de página con gradiente -->
<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-box"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Producto/create" class="btn btn-add">
        <i class="fas fa-plus mr-2"></i> Nuevo Producto
    </a>
</div>

<!-- Tarjetas de estadísticas -->
<div class="card-stats">
    <div class="stat-card stat-card-info">
        <div class="stat-card-value" id="total-productos"><?php echo count($productos); ?></div>
        <div class="stat-card-title">Total Productos</div>
        <div class="stat-card-icon">
            <i class="fas fa-boxes"></i>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-value" id="productos-activos"><?php 
            $activos = 0;
            foreach ($productos as $producto) {
                if ($producto['estado'] == 1) $activos++;
            }
            echo $activos;
        ?></div>
        <div class="stat-card-title">Productos Activos</div>
        <div class="stat-card-icon">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
    <div class="stat-card stat-card-warning">
        <div class="stat-card-value" id="productos-stock-bajo"><?php 
            $stockBajo = 0;
            foreach ($productos as $producto) {
                if ($producto['existencia'] <= 10) $stockBajo++;
            }
            echo $stockBajo;
        ?></div>
        <div class="stat-card-title">Stock Bajo</div>
        <div class="stat-card-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
    </div>
</div>

<!-- Alertas de notificación -->
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-check-circle mr-2"></i> 
        <?php 
            switch ($_GET['success']) {
                case 1:
                    echo "Producto creado correctamente";
                    break;
                case 2:
                    echo "Producto actualizado correctamente";
                    break;
                case 3:
                    echo "Producto desactivado correctamente";
                    break;
                case 4:
                    echo "Producto activado correctamente";
                    break;
            }
        ?>
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

<!-- Tabla de productos -->
<div class="card animated-row">
    <div class="card-header">
        <h6 class="font-weight-bold text-info m-0">
            <i class="fas fa-list mr-2"></i> Listado de Productos
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td>
                                <span class="badge badge-info">
                                    <?php echo $producto['codproducto']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="product-code">
                                    <?php echo $producto['codigo']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="product-name">
                                    <i class="fas fa-box product-icon"></i>
                                    <?php echo $producto['descripcion']; ?>
                                </div>
                            </td>
                            <td>
                                <span class="price-tag">
                                    $<?php echo number_format($producto['precio'], 2); ?>
                                </span>
                            </td>
                            <td>
                                <div class="stock-indicator <?php 
                                    if ($producto['existencia'] <= 5) echo 'stock-low';
                                    else if ($producto['existencia'] <= 20) echo 'stock-medium';
                                    else echo 'stock-high';
                                ?>">
                                    <i class="fas <?php 
                                        if ($producto['existencia'] <= 5) echo 'fa-exclamation-circle stock-icon';
                                        else if ($producto['existencia'] <= 20) echo 'fa-exclamation-triangle stock-icon';
                                        else echo 'fa-check-circle stock-icon';
                                    ?>"></i>
                                    <?php echo $producto['existencia']; ?> unidades
                                </div>
                            </td>
                            <td>
                                <?php if ($producto['estado'] == 1) { ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo BASE_URL; ?>Producto/edit/<?php echo $producto['codproducto']; ?>" class="btn btn-edit btn-action" data-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($producto['estado'] == 1) { ?>
                                    <a href="javascript:void(0)" onclick="confirmarDesactivar(<?php echo $producto['codproducto']; ?>, '<?php echo $producto['descripcion']; ?>')" class="btn btn-deactivate btn-action" data-toggle="tooltip" title="Desactivar">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:void(0)" onclick="confirmarActivar(<?php echo $producto['codproducto']; ?>, '<?php echo $producto['descripcion']; ?>')" class="btn btn-activate btn-action" data-toggle="tooltip" title="Activar">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmarDesactivar(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            html: `Desea desactivar el producto <strong>${nombre}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo BASE_URL; ?>Producto/desactivar/${id}`;
            }
        });
    }

    function confirmarActivar(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            html: `Desea activar el producto <strong>${nombre}</strong>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1cc88a',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, activar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo BASE_URL; ?>Producto/activar/${id}`;
            }
        });
    }

    $(document).ready(function() {
        // Inicializar DataTables
        var table = $('#dataTable').DataTable({
            language: {
                url: '<?php echo BASE_URL; ?>assets/js/spanish.json'
            },
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Listado de Productos'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Listado de Productos'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Listado de Productos'
                }
            ]
        });
        
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
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
            
            $({ countNum: 0 }).animate({
                countNum: parseInt(countTo)
            }, {
                duration: 1000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(countTo);
                }
            });
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 