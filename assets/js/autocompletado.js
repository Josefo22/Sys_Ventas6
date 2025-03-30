/**
 * Funciones de autocompletado para productos, clientes y proveedores
 */

document.addEventListener('DOMContentLoaded', function() {
    /**
     * Inicializa el autocompletado para productos
     */
    function initProductoAutocomplete() {
        // Verificar si existe el elemento en la página
        const inputProducto = document.getElementById('producto_search');
        if (!inputProducto) return;

        $(inputProducto).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: BASE_URL + 'Producto/buscarAjax',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            const noResult = [{
                                id: 0,
                                label: "No se encontraron productos",
                                value: "",
                                isNoResult: true
                            }];
                            response(noResult);
                        } else {
                            response(data);
                        }
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                if (ui.item.isNoResult) {
                    return false;
                }
                $('#producto_search').val(ui.item.label);
                $('#id_producto').val(ui.item.id);
                $('#descripcion').val(ui.item.descripcion);
                $('#stock').val(ui.item.stock);
                $('#precio').val(ui.item.precio);
                $('#cantidad').focus();
                $('#producto_detalle').removeClass('d-none');
                return false;
            },
            open: function() {
                $(this).autocomplete('widget').css('z-index', 100);
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            if (item.isNoResult) {
                return $("<li class='ui-state-disabled'>")
                    .append("<div class='text-center font-italic'>" + item.label + "</div>")
                    .appendTo(ul);
            }
            return $("<li>")
                .append("<div><strong>" + item.codigo + "</strong> - " + item.label + "<br><small>Stock: " + item.stock + " | Precio: $" + item.precio + "</small></div>")
                .appendTo(ul);
        };
    }

    /**
     * Inicializa el autocompletado para clientes
     */
    function initClienteAutocomplete() {
        // Verificar si existe el elemento en la página
        const inputCliente = document.getElementById('cliente_search');
        if (!inputCliente) return;

        $(inputCliente).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: BASE_URL + 'Cliente/buscarAjax',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            const noResult = [{
                                id: 0,
                                label: "No se encontraron clientes",
                                value: "",
                                isNoResult: true
                            }];
                            response(noResult);
                        } else {
                            response(data);
                        }
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                if (ui.item.isNoResult) {
                    return false;
                }
                $('#cliente_search').val(ui.item.label);
                $('#id_cliente').val(ui.item.id);
                return false;
            },
            open: function() {
                $(this).autocomplete('widget').css('z-index', 100);
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            if (item.isNoResult) {
                return $("<li class='ui-state-disabled'>")
                    .append("<div class='text-center font-italic'>" + item.label + "</div>")
                    .appendTo(ul);
            }
            return $("<li>")
                .append("<div><strong>" + item.label + "</strong><br><small>" + item.telefono + " | " + item.direccion + "</small></div>")
                .appendTo(ul);
        };
    }

    /**
     * Inicializa el autocompletado para proveedores
     */
    function initProveedorAutocomplete() {
        // Verificar si existe el elemento en la página
        const inputProveedor = document.getElementById('proveedor_search');
        if (!inputProveedor) return;

        $(inputProveedor).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: BASE_URL + 'Proveedor/buscarAjax',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            const noResult = [{
                                id: 0,
                                label: "No se encontraron proveedores",
                                value: "",
                                isNoResult: true
                            }];
                            response(noResult);
                        } else {
                            response(data);
                        }
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                if (ui.item.isNoResult) {
                    return false;
                }
                $('#proveedor_search').val(ui.item.label);
                $('#id_proveedor').val(ui.item.id);
                return false;
            },
            open: function() {
                $(this).autocomplete('widget').css('z-index', 100);
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            if (item.isNoResult) {
                return $("<li class='ui-state-disabled'>")
                    .append("<div class='text-center font-italic'>" + item.label + "</div>")
                    .appendTo(ul);
            }
            return $("<li>")
                .append("<div><strong>" + item.label + "</strong><br><small>" + item.telefono + " | " + item.direccion + "</small></div>")
                .appendTo(ul);
        };
    }

    // Inicializar los autocompletados
    initProductoAutocomplete();
    initClienteAutocomplete();
    initProveedorAutocomplete();
}); 