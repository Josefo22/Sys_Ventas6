<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos personalizados para la vista de detalles de compra -->
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
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-bottom: none;
        padding: 20px;
        border-radius: 10px 10px 0 0 !important;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 700;
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
    .info-container {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .info-item {
        flex: 1;
        min-width: 200px;
        margin: 10px;
        padding: 15px;
        background-color: #f8f9fc;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        display: flex;
        align-items: center;
    }
    .info-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    .info-item-content {
        flex-grow: 1;
    }
    .info-item-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #5a5c69;
        margin-bottom: 5px;
    }
    .info-item-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #3a3b45;
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
    .price-column {
        font-weight: 700;
        color: #36b9cc;
    }
    .quantity-badge {
        background-color: #4e73df;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
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
    .product-name {
        display: flex;
        align-items: center;
    }
    .product-icon {
        color: #4e73df;
        margin-right: 10px;
    }
    .animated-row {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .print-section {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }
    .print-btn {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .print-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $pageTitle; ?></h1>
    <div>
        <a href="<?php echo BASE_URL; ?>Compra" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="<?php echo BASE_URL; ?>Compra/generarPDF/<?php echo $compra['id']; ?>" class="btn btn-danger btn-sm" target="_blank">
            <i class="fas fa-file-pdf"></i> Generar PDF
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card animated-row">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Información de la Compra</h5>
            </div>
            <div class="card-body">
                <div class="info-container">
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Proveedor</div>
                            <div class="info-item-value"><?php echo isset($compra['proveedor']) ? $compra['proveedor'] : ''; ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Usuario</div>
                            <div class="info-item-value"><?php echo isset($compra['usuario']) ? $compra['usuario'] : ''; ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Fecha</div>
                            <div class="info-item-value"><?php echo isset($compra['fecha']) ? date('d/m/Y', strtotime($compra['fecha'])) : ''; ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Total</div>
                            <div class="info-item-value">$<?php echo isset($compra['total']) ? number_format($compra['total'], 2) : '0.00'; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card animated-row">
            <div class="card-header">
                <h5><i class="fas fa-shopping-basket"></i> Productos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($detalle)) : ?>
                                <?php foreach ($detalle as $item) : ?>
                                    <tr>
                                        <td>
                                            <div class="product-name">
                                                <i class="fas fa-box product-icon"></i>
                                                <?php echo isset($item['descripcion']) ? $item['descripcion'] : ''; ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="quantity-badge">
                                                <?php echo isset($item['cantidad']) ? $item['cantidad'] : ''; ?>
                                            </span>
                                        </td>
                                        <td class="price-column">
                                            $<?php echo isset($item['precio']) ? number_format($item['precio'], 2) : '0.00'; ?>
                                        </td>
                                        <td class="price-column">
                                            $<?php echo isset($item['cantidad']) && isset($item['precio']) ? number_format($item['cantidad'] * $item['precio'], 2) : '0.00'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay productos en esta compra</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="text-right total-label">TOTAL</td>
                                <td class="total-value">$<?php echo isset($compra['total']) ? number_format($compra['total'], 2) : '0.00'; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="print-section">
                    <button class="print-btn" id="btnImprimir">
                        <i class="fas fa-print mr-2"></i> Imprimir Comprobante
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Animaciones para elementos de la página
        $(".info-item").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            }).delay(100 * index).animate({
                'opacity': 1,
                'transform': 'translateY(0)'
            }, 500);
        });
        
        // Función para imprimir
        $("#btnImprimir").click(function() {
            window.print();
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 