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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            margin: 2px;
        }
    </style>
</head>
<body>
    <h2>Carrito de Compras</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
        <?php
        $totalGeneral = 0;
        foreach ($_SESSION['carrito'] as $index => $producto) {
            $total = $producto['cantidad'] * $producto['precio'];
            $totalGeneral += $total;
            echo "<tr>
                    <td>{$producto['idProducto']}</td>
                    <td>{$producto['nombre']}</td>
                    <td>
                        <a class='btn' href='carrito.php?accion=restar&index={$index}'>-</a>
                        {$producto['cantidad']}
                        <a class='btn' href='carrito.php?accion=sumar&index={$index}'>+</a>
                    </td>
                    <td>\${$producto['precio']}</td>
                    <td>\${$total}</td>
                    <td><a class='btn' href='carrito.php?eliminar={$index}'>Eliminar</a></td>
                </tr>";
        }
        ?>
        <tr>
            <td colspan="4"><strong>Total General</strong></td>
            <td><strong>\$<?php echo $totalGeneral; ?></strong></td>
            <td><a href="procesar.php" class="btn">Realizar Orden</a></td>
        </tr>
    </table>
    <br>
    <a href="index.php">Seguir Comprando</a>
</body>
</html>
