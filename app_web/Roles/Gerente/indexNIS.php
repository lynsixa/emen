<?php
require_once 'Conexion.php';
require_once 'ControladorNIS.php';

    

$controladorNIS = new ControladorNIS();
$menus = $controladorNIS->obtenerMenus();
$nis = $controladorNIS->obtenerNIS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'crear') {
        $descripcion = $_POST['descripcion'];
        $numero_piso = $_POST['numero_piso'];
        $numero_mesa = $_POST['numero_mesa'];
        $menu_id = $_POST['menu_id'];
        $mesa_id = obtenerIdMesa($numero_piso, $numero_mesa, $controladorNIS);
        $controladorNIS->crearNIS($descripcion, $mesa_id, $menu_id);
    }

    if ($accion === 'editar') {
        $idNIS = $_POST['idNIS'];
        $descripcion = $_POST['descripcion'];
        $numero_piso = $_POST['numero_piso'];
        $numero_mesa = $_POST['numero_mesa'];
        $menu_id = $_POST['menu_id'];
        $mesa_id = obtenerIdMesa($numero_piso, $numero_mesa, $controladorNIS);
        $controladorNIS->editarNIS($idNIS, $descripcion, $mesa_id, $menu_id);
    }

    if ($accion === 'eliminar') {
        $idNIS = $_POST['idNIS'];
        $controladorNIS->eliminarNIS($idNIS);
    }

    header('Location: indexNIS.php');
    exit;
}

function obtenerIdMesa($numero_piso, $numero_mesa, $controladorNIS) {
    $mesas = $controladorNIS->obtenerMesas();
    foreach ($mesas as $mesa) {
        if ($mesa['NumeroPiso'] == $numero_piso && $mesa['NumeroMesa'] == $numero_mesa) {
            return $mesa['idMesa'];
        }
    }

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
    <link rel="icon" href="imagenes/log.png" type="image/png">
    <link rel="stylesheet" href="../Admin/CSS/CssNis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="fondo-rotativo">
    <img src="imagenes/IMG_5081.JPG" alt="Fondo 1">
    <img src="imagenes/DSC06494.JPG" alt="Fondo 2">
    <img src="imagenes/IMG_5105.JPG" alt="Fondo 3">
</div>

<header class="bg-dark py-3 shadow-sm">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <!-- Logo -->
        <a href="indexNIS.php" class="d-flex align-items-center text-white text-decoration-none">
            <img src="imagenes/log.png" alt="Logo" style="height: 50px;">

        </a>

        <!-- Navegación -->
        <nav class="nav">
 
            <a  href="indexGerente.php" class="btn btn-dark btn-volver">
            <i class="bi bi-arrow-left-circle">  Volver</a>
        </nav>
    </div>
</header>

<h1 class="text-center text-white mb-4">Gestión de NIS</h1>

<h2 class="text-center text-white mb-4">Nuevo NIS</h2>
<div class="formulario-container">
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
</div>


<h2 class="text-center text-white mb-4">Lista de NIS</h2>
<div class="tabla-container">
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
                            <form  method="POST" style="display:inline;">
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
</div>


<!-- Script para rotar el fondo -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const imagenes = document.querySelectorAll('.fondo-rotativo img');
        let indice = 0;

        if (imagenes.length > 0) {
            imagenes[indice].classList.add('activo');

            setInterval(() => {
                imagenes[indice].classList.remove('activo');
                indice = (indice + 1) % imagenes.length;
                imagenes[indice].classList.add('activo');
            }, 5000);
        }
    });
</script>
</body>
</html>
