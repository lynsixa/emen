<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../Login/vista/login.php"); // Redirección si no ha iniciado sesión
    exit();
}

// Si ya hay un código NIS registrado, redirigir directamente
if (isset($_SESSION['codigo'])) {
    header("Location: /proyecto/app_web/Roles/Usuariosincrud/indexscannis.php");
    exit();
}

// Incluir la lógica de validación del código
include('../../Controlador/validar_codigo_logic.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Código</title>
    
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="cssnis.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
    (function() {
        window.history.pushState(null, "", window.location.href);
        window.addEventListener("popstate", function() {
            window.history.pushState(null, "", window.location.href);
        });

        // Bloquear teclas para retroceder
        document.addEventListener("keydown", function(event) {
            if (event.key === "Backspace" || (event.altKey && event.key === "ArrowLeft")) {
                event.preventDefault();
                alert("No puedes retroceder en esta página.");
            }
        });
    })();
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-white">Ingrese el Código</h1>

        <?php
        // Mostrar mensaje si existe
        if (!empty($mensaje)) {
            echo "<div class='alert alert-warning'>$mensaje</div>";
        }
        ?>

        <!-- Formulario -->
        <div class="formu">
        <form action="" method="POST" class="mb-4">
            <input type="text" id="codigo" name="codigo" class="form-control mb-3" placeholder="Código" required>
            <input type="submit" value="Validar" class="btn btn-primary">
        </form>
        </div>
        <!-- Mostrar información de mesa y piso si están disponibles -->
        <?php if (isset($_SESSION['numeroMesa']) && isset($_SESSION['numeroPiso'])): ?>
            <div class="alert alert-success">
                <strong>Mesa:</strong> <?php echo $_SESSION['numeroMesa']; ?><br>
                <strong>Piso:</strong> <?php echo $_SESSION['numeroPiso']; ?>
            </div>
        <?php endif; ?>

        <!-- Cerrar sesión -->
        <div>
            <a href="../../Controlador/cerrar_sesion.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Fondo dinámico -->
    <script>
        let currentIndex = 0; 
        const images = ['1.jpg', '2.jpg', '3.jpg']; 

        function changeBackground() {
            document.body.style.backgroundImage = `url(${images[currentIndex]})`;
            currentIndex = (currentIndex + 1) % images.length;
        }

        setInterval(changeBackground, 2000);
        changeBackground();
    </script>
</body>
</html>
