<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos de la Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        h2 {
            color: #333;
        }
        .session-data {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            max-width: 600px;
            margin: auto;
        }
        .session-data p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="session-data">
    <h2>🔐 Datos guardados en la sesión</h2>

    <?php if (!empty($_SESSION)): ?>
        <?php foreach ($_SESSION as $key => $value): ?>
            <p><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars(is_array($value) ? json_encode($value) : $value) ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay datos en la sesión.</p>
    <?php endif; ?>

    <a href="cerrar_sesion.php">Cerrar sesión</a>
</div>

</body>
</html>
