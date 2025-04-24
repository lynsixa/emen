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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMEN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Admin/CSS/estilos4.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="icon" type="image/png" href="../Admin/imagenes/log.png">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Estilo general para los botones */
        .btn {
            background-color: #FFD700;  /* Color dorado */
            color: #111;                 /* Texto en color oscuro */
            padding: 12px 24px;          /* Relleno de los botones */
            border: none;                /* Eliminar borde */
            border-radius: 5px;          /* Bordes redondeados */
            font-size: 16px;             /* Tamaño de la fuente */
            cursor: pointer;            /* Cursor en forma de mano */
            transition: transform 0.3s ease, background-color 0.3s ease;
            margin: 10px;                /* Espaciado entre los botones */
            display: inline-block;       /* Hace que los botones estén en línea */
            text-align: center;          /* Centra el texto en el botón */
            text-decoration: none;       /* Quita el subrayado del enlace */
        }

        .btn:hover {
            background-color: #FFB600;  /* Cambio de color al pasar el cursor */
            transform: scale(1.05);      /* Animación de escala */
        }

        /* Contenedor de botones */
        .botones-container {
            display: flex;
            justify-content: center;     /* Centra los botones en el contenedor */
            align-items: center;
            gap: 20px;                   /* Espaciado entre los botones */
            flex-wrap: wrap;             /* Permite que los botones se acomoden en varias filas */
            margin-top: 20px;            /* Espaciado superior */
        }
    </style>

</head>
<body>

    <div class="wrapper">
        <header class="header-mobile">
            <h1 class="logo">EMEN</h1>
            <button class="open-menu" id="open-menu">
                <i class="bi bi-list"></i>
            </button>
        </header>
        <aside>
            <button class="close-menu" id="close-menu">
                <i class="bi bi-x"></i>
            </button>
            <header>
                <h1 class="logo">
                    <a href="indexAdmin.php">
                        <img class="dv" src="../Admin/imagenes/log.png" alt="EMEN">
                    </a>
                    EMEN
                </h1>
            </header>
            <nav>
                <ul class="menu">
                    <li>
                        <a href="indexAdmin.php" class="boton-menu boton-categoria active"><i class="bi bi-house-door-fill"></i> Inicio</a>
                    </li>
                    <li>
                        <a href="../api/agregar_eventos.php" class="boton-menu boton-categoria"><i class="bi bi-list-ul"></i> Eventos</a>
                    </li>
                    <li>
                        <a href="indexNIS.php" class="boton-menu boton-categoria"><i class="bi bi-tags"></i> NIS</a>
                    </li>
                    <li>
                        <a href="crudUsuarios.php" class="boton-menu boton-categoria"><i class="bi bi-person-fill"></i> Usuarios</a>
                    </li>
                    <li>
                        <a href="informe.php" class="boton-menu boton-categoria"><i class="bi bi-archive"></i> Informe</a>
                    </li>
                    <li>
                        <a href="subir_producto.php" class="boton-menu boton-categoria"><i class="bi bi-bag-plus"></i> Subir producto</a>
                    </li>
                    <li>
                        <a href="../../Controlador/cerrar_sesion.php" class="boton-menu boton-categoria"><i class="bi bi-exclamation-circle"></i> Cerrar Sesión</a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© 2024 EMEN</p>
            </footer>
        </aside>
        <main>
            <h2 class="titulo-principal" id="titulo-principal">Bienvenido Administrador</h2>
            <div id="contenedor-productos" class="contenedor-productos">
            <!-- Logo grande al lado derecho -->


    <!-- Agregar los botones con enlaces -->
    <div class="botones-container">
        <a href="/Proyecto/app_web\Roles/api/calendario_.php" class="btn btn-cuadro">Calendario</a>
        <a href="/Proyecto/app_web\Roles/api/Agregar_eventos.php" class="btn btn-cuadro">Eventos</a>
        <a href="indexNIS.php" class="btn btn-cuadro">NIS</a>
        <a href="crudUsuarios.php" class="btn btn-cuadro">Usuarios</a>
        <a href="informe.php" class="btn btn-cuadro">Informe</a>
        <a href="subir_producto.php" class="btn btn-cuadro">Subir Producto</a>
        <a href="../../Controlador/cerrar_sesion.php" class="btn btn-cuadro btn-dorado">Cerrar Sesión</a>
    </div>
    <div class="logo-derecho">
    <img src="../Admin/imagenes/log.png" alt="Logo grande EMEN">
</div>
</div>

        </main>
    </div>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
</body>
</html>
