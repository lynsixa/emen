<?php
include('../conexion.php'); // Asegúrate de que el path es correcto

class Carrito {
    private $conn;

    public function __construct() {
        $conexion = new Conexion(); // Crear una instancia de la clase Conexion
        $this->conn = $conexion->getConnection(); // Obtener la conexión
    }

    // Agregar producto al carrito
    public function agregarProducto($id_usuario, $id_producto, $cantidad) {
        $query = "SELECT * FROM carrito WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $query = "UPDATE carrito SET cantidad = cantidad + ? WHERE id_usuario = ? AND id_producto = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iii", $cantidad, $id_usuario, $id_producto);
        } else {
            $query = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iii", $id_usuario, $id_producto, $cantidad);
        }

        return $stmt->execute();
    }

    // Disminuir cantidad o eliminar si es 0
    public function disminuirProducto($id_usuario, $id_producto) {
        $query = "SELECT cantidad FROM carrito WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        if ($fila && $fila['cantidad'] > 1) {
            $query = "UPDATE carrito SET cantidad = cantidad - 1 WHERE id_usuario = ? AND id_producto = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $id_usuario, $id_producto);
        } else {
            $query = "DELETE FROM carrito WHERE id_usuario = ? AND id_producto = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $id_usuario, $id_producto);
        }

        return $stmt->execute();
    }

    // Eliminar un producto del carrito
    public function eliminarProducto($id_usuario, $id_producto) {
        $query = "DELETE FROM carrito WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_usuario, $id_producto);

        return $stmt->execute();
    }

    // Vaciar todo el carrito de un usuario
    public function vaciarCarrito($id_usuario) {
        $query = "DELETE FROM carrito WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);

        return $stmt->execute();
    }

    // Calcular total y cantidad de productos en el carrito
    public function obtenerTotalCarrito($id_usuario) {
        $query = "SELECT SUM(c.cantidad * p.Pro_Precio) AS total, SUM(c.cantidad) AS cantidad 
                  FROM carrito c 
                  INNER JOIN producto p ON c.id_producto = p.Pro_ProductoRef 
                  WHERE c.id_usuario = ?";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }
}
?>
