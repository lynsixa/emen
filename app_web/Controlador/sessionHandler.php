<?php
session_start();
require_once 'Conexion.php';

// ⏳ Duración máxima de sesión con código validado (6 horas = 21600 segundos)
$vida_maxima = 21600;

// Verificar si existe y ya expiró la sesión del código NIS
if (isset($_SESSION['codigo_validado_hora'])) {
    if (time() - $_SESSION['codigo_validado_hora'] > $vida_maxima) {
        session_unset();
        session_destroy();
        setcookie("user_session", "", time() - 3600, "/");

        header("Location: /proyecto/app_web/Roles/Login/vista/login.php?expirada=1");
        exit();
    }
}

// Función reutilizable para forzar validación en cualquier archivo
function verificarSesion() {
    global $vida_maxima;

    if (!isset($_SESSION['codigo_validado_hora']) || (time() - $_SESSION['codigo_validado_hora'] > $vida_maxima)) {
        session_unset();
        session_destroy();
        setcookie("user_session", "", time() - 3600, "/");
        header("Location: /proyecto/app_web/Roles/Login/vista/login.php?expirada=1");
        exit();
    }
}

function manejarSesion() {
    if (isset($_SESSION['idUsuario']) && isset($_SESSION['rol'])) {
        redirigirPorRol($_SESSION['rol']);
    }

    if (isset($_COOKIE['user_session'])) {
        $_SESSION['idUsuario'] = $_COOKIE['user_session'];

        $conexionObj = new Conexion();
        $conexion = $conexionObj->getConnection();

        $stmt = $conexion->prepare("SELECT Roles_idRoles, nombres FROM Usuario WHERE idUsuario = ?");
        $stmt->execute([$_SESSION['idUsuario']]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['rol'] = $usuario['Roles_idRoles'];
            $_SESSION['nombreUsuario'] = $usuario['nombres'];
            redirigirPorRol($_SESSION['rol']);
        }
    }
}

function redirigirPorRol($rol) {
    switch ($rol) {
        case 1: header("Location: /proyecto/app_web/roles/Admin/indexAdmin.php"); break;
        case 2: header("Location: /proyecto/app_web/roles/Gerente/indexGerente.php"); break;
        case 3: header("Location: /proyecto/app_web/roles/mesero/indexmesero.php"); break;
        case 4: header("Location: /proyecto/app_web/roles/Usuariosincrud/indexscannis.php"); break;
        case 5: header("Location: /proyecto/app_web/roles/Bartender/indexBartender.php"); break;
        default: echo "Rol no reconocido."; exit();
    }
    exit();
}

function crearOrden($productoId, $cantidad, $precioUnitario, $nombreProducto) {
    if (isset($_SESSION['idUsuario']) && isset($_SESSION['idCodigoNis'])) {
        $idUsuario = $_SESSION['idUsuario'];
        $nombreUsuario = $_SESSION['nombreUsuario'];
        $idCodigoNis = $_SESSION['idCodigoNis'];

        $conexionObj = new Conexion();
        $conexion = $conexionObj->getConnection();

        $sql = "SELECT 
                    cn.Descripcion AS codigoNis,
                    m.NumeroMesa AS numeroMesa,
                    m.NumeroPiso AS numeroPiso
                FROM CodigoNis cn
                JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
                WHERE cn.idCodigoNis = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$idCodigoNis]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        $codigoNis = $info['codigoNis'] ?? 'Desconocido';
        $numeroMesa = $info['numeroMesa'] ?? 'N/A';
        $numeroPiso = $info['numeroPiso'] ?? 'N/A';

        $total = $precioUnitario * $cantidad;

        $descripcion = "$nombreProducto (Cantidad: $cantidad) - Precio: $" . number_format($precioUnitario, 3, '.', '') .
                       " | $nombreUsuario | Total: $" . number_format($total, 0, '.', '') .
                       " | Código NIS: $codigoNis | Mesa: $numeroMesa | Piso: $numeroPiso";

        $sqlInsert = "INSERT INTO Orden (TokenCliente, Descripcion, PrecioFinal, Fecha, Producto_idProducto, Usuario_idUsuario) 
                      VALUES (?, ?, ?, NOW(), ?, ?)";
        $stmtInsert = $conexion->prepare($sqlInsert);
        $stmtInsert->execute([
            'token_123',
            $descripcion,
            $total,
            $productoId,
            $idUsuario
        ]);
    } else {
        echo "⚠️ Faltan datos de sesión (usuario o código NIS).";
    }
}
?>
