<?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar las ventas
 */
class VentaModel extends Model {
    protected $table = 'ventas';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para agregar un producto al carrito
     */
    public function agregarAlCarrito($id_producto, $id_usuario, $cantidad, $precio) {
        // Verificar si el producto ya está en el carrito
        $query = "SELECT * FROM detalle_temp WHERE id_producto = ? AND id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_producto, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Actualizar cantidad
            $row = $result->fetch_assoc();
            $nueva_cantidad = $row['cantidad'] + $cantidad;
            
            $update_query = "UPDATE detalle_temp SET cantidad = ? WHERE id = ?";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bind_param("ii", $nueva_cantidad, $row['id']);
            
            return $update_stmt->execute();
        } else {
            // Insertar nuevo
            $insert_query = "INSERT INTO detalle_temp (id_producto, id_usuario, cantidad, precio_venta) VALUES (?, ?, ?, ?)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bind_param("iiid", $id_producto, $id_usuario, $cantidad, $precio);
            
            return $insert_stmt->execute();
        }
    }
    
    /**
     * Método para obtener los productos en el carrito
     */
    public function getCarrito($id_usuario) {
        $query = "SELECT t.*, p.descripcion, p.codigo FROM detalle_temp t 
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
     * Método para obtener el total del carrito
     */
    public function getTotalCarrito($id_usuario) {
        $query = "SELECT SUM(cantidad * precio_venta) as total FROM detalle_temp WHERE id_usuario = ?";
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
     * Método para eliminar un producto del carrito
     */
    public function eliminarDelCarrito($id) {
        $query = "DELETE FROM detalle_temp WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
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
    
    /**
     * Método para registrar el detalle de una venta
     */
    public function registrarDetalleVenta($id_venta, $id_producto, $cantidad, $precio) {
        $query = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iidd", $id_venta, $id_producto, $cantidad, $precio);
        return $stmt->execute();
    }
    
    /**
     * Método para obtener ventas por mes (último año)
     */
    public function getVentasPorMes() {
        $query = "SELECT 
                    MONTH(fecha) as mes, 
                    YEAR(fecha) as año, 
                    SUM(total) as total 
                FROM ventas 
                WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                GROUP BY YEAR(fecha), MONTH(fecha) 
                ORDER BY YEAR(fecha), MONTH(fecha)";
        
        $result = $this->conn->query($query);
        $ventas = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombreMes = date("M", mktime(0, 0, 0, $row['mes'], 10));
                $ventas[] = [
                    'mes' => $nombreMes,
                    'año' => $row['año'],
                    'total' => $row['total']
                ];
            }
        }
        
        return $ventas;
    }
    
    /**
     * Método para obtener los 5 productos más vendidos
     */
    public function getProductosMasVendidos($limite = 5) {
        $query = "SELECT 
                    p.descripcion, 
                    SUM(d.cantidad) as cantidad,
                    SUM(d.cantidad * d.precio) as total
                FROM detalle_venta d 
                INNER JOIN producto p ON d.id_producto = p.codproducto 
                GROUP BY p.codproducto 
                ORDER BY cantidad DESC 
                LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $productos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }
        
        return $productos;
    }
    
    /**
     * Método para obtener ventas por día (última semana)
     */
    public function getVentasPorDia() {
        $query = "SELECT 
                    DATE(fecha) as dia, 
                    SUM(total) as total,
                    COUNT(*) as cantidad
                FROM ventas 
                WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
                GROUP BY DATE(fecha) 
                ORDER BY DATE(fecha)";
        
        $result = $this->conn->query($query);
        $ventas = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombreDia = date("D", strtotime($row['dia']));
                $ventas[] = [
                    'dia' => $nombreDia,
                    'fecha' => $row['dia'],
                    'total' => $row['total'],
                    'cantidad' => $row['cantidad']
                ];
            }
        }
        
        return $ventas;
    }
    
    /**
     * Método para obtener el total de ventas por categoría
     */
    public function getVentasPorCategoria() {
        $query = "SELECT 
                    p.descripcion as categoria, 
                    SUM(d.cantidad * d.precio) as total
                FROM detalle_venta d 
                INNER JOIN producto p ON d.id_producto = p.codproducto 
                GROUP BY p.codproducto
                ORDER BY total DESC
                LIMIT 7";
        
        $result = $this->conn->query($query);
        $categorias = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row;
            }
        }
        
        return $categorias;
    }
    
    /**
     * Método para contar ventas
     */
    public function contarVentas() {
        // Verificar si la columna estado existe en la tabla ventas
        $checkColumn = "SHOW COLUMNS FROM ventas LIKE 'estado'";
        $result = $this->conn->query($checkColumn);
        
        if ($result->num_rows > 0) {
            // Si la columna existe, filtrar por estado
            $consulta = "SELECT COUNT(*) as total FROM ventas WHERE estado = 1";
        } else {
            // Si la columna no existe, contar todas las ventas
            $consulta = "SELECT COUNT(*) as total FROM ventas";
        }
        
        $stmt = $this->conn->prepare($consulta);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'];
    }
}
?> 