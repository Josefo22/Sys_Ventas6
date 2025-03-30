?php
require_once 'Model.php';

/**
 * Clase modelo para gestionar los clientes
 */
class Cliente extends Model {
    protected $table = 'cliente';
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Método para obtener todos los clientes activos
     */
    public function getClientesActivos() {
        $query = "SELECT * FROM cliente WHERE estado = 1";
        $result = $this->conn->query($query);
        $clientes = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clientes[] = $row;
            }
        }
        
        return $clientes;
    }
    
    /**
     * Método para buscar un cliente por su cédula
     */
    public function buscarPorCedula($cedula) {
        $query = "SELECT * FROM cliente WHERE cedula = ? AND estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Método para obtener un cliente por su ID
     */
    public function getCliente($id) {
        $query = "SELECT * FROM cliente WHERE idcliente = ?";
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
     * Método para registrar un nuevo cliente
     */
    public function crearCliente($nombre, $telefono, $direccion, $cedula, $usuario_id) {
        $query = "INSERT INTO cliente (nombre, telefono, direccion, cedula, usuario_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssii", $nombre, $telefono, $direccion, $cedula, $usuario_id);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        
        return false;
    }
    
    /**
     * Método para actualizar un cliente
     */
    public function actualizarCliente($id, $nombre, $telefono, $direccion, $cedula) {
        $query = "UPDATE cliente SET nombre = ?, telefono = ?, direccion = ?, cedula = ? WHERE idcliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssii", $nombre, $telefono, $direccion, $cedula, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Método para cambiar el estado de un cliente
     */
    public function cambiarEstado($id, $estado) {
        $query = "UPDATE cliente SET estado = ? WHERE idcliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $estado, $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>