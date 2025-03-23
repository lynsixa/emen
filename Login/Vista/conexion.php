<?php
$host = 'localhost'; // o tu host de base de datos
$usuario = 'root'; // tu usuario de la base de datos
$password = ''; // tu contraseña de la base de datos
$nombre_bd = 'emendsrtv'; // nombre de la base de datos

// Crea la conexión
$mysqli = new mysqli($host, $usuario, $password, $nombre_bd);

// Verifica si la conexión fue exitosa
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}
?>
