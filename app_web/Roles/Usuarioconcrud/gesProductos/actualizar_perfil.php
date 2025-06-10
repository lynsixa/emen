<?php
session_start();
include("../gesProductos/conexion.php");

if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$documento = $_POST['documento'];
$correo = $_POST['correo'];
$fechaNacimiento = $_POST['fechaNacimiento'];

$sql = "UPDATE Usuario SET Nombres=?, Apellidos=?, Documento=?, Correo=?, FechaDeNacimiento=? WHERE idUsuario=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssssi", $nombres, $apellidos, $documento, $correo, $fechaNacimiento, $idUsuario);

if ($stmt->execute()) {
    echo "<script>alert('Perfil actualizado correctamente'); window.location.href='perfil.php';</script>";
} else {
    echo "<script>alert('Error al actualizar el perfil'); window.location.href='perfil.php';</script>";
}
?>
