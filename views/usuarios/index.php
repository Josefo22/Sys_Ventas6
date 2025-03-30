<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el módulo de usuarios -->
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
    .stat-card-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #be3c30 100%);
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
    .btn-edit {
        background: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    .btn-delete {
        background: #e74a3b;
        border-color: #e74a3b;
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
    .badge-primary {
        background: #4e73df;
    }
    .badge-secondary {
        background: #858796;
    }
    .user-name {
        font-weight: 600;
        color: #3a3b45;
        display: flex;
        align-items: center;
    }
    .user-icon {
        margin-right: 10px;
        color: #4e73df;
    }
    .user-email {
        display: flex;
        align-items: center;
        color: #6e707e;
    }
    .user-email i {
        margin-right: 8px;
        color: #36b9cc;
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
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
        font-weight: 600;
    }
    .role-badge i {
        margin-right: 6px;
        font-size: 0.9rem;
    }
</style>

<!-- Encabezado de página con gradiente -->
<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-users"></i> <?php echo $pageTitle; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Usuario/create" class="btn btn-add">
        <i class="fas fa-user-plus mr-2"></i> Nuevo Usuario
    </a>
</div>

<!-- Tarjetas de estadísticas -->
<div class="card-stats">
    <div class="stat-card stat-card-primary">
        <div class="stat-card-value" id="total-usuarios"><?php echo count($usuarios); ?></div>
        <div class="stat-card-title">Total Usuarios</div>
        <div class="stat-card-icon">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-value" id="usuarios-activos"><?php 
            $activos = 0;
            foreach ($usuarios as $usuario) {
                if ($usuario['estado'] == 1) $activos++;
            }
            echo $activos;
        ?></div>
        <div class="stat-card-title">Usuarios Activos</div>
        <div class="stat-card-icon">
            <i class="fas fa-user-check"></i>
        </div>
    </div>
    <div class="stat-card stat-card-danger">
        <div class="stat-card-value" id="usuarios-inactivos"><?php 
            $inactivos = 0;
            foreach ($usuarios as $usuario) {
                if ($usuario['estado'] == 0) $inactivos++;
            }
            echo $inactivos;
        ?></div>
        <div class="stat-card-title">Usuarios Inactivos</div>
        <div class="stat-card-icon">
            <i class="fas fa-user-times"></i>
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
                    echo "Usuario creado correctamente";
                    break;
                case 2:
                    echo "Usuario actualizado correctamente";
                    break;
                case 3:
                    echo "Usuario eliminado correctamente";
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

<!-- Tabla de usuarios -->
<div class="card animated-row">
    <div class="card-header">
        <h6 class="font-weight-bold text-primary m-0">
            <i class="fas fa-list mr-2"></i> Listado de Usuarios
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <tr>
                            <td>
                                <span class="badge badge-primary">
                                    <?php echo $usuario['idusuario']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="user-name">
                                    <i class="fas fa-user user-icon"></i>
                                    <?php echo $usuario['nombre']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="user-email">
                                    <i class="fas fa-envelope"></i>
                                    <?php echo $usuario['correo']; ?>
                                </div>
                            </td>
                            <td><?php echo $usuario['usuario']; ?></td>
                            <td>
                                <div class="role-badge">
                                    <i class="fas fa-id-badge"></i>
                                    <?php echo isset($usuario['rol_nombre']) ? $usuario['rol_nombre'] : 'Sin rol'; ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($usuario['estado'] == 1) { ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo BASE_URL; ?>Usuario/edit/<?php echo $usuario['idusuario']; ?>" class="btn btn-edit btn-action" data-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($usuario['idusuario'] != $_SESSION['idUser']) { ?>
                                    <a href="javascript:void(0)" onclick="confirmarEliminar(<?php echo $usuario['idusuario']; ?>, '<?php echo $usuario['nombre']; ?>')" class="btn btn-delete btn-action" data-toggle="tooltip" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
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
    function confirmarEliminar(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            html: `Desea eliminar al usuario <strong>${nombre}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo BASE_URL; ?>Usuario/delete/${id}`;
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
                    title: 'Listado de Usuarios'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Listado de Usuarios'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    title: 'Listado de Usuarios'
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