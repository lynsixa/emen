<?php
header('Content-Type: application/json');
include 'conexion.php'; // Asegúrate de que la conexión está bien definida

$sql = "SELECT 
            p.idProducto, 
            p.Precio, 
            p.Disponibilidad, 
            p.Cantidad, 
            c.Nombre, 
            c.Descripcion, 
            c.Foto1 
        FROM Producto p
        INNER JOIN Categoria c ON p.idProducto = c.Producto_idProducto
        WHERE p.Disponibilidad = 1";

$result = $con->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);
$con->close();
?>
