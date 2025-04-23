<?php
$usuario = "root"; // Reemplaza con el usuario correcto
$password = ""; // Reemplaza con la contraseña correcta
$servidor = "localhost";
$basededatos = "emendsrtv";

// Crear la conexión
$con = new mysqli($servidor, $usuario, $password, $basededatos);

// Verificar la conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}
?>
