<?php
require_once '../Modelo/Conexion.php';

class ControladorProductos {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    public function obtenerProductos() {
        $sql = "SELECT p.idProducto, c.nombre AS Nombre, p.Precio, p.Disponibilidad, p.Cantidad 
                FROM producto p
                LEFT JOIN categoria c ON p.idProducto = c.Producto_idProducto"; 
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearProducto($nombre, $precio, $disponibilidad, $cantidad) {
        $sql = "INSERT INTO producto (Precio, Disponibilidad, Cantidad) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$precio, $disponibilidad, $cantidad]);
        
        if (!empty($nombre)) {
            $idProducto = $this->conexion->lastInsertId();
            $sqlCategoria = "INSERT INTO categoria (nombre, Producto_idProducto) VALUES (?, ?)";
            $stmtCategoria = $this->conexion->prepare($sqlCategoria);
            $stmtCategoria->execute([$nombre, $idProducto]);
        }
    }

    public function editarProducto($id, $nombre, $precio, $disponibilidad, $cantidad) {
        // Actualizar el producto
        $sql = "UPDATE producto SET Precio = ?, Disponibilidad = ?, Cantidad = ? WHERE idProducto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$precio, $disponibilidad, $cantidad, $id]);

        // Actualizar la categoría si el nombre no está vacío
        if (!empty($nombre)) {
            $sqlCategoria = "UPDATE categoria SET nombre = ? WHERE Producto_idProducto = ?";
            $stmtCategoria = $this->conexion->prepare($sqlCategoria);
            $stmtCategoria->execute([$nombre, $id]);
        }
    }

    public function eliminarProducto($id) {
        // Primero eliminamos las entradas en la tabla categoria que referencian el producto
        $sql = "DELETE FROM categoria WHERE Producto_idProducto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);

        // Luego eliminamos el producto de la tabla producto
        $sql = "DELETE FROM producto WHERE idProducto = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerProductoPorId($id) {
        $sql = "SELECT p.idProducto, c.nombre AS Nombre, p.Precio, p.Disponibilidad, p.Cantidad 
                FROM producto p
                LEFT JOIN categoria c ON p.idProducto = c.Producto_idProducto
                WHERE p.idProducto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
