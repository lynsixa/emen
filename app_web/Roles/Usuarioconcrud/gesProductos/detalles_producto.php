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

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f4f8;
            font-family: 'Segoe UI', sans-serif;
        }

        .product-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 5% auto;
            max-width: 1100px;
        }

        .main-image img {
            width: 100%;
            max-height: 450px;
            object-fit: contain;
            border-radius: 10px;
            border: 2px solid #ddd;
            transition: transform 0.3s;
        }

        .main-image img:hover {
            transform: scale(1.02);
        }

        .thumbnail {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #0d6efd;
            margin-bottom: 10px;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .thumbnail:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-cart {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-cart:hover {
            background-color: #218838;
            transform: scale(1.03);
        }

        .btn-back {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #084298;
            transform: scale(1.03);
        }

        h2.product-title {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 1.5rem;
            color: #28a745;
        }

        .header {
            background: linear-gradient(90deg, #007bff, #6f42c1);
            color: white;
            padding: 20px 0;
            text-align: center;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header i {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .thumbnail {
                width: 70px;
                height: 70px;
            }
        }
    </style>

    <script>
        function cambiarImagen(src) {
            document.getElementById('imagenPrincipal').src = src;
        }
    </script>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-box-open"></i> Detalle del Producto</h1>
    </div>

    <div class="container product-container">
        <div class="row">
            <!-- Miniaturas -->
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-center">
                <?php if (!empty($producto['Foto1'])): ?>
                    <img class="thumbnail" src="<?= htmlspecialchars($producto['Foto1']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto1']) ?>')">
                <?php endif; ?>
                <?php if (!empty($producto['Foto2'])): ?>
                    <img class="thumbnail" src="<?= htmlspecialchars($producto['Foto2']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto2']) ?>')">
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
                <h2 class="product-title"><i class="fas fa-tag text-primary"></i> <?= htmlspecialchars($producto['Nombre']) ?></h2>
                <p><?= nl2br(htmlspecialchars($producto['Descripcion'])) ?></p>
                <p class="product-price"><i class="fas fa-dollar-sign"></i> <?= number_format($producto['Precio'], 2) ?></p>

                <form action="carrito.php" method="POST">
                    <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
                    <div class="mb-3">
                        <label for="cantidad" class="form-label fw-bold"><i class="fas fa-sort-numeric-up"></i> Cantidad:</label>
                        <input type="number" class="form-control w-50" name="cantidad" id="cantidad" min="1" max="<?= $producto['Cantidad'] ?>" value="1" required>
                    </div>

                    <button type="submit" class="btn btn-cart w-100">
                        <i class="fas fa-cart-plus"></i> Agregar al Carrito
                    </button>
                </form>

                <a href="index.php" class="btn btn-back mt-3 w-100">
                    <i class="fas fa-arrow-left"></i> Volver a la Tienda
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
