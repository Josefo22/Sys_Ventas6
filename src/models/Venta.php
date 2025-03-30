<?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar las ventas
 */
class Venta extends Model {
    protected $table = 'ventas';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para registrar una venta
     */
    public function registrarVenta($id_cliente, $total, $id_usuario) {
        // Iniciar una transacción
        $this->conn->begin_transaction();
        
        try {
            // Insertar la venta
            $query = "INSERT INTO ventas (id_cliente, total, id_usuario) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("idi", $id_cliente, $total, $id_usuario);
            $stmt->execute();
            
            $id_venta = $this->conn->insert_id;
            
            // Obtener los productos en el carrito
            $sql = "SELECT * FROM detalle_temp WHERE id_usuario = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $id_producto = $row['id_producto'];
                $cantidad = $row['cantidad'];
                $precio = $row['precio_venta'];
                
                // Insertar en la tabla de detalle de venta
                $detalle_query = "INSERT INTO detalle_venta (id_producto, id_venta, cantidad, precio) VALUES (?, ?, ?, ?)";
                $detalle_stmt = $this->conn->prepare($detalle_query);
                $detalle_stmt->bind_param("iiid", $id_producto, $id_venta, $cantidad, $precio);
                $detalle_stmt->execute();
                
                // Actualizar el stock del producto
                $stock_query = "UPDATE producto SET existencia = existencia - ? WHERE codproducto = ?";
                $stock_stmt = $this->conn->prepare($stock_query);
                $stock_stmt->bind_param("ii", $cantidad, $id_producto);
                $stock_stmt->execute();
            }
            
            // Vaciar el carrito
            $vaciar_query = "DELETE FROM detalle_temp WHERE id_usuario = ?";
            $vaciar_stmt = $this->conn->prepare($vaciar_query);
            $vaciar_stmt->bind_param("i", $id_usuario);
            $vaciar_stmt->execute();
            
            // Confirmar la transacción
            $this->conn->commit();
            
            return $id_venta;
        } catch (Exception $e) {
            // Deshacer cambios en caso de error
            $this->conn->rollback();
            return false;
        }
    }
    
    /**
     * Método para listar todas las ventas
     */
    public function getVentas() {
        $query = "SELECT v.*, c.nombre FROM ventas v INNER JOIN cliente c ON v.id_cliente = c.idcliente ORDER BY v.fecha DESC";
        $result = $this->conn->query($query);
        $ventas = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ventas[] = $row;
            }
        }
        
        return $ventas;
    }
    
    /**
     * Método para obtener una venta por su ID
     */
    public function getVenta($id) {
        $query = "SELECT v.*, c.nombre FROM ventas v INNER JOIN cliente c ON v.id_cliente = c.idcliente WHERE v.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Método para obtener el detalle de una venta
     */
    public function getDetalleVenta($id_venta) {
        $query = "SELECT d.*, p.descripcion FROM detalle_venta d INNER JOIN producto p ON d.id_producto = p.codproducto WHERE d.id_venta = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_venta);
        $stmt->execute();
        $result = $stmt->get_result();
        $detalle = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $detalle[] = $row;
            }
        }
        
        return $detalle;
    }
    
    /**
     * Método para anular una venta
     */
    public function anularVenta($id_venta) {
        // Obtener detalle de la venta
        $detalle = $this->getDetalleVenta($id_venta);
        
        // Iniciar transacción
        $this->conn->begin_transaction();
        
        try {
            // Devolver stock de productos
            foreach ($detalle as $item) {
                $id_producto = $item['id_producto'];
                $cantidad = $item['cantidad'];
                
                $stock_query = "UPDATE producto SET existencia = existencia + ? WHERE codproducto = ?";
                $stock_stmt = $this->conn->prepare($stock_query);
                $stock_stmt->bind_param("ii", $cantidad, $id_producto);
                $stock_stmt->execute();
            }
            
            // Eliminar detalle de venta
            $del_detalle_query = "DELETE FROM detalle_venta WHERE id_venta = ?";
            $del_detalle_stmt = $this->conn->prepare($del_detalle_query);
            $del_detalle_stmt->bind_param("i", $id_venta);
            $del_detalle_stmt->execute();
            
            // Eliminar venta
            $del_venta_query = "DELETE FROM ventas WHERE id = ?";
            $del_venta_stmt = $this->conn->prepare($del_venta_query);
            $del_venta_stmt->bind_param("i", $id_venta);
            $del_venta_stmt->execute();
            
            // Confirmar transacción
            $this->conn->commit();
            
            return true;
        } catch (Exception $e) {
            // Deshacer cambios en caso de error
            $this->conn->rollback();
            return false;
        }
    }
}
?>