<?php
session_start();
require_once 'Conexion.php';

// Función para manejar la sesión y redirigir según el rol
function manejarSesion() {
    if (isset($_SESSION['idUsuario']) && isset($_SESSION['rol'])) {
        redirigirPorRol($_SESSION['rol']);
    }

    // Si el usuario tiene una cookie de sesión, restaurar sesión y redirigir
    if (isset($_COOKIE['user_session'])) {
        $_SESSION['idUsuario'] = $_COOKIE['user_session'];

        // Obtener el rol y nombre del usuario desde la base de datos
        $conexionObj = new Conexion();
        $conexion = $conexionObj->getConnection();
        
        $stmt = $conexion->prepare("SELECT Roles_idRoles, nombre FROM Usuario WHERE idUsuario = ?");
        $stmt->execute([$_SESSION['idUsuario']]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['rol'] = $usuario['Roles_idRoles'];
            $_SESSION['nombreUsuario'] = $usuario['nombre'];  // Guardar el nombre del usuario en la sesión
            redirigirPorRol($_SESSION['rol']);
        }
    }
}

// Función para redirigir según el rol del usuario
function redirigirPorRol($rol) {
    switch ($rol) {
        case 1: header("Location: /proyecto/Roles/Admin/indexAdmin.html"); break;
        case 2: header("Location: ../indexGerente.html"); break;
        case 3: header("Location: ../indexBartender.html"); break;
        case 4: header("Location: /proyecto/Roles/Usuariosincrud/indexscannis.php"); break;
        default: echo "Error: Rol no reconocido."; exit();
    }
    exit();
}

// Función para crear una nueva orden con la descripción
function crearOrden($productoId, $cantidad, $precioUnitario) {
    if (isset($_SESSION['idUsuario'])) {
        $idUsuario = $_SESSION['idUsuario'];
        $nombreUsuario = $_SESSION['nombreUsuario'];  // Nombre del usuario desde la sesión
        
        // Ejemplo de cómo obtener la información de mesa, piso y código Nis (ajusta según tu lógica)
        $codigoNis = 'NIS123';  // Esto debe ser obtenido dinámicamente según tu lógica
        $numeroMesa = '5';      // Esto también debe ser obtenido dinámicamente
        $numeroPiso = '2';      // Esto también debe ser obtenido dinámicamente

        // Construir la descripción de la orden
        $descripcion = "Solicitud de productos: Producto (Cantidad: $cantidad) - Precio: \$" . number_format($precioUnitario, 2) . " | Total: \$" . number_format($precioUnitario * $cantidad, 2) . " | Nombre usuario: $nombreUsuario | Código Nis: $codigoNis | Mesa: $numeroMesa | Piso: $numeroPiso";
        
        // Insertar la orden en la base de datos
        $conexionObj = new Conexion();
        $conexion = $conexionObj->getConnection();

        // Preparar el SQL para insertar la orden
        $sql = "INSERT INTO Orden (TokenCliente, Descripcion, PrecioFinal, Fecha, Producto_idProducto, Usuario_idUsuario) 
                VALUES (?, ?, ?, NOW(), ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            $tokenCliente = 'token_123',  // Asume que tienes algún valor de TokenCliente
            $descripcion,
            $precioFinal = $precioUnitario * $cantidad,  // Precio final de la orden
            $productoId,  // ID del producto
            $idUsuario    // ID del usuario que realizó la orden (desde la sesión)
        ]);
    } else {
        echo "Usuario no autenticado.";
    }
}
?>
