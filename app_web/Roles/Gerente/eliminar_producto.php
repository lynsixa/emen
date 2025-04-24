<?php
require_once 'Conexion.php';
$conexion = (new Conexion())->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conexion->query("DELETE FROM categoria WHERE Producto_idProducto = $id");
    $conexion->query("DELETE FROM producto WHERE idProducto = $id");

    header("Location: listar_productos.php");
    exit();
}
?>
