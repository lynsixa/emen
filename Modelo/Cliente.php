<?php
include_once 'conexion.php'; 
class Cliente {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Verificar si el correo ya existe en la base de datos
    public function verificarUsuarioExistente($correo) {
        $query = "SELECT * FROM cliente WHERE Correo = :correo";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Retorna true si ya existe
    }

    // Registrar un nuevo cliente
    public function registrarCliente($nombre, $correo, $documento, $fechadenacimiento, $password, $rolId) {
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

        // Convertir la contraseña a formato binario (si no es encriptada)
        $passwordBinaria = bin2hex($password); // Si deseas hacer un hash binario

        // Consulta para insertar el nuevo cliente
        $query = "INSERT INTO cliente (Nombre, Documento, Correo, Contraseña, Fechadenacimiento, Roles_idRoles) 
                  VALUES (:nombre, :documento, :correo, :password, :fechadenacimiento, :rolId)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        $stmt->bindParam(':fechadenacimiento', $fechadenacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordBinaria, PDO::PARAM_STR);
        $stmt->bindParam(':rolId', $rolId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al registrar el cliente: " . implode(" | ", $stmt->errorInfo());
        }
    }

    // Método para autenticar al cliente
    public function autenticarCliente($correo, $password) {
        // Verificar si el correo existe en la base de datos
        $query = "SELECT * FROM cliente WHERE Correo = :correo";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        // Si el correo no existe, retornar false
        if ($stmt->rowCount() == 0) {
            return false;
        }

        // Obtener los datos del cliente
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña
        // Como las contraseñas en la base de datos son almacenadas en formato binario,
        // convertimos la contraseña ingresada también a binario
        if (hash('sha256', $password) === $cliente['Contraseña']) {
            return $cliente['idClientes']; // Retornar el id del cliente autenticado
        } else {
            return false; // La contraseña no es correcta
        }
    }
}
?>
