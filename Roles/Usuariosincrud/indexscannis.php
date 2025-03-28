<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../Login/vista/login.php"); // Corregido
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
    
    <!-- Vinculando el archivo CSS separado -->
    <link rel="stylesheet" href="cssnis.css">

    <!-- Vinculando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJv6p7fEx7gkExO4vbbWro8npAvb7LRAtjzEo9tuJ8U1WVm7l9K7dW4ywlHk" crossorigin="anonymous">

    <script>
    // Evitar que el usuario regrese con la flecha de atrás o el historial
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        location.reload(); // Recarga la página
    };

    // Evitar atajos de teclado para retroceder (ALT + Flecha Izquierda, Backspace)
    document.addEventListener("keydown", function (event) {
        if (event.key === "Backspace" || (event.altKey && event.key === "ArrowLeft")) {
            event.preventDefault();
            location.reload(); // Recarga la página al detectar intento de retroceso
        }
    });
</script>

</head>
<body>
   
    <div class="container">
        <h1>Ingrese el Código</h1>
        
        <?php
        // Si hay un mensaje de error, mostrarlo
        if (!empty($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>
        
        <form action="" method="POST">
            <label for="codigo" style="display: none;">Código:</label>  <!-- Ocultamos el texto -->
            <input type="text" id="codigo" name="codigo" placeholder="Código" required> <!-- Placeholder dentro del cuadro -->
            <input type="submit" value="Validar"> 
        </form>

        <!-- Enlace de Cerrar sesión debajo del formulario -->
        <div class="ya">
            <br>
            <a href="../../Controlador/cerrar_sesion.php" class="ya" style="color: #fff; text-decoration: none;">Cerrar sesión</a>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb0dQ2Y5O+J2Z0b28wX5ODV40zypYgnT2Nm/MZlA5EXRk9gRs" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0L9gFg3ntb0n4I1FfsHlgPUzYq5STzBxdiyJtHhDsgddNxl9" crossorigin="anonymous"></script>

    <!-- Script para cambiar el fondo dinámicamente -->
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
