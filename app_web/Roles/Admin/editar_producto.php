<?php
require_once 'Conexion.php';
$conexion = (new Conexion())->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $disponibilidad = ($cantidad == 0) ? 0 : 1;

    // Manejo de imágenes
    $imagenes = [];
    $carpetaDestino = "../gesProductos/fotosProductos/";

    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_FILES["imagen$i"]['name'])) {
            $nombreArchivo = time() . "_img{$i}_" . basename($_FILES["imagen$i"]['name']);
            $rutaFinal = $carpetaDestino . $nombreArchivo;

            if (move_uploaded_file($_FILES["imagen$i"]['tmp_name'], $rutaFinal)) {
                $imagenes[] = $carpetaDestino . $nombreArchivo;
            } else {
                $imagenes[] = $_POST["imagen_actual$i"] ?? null;
            }
        } else {
            $imagenes[] = $_POST["imagen_actual$i"] ?? null;
        }
    }

    $conexion->query("UPDATE producto SET Precio = $precio, Cantidad = $cantidad, Disponibilidad = $disponibilidad WHERE idProducto = $id");

    $stmt = $conexion->prepare("UPDATE categoria SET Nombre = ?, Descripcion = ?, Foto1 = ?, Foto2 = ?, Foto3 = ? WHERE Producto_idProducto = ?");
    $stmt->bind_param("sssssi", $nombre, $descripcion, $imagenes[0], $imagenes[1], $imagenes[2], $id);
    $stmt->execute();

    header("Location: listar_productos.php");
    exit();
}

$id = $_GET['id'];
$producto = $conexion->query("SELECT p.*, c.Nombre, c.Descripcion, c.Foto1, c.Foto2, c.Foto3 
                              FROM producto p 
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

<a href="subir_producto.php" class="btn btn-dark mb-3"><i class="bi bi-arrow-left-circle"></i> Volver</a>

<h2>✏️ Editar Producto</h2>
<form method="POST" enctype="multipart/form-data" class="border p-4 bg-light rounded">
    <input type="hidden" name="id" value="<?= $producto['idProducto'] ?>">

    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" value="<?= $producto['Nombre'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="descripcion" class="form-control" required><?= $producto['Descripcion'] ?></textarea>
    </div>

    <div class="mb-3">
        <label>Precio:</label>
        <input type="number" step="0.001" name="precio" class="form-control" value="<?= $producto['Precio'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Cantidad:</label>
        <input type="number" name="cantidad" class="form-control" value="<?= $producto['Cantidad'] ?>" required>
    </div>

    <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="mb-3">
            <label>Imagen <?= $i ?> <?= $i === 1 ? '(Obligatoria)' : '(Opcional)' ?>:</label><br>
            <?php if (!empty($producto["Foto$i"])): ?>
                <img src="<?= $producto["Foto$i"] ?>" style="height: 60px;"><br>
            <?php endif; ?>
            <input type="file" name="imagen<?= $i ?>" class="form-control" accept="image/*">
            <input type="hidden" name="imagen_actual<?= $i ?>" value="<?= $producto["Foto$i"] ?>">
        </div>
    <?php endfor; ?>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="listar_productos.php" class="btn btn-secondary">Cancelar</a>
</form>
</body>
</html>
