<?php
include_once 'conexion.php'; 
<<<<<<< HEAD

class Usuario {
    private $conexion;

    // Constructor de la clase Usuario, se pasa la conexión a la base de datos
=======
class Cliente {
    private $conexion;

    // Constructor de la clase Cliente, se pasa la conexión a la base de datos
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

<<<<<<< HEAD
    // Método para verificar si el correo del usuario ya existe
    public function verificarUsuarioExistente($correo) {
        // Consulta para verificar si el correo ya existe en la base de datos
        $query = "SELECT * FROM usuario WHERE Correo = :correo";
=======
    // Método para verificar si el correo del cliente ya existe
    public function verificarUsuarioExistente($correo) {
        // Consulta para verificar si el correo ya existe en la base de datos
        $query = "SELECT * FROM cliente WHERE Correo = :correo";
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        // Si el número de filas es mayor que 0, significa que el usuario ya existe
        return $stmt->rowCount() > 0;
    }

<<<<<<< HEAD
    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombres, $apellidos, $correo, $documento, $fechadenacimiento, $password, $rolId, $tipoDocumentoId) {
=======
    // Método para registrar un nuevo cliente
    public function registrarCliente($nombre, $correo, $documento, $fechadenacimiento, $password, $rolId) {
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
        // Validación de edad
        $fechaNacimiento = new DateTime($fechadenacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento)->y;

        if ($edad < 18) {
            return "Debes tener al menos 18 años para registrarte.";
        }

        // Validación de contraseña
        if (strlen($password) < 5 || preg_match_all('/\d/', $password) < 2) {
            return "La contraseña debe tener al menos 5 caracteres y contener al menos 2 números.";
        }

        // Encriptar la contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

<<<<<<< HEAD
        // Consulta para insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO usuario (Nombres, Apellidos, Documento, Correo, Contraseña, FechaDeNacimiento, Roles_idRoles, `Tipo de documento_idTipodedocumento`) 
                  VALUES (:nombres, :apellidos, :documento, :correo, :password, :fechadenacimiento, :rolId, :tipoDocumentoId)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
=======
        // Consulta para insertar el nuevo cliente en la base de datos
        $query = "INSERT INTO cliente (Nombre, Documento, Correo, Contraseña, Fechadenacimiento, Roles_idRoles) 
                  VALUES (:nombre, :documento, :correo, :password, :fechadenacimiento, :rolId)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        $stmt->bindParam(':fechadenacimiento', $fechadenacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':rolId', $rolId, PDO::PARAM_INT);
<<<<<<< HEAD
        $stmt->bindParam(':tipoDocumentoId', $tipoDocumentoId, PDO::PARAM_INT);
=======
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467

        // Verificar si se ejecutó correctamente
        if ($stmt->execute()) {
            return true;
        } else {
<<<<<<< HEAD
            return "Error al registrar el usuario: " . implode(" | ", $stmt->errorInfo());
        }
    }

    // Método para autenticar al usuario
    public function autenticarUsuario($correo, $password) {
        $query = "SELECT idUsuario, Contraseña FROM usuario WHERE Correo = :correo";
=======
            return "Error al registrar el cliente: " . implode(" | ", $stmt->errorInfo());
        }
    }

    // Método para autenticar al cliente
    public function autenticarCliente($correo, $password) {
        // Consulta para buscar el cliente por correo
        $query = "SELECT idClientes, Contraseña FROM cliente WHERE Correo = :correo";
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

<<<<<<< HEAD
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $usuario['Contraseña'])) {
                return $usuario['idUsuario']; // Retornar el ID del usuario
=======
        // Verificar si se encontró el cliente
        if ($stmt->rowCount() > 0) {
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si la contraseña es correcta
            if (password_verify($password, $cliente['Contraseña'])) {
                return $cliente['idClientes']; // Retornar el ID del cliente
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    }
<<<<<<< HEAD
=======

    // Otros métodos de la clase Cliente, si los tienes...
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
}
?>
