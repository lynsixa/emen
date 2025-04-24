<?php
require_once '../Admin/Controlador/ControladorCrudUsuarios.php';


session_start();
require_once 'Conexion.php';  // Asegúrate de que la clase de conexión esté correctamente incluida

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario']) || $_SESSION['rol'] != 1) {
    header("Location: /proyecto/app_web/Roles/Login/vista/login.php");
    exit();
}


$usuarios = $controlador->obtenerUsuarios();
$roles = $controlador->obtenerRoles();
$usuarioEditar = isset($_GET['editar']) ? $controlador->obtenerUsuarioPorId($_GET['editar']) : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="icon" type="image/png" href="../Admin/imagenes/log.png">
    <link rel="stylesheet" href="../Admin/CSS/CssUsuario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
         body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, rgb(200, 153, 45), rgb(62, 61, 63), rgb(0, 0, 0));
    margin: 0;
    padding: 0;
       }

        .btn-volver {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }
    </style>
</head>
<body class="bg-light">

    <!-- BOTÓN VOLVER -->
    <a href="indexAdmin.php" class="btn btn-dark btn-volver">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>


    <div class="container py-5">
        <h1 class= "text-center text-white mb-4"><i class="bi bi-people-fill"></i> Gestión de Usuarios</h1>

        <!-- FORMULARIO -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-person-plus-fill"></i> <?= $usuarioEditar ? 'Editar Usuario' : 'Nuevo Usuario' ?>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="accion" value="<?= $usuarioEditar ? 'editar' : 'crear' ?>">
                    <?php if ($usuarioEditar): ?>
                        <input type="hidden" name="id" value="<?= $usuarioEditar['idUsuario'] ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombres</label>
                            <input type="text" name="nombres" class="form-control" required value="<?= $usuarioEditar['Nombres'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" required value="<?= $usuarioEditar['Apellidos'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Documento</label>
                            <input type="text" name="documento" class="form-control" required value="<?= $usuarioEditar['Documento'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control" required value="<?= $usuarioEditar['Correo'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="date" name="fecha" class="form-control" required value="<?= $usuarioEditar['FechaDeNacimiento'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select name="rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['idRoles'] ?>" <?= ($usuarioEditar && $usuarioEditar['Roles_idRoles'] == $rol['idRoles']) ? 'selected' : '' ?>>
                                        <?= $rol['Descripcion'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (!$usuarioEditar): ?>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="contrasena" class="form-control" required>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle-fill"></i> Guardar
                        </button>
                        <?php if ($usuarioEditar): ?>
                        <a href="crudUsuarios.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLA DE USUARIOS -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-table"></i> Lista de Usuarios
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Correo</th>
                            <th>Fecha Nacimiento</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $index => $usuario): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $usuario['Nombres'] ?></td>
                                <td><?= $usuario['Apellidos'] ?></td>
                                <td><?= $usuario['Documento'] ?></td>
                                <td><?= $usuario['Correo'] ?></td>
                                <td><?= $usuario['FechaDeNacimiento'] ?></td>
                                <td><?= $usuario['Rol'] ?></td>
                                <td>
                                    <a href="?editar=<?= $usuario['idUsuario'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="?eliminar=<?= $usuario['idUsuario'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
