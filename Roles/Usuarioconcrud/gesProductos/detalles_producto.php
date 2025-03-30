<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

if (!isset($_GET['idProducto'])) {
    die("Error: No se proporcionó un ID de producto.");
}

$idProducto = $_GET['idProducto'];

// Preparar la consulta para evitar inyección SQL
$sql = "SELECT p.idProducto, p.Precio, p.Cantidad, c.Nombre, c.Descripcion, c.Foto1, c.Foto2, c.Foto3 
        FROM Producto p 
        INNER JOIN Categoria c ON p.idProducto = c.Producto_idProducto
        WHERE p.idProducto = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idProducto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            width: 80%;
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .left img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
            border: 2px solid transparent;
        }
        .left img:hover {
            border-color: #007bff;
        }
        .center {
            flex: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .center img {
            width: 100%;
            max-width: 350px;
            height: 300px;
            object-fit: cover;
            border-radius: 5px;
        }
        .right {
            flex: 2;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .cantidad {
            margin: 10px 0;
        }
        input {
            width: 50px;
            text-align: center;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #218838;
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
        <!-- Sección Izquierda: Miniaturas -->
        <div class="left">
            <?php if (!empty($producto['Foto1'])): ?>
                <img src="<?= htmlspecialchars($producto['Foto1']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto1']) ?>')">
            <?php endif; ?>
            <?php if (!empty($producto['Foto2'])): ?>
                <img src="<?= htmlspecialchars($producto['Foto2']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto2']) ?>')">
            <?php endif; ?>
            <?php if (!empty($producto['Foto3'])): ?>
                <img src="<?= htmlspecialchars($producto['Foto3']) ?>" onclick="cambiarImagen('<?= htmlspecialchars($producto['Foto3']) ?>')">
            <?php endif; ?>
        </div>

        <!-- Sección Central: Imagen Principal -->
        <div class="center">
            <img id="imagenPrincipal" src="<?= htmlspecialchars($producto['Foto1']) ?>" alt="<?= htmlspecialchars($producto['Nombre']) ?>">
        </div>

        <!-- Sección Derecha: Información del Producto -->
        <div class="right">
            <h2><?= htmlspecialchars($producto['Nombre']) ?></h2>
            <p><?= htmlspecialchars($producto['Descripcion']) ?></p>
            <p><strong>Precio:</strong> $<?= number_format($producto['Precio'], 2) ?></p>
            <form action="carrito.php" method="POST">
                <input type="hidden" name="idProducto" value="<?= $producto['idProducto'] ?>">
                <div class="cantidad">
                    <label for="cantidad"><strong>Cantidad:</strong></label>
                    <input type="number" name="cantidad" id="cantidad" min="1" max="<?= $producto['Cantidad'] ?>" value="1" required>
                </div>
                <button type="submit">Agregar al Carrito</button>
            </form>
        </div>
    </div>

</body>
</html>
