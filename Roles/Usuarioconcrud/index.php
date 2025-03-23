<?php
// Incluir el controlador que obtiene los datos de la base de datos
$data = include('../../Controlador/obtener_datos.php');

// Comprobar si los datos fueron obtenidos correctamente
if ($data) {
    $numeroMesa = $data['NumeroMesa'];
    $numeroPiso = $data['NumeroPiso'];
    $menuDescripcion = $data['MenuDescripcion'];
} else {
    // Si no se obtienen datos, mostrar un mensaje por defecto
    $numeroMesa = 'No disponible';
    $numeroPiso = 'No disponible';
    $menuDescripcion = 'No disponible';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/log.png" type="image/png">
    <title>Detalles de la Mesa</title>
    <link rel="stylesheet" href="Css/StylePrincipall.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <div class="fondo-rotativo">
        <img src="Img/IMG_5081.JPG" alt="Fondo 1">
        <img src="Img/DSC06494.jpg" alt="Fondo 2">
        <img src="Img/IMG_5105.JPG" alt="Fondo 3">
    </div>

    <header>
        <div class="logo">
            <a href="index.php">
                <img src="img/log.png" alt="Logo" style="height: 50px;">
            </a>
        </div>
        <nav class="menu">
            <a href="#redes">Redes</a>
            <a href="//menu">Menú</a>
            <a href="../../index.php">Cerrar sesión</a>
        </nav>
    </header>

    <main id="main-content">
        <section class="bienvenida animate__animated animate__fadeIn">
            <h2>Detalles de la Mesa</h2>
            <div class="mesa-detalles">
                <p><strong>Número de Mesa:</strong> <?php echo $numeroMesa; ?></p>
                <p><strong>Número de Piso:</strong> <?php echo $numeroPiso; ?></p>
                <p><strong>Descripción del Menú:</strong> <?php echo $menuDescripcion; ?></p>
            </div>
        </section>
    </main>

    <!-- Enlace al archivo JavaScript -->
    <script src="../../js/fondo.js"></script>
</body>
</html>
