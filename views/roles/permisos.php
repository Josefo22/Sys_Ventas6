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
                <h6 class="m-0 font-weight-bold text-primary">Asignar Permisos al Rol: <strong><?php echo $rol['nombre']; ?></strong></h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo BASE_URL; ?>Rol/asignarPermisos">
                    <input type="hidden" name="id_rol" value="<?php echo $rol['id']; ?>">
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label font-weight-bold" for="selectAll">
                                    Seleccionar Todos
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <?php 
                        $modulos = [];
                        foreach ($permisos as $permiso) {
                            $modulo = explode('_', $permiso['nombre'])[0];
                            if (!isset($modulos[$modulo])) {
                                $modulos[$modulo] = [];
                            }
                            $modulos[$modulo][] = $permiso;
                        }
                        
                        foreach ($modulos as $modulo => $moduloPermisos) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card">';
                            echo '<div class="card-header bg-primary text-white">';
                            echo '<h6 class="m-0 font-weight-bold text-capitalize">' . $modulo . '</h6>';
                            echo '</div>';
                            echo '<div class="card-body">';
                            
                            foreach ($moduloPermisos as $permiso) {
                                $checked = in_array($permiso['id'], $permisosRol) ? 'checked' : '';
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input permiso-check" type="checkbox" id="permiso_' . $permiso['id'] . '" name="permisos[]" value="' . $permiso['id'] . '" ' . $checked . '>';
                                echo '<label class="form-check-label" for="permiso_' . $permiso['id'] . '">';
                                echo ucfirst(str_replace($modulo . '_', '', $permiso['nombre']));
                                echo '</label>';
                                echo '</div>';
                            }
                            
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3">Guardar Permisos</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const permisos = document.querySelectorAll('.permiso-check');
        permisos.forEach(permiso => {
            permiso.checked = this.checked;
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 