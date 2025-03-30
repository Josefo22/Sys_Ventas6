<?php
/**
 * Vista para crear un nuevo rol
 */
?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Nuevo Rol</h5>
    </div>
    <div class="card-body">
        <form action="<?= BASE_URL ?>Rol/store" method="post" id="formRol">
            <!-- Incluir el formulario común -->
            <?php include_once 'views/roles/form.php'; ?>
            
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?= BASE_URL ?>Rol" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    document.getElementById('formRol').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value;
        
        if (nombre.trim() === '') {
            e.preventDefault();
            showAlert('El nombre del rol es obligatorio', 'error');
        }
    });
});
</script> 