<?php
require_once '../Controlador/controladorCategoria.php';

$controlador = new controladorCategoria();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['agregar'])) {
        // Verificar que el campo 'nombre' existe y no está vacío
        $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
        $producto_id = $_POST['producto_id'] ?? null; // Asignar null si no se proporciona
        if ($nombre) {
            $controlador->agregarCategoria($nombre, $producto_id);
        }
    } elseif (isset($_POST['editar'])) {
        $id = $_POST['idCategoria'];
        // Verificar que el campo 'nombre' existe y no está vacío
        $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
        if ($nombre) {
            $controlador->editarCategoria($id, $nombre);
        }
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['idCategoria'];
        $controlador->eliminarCategoria($id);
    }
}

$categorias = $controlador->listarCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="../CSS/estilos4.css?v=<?php echo time(); ?>">
    <meta charset="UTF-8">
    <title>CRUD Categorías</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Gestión de Categorías</h2>

    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre de Categoría</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="producto_id">ID del Producto (opcional)</label>
            <input type="number" class="form-control" name="producto_id">
        </div>
        <button type="submit" name="agregar" class="btn btn-primary">Agregar Categoría</button>
        <button type="submit" name="editar" class="btn btn-warning">Editar Categoría</button>
        <input type="hidden" name="idCategoria" id="idCategoria"> <!-- Campo oculto para el ID de la categoría -->
    </form>

    <br>
    <h3>Lista de Categorías</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?php echo $categoria['idCategoria']; ?></td>
                <td><?php echo $categoria['nombre']; ?></td>
                <td>
                    <button class="btn btn-info" onclick="editarCategoria(<?php echo $categoria['idCategoria']; ?>, '<?php echo $categoria['nombre']; ?>')">Editar</button>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="idCategoria" value="<?php echo $categoria['idCategoria']; ?>">
                        <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function editarCategoria(id, nombre) {
        document.getElementById('idCategoria').value = id;
        document.querySelector('input[name="nombre"]').value = nombre;
    }
</script>

</body>
</html>
