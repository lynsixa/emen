<?php
// Incluir los archivos necesarios
require_once 'ControladorNIS.php';
require_once 'Conexion.php'; // Si es necesario, incluye el archivo de conexión

// Crear una instancia del controlador
$controlador = new ControladorNIS();

// Obtener todos los menús
$menus = $controlador->obtenerMenus();

// Obtener todos los NIS
$nis = $controlador->obtenerNIS();

// Manejo de acciones (crear, editar, eliminar NIS)
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'crear':
            // Crear un nuevo NIS
            if (isset($_POST['descripcion'], $_POST['mesa_id'], $_POST['menu_id'])) {
                $descripcion = $_POST['descripcion'];
                $mesa_id = $_POST['mesa_id'];
                $menu_id = $_POST['menu_id'];
                $controlador->crearNIS($descripcion, $mesa_id, $menu_id);
            }
            break;
        case 'editar':
            // Editar un NIS
            if (isset($_POST['idNIS'], $_POST['descripcion'], $_POST['mesa_id'], $_POST['menu_id'])) {
                $idNIS = $_POST['idNIS'];
                $descripcion = $_POST['descripcion'];
                $mesa_id = $_POST['mesa_id'];
                $menu_id = $_POST['menu_id'];
                $controlador->editarNISyMesa($idNIS, $descripcion, $mesa_id, $menu_id);
            }
            break;
        case 'eliminar':
            // Eliminar un NIS
            if (isset($_POST['idNIS'])) {
                $idNIS = $_POST['idNIS'];
                $controlador->eliminarNIS($idNIS);
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de NIS</title>
</head>
<body>
    <h1>Gestión de NIS</h1>

    <!-- Formulario para agregar nuevo NIS -->
    <h2>Nuevo NIS</h2>
    <form method="POST" action="indexNIS.php">
        <input type="hidden" name="accion" value="crear">
        <label for="descripcion">Descripción del NIS:</label>
        <input type="text" name="descripcion" required>
        <label for="mesa_id">Número de Mesa:</label>
        <select name="mesa_id" required>
            <?php foreach ($nis as $row): ?>
                <option value="<?= $row['idMesa']; ?>">Mesa <?= $row['NumeroMesa']; ?> - Piso <?= $row['NumeroPiso']; ?></option>
            <?php endforeach; ?>
        </select>
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
                <th>Número de Piso</th>
                <th>Menú</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nis as $row): ?>
                <tr>
                    <td><?= $row['idCodigoNis']; ?></td>
                    <td><?= $row['CodigoNIS']; ?></td>
                    <td><?= $row['NumeroMesa']; ?></td>
                    <td><?= $row['NumeroPiso']; ?></td>
                    <td><?= $row['MenuDescripcion']; ?></td>
                    <td>
                        <!-- Botón para editar -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="accion" value="editar">
                            <input type="hidden" name="idNIS" value="<?= $row['idCodigoNis']; ?>">
                            <input type="text" name="descripcion" value="<?= $row['CodigoNIS']; ?>" required>
                            <select name="mesa_id" required>
                                <?php foreach ($nis as $mesa): ?>
                                    <option value="<?= $mesa['idMesa']; ?>" <?= $mesa['idMesa'] == $row['Mesa_idMesa'] ? 'selected' : ''; ?>>Mesa <?= $mesa['NumeroMesa']; ?> - Piso <?= $mesa['NumeroPiso']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="menu_id" required>
                                <?php foreach ($menus as $menu): ?>
                                    <option value="<?= $menu['idMenu']; ?>" <?= $menu['idMenu'] == $row['Menu_idMenu'] ? 'selected' : ''; ?>><?= $menu['Descripcion']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">Editar</button>
                        </form>

                        <!-- Botón para eliminar -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="idNIS" value="<?= $row['idCodigoNis']; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
