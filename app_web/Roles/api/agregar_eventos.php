<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "";
$dbname = "emendsrtv";

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Agregar evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_evento'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];

    // Usar una consulta con el formato DATETIME completo para evitar duplicados por hora y minuto
    $query = "SELECT * FROM eventos WHERE Fecha_Evento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $fecha_evento); // 's' indica que es un string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Si ya existe un evento en esa fecha y hora exacta
        echo "<script>alert('Ya existe un evento en esta fecha y hora. No se puede repetir.');</script>";
    } else {
        // Si no existe, procedemos a agregar el nuevo evento
        $query = "INSERT INTO eventos (Titulo, Descripcion, Fecha_Evento) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error al preparar la consulta de inserción: " . $conn->error);
        }
        $stmt->bind_param('sss', $titulo, $descripcion, $fecha_evento);
        if ($stmt->execute()) {
            echo "<script>alert('Evento agregado con éxito');</script>";
        } else {
            echo "<script>alert('Error al agregar evento: " . $stmt->error . "');</script>";
        }
    }
    $stmt->close();
}

// Editar evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_evento'])) {
    $evento_id = $_POST['evento_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];

    // Consulta para actualizar el evento
    $query = "UPDATE eventos SET Titulo = ?, Descripcion = ?, Fecha_Evento = ? WHERE idEventos = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $titulo, $descripcion, $fecha_evento, $evento_id);
    if ($stmt->execute()) {
        echo "<script>alert('Evento actualizado con éxito');</script>";
    } else {
        echo "<script>alert('Error al actualizar evento: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Eliminar evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_evento'])) {
    $evento_id = $_POST['evento_id'];
    $query = "DELETE FROM eventos WHERE idEventos = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $evento_id);
    if ($stmt->execute()) {
        echo "<script>alert('Evento eliminado con éxito');</script>";
    } else {
        echo "<script>alert('Error al eliminar evento: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Consultar eventos
$query = "SELECT idEventos, Titulo, Descripcion, Fecha_Evento FROM eventos ORDER BY Fecha_Evento ASC"; // Aseguramos que estén ordenados por fecha
$eventosResult = $conn->query($query);

// Verificamos si la consulta se ejecutó correctamente
if (!$eventosResult) {
    die("Error al obtener los eventos: " . $conn->error);  // Si la consulta falla, mostramos el error
}

// Si la consulta fue exitosa, la variable $eventosResult debería contener el resultado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos</title>
    <link rel="stylesheet" href="StyleApi.css">
    <link rel="icon" type="image/png" href="../Admin/imagenes/log.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<a href="../Admin/indexAdmin.php" class="btn btn-dark btn-volver">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>

<div class="container py-5">
    <div class="card shadow p-4 mb-5 bg-white rounded">
        <h2 class="mb-4 text-primary"><?php echo isset($_POST['editar_evento']) ? 'Editar Evento' : 'Agregar Evento'; ?></h2>
        <form method="POST" action="agregar_eventos.php">
            <input type="hidden" name="evento_id" value="<?php echo $_POST['evento_id'] ?? ''; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título del Evento</label>
                <input type="text" class="form-control" name="titulo" id="titulo" required value="<?php echo $_POST['titulo'] ?? ''; ?>">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" required><?php echo $_POST['descripcion'] ?? ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="fecha_evento" class="form-label">Fecha y Hora del Evento</label>
                <input type="datetime-local" class="form-control" name="fecha_evento" id="fecha_evento" required value="<?php echo $_POST['fecha_evento'] ?? ''; ?>">
            </div>

            <button type="submit" name="agregar_evento" class="btn btn-success">Agregar Evento</button>
            <?php if (isset($_POST['editar_evento'])): ?>
                <button type="submit" name="editar_evento" class="btn btn-warning">Actualizar Evento</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="card shadow p-4 bg-white">
        <h2 class="mb-4 text-primary">Eventos Existentes</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha y Hora</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($evento = $eventosResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= $evento['idEventos'] ?></td>
                        <td><?= $evento['Titulo'] ?></td>
                        <td><?= $evento['Descripcion'] ?></td>
                        <td><?= $evento['Fecha_Evento'] ?></td>
                        <td>
                            <form method="POST" action="agregar_eventos.php" class="d-inline">
                                <input type="hidden" name="evento_id" value="<?= $evento['idEventos'] ?>">
                                <input type="hidden" name="titulo" value="<?= $evento['Titulo'] ?>">
                                <input type="hidden" name="descripcion" value="<?= $evento['Descripcion'] ?>">
                                <input type="hidden" name="fecha_evento" value="<?= $evento['Fecha_Evento'] ?>">
                                <button type="submit" name="editar_evento" class="btn btn-warning btn-sm">Editar</button>
                            </form>
                            <form method="POST" action="agregar_eventos.php" class="d-inline">
                                <input type="hidden" name="evento_id" value="<?= $evento['idEventos'] ?>">
                                <button type="submit" name="eliminar_evento" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>