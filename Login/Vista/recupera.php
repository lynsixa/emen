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
                        window.location.href='login.html';
                    </script>";
                    exit();
                } else {
                    echo "<script>
                        console.log('Error al enviar el correo, pero podría haberse enviado.');
                        alert('⚠️ Hubo un problema, pero verifica tu bandeja de entrada o spam.');
                        window.location.href='login.html'; // Asegura que regrese al login
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
</head>
<body>
    <h2>Recuperar Contraseña</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
