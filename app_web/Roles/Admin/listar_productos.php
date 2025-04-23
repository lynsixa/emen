<?php
require_once 'Conexion.php';
$conexion = (new Conexion())->getConnection();

$resultado = $conexion->query("SELECT 
    p.idProducto, p.Precio, p.Cantidad, c.Nombre, c.Descripcion, c.Foto1 
    FROM producto p
    JOIN categoria c ON p.idProducto = c.Producto_idProducto
    ORDER BY p.idProducto DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2 class="mb-4">📋 Lista de Productos</h2>
    <a href="subir_producto.php" class="btn btn-success mb-3">➕ Agregar Nuevo Producto</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($producto = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $producto['idProducto'] ?></td>
                <td><?= $producto['Nombre'] ?></td>
                <td><?= $producto['Descripcion'] ?></td>
                <td>$<?= number_format($producto['Precio'], 3) ?></td>
                <td><?= $producto['Cantidad'] ?></td>
                <td><img src="gesProductos/fotosProductos/<?= $producto['Foto1'] ?>" alt="Imagen" style="height: 60px;"></td>
                <td>
                    <a href="editar_producto.php?id=<?= $producto['idProducto'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="eliminar_producto.php?id=<?= $producto['idProducto'] ?>" onclick="return confirm('¿Estás seguro de eliminar?')" class="btn btn-danger btn-sm">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
