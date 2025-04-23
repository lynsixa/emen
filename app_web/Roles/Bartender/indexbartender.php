<?php
include_once '../../Modelo/conexion.php';

if (!isset($conn) || !$conn) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

$conn->set_charset("utf8");

// Control de acciones
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    if ($_POST["accion"] === "despachar") {
        $stmt = $conn->prepare("UPDATE solicitud SET Despachado = 1 WHERE idSolicitud = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: ".$_SERVER['PHP_SELF']."?despachado=1");
        exit;
    } elseif ($_POST["accion"] === "rechazar") {
        $motivo = $_POST["motivo"];
        $stmt = $conn->prepare("UPDATE solicitud SET Despachado = -1, Informe = CONCAT(IFNULL(Informe, ''), '\nMotivo: ', ?) WHERE idSolicitud = ?");
        $stmt->bind_param("si", $motivo, $id);
        $stmt->execute();
        header("Location: ".$_SERVER['PHP_SELF']."?rechazado=1");
        exit;
    }
}

$resultado = $conn->query("SELECT idSolicitud, Descripcion FROM solicitud WHERE Despachado = 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes Bartender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CssBartender.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="Img/log.png" type="image/png">
    <style>
        body {
            background: linear-gradient(to right, #1f1c2c, #928dab);
            color: white;
        }
        .card {
            border-radius: 15px;
        }
        .btn-custom {
            border-radius: 30px;
        }
        .fondo-rotativo img {
            display: none;
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .fondo-rotativo img.activo {
            display: block;
        }
    </style>
</head>
<body>

<div class="fondo-rotativo">
    <img src="Img/IMG_5081.JPG" alt="Fondo 1">
    <img src="Img/DSC06494.JPG" alt="Fondo 2">
    <img src="Img/IMG_5105.JPG" alt="Fondo 3">
</div>

<header class="animate__animated animate__fadeInDown">
    <div class="logo">
        <a href="index.php">
            <img src="Img/log.png" alt="Logo">
        </a>
    </div>
    <div class="menu">
        <nav class="menu">
            <ul>
                <li><a href="../../Controlador/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container mt-5">
    <h2 class="text-center mb-4">📦 Solicitudes Pendientes (Bartender)</h2>
    <div class="row">
        <?php if ($resultado->num_rows == 0): ?>
            <div class="col-12">
                <div class="alert alert-light text-dark text-center">No hay solicitudes pendientes</div>
            </div>
        <?php endif; ?>
        <?php while ($sol = $resultado->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow bg-dark text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">🧾 Solicitud #<?= $sol['idSolicitud'] ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($sol['Descripcion'])) ?></p>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $sol['idSolicitud'] ?>">
                            <input type="hidden" name="accion" value="despachar">
                            <button class="btn btn-success btn-custom w-100 mt-2" type="submit">✅ Marcar como Listo</button>
                        </form>
                        <button class="btn btn-danger btn-custom w-100 mt-2" onclick="mostrarRechazo(<?= $sol['idSolicitud'] ?>)">❌ Rechazar</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<form id="formRechazo" method="POST" style="display: none;">
    <input type="hidden" name="id" id="rechazoId">
    <input type="hidden" name="accion" value="rechazar">
    <input type="hidden" name="motivo" id="motivoTexto">
</form>

<script>
function mostrarRechazo(id) {
    Swal.fire({
        title: 'Motivo del Rechazo',
        input: 'textarea',
        inputPlaceholder: 'Escribe el motivo del rechazo...',
        inputAttributes: {
            'aria-label': 'Motivo del rechazo'
        },
        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',
        background: '#1f1c2c',
        color: 'white'
    }).then((result) => {
        if (result.isConfirmed && result.value.trim() !== "") {
            document.getElementById("rechazoId").value = id;
            document.getElementById("motivoTexto").value = result.value.trim();
            document.getElementById("formRechazo").submit();
        }
    });
}

window.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get("despachado") === "1") {
        Swal.fire({
            title: '✅ Solicitud Despachada',
            text: 'La solicitud fue marcada como despachada correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar',
            background: '#1f1c2c',
            color: 'white'
        }).then(() => {
            window.location.href = window.location.pathname;
        });
    }

    if (urlParams.get("rechazado") === "1") {
        Swal.fire({
            title: '❌ Solicitud Rechazada',
            text: 'La solicitud fue rechazada correctamente.',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            background: '#1f1c2c',
            color: 'white'
        }).then(() => {
            window.location.href = window.location.pathname;
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
