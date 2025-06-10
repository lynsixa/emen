<?php
session_start();
require_once '../Controlador/conexion.php';

// Función para manejar la sesión y redirigir según el rol
function manejarSesion() {
    if (isset($_SESSION['idUsuario']) && isset($_SESSION['rol'])) {
        redirigirPorRol($_SESSION['rol']);
    }

    // Si el usuario tiene una cookie de sesión, restaurar sesión y redirigir
    if (isset($_COOKIE['user_session'])) {
        $_SESSION['idUsuario'] = $_COOKIE['user_session'];

        // Obtener el rol desde la base de datos
        $conexionObj = new Conexion();
        $conexion = $conexionObj->getConnection();
        
        $stmt = $conexion->prepare("SELECT Roles_idRoles FROM Usuario WHERE idUsuario = ?");
        $stmt->execute([$_SESSION['idUsuario']]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['rol'] = $usuario['Roles_idRoles'];
            redirigirPorRol($_SESSION['rol']);
        }
    }
}

// Función para redirigir según el rol del usuario
function redirigirPorRol($rol) {
    switch ($rol) {
        case 1: header("Location: /Proyecto/app_web/Roles/Admin/indexAdmin.php"); break;
        case 2: header("Location: /Proyecto/app_web/Roles/Gerente/indexGerente.php"); break;
        case 3: header("Location: ../indexBartender.php"); break;
        case 4: header("Location: /proyecto/Roles/Usuariosincrud/indexscannis.php"); break;
        default: echo "Error: Rol no reconocido."; exit();
    }
    exit();
}
?>
