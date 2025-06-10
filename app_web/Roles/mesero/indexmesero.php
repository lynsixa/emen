<?php
// Incluir conexión
include_once '../../Modelo/conexion.php'; // Asegúrate que la ruta sea correcta
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes del Mesero 🍽️</title>
    <link rel="stylesheet" href="CssMesero.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="img/log.png" type="image/png">
    
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
<div class="fondo-rotativo">
    <img src="img/IMG_5081.JPG" alt="Fondo 1">
    <img src="img/DSC06494.JPG" alt="Fondo 2">
    <img src="img/IMG_5105.JPG" alt="Fondo 3">
</div>

<header class="animate__animated animate__fadeInDown">
    <div class="logo">
        <a href="index.php">
            <img src="img/log.png" alt="Logo">
        </a>
    </div>
    <div class="menu">
        <nav class="menu">
            <ul>
                <li><a href="../../Controlador/cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <h1 class= "text-center text-white mb-4">👨‍🍳 Órdenes listas para entregar</h1>
    <div class="row">
        <?php
        // Consulta para obtener las órdenes de entrega y las descripciones de las solicitudes, excluyendo las rechazadas y las no despachadas (Despachado = 0)
        $sql = "SELECT e.*, s.Descripcion AS SolicitudDescripcion 
                FROM entrega e
                LEFT JOIN solicitud s ON e.idEntrega = s.Entrega_idEntrega
                WHERE e.Entregado = 0 AND (s.Despachado = 1)";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>
                    <div class='card shadow'>
                        <div class='card-body'>
                            <h5 class='card-title'>Orden ID: {$row['idEntrega']} 🍽️</h5>
                            <p class='card-text'><strong>Descripción de la Orden:</strong> " . htmlspecialchars($row['Descripcion']) . "</p>
                            <p class='card-text'><strong>Descripción de la Solicitud:</strong> " . htmlspecialchars($row['SolicitudDescripcion']) . "</p>
                            <form method='POST'>
                                <input type='hidden' name='idEntrega' value='{$row['idEntrega']}'>
                                <button type='submit' name='entregar' class='btn btn-success w-100'>✅ Entregar</button>
                               
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
                // Consultar órdenes entregadas
                $sqlEntregadas = "SELECT e.*, s.Descripcion AS SolicitudDescripcion
                                  FROM entrega e
                                  LEFT JOIN solicitud s ON e.idEntrega = s.Entrega_idEntrega
                                  WHERE e.Entregado = 1";
                $resultEntregadas = $conn->query($sqlEntregadas);

                if ($resultEntregadas && $resultEntregadas->num_rows > 0) {
                    while ($row = $resultEntregadas->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['idEntrega']}</td>
                            <td>" . htmlspecialchars($row['SolicitudDescripcion']) . "</td>
                            <td>✅ Entregada</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay órdenes entregadas.</td></tr>";
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
// Si el mesero ha entregado la orden, actualizar el estado en la base de datos
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
