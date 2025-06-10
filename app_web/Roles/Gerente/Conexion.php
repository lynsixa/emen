<?php
class Conexion {
    private $host = 'localhost';        // Servidor MySQL/MariaDB
    private $usuario = 'root';          // Usuario
    private $contraseña = '';           // Contraseña del usuario (deja vacío si no tienes)
    private $baseDeDatos = 'emendsrtv'; // Nombre de la base de datos
    private $puerto = 3306;             // Puerto de MariaDB
    private $conn;                      // La conexión MySQLi

    public function __construct() {
        // Crear la conexión
        $this->conn = new mysqli($this->host, $this->usuario, $this->contraseña, $this->baseDeDatos, $this->puerto);

        // Verificar si la conexión fue exitosa
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método para obtener la conexión
    public function getConnection() {
        return $this->conn;
    }

    // Cerrar la conexión
    public function cerrarConexion() {
        $this->conn->close();
    }
}
?>
