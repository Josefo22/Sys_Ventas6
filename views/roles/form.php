<?php require_once 'views/layouts/header.php'; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $pageTitle; ?></h1>
    <a href="<?php echo BASE_URL; ?>Rol" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $action == 'create' ? 'Nuevo Rol' : 'Editar Rol'; ?></h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>Rol/<?php echo $action == 'create' ? 'store' : 'update/' . $rol['id']; ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($rol['nombre']) ? $rol['nombre'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo isset($rol['descripcion']) ? $rol['descripcion'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="1" <?php echo (isset($rol['estado']) && $rol['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo (isset($rol['estado']) && $rol['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 