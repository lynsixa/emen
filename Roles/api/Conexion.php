<?php
$host = 'localhost';        // Servidor MySQL/MariaDB
$usuario = 'root';          // Usuario
$contraseña = '';           // Contraseña del usuario (deja vacío si no tienes)
$baseDeDatos = 'emendsrtv'; // Nombre de la base de datos
$puerto = 3306;             // Puerto de MariaDB

// Crear la conexión
$conn = new mysqli($host, $usuario, $contraseña, $baseDeDatos, $puerto);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
