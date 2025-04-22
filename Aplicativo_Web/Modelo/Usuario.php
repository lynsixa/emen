<?php
class Usuario {
    private $conexion; // Variable para almacenar la conexión a la base de datos

    // Constructor que inicializa la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion; // Asigna la conexión a la variable de instancia
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombre, $correo, $documento, $fechadenacimiento, $password, $rol) {
        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL
        $sql = "INSERT INTO Usuario (nombre, correo, documento, fechadenacimiento, contraseña, Roles_idRoles) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql); // Preparar la consulta

        // Ejecutar la consulta
        if ($stmt) {
            // Vincular los parámetros
            $stmt->bind_param('ssssss', $nombre, $correo, $documento, $fechadenacimiento, $hashedPassword, $rol);
            return $stmt->execute(); // Retornar el resultado de la ejecución
        } else {
            return false; // Retornar falso si la preparación falla
        }
    }

    // Método para autenticar un usuario
    public function autenticarUsuario($correo, $password) {
        // Consulta SQL que busca el usuario por su correo
        $query = "SELECT idUsuario, contraseña 
                  FROM Usuario 
                  WHERE correo = ?";

        $stmt = $this->conexion->prepare($query); // Preparar la consulta
        $stmt->bind_param('s', $correo); // Vincular el parámetro
        $stmt->execute(); // Ejecutar la consulta
        $result = $stmt->get_result(); // Obtener el resultado de la consulta

        // Verificar si el usuario existe
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Obtener el registro del usuario

            // Verificar la contraseña
            if (password_verify($password, $user['contraseña'])) {
                return $user['idUsuario']; // Retornar el ID del cliente si la contraseña es correcta
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // No se encontró el usuario
        }
    }
}
?>
