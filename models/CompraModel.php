<?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar las compras
 */
class CompraModel extends Model {
    protected $table = 'compras';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para registrar una nueva compra
     */
    public function registrarCompra($id_proveedor, $total, $id_usuario) {
        // Iniciar una transacción
        $this->conn->begin_transaction();
        
        try {
            // Insertar la compra
            $query = "INSERT INTO compras (id_proveedor, total, id_usuario) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("idi", $id_proveedor, $total, $id_usuario);
            $stmt->execute();
            
            $id_compra = $this->conn->insert_id;
            
            // Obtener los productos en el carrito temporal de compras
            $sql = "SELECT * FROM detalle_temp_compra WHERE id_usuario = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $id_producto = $row['id_producto'];
                $cantidad = $row['cantidad'];
                $precio = $row['precio_compra'];
                
                // Insertar en la tabla de detalle de compra
                $detalle_query = "INSERT INTO detalle_compra (id_producto, id_compra, cantidad, precio) VALUES (?, ?, ?, ?)";
                $detalle_stmt = $this->conn->prepare($detalle_query);
                $detalle_stmt->bind_param("iiid", $id_producto, $id_compra, $cantidad, $precio);
                $detalle_stmt->execute();
                
                // Actualizar el stock del producto
                $stock_query = "UPDATE producto SET existencia = existencia + ?, precio_compra = ? WHERE codproducto = ?";
                $stock_stmt = $this->conn->prepare($stock_query);
                $stock_stmt->bind_param("idi", $cantidad, $precio, $id_producto);
                $stock_stmt->execute();
            }
            
            // Vaciar el carrito de compras
            $vaciar_query = "DELETE FROM detalle_temp_compra WHERE id_usuario = ?";
            $vaciar_stmt = $this->conn->prepare($vaciar_query);
            $vaciar_stmt->bind_param("i", $id_usuario);
            $vaciar_stmt->execute();
            
            // Confirmar la transacción
            $this->conn->commit();
            
            return $id_compra;
        } catch (Exception $e) {
            // Deshacer cambios en caso de error
            $this->conn->rollback();
            return false;
        }
    }
    
    /**
     * Método para agregar un producto al carrito de compras
     */
    public function agregarAlCarritoCompra($id_producto, $id_usuario, $cantidad, $precio) {
        // Verificar si el producto ya está en el carrito
        $query = "SELECT * FROM detalle_temp_compra WHERE id_producto = ? AND id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_producto, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Actualizar cantidad
            $row = $result->fetch_assoc();
            $nueva_cantidad = $row['cantidad'] + $cantidad;
            
            $update_query = "UPDATE detalle_temp_compra SET cantidad = ?, precio_compra = ? WHERE id = ?";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bind_param("idi", $nueva_cantidad, $precio, $row['id']);
            
            return $update_stmt->execute();
        } else {
            // Insertar nuevo
            $insert_query = "INSERT INTO detalle_temp_compra (id_producto, id_usuario, cantidad, precio_compra) VALUES (?, ?, ?, ?)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bind_param("iiid", $id_producto, $id_usuario, $cantidad, $precio);
            
            return $insert_stmt->execute();
        }
    }
    
    /**
     * Método para obtener los productos en el carrito de compras
     */
    public function getCarritoCompra($id_usuario) {
        $query = "SELECT t.*, p.descripcion, p.codigo FROM detalle_temp_compra t 
                 INNER JOIN producto p ON t.id_producto = p.codproducto 
                 WHERE t.id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $carrito = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $carrito[] = $row;
            }
        }
        
        return $carrito;
    }
    
    /**
     * Método para obtener el total del carrito de compras
     */
    public function getTotalCarritoCompra($id_usuario) {
        $query = "SELECT SUM(cantidad * precio_compra) as total FROM detalle_temp_compra WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'] ?? 0;
        }
        
        return 0;
    }
    
    /**
     * Método para eliminar un producto del carrito de compras
     */
    public function eliminarDelCarritoCompra($id) {
        $query = "DELETE FROM detalle_temp_compra WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Método para listar todas las compras
     */
    public function getCompras() {
        $query = "SELECT c.*, p.nombre as proveedor, u.nombre as usuario 
                FROM compras c 
                INNER JOIN proveedor p ON c.id_proveedor = p.idproveedor 
                INNER JOIN usuario u ON c.id_usuario = u.idusuario 
                ORDER BY c.fecha DESC";
        
        $result = $this->conn->query($query);
        $compras = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $compras[] = $row;
            }
        }
        
        return $compras;
    }
    
    /**
     * Método para obtener una compra por su ID
     */
    public function getCompra($id) {
        $query = "SELECT c.*, p.nombre as proveedor, u.nombre as usuario 
                FROM compras c 
                INNER JOIN proveedor p ON c.id_proveedor = p.idproveedor 
                INNER JOIN usuario u ON c.id_usuario = u.idusuario 
                WHERE c.id = ?";
                
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
     * Método para obtener el detalle de una compra
     */
    public function getDetalleCompra($id_compra) {
        $query = "SELECT d.*, p.descripcion FROM detalle_compra d 
                INNER JOIN producto p ON d.id_producto = p.codproducto 
                WHERE d.id_compra = ?";
                
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_compra);
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
     * Método para registrar el detalle de una compra
     */
    public function registrarDetalleCompra($id_compra, $id_producto, $cantidad, $precio) {
        $query = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iidd", $id_compra, $id_producto, $cantidad, $precio);
        return $stmt->execute();
    }
} 