<?php
// Conectar a la base de datos
include('Conexion.php');

// Obtener el ID del evento para editarlo
$evento = null;
if (isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    // Validar el ID del evento para asegurarnos de que es un número
    if (filter_var($idEvento, FILTER_VALIDATE_INT)) {
        // Consultar el evento a editar
        $query = "SELECT * FROM eventos WHERE idEvento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $idEvento);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $evento = $resultado->fetch_assoc();
        $stmt->close();
    } else {
        die("ID de evento inválido.");
    }
}

// Editar evento
if (isset($_POST['editar'])) {
    // Validar y limpiar los datos del formulario
    $idEvento = $_POST['idEvento'];
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_evento = $_POST['fecha_evento'];

    // Validar que el ID de evento sea un número entero
    if (!filter_var($idEvento, FILTER_VALIDATE_INT)) {
        die("ID de evento inválido.");
    }

    // Usar consultas preparadas para actualizar el evento
    $query = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha_evento = ? WHERE idEvento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $titulo, $descripcion, $fecha_evento, $idEvento);

    if ($stmt->execute()) {
        // Redirigir al index de administración después de la actualización
        header('Location: index_admin.php');
        exit();  // Asegurarse de que no se ejecute nada más después de redirigir
    } else {
        echo "Error al actualizar el evento: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
</head>
<body>

<h1>Editar Evento</h1>

<?php if ($evento): ?>
    <form method="POST" action="">
        <input type="hidden" name="idEvento" value="<?php echo htmlspecialchars($evento['idEvento']); ?>">
        
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($evento['titulo']); ?>" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($evento['descripcion']); ?></textarea><br><br>

        <label for="fecha_evento">Fecha y Hora del Evento:</label>
        <input type="datetime-local" name="fecha_evento" value="<?php echo date('Y-m-d\TH:i', strtotime($evento['fecha_evento'])); ?>" required><br><br>

        <button type="submit" name="editar">Editar Evento</button>
    </form>
<?php else: ?>
    <p>Evento no encontrado.</p>
<?php endif; ?>

</body>
</html>
