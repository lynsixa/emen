<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1161";
$dbname = "emendsrtv";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Agregar Producto
if (isset($_POST['addProduct'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponibilidad = $_POST['disponibilidad'];
    $cantidad = $_POST['cantidad'];
    $categoria_id = $_POST['categoria_id']; // Se asume que pasas el id de la categoría

    // Insertar el producto en la tabla producto
    $sql = "INSERT INTO producto (Precio, Disponibilidad, Cantidad, idCategoria) 
            VALUES ('$precio', '$disponibilidad', '$cantidad', '$categoria_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Mostrar todos los productos con la categoría correspondiente
$sql = "SELECT p.idProducto, p.Precio, p.Disponibilidad, p.Cantidad, c.nombre AS categoria_nombre 
        FROM producto p 
        INNER JOIN categoria c ON p.idCategoria = c.idCategoria";  // Relación con la columna idCategoria
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos</title>
</head>
<body>
    <h1>Agregar Producto</h1>
    <form method="POST">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" required><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required><br>

        <label for="disponibilidad">Disponibilidad (0 o 1):</label>
        <input type="number" name="disponibilidad" id="disponibilidad" required><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required><br>

        <label for="categoria_id">Categoría:</label>
        <select name="categoria_id" id="categoria_id" required>
            <?php
            // Mostrar las categorías disponibles
            $categoriaQuery = "SELECT * FROM categoria";
            $categoriaResult = $conn->query($categoriaQuery);
            while ($categoria = $categoriaResult->fetch_assoc()) {
                echo "<option value='" . $categoria['idCategoria'] . "'>" . $categoria['nombre'] . "</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="addProduct">Agregar Producto</button>
    </form>

    <h2>Productos Registrados</h2>
    <table border="1">
        <tr>
            <th>ID Producto</th>
            <th>Precio</th>
            <th>Disponibilidad</th>
            <th>Cantidad</th>
            <th>Categoría</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['idProducto'] . "</td>";
                echo "<td>" . $row['Precio'] . "</td>";
                echo "<td>" . $row['Disponibilidad'] . "</td>";
                echo "<td>" . $row['Cantidad'] . "</td>";
                echo "<td>" . $row['categoria_nombre'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay productos registrados</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
