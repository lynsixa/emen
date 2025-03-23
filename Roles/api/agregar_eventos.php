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

<<<<<<< HEAD
// Verificar si se envió el formulario para agregar un evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_evento'])) {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];
    $menu_id = $_POST['menu_id'];

    // Verificar si el menu_id existe en la tabla menu
    $checkMenuQuery = "SELECT idMenu FROM menu WHERE idMenu = ?";
    $checkMenuStmt = $conn->prepare($checkMenuQuery);
    $checkMenuStmt->bind_param('i', $menu_id);
    $checkMenuStmt->execute();
    $checkMenuStmt->store_result();

    if ($checkMenuStmt->num_rows > 0) {
        // El menu_id existe, proceder a insertar el evento
        $query = "INSERT INTO eventos (titulo, descripcion, fecha_evento, menu_idMenu1) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $titulo, $descripcion, $fecha_evento, $menu_id);
=======
// Filtrar eventos por búsqueda
$busqueda = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['buscar'])) {
    $busqueda = $_GET['busqueda'];
}


// Agregar nuevo evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_evento'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];
    $menu_idMenu1 = $_POST['menu_idMenu1'];

    // Validar si ya existe un evento en la misma fecha y hora
    $query_verificar = "SELECT COUNT(*) AS total FROM eventos WHERE fecha_evento = ?";
    $stmt_verificar = $conn->prepare($query_verificar);
    $stmt_verificar->bind_param('s', $fecha_evento);
    $stmt_verificar->execute();
    $resultado = $stmt_verificar->get_result()->fetch_assoc();

    if ($resultado['total'] > 0) {
        echo "<script>alert('Ya existe un evento programado a esta hora.');</script>";
    } else {
        $query = "INSERT INTO eventos (titulo, descripcion, fecha_evento, menu_idMenu1) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $titulo, $descripcion, $fecha_evento, $menu_idMenu1);
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467

        if ($stmt->execute()) {
            echo "<script>alert('Evento agregado con éxito');</script>";
        } else {
            echo "<script>alert('Error al agregar evento: " . $stmt->error . "');</script>";
        }
        $stmt->close();
<<<<<<< HEAD
    } else {
        // El menu_id no existe, mostrar un mensaje de error
        echo "<script>alert('El ID del menú no existe. Por favor, seleccione un menú válido.');</script>";
    }
    $checkMenuStmt->close();
}

// Verificar si se envió el formulario para editar un evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_evento'])) {
    // Obtener los datos del formulario de edición
    $evento_id = $_POST['evento_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];
    $menu_id = $_POST['menu_id'];

    // Actualizar el evento en la base de datos
    $query = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha_evento = ?, menu_idMenu1 = ? WHERE idEvento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $titulo, $descripcion, $fecha_evento, $menu_id, $evento_id);

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
    $query = "DELETE FROM eventos WHERE idEvento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $evento_id);
=======
    }
    $stmt_verificar->close();
}

