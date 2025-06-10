<?php
session_start();
include 'conexion.php';

// Validar si hay productos en el carrito
if (empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío.";
    exit;
}

// Validar si el usuario está autenticado
if (empty($_SESSION['idUsuario']) || empty($_SESSION['nombreUsuario'])) {
    echo "Sesión inválida. Por favor inicia sesión.";
    exit;
}

$tokenCliente = bin2hex(random_bytes(16));  // Token seguro
$descripcion = "";
$totalGeneral = 0;
$fecha = date("Y-m-d H:i:s");
$idUsuario = $_SESSION['idUsuario'];
$nombreUsuario = $_SESSION['nombreUsuario'];

// Asignar CódigoNis si no se proporcionó
foreach ($_SESSION['carrito'] as &$producto) {
    if (empty($producto['CodigoNis_idCodigoNis']) && !empty($_SESSION['idCodigoNis'])) {
        $producto['CodigoNis_idCodigoNis'] = $_SESSION['idCodigoNis'];
    }
}
unset($producto); // limpiar referencia

// Recolectar descripción y calcular totales
foreach ($_SESSION['carrito'] as $producto) {
    $codigoNis = "No disponible";
    $numeroMesa = "N/A";
    $numeroPiso = "N/A";

    if (!empty($producto['CodigoNis_idCodigoNis'])) {
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

// Insertar en tabla Entrega
$sqlEntrega = "INSERT INTO Entrega (Descripcion, Entregado) VALUES (?, ?)";
$stmtEntrega = $con->prepare($sqlEntrega);
$descripcionEntrega = "Entrega de los productos en proceso. Usuario: $nombreUsuario";
$entregado = 0;
$stmtEntrega->bind_param("si", $descripcionEntrega, $entregado);
$stmtEntrega->execute();
$idEntrega = $stmtEntrega->insert_id;
$stmtEntrega->close();

// Insertar en tabla Solicitud
$sqlSolicitud = "INSERT INTO Solicitud (Descripcion, Despachado, Entrega_idEntrega) VALUES (?, ?, ?)";
$stmtSolicitud = $con->prepare($sqlSolicitud);
$descripcionSolicitud = "Solicitud de productos:\n" . $descripcion . "\nUsuario: $nombreUsuario";
$despachado = 0;
$stmtSolicitud->bind_param("sii", $descripcionSolicitud, $despachado, $idEntrega);
$stmtSolicitud->execute();
$idSolicitud = $stmtSolicitud->insert_id;
$stmtSolicitud->close();

// Insertar en tabla Orden
$sqlOrden = "INSERT INTO Orden (TokenCliente, Descripcion, PrecioFinal, Fecha, Producto_idProducto, Solicitud_idSolicitud, Usuario_idUsuario) 
             VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmtOrden = $con->prepare($sqlOrden);

// Preparar actualización de inventario y disponibilidad
$sqlActualizarCantidad = "UPDATE Producto SET Cantidad = Cantidad - ? WHERE idProducto = ?";
$sqlActualizarDisponibilidad = "UPDATE Producto SET Disponibilidad = 0 WHERE idProducto = ? AND Cantidad <= 0";
$stmtActualizarCantidad = $con->prepare($sqlActualizarCantidad);
$stmtActualizarDisponibilidad = $con->prepare($sqlActualizarDisponibilidad);

// Insertar cada producto y actualizar inventario
foreach ($_SESSION['carrito'] as $producto) {
    if (empty($producto['idProducto'])) {
        continue;
    }

    // Insertar orden
    $stmtOrden->bind_param("ssdisii", 
        $tokenCliente, 
        $descripcion, 
        $totalGeneral, 
        $fecha, 
        $producto['idProducto'], 
        $idSolicitud, 
        $idUsuario
    );
    $stmtOrden->execute();

    // Actualizar cantidad
    $stmtActualizarCantidad->bind_param("ii", $producto['cantidad'], $producto['idProducto']);
    $stmtActualizarCantidad->execute();

    // Si la cantidad es 0 o menos, marcar como no disponible
    $stmtActualizarDisponibilidad->bind_param("i", $producto['idProducto']);
    $stmtActualizarDisponibilidad->execute();
}

$stmtOrden->close();
$stmtActualizarCantidad->close();
$stmtActualizarDisponibilidad->close();
$con->close();

// Limpiar carrito y redirigir
unset($_SESSION['carrito']);
header("Location: index.php?orden=exito");
exit;
?>
