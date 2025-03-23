<?php
// Incluir la clase de conexión
include('conexion.php');

// Crear una instancia de la clase Conexion
$conexion = new Conexion();

// Obtener la conexión
$conn = $conexion->getConnection();

// Obtener el código de la URL
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';  // Asegúrate de que el código esté en la URL

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
        c.Descripcion = :codigo";  // Usamos un parámetro para evitar inyecciones SQL

// Preparar la consulta
$stmt = $conn->prepare($query);
$stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Retorna los datos obtenidos
return $data;
?>
