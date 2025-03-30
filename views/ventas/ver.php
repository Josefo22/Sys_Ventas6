<?php require_once 'views/layouts/header.php'; ?>

<!-- Estilos adicionales para el detalle de venta -->
<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .page-title {
        color: #4e73df;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
        transform: scale(1.05);
    }
    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
        border-radius: 30px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-danger:hover {
        background-color: #be3c30;
        border-color: #be3c30;
        transform: scale(1.05);
    }
    .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
        padding: 15px 20px;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .info-label {
        font-weight: 700;
        color: #4e73df;
        margin-right: 5px;
    }
    .info-value {
        font-weight: 600;
        color: #5a5c69;
    }
    .info-item {
        padding: 15px;
        background-color: #f8f9fc;
        border-radius: 8px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    .info-icon {
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.2rem;
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
    .price-text {
        font-weight: 700;
        color: #1cc88a;
    }
    .badge-primary {
        background-color: #4e73df;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    .total-row {
        background-color: #f8f9fc;
        font-weight: 700;
    }
    .total-row td {
        font-size: 1.1rem;
        color: #4e73df;
    }
    .product-icon {
        color: #4e73df;
        margin-right: 8px;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 page-title">
        <i class="fas fa-file-invoice sales-icon mr-2"></i> Detalle de Venta #<?php echo $venta['id']; ?>
    </h1>
    <a href="<?php echo BASE_URL; ?>Venta" class="btn btn-primary btn-sm">
        <i class="fas fa-arrow-left mr-2"></i> Volver al Listado
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle mr-2"></i> Información de la Venta</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <div class="info-label">Cliente:</div>
                                <div class="info-value"><?php echo $venta['cliente']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <div class="info-label">Vendedor:</div>
                                <div class="info-value"><?php echo $venta['vendedor']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <div class="info-label">Fecha:</div>
                                <div class="info-value"><?php echo date('d/m/Y', strtotime($venta['fecha'])); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-shopping-basket mr-2"></i> Productos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th width="15%">Cantidad</th>
                                <th width="20%">Precio</th>
                                <th width="20%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($detalle as $item) { 
                                $subtotal = $item['cantidad'] * $item['precio'];
                                $total += $subtotal;
                            ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-box product-icon"></i>
                                        <?php echo $item['producto']; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary">
                                            <?php echo $item['cantidad']; ?>
                                        </span>
                                    </td>
                                    <td class="text-right price-text">
                                        $<?php echo number_format($item['precio'], 2); ?>
                                    </td>
                                    <td class="text-right price-text">
                                        $<?php echo number_format($subtotal, 2); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="text-right">TOTAL</td>
                                <td class="text-right price-text">$<?php echo number_format($total, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 justify-content-center">
    <div class="col-md-4">
        <a href="<?php echo BASE_URL; ?>Venta/pdf/<?php echo $venta['id']; ?>" class="btn btn-danger btn-block py-3" target="_blank">
            <i class="fas fa-file-pdf mr-2"></i> Generar PDF
        </a>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Animación de entrada para las tarjetas
        $(".card").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });
            
            $(this).animate({
                'opacity': 1,
                'transform': 'translateY(0)'
            }, 500 + (index * 200));
        });
        
        // Animación de entrada para las filas de la tabla
        $("tbody tr").each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateX(-20px)'
            });
            
            $(this).animate({
                'opacity': 1,
                'transform': 'translateX(0)'
            }, 300 + (index * 100));
        });
    });
</script>

<?php require_once 'views/layouts/footer.php'; ?> 