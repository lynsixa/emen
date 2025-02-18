<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "emendsrtv");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el código de la URL
$codigo = $_GET['codigo'];  // Asegúrate de que el código esté en la URL

// Consulta SQL para obtener los datos
$query = "
    SELECT 
        m.NumeroMesa, 
        m.Numeropiso, 
        m.CantidadPuestos, 
        mm.Descripcion AS MenuDescripcion
    FROM 
        codigonis c
    INNER JOIN 
        mesa m ON c.mesa_idMesa = m.idMesa
    INNER JOIN 
        menu mm ON c.menu_idMenu = mm.idMenu
    WHERE 
        c.Descripcion = ?";  // Usamos ? para evitar inyecciones SQL

$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $codigo);  // Asociamos el parámetro 'codigo' a la consulta
$stmt->execute();
$result = $stmt->get_result();

// Mostrar los resultados
$data = null;
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="princal/img/log.png" type="image/png">
    <title>DisruptivoClub</title>
    <link rel="stylesheet" href="Css/StylePrincipall.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const fondoRotativo = document.querySelectorAll('.fondo-rotativo img');
            let index = 0;

            // Función para cambiar la imagen activa
            function cambiarFondo() {
                fondoRotativo.forEach((img, i) => {
                    img.classList.toggle('active', i === index);
                });
                index = (index + 1) % fondoRotativo.length;
            }

            // Cambio automático cada 5 segundos
            setInterval(cambiarFondo, 5000);

            // Evento manual con clic
            fondoRotativo.forEach((img, i) => {
                img.addEventListener('click', () => {
                    index = i;
                    cambiarFondo();
                });
            });

            // Iniciar con la primera imagen
            cambiarFondo();
        });
    </script>
    
    <div class="fondo-rotativo">
        <img src="Img/IMG_5081.JPG" alt="Fondo 1">
        <img src="Img/DSC06494.jpg" alt="Fondo 2">
        <img src="Img/IMG_5105.JPG" alt="Fondo 3">
    </div>
    
    <header class="animate__animated animate__fadeInDown">
        <div class="logo">
            <a href="index.php">
                <img src="img/log.png" alt="Logo">
            </a>
        </div>
        <div class="menu">
            <nav class="menu">
                <ul>
                    <li><a href="#redes">Redes</a></li>
                    <li><a href="//menu">Menu</a></li>
                    <li><a href="../../index.php">Cerrar sesión</a></li>



 
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content">
        <section class="bienvenida animate__animated animate__zoomIn">
            <div class="info">
            <?php if ($data): ?>
    <h3 class="mesa-details-title">Detalles de la Mesa</h3>
    <p class="mesa-detail1"><strong>Mesa:</strong> <?php echo $data['NumeroMesa']; ?></p>
    <p class="mesa-detail2"><strong>Piso:</strong> <?php echo $data['Numeropiso']; ?></p>
    <p class="mesa-detail3"><strong>Cantidad de Puestos:</strong> <?php echo $data['CantidadPuestos']; ?></p>
    <p class="mesa-detail4"><strong>Tipo de Menú:</strong> <?php echo $data['MenuDescripcion']; ?></p>
                    <?php else: ?>
                        <p>No se encontraron datos para el código proporcionado.</p>
                    <?php endif; ?>
                </div> 

            <section id="redes">
                <div class="texto">
                    <h3>Carrera 14A # 83-13 | Primer piso</h3>
                    <h3>314 343 8087</h3>
                    <h3>314 343 8087</h3>
                </div>

                <div class="contenido-derecho">
                    <img src="Img/ig.jpg" alt="QR Código" class="responsive-image">
                </div>

                <!-- Aquí empieza la sección para mostrar los datos de la mesa -->
               
            </section>
        </section>
    </main>

    <footer class="foter">
        <div class="tex">
            <p>&copy; 2024 Emen. Todos los derechos reservados.</p>
            <p>Para solicitar permisos, contacta a: <a href="mailto:emen@gmail.com">emen@gmail.com</a></p>
        </div>
    </footer>
</body>
</html>
