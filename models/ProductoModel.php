<?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar los productos
 */
class ProductoModel extends Model {
    protected $table = 'producto';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para obtener todos los productos activos
     */
    public function getProductosActivos() {
        $query = "SELECT * FROM producto WHERE estado = 1";
        $result = $this->conn->query($query);
        $productos = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }
        
        return $productos;
    }
    
    /**
     * Método para buscar un producto por su código
     */
    public function buscarPorCodigo($codigo) {
        $query = "SELECT * FROM producto WHERE codigo = ? AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Método para obtener un producto por su ID
     */
    public function getProducto($id) {
        $query = "SELECT * FROM producto WHERE codproducto = ?";
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
     * Método para registrar un nuevo producto
     */
    public function crearProducto($codigo, $descripcion, $precio, $existencia, $usuario_id) {
        $query = "INSERT INTO producto (codigo, descripcion, precio, existencia, usuario_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiii", $codigo, $descripcion, $precio, $existencia, $usuario_id);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Método para actualizar un producto
     */
    public function actualizarProducto($id, $codigo, $descripcion, $precio, $existencia) {
        $query = "UPDATE producto SET codigo = ?, descripcion = ?, precio = ?, existencia = ? WHERE codproducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdii", $codigo, $descripcion, $precio, $existencia, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Método para actualizar el stock de un producto (incrementar) en compras
     */
    public function actualizarStock($id_producto, $cantidad) {
        $query = "UPDATE producto SET existencia = existencia + ? WHERE codproducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $cantidad, $id_producto);
        return $stmt->execute();
    }
    
    /**
     * Método para disminuir el stock de un producto en ventas
     */
    public function disminuirStock($id_producto, $cantidad) {
        $query = "UPDATE producto SET existencia = existencia - ? WHERE codproducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $cantidad, $id_producto);
        return $stmt->execute();
    }
    
    /**
     * Método para cambiar el estado de un producto
     */
    public function cambiarEstado($id, $estado) {
        $query = "UPDATE producto SET estado = ? WHERE codproducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $estado, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Método para buscar productos por término de búsqueda
     */
    public function buscarProductos($term) {
        $term = "%{$term}%";
        $query = "SELECT * FROM producto WHERE (codigo LIKE ? OR descripcion LIKE ?) AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $term, $term);
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
     * Método para contar productos activos
     */
    public function contarProductosActivos() {
        $consulta = "SELECT COUNT(*) as total FROM producto WHERE estado = 1";
        $stmt = $this->conn->prepare($consulta);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'];
    }
}
?> 