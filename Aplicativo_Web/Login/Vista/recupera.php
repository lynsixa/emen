<?php
require_once 'Conexion.php';
require_once 'funcs.php';

$errors = array();

if (!empty($_POST)) {
    $email = $mysqli->real_escape_string($_POST['email']);

    if (!isEmail($email)) {
        echo "<script>
                alert('❌ Debes ingresar un correo válido.');
                window.location.href = 'recuperar.html';
              </script>";
        exit;
    }

    if (emailExiste($email)) {
        $user_id = getValor('idUsuario', 'correo', $email);
        $nombre = getValor('nombres', 'correo', $email);
        $token = generaTokenPass($user_id);

        if ($token) {
            $url = 'http://' . $_SERVER["SERVER_NAME"] . 
                '/Proyecto/login/vista/cambia_pass.php?idUsuario=' . $user_id . '&token=' . $token;

            $asunto = 'Recuperar contraseña';
            $cuerpo = "Hola $nombre,<br/><br/>
                Se ha solicitado un reinicio de contraseña.<br/><br/>
                Para restaurar tu contraseña, haz clic en el siguiente enlace:<br/>
                <a href='$url'>Cambiar contraseña</a>";

                if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
                    echo "<script>
                        alert('📩 Hemos enviado un correo electrónico a $email con las instrucciones.');
                        window.location.href='login.php ';
                    </script>";
                    exit();
                } else {
                    echo "<script>
                        console.log('Error al enviar el correo, pero podría haberse enviado.');
                        alert('⚠️ Hubo un problema, pero verifica tu bandeja de entrada o spam.');
                        window.location.href='login.php'; // Asegura que regrese al login
                    </script>";
                    exit();
                }
                
            }}}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../CSS/styleRecupera.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
</head>
<body>
    
    <div class="form-container">
        <h2><i class="fas fa-unlock-alt"></i> Recuperar Contraseña</h2>
        <p class="description">Ingresa tu correo electrónico para enviarte un enlace de recuperación.</p>
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Correo electrónico" required>
            </div>
            <button type="submit"><i class="fas fa-paper-plane"></i> Enviar</button>
        </form>
        <div class="text-end p-3">
            <a href="/Proyecto/Login/Vista/login.php" class="btn btn-custom">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>
    </div>
</body>
</html>

