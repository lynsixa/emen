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
    <link rel="stylesheet" href="Css/CssUsuarioCrud.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <script>
        // Bloquear el retroceso en el navegador
        (function() {
            window.history.pushState(null, "", window.location.href);
            window.addEventListener("popstate", function() {
                window.history.pushState(null, "", window.location.href);
            });

            // Bloquear las teclas Backspace y flecha izquierda
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
    <div class="fondo-rotativo">
        <img src="Img/IMG_5081.JPG" alt="Fondo 1">
        <img src="Img/DSC06494.jpg" alt="Fondo 2">
        <img src="Img/IMG_5105.JPG" alt="Fondo 3">
    </div>

    <!-- Asegúrate de tener el CSS de Bootstrap en tu <head> -->
<header class="bg-dark py-3 shadow-sm">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <!-- Logo -->
        <a href="index.php" class="d-flex align-items-center text-white text-decoration-none">
            <img src="img/log.png" alt="Logo" style="height: 50px;">
        </a>

        <!-- Navegación -->
        <nav class="nav">
            <a class="nav-link text-white" href="../Usuarioconcrud/gesProductos/perfil.php">Perfil</a>
            <a class="nav-link text-white" href="../Usuarioconcrud/gesProductos/Index.php">Menú</a>
            <a class="nav-link text-danger" href="../../Controlador/cerrar_sesion.php">Cerrar sesión</a>
        </nav>
    </div>
</header>

<main id="main-content" class="container py-5">
    <section class="animate__animated animate__fadeIn">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-yellow">
                <i class="bi bi-info-circle-fill me-2"></i>Detalles de la Mesa
            </h2>
        </div>

            <div class="card card-dark-yellow shadow-lg rounded-4 mx-auto" style="max-width: 600px;">
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-5">
                        <li class="list-group-item">
                            <i class="bi bi-hash me-2"></i>
                            <strong>Número de Mesa:</strong> <?php echo $numeroMesa; ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-building me-2"></i>
                            <strong>Número de Piso:</strong> <?php echo $numeroPiso; ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-card-text me-2"></i>
                            <strong>Descripción del Menú:</strong> <?php echo $menuDescripcion; ?>
                        </li>
                    </ul>
                </div>
            </div>
    </section>
</main>

<script src="../../js/fondo.js"></script>
</body>
</html>
