<?php
<<<<<<< HEAD
// Incluir la lógica de validación del código
include('../../Controlador/validar_codigo_logic.php');


=======
$host = 'localhost';        // Servidor MySQL/MariaDB
$usuario = 'root';          // Usuario
$contraseña = '';           // Contraseña del usuario (deja vacío si no tienes)
$baseDeDatos = 'emendsrtv'; // Nombre de la base de datos

$puerto = 3306;             // Puerto de MariaDB (en lugar de 3306)

// Crear la conexión
$conn = new mysqli($host, $usuario, $contraseña, $baseDeDatos, $puerto);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Código</title>
<<<<<<< HEAD
    
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
=======
    <!-- Vinculando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJv6p7fEx7gkExO4vbbWro8npAvb7LRAtjzEo9tuJ8U1WVm7l9K7dW4ywlHk" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, rgb(200, 153, 45), rgb(62, 61, 63), rgb(0, 0, 0));
            color: #fff;
            font-family: 'Arial', sans-serif;
            height: 100vh;  /* Altura total de la pantalla */
            display: flex;  /* Usamos Flexbox para centrar */
            justify-content: center;  /* Centrado horizontal */
            align-items: center;  /* Centrado vertical */
            margin: 0;  /* Eliminar márgenes predeterminados */
        }
        .container {
            max-width: 500px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: rgb(200, 153, 45);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: rgb(62, 61, 63);
        }
        p {
            color: red;
            text-align: center;
        }

        /* Responsividad */
        @media (max-width: 576px) {
            .container {
                padding: 20px;
                max-width: 100%;
                margin: 10px;
            }
            h1 {
                font-size: 24px;
            }
            input[type="submit"], input[type="text"] {
                font-size: 14px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Ingrese el Código</h1>
        <?php
        // Comprobar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $codigo = $_POST['codigo'];

            // Preparar la consulta
            $stmt = $conn->prepare("SELECT * FROM codigonis WHERE Descripcion = ?");
            $stmt->bind_param("s", $codigo);  // 's' para string
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Verificar si se encontró un registro
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Redirigir a la página con el código en la URL
                header("Location: /Principal/Roles/Usuarioconcrud/index.php?codigo=$codigo");
                exit(); // Terminar el script después de redirigir
            } else {
                echo "<p>Código no encontrado.</p>";
            }

            // Cerrar la conexión
            $stmt->close();
        }
        ?>
        <form action="" method="POST">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required>
            <input type="submit" value="Validar" > 
        </form>
        <br>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
    </div>

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb0dQ2Y5O+J2Z0b28wX5ODV40zypYgnT2Nm/MZlA5EXRk9gRs" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0L9gFg3ntb0n4I1FfsHlgPUzYq5STzBxdiyJtHhDsgddNxl9" crossorigin="anonymous"></script>
<<<<<<< HEAD

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
=======
</body>
</html>

<?php
// Recuperar el código de la URL, si existe
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


    

    <!-- Vinculando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb0dQ2Y5O+J2Z0b28wX5ODV40zypYgnT2Nm/MZlA5EXRk9gRs" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0L9gFg3ntb0n4I1FfsHlgPUzYq5STzBxdiyJtHhDsgddNxl9" crossorigin="anonymous"></script>
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
</body>
</html>
