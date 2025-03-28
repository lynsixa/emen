<?php
require_once '../Controlador/sessionHandler.php'; // Incluir el manejador de sesiones

// Verificar si el usuario ya está autenticado y redirigirlo
manejarSesion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Imagenes/log.png">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/login-registro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="form-container">
                    <center><img class="imagen" src="../Imagenes/log.png" width="80" height="70" alt="Logo"></center>
                    <h1>Inicia sesión</h1>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="../Controlador/controladorLogin.php" method="POST">
                        <div class="form-group">
                            <label for="loginEmail">Correo:</label>
                            <input type="email" class="form-control" id="loginEmail" name="userEmail" placeholder="Ingrese su correo" required>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Contraseña:</label>
                            <input type="password" class="form-control" id="loginPassword" name="userPassword" placeholder="Ingrese su contraseña" required>
                        </div>
                        <button type="submit" class="submit-button">
                            Ingresar
                        </button>
                        <a href="registro.php">¿No tienes cuenta? Registrarse</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" 
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>
</html>
