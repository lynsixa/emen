<?php
$host = 'localhost';        // Servidor MySQL/MariaDB
$usuario = 'root';          // Usuario
$contraseña = '1161';           // Contraseña del usuario (deja vacío si no tienes)
$baseDeDatos = 'emendsrtv'; // Nombre de la base de datos

$puerto = 3306;             // Puerto de MariaDB (en lugar de 3306)

// Crear la conexión
$conn = new mysqli($host, $usuario, $contraseña, $baseDeDatos, $puerto);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
