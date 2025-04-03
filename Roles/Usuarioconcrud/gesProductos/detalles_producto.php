<?php
include 'conexion.php'; // Conexión a la base de datos

if (!isset($_GET['idProducto'])) {
    die("<div class='alert alert-danger text-center'>Error: No se proporcionó un ID de producto.</div>");
}

$idProducto = $_GET['idProducto'];

// Consulta segura con prepared statements
$sql = "SELECT p.idProducto, p.Precio, p.Cantidad, c.Nombre, c.Descripcion, c.Foto1, c.Foto2, c.Foto3 
        FROM Producto p 
        INNER JOIN Categoria c ON p.idProducto = c.Producto_idProducto
        WHERE p.idProducto = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idProducto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<div class='alert alert-warning text-center'>Producto no encontrado.</div>");
}

$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .product-container {
            background: white;
            border-radius: 10px;
            box-shadow: 2px 2px 15px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .thumbnail img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.2s ease;
        }
        .thumbnail img:hover {
            transform: scale(1.1);
            border: 2px solid #007bff;
        }
        .main-image img {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 5px;
            border: 3px solid #ddd;
        }
        .btn-custom {
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-cart {
            background-color: #28a745;
            color: white;
        }
        .btn-cart:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .btn-back {
            background-color: #007bff;
            color: white;
        }
        .btn-back:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>

    <script>
        function cambiarImagen(src) {
            document.getElementById('imagenPrincipal').src = src;
        }
    </script>
</head>
<body>

<div class="container">
    <div class="row product-container">
        <!-- Miniaturas -->
        <div class="col-md-2 text-center d-flex flex-column align-items-center">
            <?php if (!empty($producto['Foto1'])): ?>
                <img class="thumbnail mb-2" src="<?= htmlspecialchars($producto['Foto1']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto1']) ?>')">
            <?php endif; ?>
            <?php if (!empty($producto['Foto2'])): ?>
                <img class="thumbnail mb-2" src="<?= htmlspecialchars($producto['Foto2']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto2']) ?>')">
            <?php endif; ?>
            <?php if (!empty($producto['Foto3'])): ?>
                <img class="thumbnail" src="<?= htmlspecialchars($producto['Foto3']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto3']) ?>')">
            <?php endif; ?>
        </div>

        <!-- Imagen Principal -->
        <div class="col-md-5 text-center">
            <div class="main-image">
                <img id="imagenPrincipal" src="<?= htmlspecialchars($producto['Foto1']) ?>" alt="<?= htmlspecialchars($producto['Nombre']) ?>">
            </div>
        </div>

        <!-- Información del Producto -->
        <div class="col-md-5">
            <h2 class="text-primary"><?= htmlspecialchars($producto['Nombre']) ?></h2>
            <p><?= nl2br(htmlspecialchars($producto['Descripcion'])) ?></p>
            <h4 class="text-success"><strong>Precio:</strong> $<?= number_format($producto['Precio'], 2) ?></h4>
            
            <form action="carrito.php" method="POST">
                <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
                <div class="mb-3">
                    <label for="cantidad" class="form-label"><strong>Cantidad:</strong></label>
                    <input type="number" class="form-control w-25 d-inline" name="cantidad" id="cantidad" min="1" max="<?= $producto['Cantidad'] ?>" value="1" required>
                </div>

                <button type="submit" class="btn btn-custom btn-cart w-100">
                    <i class="fas fa-cart-plus"></i> Agregar al Carrito
                </button>
            </form>

            <a href="index.php" class="btn btn-custom btn-back mt-3 w-100">
                <i class="fas fa-arrow-left"></i> Volver a la tienda
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
