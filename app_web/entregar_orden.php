<?php
include 'conexion.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM entrega WHERE idEntrega = $id";
    if ($conn->query($sql)) {
        echo "OK";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID no recibido";
}
?>
