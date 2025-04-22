<?php
class Conexion {
    private $host = "localhost";
    private $db_name = "emendsrtv";
    private $username = "root"; // o el usuario que uses
    private $password = ""; // o la contraseña que uses
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
