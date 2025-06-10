<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}

include("../gesProductos/conexion.php");
$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT Nombres, Apellidos, Documento, Correo, FechaDeNacimiento FROM Usuario WHERE idUsuario = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($usuario = $resultado->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(23, 23, 24),rgb(227, 243, 4));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-perfil {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .card-perfil:hover {
            transform: translateY(-5px);
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-header i {
            font-size: 6rem;
            color:rgb(1, 198, 233);
        }

        .list-group-item {
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-custom {
            background-color:rgb(45, 35, 179);
            color: white;
        }

        .btn-custom:hover {
            background-color:rgb(22, 18, 71);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        input.form-control {
            border-radius: 10px;
        }

        .form-label i {
            margin-right: 6px;
            color: #6c63ff;
        }

        .d-flex.gap-3 button {
            flex: 1;
        }
    </style>
</head>
<body>

<div class="card-perfil fade-in">
    <div class="card-header">
        <i class="bi bi-person-circle"></i>
        <h3 class="mt-3 fw-bold">Mi Perfil</h3>
    </div>

    <!-- VISTA -->
    <div id="perfilVista">
        <ul class="list-group list-group-flush mb-4">
            <li class="list-group-item"><i class="bi bi-person-fill"></i><strong>Nombres:</strong> <?= htmlspecialchars($usuario['Nombres']) ?></li>
            <li class="list-group-item"><i class="bi bi-person-lines-fill"></i><strong>Apellidos:</strong> <?= htmlspecialchars($usuario['Apellidos']) ?></li>
            <li class="list-group-item"><i class="bi bi-credit-card"></i><strong>Documento:</strong> <?= htmlspecialchars($usuario['Documento']) ?></li>
            <li class="list-group-item"><i class="bi bi-envelope-fill"></i><strong>Correo:</strong> <?= htmlspecialchars($usuario['Correo']) ?></li>
            <li class="list-group-item"><i class="bi bi-calendar-date"></i><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($usuario['FechaDeNacimiento']) ?></li>
        </ul>

        <div class="d-flex justify-content-between gap-3">
            <a href="../index.php" class="btn btn-outline-dark w-50"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
            <button class="btn btn-custom w-50" onclick="mostrarFormulario()"><i class="bi bi-pencil-square"></i> Editar Perfil</button>
        </div>
    </div>

    <!-- FORMULARIO DE EDICIÓN -->
    <div id="formEditar" style="display: none;">
        <form action="actualizar_perfil.php" method="POST">
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-person-fill"></i> Nombres</label>
                <input type="text" name="nombres" class="form-control" value="<?= htmlspecialchars($usuario['Nombres']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-person-lines-fill"></i> Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="<?= htmlspecialchars($usuario['Apellidos']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-credit-card"></i> Documento</label>
                <input type="text" name="documento" class="form-control" value="<?= htmlspecialchars($usuario['Documento']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-envelope-fill"></i> Correo</label>
                <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($usuario['Correo']) ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label"><i class="bi bi-calendar-date"></i> Fecha de Nacimiento</label>
                <input type="date" name="fechaNacimiento" class="form-control" value="<?= htmlspecialchars($usuario['FechaDeNacimiento']) ?>" required>
            </div>

            <div class="d-flex justify-content-between gap-3">
                <button type="button" class="btn btn-outline-dark w-50" onclick="cancelarEdicion()"><i class="bi bi-x-circle"></i> Cancelar</button>
                <button type="submit" class="btn btn-custom w-50"><i class="bi bi-check-circle"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function mostrarFormulario() {
        document.getElementById('perfilVista').style.display = 'none';
        document.getElementById('formEditar').style.display = 'block';
    }

    function cancelarEdicion() {
        document.getElementById('perfilVista').style.display = 'block';
        document.getElementById('formEditar').style.display = 'none';
    }
</script>

</body>
</html>
<?php
} else {
    echo "<div class='container mt-5 alert alert-danger text-center'>No se encontró el usuario.</div>";
}
?>
