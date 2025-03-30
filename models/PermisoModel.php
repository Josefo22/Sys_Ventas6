<?php
require_once 'Model.php';

/**
 * Modelo para la gestión de permisos
 */
class PermisoModel extends Model {
    protected $table = 'permisos';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Obtener todos los permisos
     */
    public function getPermisos() {
        $query = "SELECT * FROM permisos ORDER BY nombre";
        $result = $this->conn->query($query);
        $permisos = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $permisos[] = $row;
            }
        }
        
        return $permisos;
    }
    
    /**
     * Obtener un permiso por su ID
     */
    public function getPermiso($id) {
        $query = "SELECT * FROM permisos WHERE id = ?";
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
     * Crear un nuevo permiso
     */
    public function crearPermiso($nombre) {
        $query = "INSERT INTO permisos (nombre) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $nombre);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Actualizar un permiso existente
     */
    public function actualizarPermiso($id, $nombre) {
        $query = "UPDATE permisos SET nombre = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nombre, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar un permiso
     */
    public function eliminarPermiso($id) {
        $query = "DELETE FROM permisos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Verificar si un usuario tiene un permiso específico
     */
    public function hasPermission($id_usuario, $nombre_permiso) {
        // Si es el usuario 1 (administrador), tiene todos los permisos
        if ($id_usuario == 1) {
            return true;
        }
        
        // Primero obtenemos el rol del usuario
        $query = "SELECT id_rol FROM usuario WHERE idusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            return false;
        }
        
        $usuario = $result->fetch_assoc();
        $id_rol = $usuario['id_rol'];
        
        if (!$id_rol) {
            // Si no tiene rol asignado, verificamos permisos directos (sistema legacy)
            $query = "SELECT COUNT(*) as total 
                     FROM detalle_permisos dp 
                     INNER JOIN permisos p ON dp.id_permiso = p.id 
                     WHERE dp.id_usuario = ? AND p.nombre = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("is", $id_usuario, $nombre_permiso);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            return ($row['total'] > 0);
        } else {
            // Verificamos si el rol tiene el permiso
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
    
    /**
     * Obtener todos los permisos de un usuario (incluyendo por rol)
     */
    public function getPermisosUsuario($id_usuario) {
        // Si es el usuario 1 (administrador), tiene todos los permisos
        if ($id_usuario == 1) {
            return $this->getPermisos();
        }
        
        // Obtenemos el rol del usuario
        $query = "SELECT id_rol FROM usuario WHERE idusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            return [];
        }
        
        $usuario = $result->fetch_assoc();
        $id_rol = $usuario['id_rol'];
        
        $permisos = [];
        
        // Permisos directos (sistema legacy)
        $query = "SELECT p.* 
                 FROM permisos p 
                 INNER JOIN detalle_permisos dp ON p.id = dp.id_permiso 
                 WHERE dp.id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $permisos[$row['id']] = $row;
        }
        
        // Permisos por rol
        if ($id_rol) {
            $query = "SELECT p.* 
                     FROM permisos p 
                     INNER JOIN rol_permisos rp ON p.id = rp.id_permiso 
                     WHERE rp.id_rol = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id_rol);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $permisos[$row['id']] = $row;
            }
        }
        
        return array_values($permisos);
    }
}
?> 