<?php
/**
 * Vista de gestión de permisos del sistema
 */
?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Permisos del Sistema</h5>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalPermisos">
            <i class="fas fa-plus"></i> Nuevo Permiso
        </button>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data['permisos']) && is_array($data['permisos']) && count($data['permisos']) > 0): ?>
                        <?php foreach ($data['permisos'] as $permiso): ?>
                        <tr>
                            <td><?= $permiso['id'] ?></td>
                            <td><?= $permiso['permiso'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-info btn-editar" 
                                    data-id="<?= $permiso['id'] ?>" 
                                    data-nombre="<?= $permiso['permiso'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= BASE_URL ?>Configuracion/deletePermiso/<?= $permiso['id'] ?>" 
                                    class="btn btn-sm btn-danger btn-eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay permisos registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para nuevo permiso -->
<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="modalPermisosLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalPermisosLabel">Nuevo Permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASE_URL ?>Configuracion/createPermiso" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre del Permiso</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar permiso -->
<div class="modal fade" id="modalEditarPermiso" tabindex="-1" role="dialog" aria-labelledby="modalEditarPermisoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarPermisoLabel">Editar Permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASE_URL ?>Configuracion/updatePermiso" method="post">
                <input type="hidden" name="id" id="idPermiso">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreEditar">Nombre del Permiso</label>
                        <input type="text" name="nombre" id="nombreEditar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Eventos para editar permiso
    document.querySelectorAll('.btn-editar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            
            document.getElementById('idPermiso').value = id;
            document.getElementById('nombreEditar').value = nombre;
            
            // Abrir modal
            $('#modalEditarPermiso').modal('show');
        });
    });
    
    // Eventos para eliminar permiso (confirmar antes)
    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('¿Está seguro de eliminar este permiso?')) {
                window.location = this.getAttribute('href');
            }
        });
    });
});
</script> 