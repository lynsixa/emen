<?php
// Incluir archivo de conexión a la base de datos
include('conexion.php');

// Variable para almacenar el mensaje de error
$mensaje = '';

// Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el código del formulario
    $codigo = $_POST['codigo'];

    try {
        // Crear una instancia de la clase Conexion y obtener la conexión
        $conexion = new Conexion();
        $conn = $conexion->getConnection();

        // Preparar la consulta utilizando PDO
        $stmt = $conn->prepare("SELECT * FROM codigonis WHERE Descripcion = :codigo");
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);  // Enlazar parámetro
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Verificar si se encontró un registro
        if ($stmt->rowCount() > 0) {
            // Redirigir a la página con el código en la URL
            header("Location: /proyecto/Roles/Usuarioconcrud/index.php?codigo=$codigo");
            exit(); // Terminar el script después de redirigir
        } else {
            // Si no se encuentra el código, mostrar el mensaje de error
            $mensaje = "Código no encontrado.";
        }

        // Cerrar la consulta
        $stmt = null;
    } catch (PDOException $e) {
        // Manejo de excepciones en caso de error en la conexión o consulta
        $mensaje = "Error en la consulta: " . $e->getMessage();
    }
}
?>
