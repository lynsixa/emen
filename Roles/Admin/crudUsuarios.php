<?php
require_once 'ControladorClientes.php';
$controlador = new ControladorClientes();

$cliente = null;

// Si se está editando un cliente
if (isset($_GET['editar_id'])) {
    $cliente = $controlador->obtenerClientePorId($_GET['editar_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear'])) {
        $controlador->crearCliente($_POST['Nombre'], $_POST['Documento'], $_POST['Correo'], $_POST['Fechadenacimiento'], $_POST['Roles_idRoles'], $_POST['Contrasena']);
    } elseif (isset($_POST['editar'])) {
        // Aquí, verificar que el valor de 'Roles_idRoles' existe en $_POST
        if (isset($_POST['Roles_idRoles'])) {
            $controlador->editarCliente($_POST['id'], $_POST['Nombre'], $_POST['Documento'], $_POST['Correo'], $_POST['Fechadenacimiento'], $_POST['Roles_idRoles']);
        } else {
            echo "Error: No se seleccionó un rol.";
        }
    } elseif (isset($_POST['eliminar'])) {
        $controlador->eliminarCliente($_POST['id']);
    }
}

$clientes = $controlador->obtenerClientes();
$roles = $controlador->obtenerRoles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Clientes</title>
    <link rel="stylesheet" href="css/cruds.css">
</head>
<body>
    <h1>CRUD de Clientes</h1>

    <h2>Crear/Editar Cliente</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $cliente ? $cliente['idClientes'] : ''; ?>">
        Nombre: <input type="text" name="Nombre" value="<?php echo $cliente ? $cliente['Nombre'] : ''; ?>" required><br>
        Documento: <input type="text" name="Documento" value="<?php echo $cliente ? $cliente['Documento'] : ''; ?>" required><br>
        Correo: <input type="email" name="Correo" value="<?php echo $cliente ? $cliente['Correo'] : ''; ?>" required><br>
        Fecha de Nacimiento: <input type="date" name="Fechadenacimiento" value="<?php echo $cliente ? date('Y-m-d', strtotime($cliente['Fechadenacimiento'])) : ''; ?>" required><br>
        Roles:
        <select name="Roles_idRoles" required>
            <?php foreach ($roles as $rol): ?>
                <option value="<?php echo $rol['idRoles']; ?>" 
                    <?php echo ($cliente && $cliente['Roles_idRoles'] == $rol['idRoles']) ? 'selected' : ''; ?>>
                    <?php echo $rol['Descripcion']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <?php if (!$cliente): ?>
            Contraseña: <input type="password" name="Contrasena" required><br>
        <?php endif; ?>

        <button type="submit" name="<?php echo $cliente ? 'editar' : 'crear'; ?>"><?php echo $cliente ? 'Editar' : 'Crear'; ?></button><br>
    </form>

    <!-- Botón para volver a crear -->
    <form method="GET" action="">
        <button type="submit" name="crear_nuevo">Volver a Crear</button><br>
    </form>

    <h2>Lista de Clientes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Correo</th>
            <th>Fecha de Nacimiento</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo $cliente['idClientes']; ?></td>
                <td><?php echo $cliente['Nombre']; ?></td>
                <td><?php echo $cliente['Documento']; ?></td>
                <td><?php echo $cliente['Correo']; ?></td>
                <td><?php echo date('Y-m-d', strtotime($cliente['Fechadenacimiento'])); ?></td>
                <td><?php echo $cliente['RolDescripcion']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $cliente['idClientes']; ?>">
                        <a href="?editar_id=<?php echo $cliente['idClientes']; ?>">Editar</a><br>
                        <button type="submit" name="eliminar">Eliminar</button><br>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
