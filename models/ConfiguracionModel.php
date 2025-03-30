<?php
require_once 'Model.php';

class ConfiguracionModel extends Model
{
    private $id, $nombre, $telefono, $email, $direccion, $mensaje, $impuesto;
    
    protected $table = 'configuracion';

    public function __construct()
    {
        parent::__construct();
    }

    public function getConfiguracion()
    {
        $query = "SELECT * FROM configuracion LIMIT 1";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }

    public function getEmpresa()
    {
        $query = "SELECT * FROM configuracion";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }

    public function modificar(string $nombre, string $telefono, string $email, string $direccion, string $mensaje, int $impuesto)
    {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->mensaje = $mensaje;
        $this->impuesto = $impuesto;
        
        $query = "UPDATE configuracion SET nombre = ?, telefono = ?, email = ?, direccion = ?, mensaje = ?, impuesto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $this->nombre, $this->telefono, $this->email, $this->direccion, $this->mensaje, $this->impuesto);
        
        if ($stmt->execute()) {
            return "modificado";
        } else {
            return "error";
        }
    }

    public function actualizarLogo($foto)
    {
        $query = "UPDATE configuracion SET logo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $foto);
        
        if ($stmt->execute()) {
            return "modificado";
        } else {
            return "error";
        }
    }

    // Método para obtener los datos del sistema (usado para la facturación y reportes)
    public function getDatos()
    {
        $query = "SELECT * FROM configuracion";
        $result = $this->conn->query($query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }

    // Método para crear la tabla de configuración si no existe
    public function crearTablaConfiguracion()
    {
        $sql = "CREATE TABLE IF NOT EXISTS configuracion (
            id INT(11) NOT NULL AUTO_INCREMENT,
            nombre VARCHAR(100) NOT NULL,
            telefono VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            direccion TEXT NOT NULL,
            mensaje VARCHAR(255) NOT NULL,
            impuesto DECIMAL(10,2) NOT NULL DEFAULT 0,
            logo VARCHAR(100) NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        if ($this->conn->query($sql)) {
            // Verificar si hay datos en la tabla
            $sqlVerificar = "SELECT COUNT(*) as total FROM configuracion";
            $result = $this->conn->query($sqlVerificar);
            $row = $result->fetch_assoc();
            
            // Si no hay datos, insertar datos por defecto
            if ($row['total'] == 0) {
                $sqlInsertar = "INSERT INTO configuracion (nombre, telefono, email, direccion, mensaje, impuesto) 
                                VALUES ('SysVenta', '123456789', 'info@sysventas.com', 'Dirección de la empresa', 'Gracias por su compra', 18)";
                $this->conn->query($sqlInsertar);
            }
            
            return true;
        }
        
        return false;
    }

    // Método para gestionar los permisos de configuración
    public function getPermisos()
    {
        $sql = "SELECT p.id, p.permiso, d.id as id_detalle, d.id_usuario, d.estado 
                FROM permisos p 
                INNER JOIN detalle_permisos d ON p.id = d.id_permiso 
                WHERE p.tipo = 'configuracion'";
        $result = $this->conn->query($sql);
        $permisos = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $permisos[] = $row;
            }
        }
        
        return $permisos;
    }

    // Métodos para la gestión de moneda
    public function actualizarMoneda($moneda, $simbolo)
    {
        $sql = "UPDATE configuracion SET moneda = ?, simbolo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $moneda, $simbolo);
        
        if ($stmt->execute()) {
            return "modificado";
        } else {
            return "error";
        }
    }

    // Método para actualizar columnas de moneda si no existen
    public function actualizarEstructura()
    {
        // Verificar si existe la columna moneda
        $sqlCheckMoneda = "SHOW COLUMNS FROM configuracion LIKE 'moneda'";
        $resultMoneda = $this->conn->query($sqlCheckMoneda);
        
        if ($resultMoneda->num_rows == 0) {
            $sqlAlterMoneda = "ALTER TABLE configuracion ADD COLUMN moneda VARCHAR(10) DEFAULT 'PEN' AFTER logo";
            $this->conn->query($sqlAlterMoneda);
        }
        
        // Verificar si existe la columna simbolo
        $sqlCheckSimbolo = "SHOW COLUMNS FROM configuracion LIKE 'simbolo'";
        $resultSimbolo = $this->conn->query($sqlCheckSimbolo);
        
        if ($resultSimbolo->num_rows == 0) {
            $sqlAlterSimbolo = "ALTER TABLE configuracion ADD COLUMN simbolo VARCHAR(5) DEFAULT 'S/' AFTER moneda";
            $this->conn->query($sqlAlterSimbolo);
        }
        
        return true;
    }
} 