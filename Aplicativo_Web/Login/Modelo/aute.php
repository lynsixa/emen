<?php

class Cliente {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function registrarCliente($nombre, $correo, $documento, $fechadenacimiento, $password, $rolId) {
        // Código para registrar cliente (si lo tienes)
    }

    public function autenticarCliente($correo, $password) {
        $correo = $this->conexion->real_escape_string($correo);
        
        $sql = "SELECT idClientes, Contraseña, Roles_idRoles FROM cliente WHERE Correo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $cliente = $resultado->fetch_assoc();
            if (password_verify($password, $cliente['Contraseña'])) {
                return $cliente['idClientes']; // Retorna el ID del cliente si la autenticación es exitosa
            }
        }
        return false; // Retorna falso si las credenciales son incorrectas
    }
}
?>
