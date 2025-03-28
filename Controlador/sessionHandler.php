<?php
session_start();
require_once 'Modelo/Conexion.php';

function manejarSesion() {
    // Si el usuario ya tiene sesión activa, redirigirlo según su rol
    if (isset($_SESSION['idUsuario']) && isset($_SESSION['rol'])) {
        redirigirPorRol($_SESSION['rol']);
    }

    // Si hay una cookie de sesión, restaurar la sesión
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

// Función para redirigir según el rol
function redirigirPorRol($rol) {
    switch ($rol) {
        case 1: header("Location: /Principal/Roles/Admin/indexAdmin.html"); break;
        case 2: header("Location: /Principal/Roles/Gerente/indexGerente.html"); break;
        case 3: header("Location: /Principal/Roles/Bartender/indexBartender.html"); break;
        case 4: header("Location: /proyecto/Roles/Usuariosincrud/indexscannis.php"); break;
        default: echo "Error: Rol no reconocido."; exit();
    }
    exit();
}
?>
