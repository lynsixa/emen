<?php
require_once 'Conexion.php';
$conexion = (new Conexion())->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Determinar la disponibilidad en función de la cantidad
    $disponibilidad = ($cantidad == 0) ? 0 : 1;

    // Actualizar los datos del producto en la tabla `producto`
    $conexion->query("UPDATE producto SET Precio = $precio, Cantidad = $cantidad, Disponibilidad = $disponibilidad WHERE idProducto = $id");

    // Actualizar los datos de la categoría en la tabla `categoria`
    $conexion->query("UPDATE categoria SET Nombre = '$nombre', Descripcion = '$descripcion' WHERE Producto_idProducto = $id");

    // Redirigir después de guardar los cambios
    header("Location: listar_productos.php");
    exit();
}

$id = $_GET['id'];
$producto = $conexion->query("SELECT p.*, c.Nombre, c.Descripcion FROM producto p 
                              JOIN categoria c ON p.idProducto = c.Producto_idProducto 
                              WHERE p.idProducto = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
<<<<<<< HEAD
<a href="subir_producto" class="btn btn-dark btn-volver">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
=======
>>>>>>> d7ad886f3380c3d4559d10dc883980110ce673e6
    <h2>✏️ Editar Producto</h2>
    <form method="POST" class="border p-4 bg-light rounded">
        <input type="hidden" name="id" value="<?= $producto['idProducto'] ?>">

        <!-- Nombre del producto -->
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= $producto['Nombre'] ?>" required>
        </div>

        <!-- Descripción del producto -->
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" required><?= $producto['Descripcion'] ?></textarea>
        </div>

        <!-- Precio del producto -->
        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" step="0.001" name="precio" class="form-control" value="<?= $producto['Precio'] ?>" required>
        </div>

        <!-- Cantidad del producto -->
        <div class="mb-3">
            <label>Cantidad:</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $producto['Cantidad'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="listar_productos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
    