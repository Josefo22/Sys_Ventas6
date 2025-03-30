<?php require_once 'views/layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $pageTitle; ?></h1>
    <?php if ($this->checkPermission('crear_rol')): ?>
    <a href="<?php echo BASE_URL; ?>Rol/create" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Nuevo Rol
    </a>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Roles</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roles as $rol): ?>
                            <tr>
                                <td><?php echo $rol['id']; ?></td>
                                <td><?php echo $rol['nombre']; ?></td>
                                <td>
                                    <?php if ($rol['estado'] == 1): ?>
                                        <span class="badge badge-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($this->checkPermission('editar_rol')): ?>
                                    <a href="<?php echo BASE_URL; ?>Rol/edit/<?php echo $rol['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($this->checkPermission('permisos_rol')): ?>
                                    <a href="<?php echo BASE_URL; ?>Rol/permisos/<?php echo $rol['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-key"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($this->checkPermission('eliminar_rol')): ?>
                                    <a href="#" onclick="cambiarEstado(<?php echo $rol['id']; ?>, '<?php echo $rol['estado'] == 1 ? 'inactivar' : 'activar'; ?>')" class="btn btn-sm <?php echo $rol['estado'] == 1 ? 'btn-danger' : 'btn-success'; ?>">
                                        <i class="fas <?php echo $rol['estado'] == 1 ? 'fa-times' : 'fa-check'; ?>"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cambiarEstado(id, accion) {
        const confirmar = confirm(`¿Está seguro de ${accion} este rol?`);
        if (confirmar) {
            window.location = `<?php echo BASE_URL; ?>Rol/cambiarEstado/${id}`;
        }
    }
</script>

<?php require_once 'views/layouts/footer.php'; ?> 