<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos adicionales para el módulo de clientes -->
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
    .btn-edit {
        background-color: #36b9cc;
        border-color: #36b9cc;
        color: white;
    }
    .btn-edit:hover {
        background-color: #2c9faf;
        border-color: #2c9faf;
    }
    .btn-delete {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }
    .btn-delete:hover {
        background-color: #be3c30;
        border-color: #be3c30;
    }
    .badge {
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-success {
        background-color: #1cc88a;
    }
    .badge-danger {
        background-color: #e74a3b;
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
    .client-icon {
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
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 page-title">
        <i class="fas fa-users client-icon"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Cliente/create" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-2"></i> Nuevo Cliente
    </a>
</div>

<?php 
// Contar clientes activos e inactivos
$clientesActivos = 0;
$clientesInactivos = 0;
foreach ($clientes as $cliente) {
    if ($cliente['estado'] == 1) {
        $clientesActivos++;
    } else {
        $clientesInactivos++;
    }
}
$totalClientes = count($clientes);
?>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-4">
        <div class="stats-card stats-card-primary">
            <div>
                <div class="stats-card-title">Total Clientes</div>
                <div class="stats-card-value"><?php echo $totalClientes; ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="stats-card stats-card-success">
            <div>
                <div class="stats-card-title">Clientes Activos</div>
                <div class="stats-card-value"><?php echo $clientesActivos; ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="stats-card stats-card-info">
            <div>
                <div class="stats-card-title">Clientes Inactivos</div>
                <div class="stats-card-value"><?php echo $clientesInactivos; ?></div>
            </div>
            <div class="stats-card-icon">
                <i class="fas fa-user-times"></i>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['success'])) { ?>
    <?php if ($_GET['success'] == 1) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> Cliente creado correctamente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['success'] == 2) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> Cliente actualizado correctamente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } else if ($_GET['success'] == 3) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> Cliente eliminado correctamente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
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
                    <i class="fas fa-list mr-2"></i> Listado de Clientes
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Cédula</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente) { ?>
                                <tr>
                                    <td><?php echo $cliente['idcliente']; ?></td>
                                    <td>
                                        <i class="fas fa-user text-primary mr-2"></i>
                                        <?php echo $cliente['nombre']; ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone text-primary mr-2"></i>
                                        <?php echo $cliente['telefono']; ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                        <?php echo $cliente['direccion']; ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-id-card text-primary mr-2"></i>
                                        <?php echo $cliente['cedula']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($cliente['estado'] == 1) { ?>
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i> Activo
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i> Inactivo
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo BASE_URL; ?>Cliente/edit/<?php echo $cliente['idcliente']; ?>" class="btn btn-edit btn-action" data-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>Cliente/delete/<?php echo $cliente['idcliente']; ?>" class="btn btn-delete btn-action btn-delete" data-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
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
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                    className: 'btn btn-success btn-sm mr-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    className: 'btn btn-danger btn-sm mr-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-2"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ]
        });
        
        // Confirmación de eliminación con animación mejorada
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este cliente será eliminado",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                backdrop: `rgba(0,0,123,0.4)`,
                heightAuto: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loader mientras se procesa
                    Swal.fire({
                        title: 'Procesando',
                        text: 'Eliminando cliente...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    window.location.href = href;
                }
            });
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