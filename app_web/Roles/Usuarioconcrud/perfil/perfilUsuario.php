<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$contrasena_actual = $_POST['contrasena_actual'];
$nueva_contrasena = $_POST['nueva_contrasena'];
$confirmar_contrasena = $_POST['confirmar_contrasena'];

if ($nueva_contrasena !== $confirmar_contrasena) {
    echo "<script>alert('Las contraseñas no coinciden'); window.location.href='perfil.php';</script>";
    exit();
}

// Obtener la contraseña actual desde la base de datos
$sql = "SELECT Contraseña FROM Usuario WHERE idUsuario=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario || !password_verify($contrasena_actual, $usuario['Contraseña'])) {
    echo "<script>alert('Contraseña actual incorrecta'); window.location.href='perfil.php';</script>";
    exit();
}

// Actualizar la contraseña
$nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
$sql = "UPDATE Usuario SET Contraseña=? WHERE idUsuario=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $nueva_contrasena_hash, $idUsuario);

if ($stmt->execute()) {
    echo "<script>alert('Contraseña actualizada correctamente'); window.location.href='perfil.php';</script>";
} else {
    echo "<script>alert('Error al cambiar contraseña'); window.location.href='perfil.php';</script>";
}
?>
