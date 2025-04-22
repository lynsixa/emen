<?php
include_once 'conexion.php'; 

class Usuario {
    private $conexion;

    // Constructor de la clase Usuario, se pasa la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para verificar si el correo del cliente ya existe
    public function verificarUsuarioExistente($correo) {
        // Consulta para verificar si el correo ya existe en la base de datos
        $query = "SELECT * FROM usuario WHERE Correo = :correo";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        // Si el número de filas es mayor que 0, significa que el usuario ya existe
        return $stmt->rowCount() > 0;
    }

    // Función para generar un token único
    public function generateToken() {
        // Usamos md5 y uniqid para generar un token único
        return md5(uniqid(mt_rand(), true));    
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombres, $apellidos, $correo, $documento, $fechadenacimiento, $password, $rolId, $tipoDocumentoId) {
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

        // Generar el token
        $token = $this->generateToken();  // Generamos un token único

        // Consulta para insertar el nuevo usuario en la base de datos (incluyendo el token)
        $query = "INSERT INTO usuario (Nombres, Apellidos, Documento, Correo, Contraseña, FechaDeNacimiento, token, Roles_idRoles, `Tipo de documento_idTipodedocumento`) 
                  VALUES (:nombres, :apellidos, :documento, :correo, :password, :fechadenacimiento, :token, :rolId, :tipoDocumentoId)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':fechadenacimiento', $fechadenacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);  // Insertamos el token
        $stmt->bindParam(':rolId', $rolId, PDO::PARAM_INT);
        $stmt->bindParam(':tipoDocumentoId', $tipoDocumentoId, PDO::PARAM_INT);

        // Verificar si se ejecutó correctamente
        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al registrar el usuario: " . implode(" | ", $stmt->errorInfo());
        }
    }

    // Método para autenticar al usuario
    public function autenticarUsuario($correo, $password) {
        $query = "SELECT idUsuario, Contraseña FROM usuario WHERE Correo = :correo";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $usuario['Contraseña'])) {
                return $usuario['idUsuario']; // Retornar el ID del usuario
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    }
}
?>
