<?php
require_once './conexion.php';

class ControladorUsuarios {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
        $this->procesarAcciones();
    }

    public function obtenerUsuarios() {
        $sql = "SELECT u.idUsuario, u.Nombres, u.Apellidos, u.Documento, u.Correo, u.FechaDeNacimiento, r.Descripcion AS Rol
                FROM usuario u
                INNER JOIN roles r ON u.Roles_idRoles = r.idRoles";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerRoles() {
        $sql = "SELECT * FROM roles";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT * FROM usuario WHERE idUsuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function crearUsuario($nombres, $apellidos, $documento, $correo, $fecha, $rol, $contrasena) {
        $hashed = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (Nombres, Apellidos, Documento, Correo, FechaDeNacimiento, Roles_idRoles, Contraseña) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssis", $nombres, $apellidos, $documento, $correo, $fecha, $rol, $hashed);
        return $stmt->execute();
    }

    public function editarUsuario($id, $nombres, $apellidos, $documento, $correo, $fecha, $rol) {
        $sql = "UPDATE usuario SET Nombres=?, Apellidos=?, Documento=?, Correo=?, FechaDeNacimiento=?, Roles_idRoles=? WHERE idUsuario=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssii", $nombres, $apellidos, $documento, $correo, $fecha, $rol, $id);
        return $stmt->execute();
    }

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuario WHERE idUsuario=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    private function procesarAcciones() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            if ($accion === 'crear') {
                $this->crearUsuario($_POST['nombres'], $_POST['apellidos'], $_POST['documento'], $_POST['correo'], $_POST['fecha'], $_POST['rol'], $_POST['contrasena']);
                header('Location: crudUsuarios.php');
                exit;
            }
            if ($accion === 'editar') {
                $this->editarUsuario($_POST['id'], $_POST['nombres'], $_POST['apellidos'], $_POST['documento'], $_POST['correo'], $_POST['fecha'], $_POST['rol']);
                header('Location: crudUsuarios.php');
                exit;
            }
        }

        if (isset($_GET['eliminar'])) {
            $this->eliminarUsuario($_GET['eliminar']);
            header('Location: crudUsuarios.php');
            exit;
        }
    }
}

$controlador = new ControladorUsuarios();
?>
