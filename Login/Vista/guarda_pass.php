<?php
include 'conexion.php'; // Asegúrate de incluir la conexión a la base de datos

function cambiaPassword($password, $user_id, $token) {
    global $mysqli;

    // Encriptamos la nueva contraseña usando password_hash()
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Verificamos si el usuario y el token existen en la base de datos
    $stmt = $mysqli->prepare("SELECT idUsuario FROM Usuario WHERE idUsuario = ? AND token_password = ? LIMIT 1");
    $stmt->bind_param("is", $user_id, $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si existe, actualizamos la contraseña y limpiamos el token
        $update = $mysqli->prepare("UPDATE Usuario SET Contraseña = ?, token_password = '', password_request = 0 WHERE idUsuario = ?");
        $update->bind_param("si", $passwordHash, $user_id);
        
        if ($update->execute()) {
            echo "✅ Contraseña actualizada correctamente.";
            return true;
        } else {
            echo "❌ Error al actualizar la contraseña: " . $mysqli->error;
            return false;
        }
    } else {
        echo "❌ Usuario o token inválido.";
        return false;
    }
}
?>
