<?php
require_once '../Modelo/Conexion.php';

class ControladorClientes {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    public function obtenerClientes() {
        $sql = "SELECT c.idClientes, c.Nombre, c.Documento, c.Correo, c.Fechadenacimiento, r.Descripcion AS RolDescripcion
                FROM cliente c
                JOIN roles r ON c.Roles_idRoles = r.idRoles
                ORDER BY c.idClientes ASC"; // Ordenar por idClientes en orden ascendente
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerRoles() {
        $sql = "SELECT * FROM roles";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCliente($nombre, $documento, $correo, $fechadenacimiento, $roles_id) {
        $sql = "INSERT INTO cliente (Nombre, Documento, Correo, Fechadenacimiento, Roles_idRoles) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $documento, $correo, $fechadenacimiento, $roles_id]);
    }

    public function obtenerClientePorId($id) {
        $sql = "SELECT * FROM cliente WHERE idClientes = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarCliente($id, $nombre, $documento, $correo, $fechadenacimiento, $roles_id) {
        $sql = "UPDATE cliente SET Nombre = ?, Documento = ?, Correo = ?, Fechadenacimiento = ?, Roles_idRoles = ? WHERE idClientes = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $documento, $correo, $fechadenacimiento, $roles_id, $id]);
    }

    public function eliminarCliente($id) {
        $sql = "DELETE FROM cliente WHERE idClientes = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
