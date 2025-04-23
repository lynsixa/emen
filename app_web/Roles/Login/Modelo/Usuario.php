<?php
class Usuario {
    private $conexion; // Variable para almacenar la conexión a la base de datos

    // Constructor que inicializa la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion; // Asigna la conexión a la variable de instancia
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombre, $correo, $documento, $fechadenacimiento, $password, $rol) {
        try {
            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preparar la consulta SQL
            $sql = "INSERT INTO Usuario (nombre, correo, documento, fechadenacimiento, contraseña, Roles_idRoles) 
                    VALUES (:nombre, :correo, :documento, :fechadenacimiento, :password, :rol)";
            $stmt = $this->conexion->prepare($sql); // Preparar la consulta

            // Vincular los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':fechadenacimiento', $fechadenacimiento);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':rol', $rol);

            return $stmt->execute(); // Retornar el resultado de la ejecución
        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
            return false;
        }
    }

    // Método para autenticar un usuario
    public function autenticarUsuario($correo, $password) {
        try {
            // Consulta SQL que busca el usuario por su correo
            $query = "SELECT idUsuario, contraseña 
                      FROM Usuario 
                      WHERE correo = :correo";

            $stmt = $this->conexion->prepare($query); // Preparar la consulta
            $stmt->bindParam(':correo', $correo);
            $stmt->execute(); // Ejecutar la consulta
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el registro del usuario

            // Verificar si el usuario existe y si la contraseña es correcta
            if ($user && password_verify($password, $user['contraseña'])) {
                return $user['idUsuario']; // Retornar el ID del usuario si la contraseña es correcta
            } else {
                return false; // Credenciales incorrectas
            }
        } catch (PDOException $e) {
            echo "Error al autenticar usuario: " . $e->getMessage();
            return false;
        }
    }
}
?>
