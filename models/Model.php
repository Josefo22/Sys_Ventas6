<?php
/**
 * Clase Model base
 * Todos los modelos deben extender de esta clase
 */
class Model {
    protected $conn;
    protected $table;
    
    /**
     * Constructor de la clase
     */
    public function __construct() {
        // Conexión a la base de datos
        $this->conectar();
    }
    
    /**
     * Método para conectar a la base de datos
     */
    private function conectar() {
        // Parámetros de conexión
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'sis_venta';
        
        // Crear conexión
        $this->conn = new mysqli($host, $user, $password, $database);
        
        // Verificar conexión
        if ($this->conn->connect_error) {
            die('Error de conexión a la base de datos: ' . $this->conn->connect_error);
        }
        
        // Establecer charset
        $this->conn->set_charset('utf8');
    }
    
    /**
     * Método para obtener todos los registros de la tabla
     */
    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($query);
        $data = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
    
    /**
     * Método para obtener un registro por su ID
     */
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id{$this->table} = ?";
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
     * Método para eliminar un registro por su ID
     */
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id{$this->table} = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Cerrar conexión al destruir el objeto
     */
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}