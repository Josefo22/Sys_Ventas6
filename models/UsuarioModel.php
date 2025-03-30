<?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar los usuarios
 */
class UsuarioModel extends Model {
    protected $table = 'usuario';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para validar un usuario
     */
    public function validarUsuario($usuario, $clave) {
        $clave = md5($clave);
        $query = "SELECT * FROM usuario WHERE usuario = ? AND clave = ? AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Método para obtener todos los usuarios activos
     */
    public function getUsuariosActivos() {
        $query = "SELECT u.*, r.nombre as rol_nombre 
                 FROM usuario u 
                 LEFT JOIN roles r ON u.id_rol = r.id 
                 WHERE u.estado = 1";
        $result = $this->conn->query($query);
        $usuarios = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        
        return $usuarios;
    }
    
    /**
     * Método para registrar un nuevo usuario
     */
    public function crearUsuario($nombre, $correo, $usuario, $clave, $id_rol = null) {
        $clave = md5($clave);
        $query = "INSERT INTO usuario (nombre, correo, usuario, clave, id_rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $nombre, $correo, $usuario, $clave, $id_rol);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Método para actualizar un usuario
     */
    public function actualizarUsuario($id, $nombre, $correo, $usuario, $id_rol = null) {
        $query = "UPDATE usuario SET nombre = ?, correo = ?, usuario = ?, id_rol = ? WHERE idusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssii", $nombre, $correo, $usuario, $id_rol, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Método para cambiar la contraseña de un usuario
     */
    public function cambiarClave($id, $nueva_clave) {
        $clave = md5($nueva_clave);
        $query = "UPDATE usuario SET clave = ? WHERE idusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $clave, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Método para cambiar el estado de un usuario
     */
    public function cambiarEstado($id, $estado) {
        $query = "UPDATE usuario SET estado = ? WHERE idusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $estado, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Método para obtener un usuario por su ID
     */
    public function getById($id) {
        $query = "SELECT u.*, r.nombre as rol_nombre 
                 FROM usuario u 
                 LEFT JOIN roles r ON u.id_rol = r.id 
                 WHERE u.idusuario = ?";
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
     * Método para cambiar el rol de un usuario
     */
    public function cambiarRol($id_usuario, $id_rol) {
        $query = "UPDATE usuario SET id_rol = ? WHERE idusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_rol, $id_usuario);
        
        return $stmt->execute();
    }
    
    /**
     * Método para contar usuarios activos
     */
    public function contarUsuariosActivos() {
        $consulta = "SELECT COUNT(*) as total FROM usuario WHERE estado = 1";
        $stmt = $this->conn->prepare($consulta);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'];
    }
}
?>