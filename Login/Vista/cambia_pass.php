<?php
require 'conexion.php';  // Asegúrate de que este archivo establece $mysqli
require 'funcs.php';     // Asegúrate de que verificaTokenPass está bien definido

$user_id = $_GET['idUsuario'] ?? null;
$token = $_GET['token'] ?? null;

if ($user_id && $token) {
    if (!verificaTokenPass($user_id, $token)) {
        echo "⚠️ Token inválido o expirado.<br>";
        echo "User ID recibido: " . htmlspecialchars($user_id) . "<br>";
        echo "Token recibido: " . htmlspecialchars($token) . "<br>";
        exit;
    }
} else {
    echo "⚠️ Falta el ID de usuario o el token.<br>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $token = $_POST['token'] ?? null;
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['con_password'] ?? '';

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Verificar si el usuario y el token existen antes de actualizar
        $stmt = $mysqli->prepare("SELECT idUsuario FROM Usuario WHERE idUsuario = ? AND token_password = ? LIMIT 1");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si existe, actualizamos la contraseña y limpiamos el token
            $update = $mysqli->prepare("UPDATE Usuario SET Contraseña = ?, token_password = NULL, password_request = 0 WHERE idUsuario = ?");
            $update->bind_param("si", $hashed_password, $user_id);

            if ($update->execute()) {
                // Alerta de éxito y redirección inmediata
                echo "<script>
                        alert('✅ Contraseña actualizada con éxito.');
                        window.location.href = 'login.php'; // Redirige a login.php inmediatamente
                      </script>";
                exit;
            } else {
                echo "❌ Error al actualizar la contraseña: " . $mysqli->error . "<br>";
            }
        } else {
            echo "❌ Usuario o token no encontrado en la base de datos.<br>";
        }
    } else {
        echo "⚠️ Las contraseñas no coinciden.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h2>Cambiar Contraseña</h2>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" required>

        <label for="con_password">Confirmar Contraseña:</label>
        <input type="password" name="con_password" required>

        <button type="submit">Actualizar Contraseña</button>
    </form>
</body>
</html>
