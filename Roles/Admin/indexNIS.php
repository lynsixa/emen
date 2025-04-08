<?php
// Incluir el archivo de conexión y el controlador
require_once 'Conexion.php';
require_once 'ControladorNIS.php';

// Instanciamos el controlador
$controladorNIS = new ControladorNIS();

// Obtener los menús
$menus = $controladorNIS->obtenerMenus();

// Obtener los NIS registrados
$nis = $controladorNIS->obtenerNIS();

// Manejo de las acciones de formulario (crear, editar, eliminar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'crear') {
        $descripcion = $_POST['descripcion'];
        $numero_piso = $_POST['numero_piso'];
        $numero_mesa = $_POST['numero_mesa'];
        $menu_id = $_POST['menu_id'];

        // Lógica para obtener el ID de la mesa según el número de piso y número de mesa
        $mesa_id = obtenerIdMesa($numero_piso, $numero_mesa, $controladorNIS);

        $controladorNIS->crearNIS($descripcion, $mesa_id, $menu_id);
    }

    if ($accion === 'editar') {
        $idNIS = $_POST['idNIS'];
        $descripcion = $_POST['descripcion'];
        $numero_piso = $_POST['numero_piso'];
        $numero_mesa = $_POST['numero_mesa'];
        $menu_id = $_POST['menu_id'];

        // Lógica para obtener el ID de la mesa según el número de piso y número de mesa
        $mesa_id = obtenerIdMesa($numero_piso, $numero_mesa, $controladorNIS);

        $controladorNIS->editarNIS($idNIS, $descripcion, $mesa_id, $menu_id);
    }

    if ($accion === 'eliminar') {
        $idNIS = $_POST['idNIS'];
        $controladorNIS->eliminarNIS($idNIS);
    }

    // Recargar la página para reflejar cambios
    header('Location: indexNIS.php');
    exit;
}

// Función para obtener el ID de la mesa
function obtenerIdMesa($numero_piso, $numero_mesa, $controladorNIS) {
    $mesas = $controladorNIS->obtenerMesas();

    foreach ($mesas as $mesa) {
        if ($mesa['NumeroPiso'] == $numero_piso && $mesa['NumeroMesa'] == $numero_mesa) {
            return $mesa['idMesa'];
        }
    }

    // Si no existe la mesa, crearla y devolver el ID de la nueva mesa
    $conexion = (new Conexion())->getConnection();
    $sql = "INSERT INTO Mesa (NumeroPiso, NumeroMesa) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $numero_piso, $numero_mesa);
    $stmt->execute();

    return $conexion->insert_id;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de NIS</title>
    <link rel="stylesheet" href="../Admin/CSS/CssNis.css">
</head>
<body>
    <h1>Gestión de NIS</h1>

    <!-- Formulario para agregar nuevo NIS -->
    <h2>Nuevo NIS</h2>
    <form method="POST" action="indexNIS.php">
        <input type="hidden" name="accion" value="crear">
        <label for="descripcion">Descripción del NIS:</label>
        <input type="text" name="descripcion" required>

        <label for="numero_piso">Número de Piso:</label>
        <input type="number" name="numero_piso" required>

        <label for="numero_mesa">Número de Mesa:</label>
        <input type="number" name="numero_mesa" required>

        <label for="menu_id">Tipo de Menú:</label>
        <select name="menu_id" required>
            <?php foreach ($menus as $menu): ?>
                <option value="<?= $menu['idMenu']; ?>"><?= $menu['Descripcion']; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Crear NIS</button>
    </form>

    <h2>Lista de NIS</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Número de Mesa</th>
                <th>Menú</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($nis)): ?>
                <?php foreach ($nis as $row): ?>
                    <tr>
                        <td><?= $row['idCodigoNis']; ?></td>
                        <td><?= $row['CodigoNIS']; ?></td>
                        <td><?= $row['NumeroMesa']; ?></td>
                        <td><?= $row['MenuDescripcion']; ?></td>
                        <td>
                            <!-- Formulario para editar -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="editar">
                                <input type="hidden" name="idNIS" value="<?= $row['idCodigoNis']; ?>">
                                <input type="text" name="descripcion" value="<?= $row['CodigoNIS']; ?>" required>
                                <input type="number" name="numero_piso" value="<?= $row['NumeroPiso']; ?>" required>
                                <input type="number" name="numero_mesa" value="<?= $row['NumeroMesa']; ?>" required>
                                <select name="menu_id" required>
                                    <?php foreach ($menus as $menu): ?>
                                        <option value="<?= $menu['idMenu']; ?>" <?= $menu['idMenu'] == $row['Menu_idMenu'] ? 'selected' : ''; ?>><?= $menu['Descripcion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit">Editar</button>
                            </form>

                            <!-- Formulario para eliminar -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="idNIS" value="<?= $row['idCodigoNis']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay registros de NIS disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
