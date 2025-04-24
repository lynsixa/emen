<?php
require_once 'Conexion.php';
session_start();

$conexion = (new Conexion())->getConnection();
$mensaje = "";

// ✅ CREAR NUEVO PRODUCTO
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    // Si la cantidad es 0, se marca disponibilidad como 0, si es mayor a 0, disponibilidad es 1
    $disponibilidad = ($cantidad == 0) ? 0 : 1;
    $nombreCategoria = $_POST['nombre_categoria'];
    $descripcion = $_POST['descripcion'];

    if (empty($_FILES['imagen1']['name'])) {
        $mensaje = "⚠️ Debes subir al menos una imagen.";
    } else {
        $imagenes = [];
        $carpetaDestino = "../Usuarioconcrud/gesProductos/fotosProductos/";

        for ($i = 1; $i <= 3; $i++) {
            if (!empty($_FILES["imagen$i"]['name'])) {
                $nombreArchivo = time() . "_img{$i}_" . basename($_FILES["imagen$i"]['name']);
                $rutaFinal = $carpetaDestino . $nombreArchivo;

                if (move_uploaded_file($_FILES["imagen$i"]['tmp_name'], $rutaFinal)) {
                    $imagenes[] = $nombreArchivo;
                } else {
                    $imagenes[] = null;
                }
            } else {
                $imagenes[] = null;
            }
        }

        // Insertar en tabla producto
        $stmt = $conexion->prepare("INSERT INTO producto (Precio, Disponibilidad, Cantidad) VALUES (?, ?, ?)");
        $stmt->bind_param("dii", $precio, $disponibilidad, $cantidad);
        $stmt->execute();
        $idProducto = $conexion->insert_id;

        // Insertar en tabla categoria
        $stmt = $conexion->prepare("INSERT INTO categoria (Nombre, Descripcion, Foto1, Foto2, Foto3, Producto_idProducto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $nombreCategoria, $descripcion, $imagenes[0], $imagenes[1], $imagenes[2], $idProducto);
        $stmt->execute();

        $mensaje = "✅ Producto subido correctamente.";
    }
}

// ✅ EDITAR PRODUCTO
if (isset($_GET['editar']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProducto = $_POST['idProducto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    // Actualizamos disponibilidad en función de la cantidad
    $disponibilidad = ($cantidad == 0) ? 0 : 1;
    $nombreCategoria = $_POST['nombre_categoria'];
    $descripcion = $_POST['descripcion'];

    if (empty($_FILES['imagen1']['name'])) {
        $mensaje = "⚠️ Debes subir al menos una imagen.";
    } else {
        $imagenes = [];
        $carpetaDestino = "../Usuarioconcrud/gesProductos/fotosProductos/";

        for ($i = 1; $i <= 3; $i++) {
            if (!empty($_FILES["imagen$i"]['name'])) {
                $nombreArchivo = time() . "_img{$i}_" . basename($_FILES["imagen$i"]['name']);
                $rutaFinal = $carpetaDestino . $nombreArchivo;

                if (move_uploaded_file($_FILES["imagen$i"]['tmp_name'], $rutaFinal)) {
                    $imagenes[] = $nombreArchivo;
                } else {
                    $imagenes[] = null;
                }
            } else {
                $imagenes[] = null;
            }
        }

        // Actualizamos el producto en la tabla producto
        $stmt = $conexion->prepare("UPDATE producto SET Precio = ?, Disponibilidad = ?, Cantidad = ? WHERE idProducto = ?");
        $stmt->bind_param("diii", $precio, $disponibilidad, $cantidad, $idProducto);
        $stmt->execute();

        // Actualizamos la categoría en la tabla categoria
        $stmt = $conexion->prepare("UPDATE categoria SET Nombre = ?, Descripcion = ?, Foto1 = ?, Foto2 = ?, Foto3 = ? WHERE Producto_idProducto = ?");
        $stmt->bind_param("sssssi", $nombreCategoria, $descripcion, $imagenes[0], $imagenes[1], $imagenes[2], $idProducto);
        $stmt->execute();

        $mensaje = "✅ Producto actualizado correctamente.";
    }
}

// ✅ ELIMINAR PRODUCTO
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM categoria WHERE Producto_idProducto = $id");
    $conexion->query("DELETE FROM producto WHERE idProducto = $id");
    $mensaje = "🗑️ Producto eliminado.";
}

// ✅ CARGAR PRODUCTOS
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
    <title>Gestión de Productos</title>
    <link rel="icon" type="image/png" href="../Admin/imagenes/log.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Admin/CSS/CssProducto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
  body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, rgb(200, 153, 45), rgb(62, 61, 63), rgb(0, 0, 0));
    margin: 0;
    padding: 0;
       }
        .btn-volver {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }
    </style>
</head>
<body class="container py-5">

<a href="indexAdmin.php" class="btn btn-dark btn-volver">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>


    <h2 class="text-center text-white mb-4">📦 Subir Nuevo Producto</h2>
    
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
        <input type="hidden" name="crear" value="1">
        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" step="0.001" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Cantidad:</label>
            <input type="number" name="cantidad" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nombre de la Categoría:</label>
            <input type="text" name="nombre_categoria" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Imagen 1 (Obligatoria):</label>
            <input type="file" name="imagen1" accept="image/*" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Imagen 2 (Opcional):</label>
            <input type="file" name="imagen2" accept="image/*" class="form-control">
        </div>
        <div class="mb-3">
            <label>Imagen 3 (Opcional):</label>
            <input type="file" name="imagen3" accept="image/*" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Subir Producto</button>
    </form>

    <hr class="my-5">

    <h3 class="text-center text-white mb-4">📋 Lista de Productos</h3>
    
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
        <?php while ($p = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $p['idProducto'] ?></td>
                <td><?= $p['Nombre'] ?></td>
                <td><?= $p['Descripcion'] ?></td>
                <td>$<?= number_format($p['Precio'], 3) ?></td>
                <td><?= $p['Cantidad'] ?></td>
                <td><img src="gesProductos/fotosProductos/<?= $p['Foto1'] ?>" alt="img" style="height: 60px;"></td>
                <td>
                    <a href="editar_producto.php?id=<?= $p['idProducto'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="?eliminar=<?= $p['idProducto'] ?>" onclick="return confirm('¿Seguro que deseas eliminar?')" class="btn btn-danger btn-sm">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
