<?php
session_start(); // Asegúrate de que la sesión esté activa

// Incluir la clase de conexión
include('conexion.php');

// Verificar que el código exista en la sesión
if (!isset($_SESSION['codigo'])) {
    return false; // No hay código en sesión
}

// Obtener el código desde la sesión
$codigo = $_SESSION['codigo'];

// Crear conexión
$conexion = new Conexion();
$conn = $conexion->getConnection();

// Consulta SQL para obtener los datos
$query = "
    SELECT 
        m.NumeroMesa, 
        m.NumeroPiso, 
        mm.Descripcion AS MenuDescripcion
    FROM 
        codigonis c
    INNER JOIN 
        mesa m ON c.mesa_idMesa = m.idMesa
    INNER JOIN 
        menu mm ON c.menu_idMenu = mm.idMenu
    WHERE 
        c.Descripcion = :codigo";

// Preparar y ejecutar
$stmt = $conn->prepare($query);
$stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
$stmt->execute();

// Obtener los resultados
$data = $stmt->fetch(PDO::FETCH_ASSOC);

return $data;
?>
