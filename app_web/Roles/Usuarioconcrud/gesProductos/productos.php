<?php
header('Content-Type: application/json');
include '../gesProductos/conexion.php'; // Ajusta si tu conexión está en otra ruta

function limpiarRuta($ruta) {
    // Reemplaza espacios con guiones bajos y elimina caracteres especiales inseguros
    $ruta = str_replace(' ', '_', $ruta);
    return preg_replace('/[^A-Za-z0-9_\-\/\.]/', '', $ruta);
}

// Detecta si estás en localhost o producción
$host = $_SERVER['HTTP_HOST'];
$base_url = "http://$host/Proyecto/Roles/Usuarioconcrud/";

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
    $rutaRelativa = limpiarRuta($row['Foto1']);
    $row['Foto1'] = $base_url . $rutaRelativa;
    $productos[] = $row;
}

echo json_encode($productos);
$con->close();
?>
