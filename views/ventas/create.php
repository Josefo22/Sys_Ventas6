<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos adicionales para el módulo de venta -->
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .search-input {
        border-radius: 30px;
        padding-left: 15px;
    }
    .btn-primary {
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        transform: scale(1.05);
    }
    .btn-danger {
        border-radius: 20px;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
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
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 1rem;
        border-left: 4px solid #4e73df;
        padding-left: 10px;
    }
    #producto_detalle {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
    .total-section {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 20px;
    }
    .total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4e73df;
    }
    .input-with-icon {
        position: relative;
    }
    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #d1d3e2;
    }
    .input-with-icon input {
        padding-left: 40px;
    }
    .action-btn {
        margin-top: 30px;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 page-title">Nueva Venta</h1>
    <a href="<?php echo BASE_URL; ?>Venta" class="btn btn-primary btn-sm">
        <i class="fas fa-arrow-left mr-2"></i> Volver
    </a>
</div>

<?php if (isset($error_stock)) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error_stock; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Información de Venta</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cliente_search" class="font-weight-bold"><i class="fas fa-user mr-2 text-primary"></i>Cliente</label>
                            <div class="input-with-icon">
                                <i class="fas fa-search"></i>
                                <input type="text" id="cliente_search" class="form-control search-input" placeholder="Buscar cliente...">
                            </div>
                            <input type="hidden" id="id_cliente">
                            <small class="form-text text-muted">Escriba al menos 2 letras para buscar un cliente</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="producto_search" class="font-weight-bold"><i class="fas fa-box mr-2 text-primary"></i>Producto</label>
                            <div class="input-with-icon">
                                <i class="fas fa-search"></i>
                                <input type="text" id="producto_search" class="form-control search-input" placeholder="Buscar producto...">
                            </div>
                            <input type="hidden" id="id_producto">
                            <small class="form-text text-muted">Escriba al menos 2 letras para buscar un producto</small>
                        </div>
                    </div>
                </div>
                <div class="row d-none" id="producto_detalle">
                    <div class="col-12">
                        <h6 class="section-title">Detalles del Producto</h6>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-tag mr-2 text-primary"></i>Descripción</label>
                            <input id="descripcion" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-layer-group mr-2 text-primary"></i>Stock</label>
                            <input id="stock" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-dollar-sign mr-2 text-primary"></i>Precio</label>
                            <input id="precio" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-sort-numeric-up mr-2 text-primary"></i>Cantidad</label>
                            <input id="cantidad" class="form-control" type="number" min="1" value="1">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold">Acción</label><br>
                            <button id="btn_agregar" class="btn btn-primary btn-block action-btn">
                                <i class="fas fa-plus mr-2"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detalles de Venta</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_detalle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="detalle_venta">
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="4" class="text-right">TOTAL</td>
                                <td id="total" class="total-amount">0.00</td>
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
            <button id="btn_generar_venta" class="btn btn-primary btn-block py-3">
                <i class="fas fa-check-circle mr-2"></i> Generar Venta
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
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas eliminar este producto de la venta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Acceder a la variable global y eliminar el elemento
                window.productosAgregados.splice(index, 1);
                
                // Actualizar la tabla después de eliminar
                window.actualizarTabla();
                
                Swal.fire(
                    'Eliminado',
                    'El producto ha sido eliminado de la venta.',
                    'success'
                );
            }
        });
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
        
        // Inicializar autocompletado para clientes
        $('#cliente_search').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>Cliente/buscarPorNombre',
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
                $('#cliente_search').val(ui.item.label);
                $('#id_cliente').val(ui.item.id);
                
                // Mostrar notificación de cliente seleccionado
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente seleccionado',
                    text: 'Has seleccionado a ' + ui.item.label,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
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
                        $('#precio').val(data.precio_venta);
                        $('#cantidad').val(1);
                        $('#cantidad').attr('max', data.existencia);
                        $('#id_producto').val(data.id);
                        console.log("ID del producto:", data.id);
                        $('#cantidad').focus();
                        
                        // Animación suave para mostrar los detalles
                        $('#producto_detalle').hide().slideDown(300);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener producto:", error);
                    console.log("Respuesta del servidor:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al obtener detalles del producto'
                    });
                }
            });
        }
        
        // Buscar producto por código
        $('#codigo_producto').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode === 13) {
                buscarProducto();
            }
        });
        
        function buscarProducto() {
            const codigo = $('#codigo_producto').val();
            if (codigo !== '') {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>Producto/buscar',
                    type: 'POST',
                    data: {
                        codigo: codigo
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.error) {
                            $('#error_codigo').removeClass('d-none');
                            $('#producto_detalle').addClass('d-none');
                        } else {
                            $('#error_codigo').addClass('d-none');
                            $('#producto_detalle').removeClass('d-none');
                            $('#descripcion').val(data.descripcion);
                            $('#stock').val(data.existencia);
                            $('#precio').val(data.precio);
                            $('#cantidad').val(1);
                            $('#cantidad').attr('max', data.existencia);
                            $('#id_producto').val(data.codproducto);
                            $('#cantidad').focus();
                        }
                    }
                });
            }
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
        
        function agregarProducto() {
            const id = $('#id_producto').val();
            const descripcion = $('#descripcion').val();
            const cantidad = parseInt($('#cantidad').val());
            const stock = parseInt($('#stock').val());
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
                    text: 'La cantidad debe ser mayor a cero'
                });
                return;
            }
            
            if (cantidad > stock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La cantidad no puede superar el stock disponible'
                });
                return;
            }
            
            // Verificar si el producto ya está en la tabla
            const existeProducto = window.productosAgregados.findIndex(item => item.id === id);
            
            console.log("Existe producto:", existeProducto >= 0, "Array productos:", window.productosAgregados);
            
            if (existeProducto >= 0) {
                // Verificar que la cantidad actualizada no supere el stock
                if (cantidad > stock) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La cantidad no puede superar el stock disponible'
                    });
                    return;
                }
                
                // Actualizar cantidad y subtotal
                window.productosAgregados[existeProducto].cantidad = cantidad;
                window.productosAgregados[existeProducto].subtotal = cantidad * window.productosAgregados[existeProducto].precio;

                Swal.fire({
                    icon: 'success',
                    title: 'Producto actualizado',
                    text: 'Se actualizó la cantidad del producto',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                // Agregar nuevo producto
                const subtotal = cantidad * precio;
                window.productosAgregados.push({
                    id: id,
                    descripcion: descripcion,
                    cantidad: cantidad,
                    precio: precio,
                    subtotal: subtotal
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Producto agregado',
                    text: 'El producto se ha agregado a la venta',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            
            // Actualizar la tabla y el total
            actualizarTabla();
            
            // Limpiar campos y preparar para siguiente producto
            $('#producto_search').val('');
            $('#id_producto').val('');
            $('#producto_detalle').addClass('d-none');
            $('#producto_search').focus();
        }
        
        // Hacemos actualizarTabla accesible globalmente
        window.actualizarTabla = function() {
            let html = '';
            let suma = 0;
            
            console.log("Actualizando tabla con productos:", window.productosAgregados);
            
            if (window.productosAgregados.length === 0) {
                html = `<tr><td colspan="6" class="text-center">No hay productos agregados</td></tr>`;
            } else {
                window.productosAgregados.forEach((item, index) => {
                    html += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.descripcion}</td>
                            <td>${item.cantidad}</td>
                            <td>${item.precio.toFixed(2)}</td>
                            <td>${item.subtotal.toFixed(2)}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    suma += item.subtotal;
                });
            }
            
            console.log("HTML generado:", html);
            
            $('#detalle_venta').html(html);
            $('#total').text(suma.toFixed(2));
            
            // Animar el cambio de total
            $('#total').fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
            
            total = suma;
        };
        
        // Generar venta
        $('#btn_generar_venta').click(function() {
            const id_cliente = $('#id_cliente').val();
            
            if (id_cliente === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe seleccionar un cliente'
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
            
            // Confirmación antes de generar la venta
            Swal.fire({
                title: '¿Confirmar venta?',
                text: `Total a pagar: $${total.toFixed(2)}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, generar venta',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Preparar datos para enviar
                    const data = {
                        id_cliente: id_cliente,
                        total: total,
                        productos: window.productosAgregados
                    };
                    
                    // Mostrar loader mientras se procesa
                    Swal.fire({
                        title: 'Procesando venta',
                        text: 'Por favor espere...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar datos al servidor
                    $.ajax({
                        url: '<?php echo BASE_URL; ?>Venta/store',
                        type: 'POST',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Venta exitosa!',
                                    text: 'La venta se ha registrado correctamente',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '<?php echo BASE_URL; ?>Venta';
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Ha ocurrido un error al registrar la venta'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ha ocurrido un error en la comunicación con el servidor'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 