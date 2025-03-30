<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el módulo de proveedores -->
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
    .btn-warning {
        background: #f6c23e;
        border-color: #f6c23e;
        color: white;
    }
    .btn-danger {
        background: #e74a3b;
        border-color: #e74a3b;
    }
    .badge {
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-primary {
        background: #4e73df;
    }
    .badge-success {
        background: #1cc88a;
    }
    .badge-info {
        background: #36b9cc;
    }
    .proveedor-name {
        font-weight: 600;
        color: #3a3b45;
        display: flex;
        align-items: center;
    }
    .proveedor-icon {
        margin-right: 10px;
        color: #4e73df;
    }
    .contact-info {
        display: flex;
        align-items: center;
        color: #5a5c69;
    }
    .contact-icon {
        margin-right: 8px;
        color: #36b9cc;
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
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Encabezado de página con gradiente -->
<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-building"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Proveedor/create" class="btn btn-add">
        <i class="fas fa-plus mr-2"></i> Nuevo Proveedor
    </a>
</div>

<!-- Tarjetas de estadísticas -->
<div class="card-stats">
    <div class="stat-card stat-card-primary">
        <div class="stat-card-value" id="total-proveedores"><?php echo $totalProveedores; ?></div>
        <div class="stat-card-title">Proveedores Totales</div>
        <div class="stat-card-icon">
            <i class="fas fa-building"></i>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-value" id="proveedores-activos"><?php echo $proveedoresActivos; ?></div>
        <div class="stat-card-title">Proveedores Activos</div>
        <div class="stat-card-icon">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
    <div class="stat-card stat-card-info">
        <div class="stat-card-value" id="compras-mes"><?php echo $comprasMes; ?></div>
        <div class="stat-card-title">Compras del Mes</div>
        <div class="stat-card-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
    </div>
</div>

<!-- Alertas de notificación -->
<?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-check-circle mr-2"></i> <?php echo $_SESSION['success']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php } ?>

<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php } ?>

<!-- Tabla de proveedores -->
<div class="card animated-row">
    <div class="card-header">
        <h6 class="font-weight-bold text-primary m-0">
            <i class="fas fa-list mr-2"></i> Listado de Proveedores
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="tblProveedores" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($proveedores)) { ?>
                        <?php foreach ($proveedores as $proveedor) { ?>
                            <tr>
                                <td>
                                    <span class="badge badge-primary">
                                        <?php echo $proveedor['idproveedor']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="proveedor-name">
                                        <i class="fas fa-building proveedor-icon"></i>
                                        <?php echo $proveedor['nombre']; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <i class="fas fa-phone contact-icon"></i>
                                        <?php echo $proveedor['telefono'] ? $proveedor['telefono'] : 'No disponible'; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <i class="fas fa-map-marker-alt contact-icon"></i>
                                        <?php echo $proveedor['direccion'] ? $proveedor['direccion'] : 'No disponible'; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo BASE_URL . 'Proveedor/edit/' . $proveedor['idproveedor']; ?>" class="btn btn-warning btn-action" data-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmarEliminar(<?php echo $proveedor['idproveedor']; ?>, '<?php echo $proveedor['nombre']; ?>')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay proveedores registrados</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmarEliminar(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            html: `Desea eliminar al proveedor <strong>${nombre}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo BASE_URL; ?>Proveedor/delete/${id}`;
            }
        });
    }

    $(document).ready(function() {
        // Inicializar DataTables
        var table = $('#tblProveedores').DataTable({
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
                        columns: [0, 1, 2, 3]
                    },
                    title: 'Listado de Proveedores'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    title: 'Listado de Proveedores'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    title: 'Listado de Proveedores'
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