<?php require_once 'views/layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $pageTitle; ?></h1>
    <a href="<?php echo BASE_URL; ?>Configuracion" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Asignar Roles a Usuarios</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Rol Actual</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['nombre']; ?></td>
                                <td><?php echo $usuario['usuario']; ?></td>
                                <td><?php echo $usuario['correo']; ?></td>
                                <td>
                                    <?php 
                                    foreach ($roles as $rol) {
                                        if ($rol['id'] == $usuario['id_rol']) {
                                            echo $rol['nombre'];
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($usuario['estado'] == 1): ?>
                                        <span class="badge badge-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#cambiarRolModal" 
                                        data-id="<?php echo $usuario['id']; ?>" 
                                        data-nombre="<?php echo $usuario['nombre']; ?>"
                                        data-rol="<?php echo $usuario['id_rol']; ?>">
                                        <i class="fas fa-exchange-alt"></i> Cambiar Rol
                                    </button>
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

<!-- Modal para cambiar rol -->
<div class="modal fade" id="cambiarRolModal" tabindex="-1" role="dialog" aria-labelledby="cambiarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambiarRolModalLabel">Cambiar Rol de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>Rol/asignarRol" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_usuario" id="id_usuario">
                    <div class="form-group">
                        <label for="nombre_usuario">Usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_rol">Rol</label>
                        <select class="form-control" id="id_rol" name="id_rol" required>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cambiarRolModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nombre = button.data('nombre');
            const rol = button.data('rol');
            
            const modal = $(this);
            modal.find('#id_usuario').val(id);
            modal.find('#nombre_usuario').val(nombre);
            modal.find('#id_rol').val(rol);
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 