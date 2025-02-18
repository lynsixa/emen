<?php
class Conexion {
    private $host = "localhost";
    private $username = "root";
    private $password = "1161";
    private $dbname = "emendsrtv";
    private $conn;

    // Constructor que establece la conexión a la base de datos utilizando PDO
    public function __construct() {
        try {
            // Establecer conexión utilizando PDO
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            // Establecer el modo de error de PDO a excepción
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Manejo de errores
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    // Método para obtener la conexión PDO
    public function getConnection() {
        return $this->conn;
    }
}

// Crear una nueva instancia de la clase Conexion
$conexion = new Conexion();

// Obtener la conexión a la base de datos
$conn = $conexion->getConnection();
?>
