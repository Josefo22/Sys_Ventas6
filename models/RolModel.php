<?php
require_once 'Model.php';

/**
 * Modelo para la gestión de roles
 */
class RolModel extends Model {
    protected $table = 'roles';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Obtener todos los roles activos
     */
    public function getRoles() {
        $query = "SELECT * FROM roles WHERE estado = 1 ORDER BY nombre";
        $result = $this->conn->query($query);
        $roles = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $roles[] = $row;
            }
        }
        
        return $roles;
    }
    
    /**
     * Obtener un rol por su ID
     */
    public function getRol($id) {
        $query = "SELECT * FROM roles WHERE id = ?";
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
     * Crear un nuevo rol
     */
    public function crearRol($nombre, $descripcion) {
        $query = "INSERT INTO roles (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $nombre, $descripcion);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Actualizar un rol existente
     */
    public function actualizarRol($id, $nombre, $descripcion) {
        $query = "UPDATE roles SET nombre = ?, descripcion = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $nombre, $descripcion, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Cambiar el estado de un rol
     */
    public function cambiarEstado($id, $estado) {
        $query = "UPDATE roles SET estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $estado, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener permisos asignados a un rol
     */
    public function getPermisosRol($id_rol) {
        $query = "SELECT p.id, p.nombre 
                 FROM permisos p 
                 INNER JOIN rol_permisos rp ON p.id = rp.id_permiso 
                 WHERE rp.id_rol = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_rol);
        $stmt->execute();
        $result = $stmt->get_result();
        $permisos = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $permisos[] = $row;
            }
        }
        
        return $permisos;
    }
    
    /**
     * Asignar permisos a un rol
     */
    public function asignarPermisos($id_rol, $permisos) {
        // Iniciar transacción
        $this->conn->begin_transaction();
        
        try {
            // Eliminar permisos actuales
            $query = "DELETE FROM rol_permisos WHERE id_rol = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id_rol);
            $stmt->execute();
            
            // Insertar nuevos permisos
            if (!empty($permisos)) {
                $query = "INSERT INTO rol_permisos (id_rol, id_permiso) VALUES (?, ?)";
                $stmt = $this->conn->prepare($query);
                
                foreach ($permisos as $id_permiso) {
                    $stmt->bind_param("ii", $id_rol, $id_permiso);
                    $stmt->execute();
                }
            }
            
            // Confirmar transacción
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir en caso de error
            $this->conn->rollback();
            return false;
        }
    }
    
    /**
     * Verificar si un rol tiene un permiso específico
     */
    public function tienePermiso($id_rol, $nombre_permiso) {
        $query = "SELECT COUNT(*) as total 
                 FROM rol_permisos rp 
                 INNER JOIN permisos p ON rp.id_permiso = p.id 
                 WHERE rp.id_rol = ? AND p.nombre = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $id_rol, $nombre_permiso);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return ($row['total'] > 0);
    }
}
?> 