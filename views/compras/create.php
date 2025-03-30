<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para el formulario de compras -->
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
    .btn-back {
        background: white;
        color: #4e73df;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .btn-back:hover {
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
    .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #4e73df;
        display: flex;
        align-items: center;
    }
    .card-header h5 i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    .card-body {
        padding: 25px;
    }
    .form-group label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    .form-group label i {
        margin-right: 8px;
        color: #4e73df;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #d1d3e2;
        transition: all 0.2s;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #bac8f3;
    }
    .search-input {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%234e73df" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 20px;
        padding-right: 40px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.25);
    }
    .btn-block {
        border-radius: 30px;
        padding: 15px;
        font-size: 1.1rem;
        letter-spacing: 1px;
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
    .badge {
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-primary {
        background: #4e73df;
    }
    .badge-info {
        background: #36b9cc;
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
    }
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .btn-danger {
        background: #e74a3b;
        border-color: #e74a3b;
    }
    .price-column {
        font-weight: 700;
        color: #36b9cc;
    }
    .total-row {
        background: linear-gradient(135deg, #f8f9fc 0%, #f1f3f9 100%);
    }
    .total-label {
        font-weight: 700;
        text-transform: uppercase;
        color: #5a5c69;
        letter-spacing: 1px;
    }
    .total-value {
        font-weight: 700;
        font-size: 1.2rem;
        color: #1cc88a;
    }
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px;
        border: none;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .ui-menu-item {
        border-radius: 5px;
        padding: 8px 10px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .ui-menu-item:hover {
        background-color: #eaecf4;
    }
    .ui-menu-item-wrapper.ui-state-active {
        background-color: #4e73df;
        color: white;
        border: none;
        margin: 0;
    }
    .producto-detalle {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-top: 20px;
        border-left: 4px solid #4e73df;
    }
    /* Estilos para dispositivos móviles */
    @media (max-width: 768px) {
        .form-inline {
            flex-direction: column;
            align-items: stretch;
        }
        .card-stats {
            flex-direction: column;
        }
    }
    .loader {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #4e73df;
        width: 40px;
        height: 40px;
        margin: 0 auto;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        flex-direction: column;
    }
    .loading-text {
        margin-top: 10px;
        color: #4e73df;
        font-weight: 600;
    }
</style>

<!-- Overlay de carga -->
<div class="loading-overlay" id="loadingOverlay" style="display: none;">
    <div class="loader"></div>
    <div class="loading-text">Procesando compra...</div>
</div>

<div class="page-header animated-row">
    <h1 class="page-title">
        <i class="fas fa-truck-loading"></i> Nueva Compra
    </h1>
    <a href="<?php echo BASE_URL; ?>Compra" class="btn btn-back">
        <i class="fas fa-arrow-left mr-2"></i> Volver
    </a>
</div>

<?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show animated-row" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> Ha ocurrido un error en la operación
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card animated-row">
            <div class="card-header">
                <h5><i class="fas fa-shopping-cart"></i> Datos de la Compra</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="proveedor_search"><i class="fas fa-building"></i> Proveedor</label>
                            <input type="text" id="proveedor_search" class="form-control search-input" placeholder="Buscar proveedor...">
                            <input type="hidden" id="id_proveedor">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="producto_search"><i class="fas fa-box"></i> Producto</label>
                            <input type="text" id="producto_search" class="form-control search-input" placeholder="Buscar producto...">
                            <input type="hidden" id="id_producto">
                        </div>
                    </div>
                </div>
                <div class="row d-none producto-detalle" id="producto_detalle">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Descripción</label>
                            <input id="descripcion" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><i class="fas fa-cubes"></i> Stock Actual</label>
                            <input id="stock" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Precio de Compra</label>
                            <input id="precio" class="form-control" type="number" min="0.01" step="0.01" value="0.00">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><i class="fas fa-sort-numeric-up"></i> Cantidad</label>
                            <input id="cantidad" class="form-control" type="number" min="1" value="1">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Acción</label><br>
                            <button id="btn_agregar" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card animated-row">
            <div class="card-header">
                <h5><i class="fas fa-shopping-basket"></i> Detalle de Productos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_detalle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="detalle_compra">
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="4" class="text-right total-label">TOTAL</td>
                                <td id="total" class="total-value">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-end mt-3">
    <div class="col-md-4">
        <div class="form-group">
            <button id="btn_generar_compra" class="btn btn-primary btn-block">
                <i class="fas fa-save mr-2"></i> Registrar Compra
            </button>
        </div>
    </div>
</div>

<script>
    // Inicializar la variable global para productos agregados
    window.productosAgregados = [];
    
    // Función para eliminar un producto (declarada en ámbito global)
    function eliminarProducto(index) {
        console.log("Eliminando producto en índice:", index);
        
        // Acceder a la variable global y eliminar el elemento
        window.productosAgregados.splice(index, 1);
        
        // Actualizar la tabla después de eliminar
        window.actualizarTabla();
    }

    $(document).ready(function() {
        let total = 0.00;
        
        // Inicializar autocompletado para productos
        $('#producto_search').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>Producto/buscarPorNombre',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $('#producto_search').val(ui.item.label);
                mostrarDetallesProducto(ui.item.id);
            }
        });
        
        // Inicializar autocompletado para proveedores
        $('#proveedor_search').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>Proveedor/buscarPorNombre',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $('#proveedor_search').val(ui.item.label);
                $('#id_proveedor').val(ui.item.id);
            }
        });
        
        // Función para mostrar detalles del producto seleccionado
        function mostrarDetallesProducto(id) {
            $.ajax({
                url: '<?php echo BASE_URL; ?>Producto/obtenerPorId',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#producto_detalle').removeClass('d-none');
                        $('#descripcion').val(data.descripcion);
                        $('#stock').val(data.existencia);
                        // En compras, el precio no viene predefinido
                        $('#precio').val('');
                        $('#cantidad').val(1);
                        $('#id_producto').val(data.id);
                        console.log("ID del producto:", data.id); // Agregamos log para depuración
                        $('#precio').focus();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener producto:", error);
                    console.log("Respuesta del servidor:", xhr.responseText); // Agregamos log para ver la respuesta completa
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al obtener detalles del producto'
                    });
                }
            });
        }
        
        // Agregar producto a la tabla
        $('#btn_agregar').click(function(e) {
            e.preventDefault();
            agregarProducto();
        });
        
        // Capturar tecla Enter en cantidad
        $('#cantidad').keyup(function(e) {
            if(e.keyCode === 13) {
                agregarProducto();
            }
        });
        
        // Capturar tecla Enter en precio
        $('#precio').keyup(function(e) {
            if(e.keyCode === 13) {
                agregarProducto();
            }
        });
        
        function agregarProducto() {
            const id = $('#id_producto').val();
            const descripcion = $('#descripcion').val();
            const cantidad = parseInt($('#cantidad').val());
            const precio = parseFloat($('#precio').val());
            
            console.log("Agregando producto - ID:", id, "Descripción:", descripcion);
            
            if (id === '' || descripcion === '' || isNaN(cantidad) || isNaN(precio)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Todos los campos son obligatorios'
                });
                return;
            }
            
            if (cantidad <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La cantidad debe ser mayor a 0'
                });
                return;
            }
            
            if (precio <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El precio debe ser mayor a 0'
                });
                return;
            }
            
            // Verificar si el producto ya está en la lista
            const productoExistente = window.productosAgregados.findIndex(item => item.id === id);
            
            if (productoExistente !== -1) {
                // Actualizar cantidad y precio si ya existe
                window.productosAgregados[productoExistente].cantidad += cantidad;
                window.productosAgregados[productoExistente].precio = precio;
            } else {
                // Agregar el producto
                window.productosAgregados.push({
                    id: id,
                    descripcion: descripcion,
                    cantidad: cantidad,
                    precio: precio
                });
            }
            
            // Actualizar la tabla
            window.actualizarTabla();
            
            // Limpiar el formulario
            $('#producto_search').val('');
            $('#id_producto').val('');
            $('#producto_detalle').addClass('d-none');
            
            // Animación de éxito
            Swal.fire({
                icon: 'success',
                title: 'Producto agregado',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#1cc88a',
                color: '#fff'
            });
        }
        
        // Actualizar la tabla de productos
        window.actualizarTabla = function() {
            let htmlDetalle = '';
            total = 0;
            
            if (window.productosAgregados.length > 0) {
                window.productosAgregados.forEach((item, index) => {
                    const subtotal = item.cantidad * item.precio;
                    total += subtotal;
                    
                    htmlDetalle += `
                        <tr class="animated-row">
                            <td><span class="badge badge-primary">${item.id}</span></td>
                            <td>${item.descripcion}</td>
                            <td class="text-center"><span class="badge badge-info">${item.cantidad}</span></td>
                            <td class="price-column">$${item.precio.toFixed(2)}</td>
                            <td class="price-column">$${subtotal.toFixed(2)}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-action" onclick="eliminarProducto(${index})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                htmlDetalle = `
                    <tr>
                        <td colspan="6" class="text-center">No hay productos agregados</td>
                    </tr>
                `;
            }
            
            $('#detalle_compra').html(htmlDetalle);
            $('#total').text(total.toFixed(2));
            
            // Habilitar o deshabilitar el botón de registrar compra
            if (window.productosAgregados.length > 0 && $('#id_proveedor').val() !== '') {
                $('#btn_generar_compra').prop('disabled', false);
            } else {
                $('#btn_generar_compra').prop('disabled', true);
            }
        };
        
        // Generar compra
        $('#btn_generar_compra').click(function(e) {
            e.preventDefault();
            
            const id_proveedor = $('#id_proveedor').val();
            
            if (id_proveedor === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe seleccionar un proveedor'
                });
                return;
            }
            
            if (window.productosAgregados.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe agregar al menos un producto'
                });
                return;
            }
            
            // Mostrar modal de confirmación
            Swal.fire({
                title: '¿Está seguro?',
                text: `Se registrará una compra por $${total.toFixed(2)}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar overlay de carga
                    $('#loadingOverlay').show();
                    
                    const data = {
                        id_proveedor: id_proveedor,
                        total: total,
                        productos: window.productosAgregados
                    };
                    
                    console.log("Datos a enviar:", data);
                    
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>Compra/store',
                        type: 'POST',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function(response) {
                            $('#loadingOverlay').hide();
                            
                            console.log("Respuesta:", response);
                            
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Compra registrada',
                                    text: `Compra #${response.id_compra} registrada correctamente`,
                                    confirmButtonColor: '#4e73df'
                                }).then(() => {
                                    window.location.href = '<?php echo BASE_URL; ?>Compra?success=1';
                                });
                            } else {
                                $('#loadingOverlay').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Error al registrar la compra',
                                    confirmButtonColor: '#4e73df'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#loadingOverlay').hide();
                            console.error("Error al registrar compra:", error);
                            console.log("Respuesta del servidor:", xhr.responseText);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al registrar la compra',
                                confirmButtonColor: '#4e73df'
                            });
                        }
                    });
                }
            });
        });
        
        // Inicializar la tabla
        window.actualizarTabla();
        
        // Deshabilitar el botón de registrar compra inicialmente
        $('#btn_generar_compra').prop('disabled', true);
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 