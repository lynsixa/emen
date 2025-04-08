<?php
// mesero.php
include './conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes del Mesero 🍽️</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #fdf6f0;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .emoji {
            font-size: 1.5rem;
        }
        .despachadas {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">👨‍🍳 Órdenes listas para entregar</h1>
        <div class="row">
            <?php
            $sql = "SELECT * FROM entrega WHERE Entregado = 1 AND Entregado = 0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>
                        <div class='card shadow'>
                            <div class='card-body'>
                                <h5 class='card-title'>Orden ID: {$row['idEntrega']} 🍽️</h5>
                                <p class='card-text'>" . htmlspecialchars($row['Descripcion']) . "</p>
                                <form method='POST'>
                                    <input type='hidden' name='idEntrega' value='{$row['idEntrega']}'>
                                    <button type='submit' name='entregar' class='btn btn-success w-100'>✅ Entregar</button>
                                    <button type='button' onclick='rechazarOrden({$row['idEntrega']})' class='btn btn-danger w-100 mt-2'>❌ Rechazar</button>
                                </form>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No hay órdenes disponibles.</p>";
            }
            ?>
        </div>

        <div class="despachadas">
            <h2>📦 Órdenes Despachadas</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlEntregadas = "SELECT * FROM entrega WHERE Entregado = 1";
                    $resultEntregadas = $conn->query($sqlEntregadas);

                    while ($row = $resultEntregadas->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['idEntrega']}</td>
                            <td>" . htmlspecialchars($row['Descripcion']) . "</td>
                            <td>✅ Entregada</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function rechazarOrden(id) {
            Swal.fire({
                title: '¿Por qué se rechaza la orden?',
                input: 'text',
                inputLabel: 'Motivo de rechazo',
                showCancelButton: true,
                confirmButtonText: 'Rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    fetch('rechazar_orden.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'idEntrega=' + id + '&motivo=' + encodeURIComponent(result.value)
                    })
                    .then(response => response.text())
                    .then(data => {
                        Swal.fire('Rechazada', 'La orden fue rechazada', 'warning').then(() => {
                            location.reload();
                        });
                    });
                }
            });
        }
    </script>

    <?php
    if (isset($_POST['entregar'])) {
        $idEntrega = $_POST['idEntrega'];
        $sql = "UPDATE entrega SET Entregado = 1 WHERE idEntrega = $idEntrega";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: '¡Entregada!',
                    text: 'La orden fue entregada al cliente 🍽️',
                    icon: 'success',
                    confirmButtonText: 'Cerrar'
                }).then(() => {
                    window.location.href = window.location.href;
                });
            </script>";
        } else {
            echo "<script>alert('Error al entregar la orden.');</script>";
        }
    }
    ?>
</body>
</html>
