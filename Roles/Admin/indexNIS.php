<?php
// Corrección de la ruta para cargar el archivo 'ControladorNIS.php' desde '../Controlador/ControladorNIS.php'
require_once 'ControladorNIS.php'; 

// Crear una instancia del controlador
$controlador = new ControladorNIS();

$error = '';
$success = '';
$editar = false;
$registroActual = null;

// Procesar la creación del registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $numeroMesa = $_POST['NumeroMesa'] ?? 0;
        $cantidadPuestos = $_POST['CantidadPuestos'] ?? 0;
        $numeroPiso = $_POST['Numeropiso'] ?? 0;
        $descripcion = $_POST['Descripcion'] ?? '';
        $menu_id = $_POST['Menu_idMenu'] ?? 0;

        // Crear mesa
        $mesa_id = $controlador->crearMesa($numeroMesa, $cantidadPuestos, $numeroPiso);
        if ($mesa_id) {
            // Crear NIS
            if (!$controlador->crearNIS($descripcion, $mesa_id, $menu_id)) {
                $error = "Error al crear el NIS. Intenta nuevamente.";
            } else {
                $success = "Registro creado exitosamente.";
            }
        } else {
            $error = "Error al crear la mesa. Intenta nuevamente.";
        }
    }

    if (isset($_POST['editar'])) {
        $idNIS = $_POST['idNIS'] ?? 0;
        $numeroMesa = $_POST['NumeroMesa'] ?? 0;
        $cantidadPuestos = $_POST['CantidadPuestos'] ?? 0;
        $numeroPiso = $_POST['Numeropiso'] ?? 0;
        $descripcion = $_POST['Descripcion'] ?? '';
        $menu_id = $_POST['Menu_idMenu'] ?? 0;

        if ($controlador->editarNISyMesa($idNIS, $descripcion, $numeroMesa, $cantidadPuestos, $numeroPiso, $menu_id)) {
            $success = "Registro editado exitosamente.";
        } else {
            $error = "Error al editar el registro. Intenta nuevamente.";
        }
    }

    if (isset($_POST['eliminar'])) {
        $idNIS = $_POST['idNIS'] ?? 0;
        if ($controlador->eliminarNIS($idNIS)) {
            $success = "Registro eliminado exitosamente.";
        } else {
            $error = "Error al eliminar el NIS. Intenta nuevamente.";
        }
    }
}

// Cargar los registros existentes
$menus = $controlador->obtenerMenus();
$nisList = $controlador->obtenerNIS();

// Verificar si se desea editar un registro
if (isset($_GET['editar'])) {
    $idNIS = $_GET['editar'];
    $registroActual = $controlador->obtenerNISPorId($idNIS);
    $editar = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear y Editar NIS y Mesa</title>
    <link rel="stylesheet" href="css/estilos24.css">

</head>
<body>
    <h1><?php echo $editar ? "Editar NIS y Mesa" : "Crear NIS y Mesa"; ?></h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="idNIS" value="<?php echo $editar ? $registroActual['idCodigoNIS'] : ''; ?>">
        Número de Mesa: <input type="number" name="NumeroMesa" required value="<?php echo $editar ? $registroActual['NumeroMesa'] : ''; ?>">
        <br>
        Cantidad de Puestos: <input type="number" name="CantidadPuestos" required value="<?php echo $editar ? $registroActual['CantidadPuestos'] : ''; ?>">
        <br>
        Número de Piso: <input type="number" name="Numeropiso" required value="<?php echo $editar ? $registroActual['Numeropiso'] : ''; ?>">
        <br>
        Código NIS: <input type="text" name="Descripcion" required value="<?php echo $editar ? $registroActual['CodigoNIS'] : ''; ?>">
        <br>
        Menú:
        <select name="Menu_idMenu" required>
            <?php foreach ($menus as $menu): ?>
                <option value="<?php echo $menu['idMenu']; ?>" <?php echo ($editar && $registroActual['Menu_idMenu'] == $menu['idMenu']) ? 'selected' : ''; ?>>
                    <?php echo $menu['Descripcion']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit" name="<?php echo $editar ? 'editar' : 'crear'; ?>">
            <?php echo $editar ? 'Actualizar Registro' : 'Crear NIS y Mesa'; ?>
        </button>
        <a href="indexNIS.php">Volver a Crear NIS</a>
    </form>

    <h2>Lista de NIS</h2>
    <table border="1">
        <tr>
            <th>ID NIS</th>
            <th>Código NIS</th>
            <th>Número de Mesa</th>
            <th>Número de Piso</th>
            <th>Cantidad de Puestos</th>
            <th>Menú</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($nisList as $nis): ?>
            <tr>
                <td><?php echo $nis['idCodigoNIS']; ?></td>
                <td><?php echo $nis['CodigoNIS']; ?></td>
                <td><?php echo $nis['NumeroMesa']; ?></td>
                <td><?php echo $nis['Numeropiso']; ?></td>
                <td><?php echo $nis['CantidadPuestos']; ?></td>
                <td><?php echo $nis['MenuDescripcion']; ?></td>
                <td>
                    <a href="?editar=<?php echo $nis['idCodigoNIS']; ?>">Editar</a>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="idNIS" value="<?php echo $nis['idCodigoNIS']; ?>">
                        <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
