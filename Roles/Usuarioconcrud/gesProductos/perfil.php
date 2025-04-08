<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}

include("../gesProductos/conexion.php");
$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT Nombres, Apellidos, Documento, Correo, FechaDeNacimiento FROM Usuario WHERE idUsuario = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($usuario = $resultado->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../gesProductos/assets/css/perfil.css">
</head>
<body>
<div class="container mt-5">
    <div class="perfil-card mx-auto" style="max-width: 550px;">
        <div class="perfil-header">
            <i class="bi bi-person-circle"></i>
            <h3>Mi Perfil</h3>
        </div>
        <div class="perfil-body">
            <p><i class="bi bi-person-fill"></i> <strong>Nombres:</strong> <?php echo $usuario['Nombres']; ?></p>
            <p><i class="bi bi-person-bounding-box"></i> <strong>Apellidos:</strong> <?php echo $usuario['Apellidos']; ?></p>
            <p><i class="bi bi-card-text"></i> <strong>Documento:</strong> <?php echo $usuario['Documento']; ?></p>
            <p><i class="bi bi-envelope-fill"></i> <strong>Correo:</strong> <?php echo $usuario['Correo']; ?></p>
            <p><i class="bi bi-calendar-heart"></i> <strong>Fecha de Nacimiento:</strong> <?php echo $usuario['FechaDeNacimiento']; ?></p>
        </div>
        <div class="text-end p-3">
            <a href="../index.php" class="btn btn-custom">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
} else {
    echo "<div class='container mt-5 alert alert-danger text-center'>No se encontró el usuario.</div>";
}
?>
