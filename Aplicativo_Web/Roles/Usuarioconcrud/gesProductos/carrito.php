<?php
session_start();
include 'conexion.php';

// Inicializar carrito si no está establecido
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idProducto'])) {
    $idProducto = $_POST['idProducto'];
    $cantidad = $_POST['cantidad'];
    
    $sql = "SELECT p.idProducto, c.Nombre, p.Precio FROM Producto p INNER JOIN Categoria c ON p.idProducto = c.Producto_idProducto WHERE p.idProducto = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $producto = [
            'idProducto' => $row['idProducto'],
            'nombre' => $row['Nombre'],
            'cantidad' => $cantidad,
            'precio' => $row['Precio']
        ];
        $_SESSION['carrito'][] = $producto;
    }
}

// Modificar cantidad del producto en el carrito
if (isset($_GET['accion']) && isset($_GET['index'])) {
    $index = $_GET['index'];
    if ($_GET['accion'] == 'sumar') {
        $_SESSION['carrito'][$index]['cantidad']++;
    } elseif ($_GET['accion'] == 'restar' && $_SESSION['carrito'][$index]['cantidad'] > 1) {
        $_SESSION['carrito'][$index]['cantidad']--;
    }
}

// Eliminar producto del carrito
if (isset($_GET['eliminar'])) {
    $indice = $_GET['eliminar'];
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar array
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../gesProductos/assets/css/styleCarrito.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Carrito de Compras</h2>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalGeneral = 0;
                    foreach ($_SESSION['carrito'] as $index => $producto):
                        $total = $producto['cantidad'] * $producto['precio'];
                        $totalGeneral += $total;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['idProducto']) ?></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-danger" href="carrito.php?accion=restar&index=<?= $index ?>">-</a>
                            <?= $producto['cantidad'] ?>
                            <a class="btn btn-sm btn-outline-success" href="carrito.php?accion=sumar&index=<?= $index ?>">+</a>
                        </td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td>$<?= number_format($total, 2) ?></td>
                        <td>
                            <a class="btn btn-sm btn-danger" href="carrito.php?eliminar=<?= $index ?>">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><strong>Total General</strong></td>
                        <td><strong>$<?= number_format($totalGeneral, 2) ?></strong></td>
                        <td>
                            <a href="procesar.php" class="btn btn-primary">Realizar Orden</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-secondary">Seguir Comprando</a>
        </div>
    </div>
</body>
</html>