<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "";
$dbname = "emendsrtv";

// Crear la conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario para agregar un evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_evento'])) {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];

    // Verificar si ya existe un evento en la misma fecha
    $query = "SELECT * FROM eventos WHERE DATE(Fecha_Evento) = DATE(?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $fecha_evento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si ya existe un evento, mostrar un mensaje de error
        echo "<script>alert('Ya existe un evento en esta fecha. No se puede repetir.');</script>";
    } else {
        // Si no existe un evento, insertar el nuevo evento
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

// Verificar si se envió el formulario para editar un evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_evento'])) {
    // Obtener los datos del formulario de edición
    $evento_id = $_POST['evento_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];

    // Actualizar el evento sin el menú
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

// Verificar si se envió el formulario para eliminar un evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_evento'])) {
    $evento_id = $_POST['evento_id'];

    // Eliminar el evento de la base de datos
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

// Obtener los eventos desde la base de datos
$query = "SELECT idEventos, Titulo, Descripcion, Fecha_Evento FROM eventos";
$eventosResult = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Eventos - CRUD</title>
    <link rel="stylesheet" href="StilyesGeneral.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        button {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Gestionar Eventos - CRUD</h1>

<!-- Formulario para agregar o editar un evento -->
<h2><?php echo isset($_POST['editar_evento']) ? 'Editar Evento' : 'Agregar Nuevo Evento'; ?></h2>
<form method="POST" action="agregar_eventos.php">
    <input type="hidden" name="evento_id" value="<?php echo isset($_POST['evento_id']) ? $_POST['evento_id'] : ''; ?>">

    <label for="titulo">Título del Evento:</label>
    <input type="text" name="titulo" id="titulo" value="<?php echo isset($_POST['titulo']) ? $_POST['titulo'] : ''; ?>" required><br><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" required><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea><br><br>

    <label for="fecha_evento">Fecha y Hora del Evento:</label>
    <input type="datetime-local" name="fecha_evento" id="fecha_evento" value="<?php echo isset($_POST['fecha_evento']) ? $_POST['fecha_evento'] : ''; ?>" required><br><br>

    <button type="submit" name="agregar_evento">Agregar Evento</button>
    <?php if (isset($_POST['editar_evento'])): ?>
        <button type="submit" name="editar_evento">Editar Evento</button>
    <?php endif; ?>
</form>

<!-- Tabla de eventos existentes -->
<h2>Eventos Existentes</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha y Hora</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Mostrar los eventos en la tabla
        while ($evento = $eventosResult->fetch_assoc()) {
            $evento_id = $evento['idEventos'];
            $titulo = $evento['Titulo'];
            $descripcion = $evento['Descripcion'];
            $fecha_evento = $evento['Fecha_Evento'];

            echo "<tr>
                    <td>$evento_id</td>
                    <td>$titulo</td>
                    <td>$descripcion</td>
                    <td>$fecha_evento</td>
                    <td>
                        <!-- Botón de edición -->
                        <form method='POST' action='agregar_eventos.php' style='display:inline;'>
                            <input type='hidden' name='evento_id' value='$evento_id'>
                            <input type='hidden' name='titulo' value='$titulo'>
                            <input type='hidden' name='descripcion' value='$descripcion'>
                            <input type='hidden' name='fecha_evento' value='$fecha_evento'>
                            <button type='submit' name='editar_evento'>Editar</button>
                        </form>
                        <!-- Botón de eliminación -->
                        <form method='POST' action='agregar_eventos.php' style='display:inline;'>
                            <input type='hidden' name='evento_id' value='$evento_id'>
                            <button type='submit' name='eliminar_evento'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
