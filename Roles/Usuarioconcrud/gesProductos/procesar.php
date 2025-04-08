<?php
session_start();
include 'conexion.php';

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    echo "Tu carrito está vacío.";
    exit;
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['nombreUsuario'])) {
    echo "Sesión inválida. Por favor inicia sesión.";
    exit;
}

$tokenCliente = bin2hex(random_bytes(16));  // Token seguro
$descripcion = "";
$totalGeneral = 0;
$fecha = date("Y-m-d H:i:s");
$idUsuario = $_SESSION['idUsuario'];
$nombreUsuario = $_SESSION['nombreUsuario'];

foreach ($_SESSION['carrito'] as $producto) {
    $codigoNis = "No disponible";
    $numeroMesa = "N/A";
    $numeroPiso = "N/A";

    if (isset($producto['CodigoNis_idCodigoNis'])) {
        $sqlCodigoNis = "SELECT c.Descripcion AS CodigoNisDescripcion, m.NumeroPiso, m.NumeroMesa
                         FROM CodigoNis c
                         JOIN Mesa m ON c.Mesa_idMesa = m.idMesa
                         WHERE c.idCodigoNis = ?";
        $stmtCodigoNis = $con->prepare($sqlCodigoNis);
        $stmtCodigoNis->bind_param("i", $producto['CodigoNis_idCodigoNis']);
        $stmtCodigoNis->execute();
        $resultCodigoNis = $stmtCodigoNis->get_result();

        if ($row = $resultCodigoNis->fetch_assoc()) {
            $codigoNis = $row['CodigoNisDescripcion'];
            $numeroMesa = $row['NumeroMesa'];
            $numeroPiso = $row['NumeroPiso'];
        }
        $stmtCodigoNis->close();
    }

    $totalProducto = $producto['cantidad'] * $producto['precio'];
    $totalGeneral += $totalProducto;

    $descripcion .= "{$producto['nombre']} (Cantidad: {$producto['cantidad']}) - Precio: \${$producto['precio']} | Total: \${$totalProducto} | Código Nis: {$codigoNis} | Mesa: {$numeroMesa} | Piso: {$numeroPiso}\n";
}

// Insertar en Entrega
$sqlEntrega = "INSERT INTO Entrega (Descripcion, Entregado) VALUES (?, ?)";
$stmtEntrega = $con->prepare($sqlEntrega);
$descripcionEntrega = "Entrega de los productos en proceso. Usuario: $nombreUsuario";
$entregado = 0;
$stmtEntrega->bind_param("si", $descripcionEntrega, $entregado);
$stmtEntrega->execute();
$idEntrega = $stmtEntrega->insert_id;
$stmtEntrega->close();

// Insertar en Solicitud
$sqlSolicitud = "INSERT INTO Solicitud (Descripcion, Despachado, Entrega_idEntrega) VALUES (?, ?, ?)";
$stmtSolicitud = $con->prepare($sqlSolicitud);
$descripcionSolicitud = "Solicitud de productos: " . $descripcion . " | Nombre usuario: $nombreUsuario";
$despachado = 0;
$stmtSolicitud->bind_param("sii", $descripcionSolicitud, $despachado, $idEntrega);
$stmtSolicitud->execute();
$idSolicitud = $stmtSolicitud->insert_id;
$stmtSolicitud->close();

// Insertar cada producto en la Orden
$sqlOrden = "INSERT INTO Orden (TokenCliente, Descripcion, PrecioFinal, Fecha, Producto_idProducto, Solicitud_idSolicitud, Usuario_idUsuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmtOrden = $con->prepare($sqlOrden);
foreach ($_SESSION['carrito'] as $producto) {
    if (!isset($producto['idProducto'])) {
        continue; // Saltar si falta el ID del producto
    }

    $stmtOrden->bind_param("ssdisii", $tokenCliente, $descripcion, $totalGeneral, $fecha, $producto['idProducto'], $idSolicitud, $idUsuario);
    $stmtOrden->execute();
}
$stmtOrden->close();

// Limpiar carrito y redirigir
unset($_SESSION['carrito']);
header("Location: index.php?orden=exito");
exit;

$con->close();
?>
