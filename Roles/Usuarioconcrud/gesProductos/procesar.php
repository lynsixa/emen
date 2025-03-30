<?php
session_start();
include 'conexion.php';

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    echo "Tu carrito está vacío.";
    exit;
}

// Generar un token único para el cliente
$tokenCliente = bin2hex(random_bytes(16));  // Genera un token aleatorio seguro

// Inicializar variables
$descripcion = "";
$totalGeneral = 0;
$fecha = date("Y-m-d H:i:s");  // Fecha actual
$idUsuario = $_SESSION['idUsuario'];  // ID del usuario que realizó la orden
$nombreUsuario = $_SESSION['nombreUsuario'];  // Nombre del usuario desde la sesión

// Crear la descripción y calcular el precio total
foreach ($_SESSION['carrito'] as $producto) {
    // Obtener el código Nis, mesa y piso relacionado con el producto
    $sqlCodigoNis = "SELECT c.Descripcion AS CodigoNisDescripcion, m.NumeroPiso, m.NumeroMesa
                     FROM CodigoNis c
                     JOIN Mesa m ON c.Mesa_idMesa = m.idMesa
                     WHERE c.idCodigoNis = ?";
    $stmtCodigoNis = $con->prepare($sqlCodigoNis);
    $stmtCodigoNis->bind_param("i", $producto['CodigoNis_idCodigoNis']);
    $stmtCodigoNis->execute();
    $resultCodigoNis = $stmtCodigoNis->get_result();
    
    if ($row = $resultCodigoNis->fetch_assoc()) {
        // Recoger la información del código Nis, mesa y piso
        $codigoNis = $row['CodigoNisDescripcion'];
        $numeroMesa = $row['NumeroMesa'];
        $numeroPiso = $row['NumeroPiso'];
    }

    $totalProducto = $producto['cantidad'] * $producto['precio'];
    $totalGeneral += $totalProducto;

    // Incluir la información de los productos, código Nis, mesa y piso en la descripción
    $descripcion .= "{$producto['nombre']} (Cantidad: {$producto['cantidad']}) - Precio: \${$producto['precio']} | Total: \${$totalProducto} | Código Nis: {$codigoNis} | Mesa: {$numeroMesa} | Piso: {$numeroPiso}\n";
}

// 1. Insertar en la tabla 'Entrega' con 'Entregado' = 0 y nombre del usuario
$sqlEntrega = "INSERT INTO Entrega (Descripcion, Entregado) VALUES (?, ?)";
$stmtEntrega = $con->prepare($sqlEntrega);
$descripcionEntrega = "Entrega de los productos en proceso. Usuario: $nombreUsuario"; // Agregar el nombre del usuario
$entregado = 0; // No entregado aún
$stmtEntrega->bind_param("si", $descripcionEntrega, $entregado);
$stmtEntrega->execute();

// Obtener el id de la entrega insertada
$idEntrega = $stmtEntrega->insert_id;

// 2. Insertar en la tabla 'Solicitud' con 'Despachado' = 0, nombre del usuario y id de entrega
$sqlSolicitud = "INSERT INTO Solicitud (Descripcion, Despachado, Entrega_idEntrega) VALUES (?, ?, ?)";
$stmtSolicitud = $con->prepare($sqlSolicitud);

// Descripción de la solicitud con los productos en el carrito y nombre del usuario
$descripcionSolicitud = "Solicitud de productos: " . $descripcion . " | Nombre usuario: $nombreUsuario";
$despachado = 0; // No despachado aún

$stmtSolicitud->bind_param("sii", $descripcionSolicitud, $despachado, $idEntrega);
$stmtSolicitud->execute();

// Obtener el id de la solicitud insertada
$idSolicitud = $stmtSolicitud->insert_id;

// 3. Insertar la orden en la tabla 'Orden' y asociarla con la solicitud
$sqlOrden = "INSERT INTO Orden (TokenCliente, Descripcion, PrecioFinal, Fecha, Producto_idProducto, Solicitud_idSolicitud, Usuario_idUsuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmtOrden = $con->prepare($sqlOrden);
foreach ($_SESSION['carrito'] as $producto) {
    // Insertar cada producto en la orden
    $stmtOrden->bind_param("ssdisii", $tokenCliente, $descripcion, $totalGeneral, $fecha, $producto['idProducto'], $idSolicitud, $idUsuario);
    $stmtOrden->execute();
}

// Limpiar el carrito después de realizar la orden
unset($_SESSION['carrito']);

// Redirigir a index.php con el parámetro "orden=exito"
header("Location: index.php?orden=exito");
exit; // Asegurarse de que el script termine después de la redirección

$stmtOrden->close();
$stmtSolicitud->close();
$stmtEntrega->close();
$stmtCodigoNis->close();
$con->close();
?>
