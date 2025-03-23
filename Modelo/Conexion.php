<?php
class Conexion {
    private $host = "localhost";
<<<<<<< HEAD
    private $username = "root";
    private $password = "";
    private $dbname = "emendsrtv";
    private $conn;

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
=======
    private $db_name = "emendsrtv";
    private $username = "root"; // o el usuario que uses
    private $password = "1161"; // o la contraseña que uses
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
        return $this->conn;
    }
}
?>
