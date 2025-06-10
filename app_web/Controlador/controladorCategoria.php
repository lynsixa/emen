<?php
require_once '../Modelo/conexion.php'; // Asegúrate de tener la conexión a la base de datos

class controladorCategoria {
    private $conn;

    public function __construct() {
        $this->conn = Conectarse(); 
    }

    public function agregarCategoria($nombre, $producto_id) {
        // Verificar que el producto existe
        $stmt = $this->conn->prepare("SELECT idProducto FROM producto WHERE idProducto = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            // El producto existe, proceder a agregar la categoría
            $stmt = $this->conn->prepare("INSERT INTO categoria (nombre, Producto_idProducto) VALUES (?, ?)");
            $stmt->bind_param("si", $nombre, $producto_id);
            $stmt->execute();
            $stmt->close();
        } else {
            // Manejar el error: el producto no existe
            throw new Exception("El producto relacionado no existe.");
        }
    }
    

    public function listarCategorias() {
        $resultado = $this->conn->query("SELECT * FROM categoria");
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function editarCategoria($id, $nombre) {
        $stmt = $this->conn->prepare("UPDATE categoria SET nombre = ? WHERE idCategoria = ?");
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarCategoria($id) {
        $stmt = $this->conn->prepare("DELETE FROM categoria WHERE idCategoria = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
