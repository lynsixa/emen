<?php
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
            <input type="submit" value="Validar" > 
        </form>

        <!-- Enlace de Cerrar sesión debajo del formulario -->
        <div class="ya">
            <br>
            <a href="../../index.php" class="ya" style="color: #fff; text-decoration: none;">Cerrar sesión</a>
        </div>
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb0dQ2Y5O+J2Z0b28wX5ODV40zypYgnT2Nm/MZlA5EXRk9gRs" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0L9gFg3ntb0n4I1FfsHlgPUzYq5STzBxdiyJtHhDsgddNxl9" crossorigin="anonymous"></script>

    <!-- Script para cambiar el fondo dinámicamente -->
    <script>
        let currentIndex = 0; // Índice de la imagen actual
        const images = ['1.jpg', '2.jpg', '3.jpg']; // Lista de imágenes

        // Función para cambiar el fondo
        function changeBackground() {
            document.body.style.backgroundImage = `url(${images[currentIndex]})`;
            currentIndex = (currentIndex + 1) % images.length; // Cambiar al siguiente índice
        }

        // Cambiar el fondo cada 1.2 segundos
        setInterval(changeBackground, 2000);
        
        // Inicializar con la primera imagen
        changeBackground();
    </script>
</body>
</html>
