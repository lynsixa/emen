<?php
class Conexion {
    private $host = "localhost";
    private $username = "root"; // Usuario de la base de datos
    private $password = "";     // Contraseña (cambiar si es necesario)
    private $dbname = "emendsrtv"; // Nombre de la base de datos
    private $conn;

    // Constructor que establece la conexión a la base de datos utilizando mysqli
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        
        // Verificar si la conexión falló
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    // Método para obtener la conexión mysqli
    public function getConnection() {
        return $this->conn;
    }
}

// Probar conexión
try {
    $conexion = new Conexion();
    echo "Conexión exitosa";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