// Editar evento existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_evento'])) {
    $idEvento = $_POST['idEvento'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_evento = $_POST['fecha_evento'];
    $menu_idMenu1 = $_POST['menu_idMenu1'];

    // Validar si ya existe otro evento en la misma fecha y hora
    $query_verificar = "SELECT COUNT(*) AS total FROM eventos WHERE fecha_evento = ? AND idEvento != ?";
    $stmt_verificar = $conn->prepare($query_verificar);
    $stmt_verificar->bind_param('si', $fecha_evento, $idEvento);
    $stmt_verificar->execute();
    $resultado = $stmt_verificar->get_result()->fetch_assoc();

    if ($resultado['total'] > 0) {
        echo "<script>alert('Ya existe otro evento programado a esta hora.');</script>";
    } else {
        $query = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha_evento = ?, menu_idMenu1 = ? WHERE idEvento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssii', $titulo, $descripcion, $fecha_evento, $menu_idMenu1, $idEvento);

        if ($stmt->execute()) {
            echo "<script>alert('Evento actualizado con éxito');</script>";
        } else {
            echo "<script>alert('Error al actualizar evento: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
    $stmt_verificar->close();
}

// Eliminar evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_evento'])) {
    $idEvento = $_POST['idEvento'];

    $query = "DELETE FROM eventos WHERE idEvento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idEvento);
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467

    if ($stmt->execute()) {
        echo "<script>alert('Evento eliminado con éxito');</script>";
    } else {
        echo "<script>alert('Error al eliminar evento: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

<<<<<<< HEAD
// Obtener los eventos desde la base de datos
$query = "SELECT idEvento, titulo, descripcion, fecha_evento, menu_idMenu1 FROM eventos";
$eventosResult = $conn->query($query);
=======
// Obtener todos los eventos
$query = "SELECT * FROM eventos";
$eventos = $conn->query($query);
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
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

    <label for="menu_id">Seleccione el Menú:</label>
    <select name="menu_id" id="menu_id" required>
        <?php
        // Obtener los menús disponibles de la base de datos
        $menuQuery = "SELECT idMenu, Descripcion FROM menu";
        $menuResult = $conn->query($menuQuery);

        // Mostrar los menús en un select
        while ($row = $menuResult->fetch_assoc()) {
            $selected = (isset($_POST['menu_id']) && $_POST['menu_id'] == $row['idMenu']) ? 'selected' : '';
            echo "<option value='" . $row['idMenu'] . "' $selected>" . $row['Descripcion'] . "</option>";
        }
        ?>
    </select><br><br>

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
            <th>Menú</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Mostrar los eventos en la tabla
        while ($evento = $eventosResult->fetch_assoc()) {
            $evento_id = $evento['idEvento'];
            $titulo = $evento['titulo'];
            $descripcion = $evento['descripcion'];
            $fecha_evento = $evento['fecha_evento'];
            $menu_id = $evento['menu_idMenu1'];

            // Obtener el nombre del menú
            $menuQuery = "SELECT Descripcion FROM menu WHERE idMenu = ?";
            $menuStmt = $conn->prepare($menuQuery);
            $menuStmt->bind_param('i', $menu_id);
            $menuStmt->execute();
            $menuResult = $menuStmt->get_result();
            $menu = $menuResult->fetch_assoc()['Descripcion'];
            $menuStmt->close();
            
            echo "<tr>
                    <td>$evento_id</td>
                    <td>$titulo</td>
                    <td>$descripcion</td>
                    <td>$fecha_evento</td>
                    <td>$menu</td>
                    <td>
                        <!-- Botón de edición -->
                        <form method='POST' action='agregar_eventos.php' style='display:inline;'>
                            <input type='hidden' name='evento_id' value='$evento_id'>
                            <input type='hidden' name='titulo' value='$titulo'>
                            <input type='hidden' name='descripcion' value='$descripcion'>
                            <input type='hidden' name='fecha_evento' value='$fecha_evento'>
                            <input type='hidden' name='menu_id' value='$menu_id'>
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

=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Eventos</title>
    <link rel="stylesheet" href="../api/StyleApi.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Gestor de Eventos</h1>

     <!-- Barra de búsqueda -->
     <form method="GET" action="" class="mb-4 d-flex justify-content-center">
        <input type="text" class="form-control w-50 me-2" name="busqueda" placeholder="Buscar eventos por título" value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit" name="buscar" class="btn btn-primary">
            <i class="fa fa-search"></i> Buscar
        </button>
    </form>

    <!-- Formulario para agregar o editar evento -->
    <div class="card mb-4">
        <div class="card-header">Agregar/Editar Evento</div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="idEvento" id="idEvento">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_evento" class="form-label">Fecha y Hora del Evento:</label>
                    <input type="datetime-local" class="form-control" id="fecha_evento" name="fecha_evento" required>
                </div>

                <div class="mb-3">
                    <label for="menu_idMenu1" class="form-label">Tipo de Menú:</label>
                    <select class="form-control" id="menu_idMenu1" name="menu_idMenu1" required>
                        <option value="1">Común</option>
                        <option value="2">Evento</option>
                    </select>
                </div>

                <button type="submit" name="agregar_evento" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button>
                <button type="submit" name="editar_evento" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de eventos -->
    <div class="card">
        <div class="card-header">Eventos Existentes</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha del Evento</th>
                    <th>Tipo de Menú</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($evento = $eventos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $evento['idEvento'] ?></td>
                        <td><?= $evento['titulo'] ?></td>
                        <td><?= $evento['descripcion'] ?></td>
                        <td><?= $evento['fecha_evento'] ?></td>
                        <td><?= $evento['menu_idMenu1'] == 1 ? 'Común' : 'Evento' ?></td>
                        <td>
                            <!-- Botón de editar -->
                            <button class="btn btn-warning btn-sm" onclick="editarEvento(<?= $evento['idEvento'] ?>, '<?= $evento['titulo'] ?>', '<?= $evento['descripcion'] ?>', '<?= $evento['fecha_evento'] ?>', <?= $evento['menu_idMenu1'] ?>)"><i class="fa fa-edit"></i> Editar</button>

                            <!-- Botón de eliminar -->
                            <form method="POST" action="" class="d-inline">
                                <input type="hidden" name="idEvento" value="<?= $evento['idEvento'] ?>">
                                <button type="submit" name="eliminar_evento" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function editarEvento(id, titulo, descripcion, fecha, menuId) {
        document.getElementById('idEvento').value = id;
        document.getElementById('titulo').value = titulo;
        document.getElementById('descripcion').value = descripcion;
        document.getElementById('fecha_evento').value = fecha.replace(' ', 'T');
        document.getElementById('menu_idMenu1').value = menuId;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
</body>
</html>
