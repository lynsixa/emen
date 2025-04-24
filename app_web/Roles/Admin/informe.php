
<?php
session_start();
require_once 'Conexion.php';  // Asegúrate de que la clase de conexión esté correctamente incluida

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    header("Location: /proyecto/app_web/Roles/Login/vista/login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Informes</title>
    <link rel="stylesheet" href="CSS/CssInformes.css">
    <link rel="icon" href="imagenes/log.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Fondo rotativo -->
<div class="fondo-rotativo">
    <img src="imagenes/IMG_5081.JPG" alt="Fondo 1">
    <img src="imagenes/DSC06494.JPG" alt="Fondo 2">
    <img src="imagenes/IMG_5105.JPG" alt="Fondo 3">
</div>

<!-- Menú de navegación -->
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="indexAdmin.php" class="text-white">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
        <nav>
            <a href="indexAdmin.php" class="text-white">Inicio</a>
        </nav>
    </div>
</header>

<!-- Título principal -->
<header class="header-informes">
    <h1>Generar Informes</h1>
</header>

<!-- Contenedor de los formularios de descarga -->
<div class="container-informes">
    <h2>Elige el Informe que deseas descargar</h2>

    <!-- Formulario para Descargar Informe de Usuarios -->
    <form method="POST" action="../../Controlador/descarga_excel/descargar_informe.php" class="form-informes">
        <button type="submit" name="descargar_usuarios" class="btn-informe">👤 Descargar Informe de Usuarios</button>
    </form>

    <br>

    <!-- Formulario para Descargar Informe de Órdenes -->
    <form method="POST" action="../../Controlador/descarga_excel/informeorden.php" class="form-informes">
        <button type="submit" name="descargar_excel_ordenes" class="btn-informe">📥 Descargar Excel de Órdenes</button>
    </form>

    <br>

    <!-- Botón para descargar todos los informes -->
    <form method="POST" action="../../Controlador/descarga_excel/descargar_todos_los_informes.php" class="form-informes">
        <button type="submit" name="descargar_todos" class="btn-informe">📦 Descargar Todos los Informes</button>
    </form>
</div>

<!-- Script para rotar fondo -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const imagenes = document.querySelectorAll('.fondo-rotativo img');
        let indice = 0;

        if (imagenes.length > 0) {
            imagenes[indice].classList.add('activo');

            setInterval(() => {
                imagenes[indice].classList.remove('activo');
                indice = (indice + 1) % imagenes.length;
                imagenes[indice].classList.add('activo');
            }, 5000);
        }
    });
</script>

</body>
</html>
