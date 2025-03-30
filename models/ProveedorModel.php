<?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar proveedores
 */
class ProveedorModel extends Model {
    protected $table = 'proveedor';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para obtener todos los proveedores activos
     */
    public function getProveedoresActivos() {
        $query = "SELECT * FROM {$this->table} WHERE estado = 1";
        $result = $this->conn->query($query);
        $proveedores = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $proveedores[] = $row;
            }
        }
        
        return $proveedores;
    }
    
    /**
     * Método para obtener un proveedor por su ID
     */
    public function getProveedor($id) {
        $query = "SELECT * FROM {$this->table} WHERE idproveedor = ?";
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
     * Método para guardar un nuevo proveedor
     */
    public function saveProveedor($nombre, $telefono, $direccion) {
        $query = "INSERT INTO {$this->table} (nombre, telefono, direccion) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $nombre, $telefono, $direccion);
        
        return $stmt->execute();
    }
    
    /**
     * Método para actualizar un proveedor
     */
    public function updateProveedor($id, $nombre, $telefono, $direccion) {
        $query = "UPDATE {$this->table} SET nombre = ?, telefono = ?, direccion = ? WHERE idproveedor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $nombre, $telefono, $direccion, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Método para eliminar lógicamente un proveedor (cambiar estado a 0)
     */
    public function deleteProveedor($id) {
        $query = "UPDATE {$this->table} SET estado = 0 WHERE idproveedor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Método para buscar proveedores por nombre, teléfono o dirección
     */
    public function searchProveedores($searchTerm) {
        $searchTerm = "%{$searchTerm}%";
        $query = "SELECT * FROM {$this->table} WHERE (nombre LIKE ? OR telefono LIKE ? OR direccion LIKE ?) AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $proveedores = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $proveedores[] = $row;
            }
        }
        
        return $proveedores;
    }
    
    /**
     * Método para contar el total de proveedores (activos e inactivos)
     */
    public function getTotalProveedores() {
        $query = "SELECT COUNT(*) AS total FROM {$this->table}";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        
        return 0;
    }
    
    /**
     * Método para contar el número de proveedores activos
     */
    public function getCountProveedoresActivos() {
        $query = "SELECT COUNT(*) AS total FROM {$this->table} WHERE estado = 1";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        
        return 0;
    }
    
    /**
     * Método para obtener el total de compras del mes actual
     */
    public function getTotalComprasMes() {
        $query = "SELECT COUNT(*) AS total FROM compras 
                 WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
                 AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        
        return 0;
    }
} 