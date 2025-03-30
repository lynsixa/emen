<?php
session_start();
require_once 'Modelo/Conexion.php';

// Si hay una sesión activa, redirigir al usuario
if (isset($_SESSION['idUsuario'])) {
    header("Location: principal.php");
    exit();
}

// Si hay una cookie con sesión, restaurarla
if (isset($_COOKIE['user_session'])) {
    $_SESSION['idUsuario'] = $_COOKIE['user_session'];

    // Redirigir al usuario a principal.php
    header("Location: /roles/Usuariosincrud/indexscannis.php");
    exit();
}

// Si no hay sesión, mostrar la página de login
header("Location: index.php");
exit();
?>
