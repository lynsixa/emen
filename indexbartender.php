<?php
include("conexion.php");
$conn->set_charset("utf8");

// Control de acciones
$ordenDespachada = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    if ($_POST["accion"] === "despachar") {
        $stmt = $conn->prepare("UPDATE Entrega SET Entregado = 1 WHERE idEntrega = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $ordenDespachada = true;
    } elseif ($_POST["accion"] === "rechazar") {
        $motivo = $_POST["motivo"];
        $stmt = $conn->prepare("UPDATE Entrega SET Entregado = -1, Descripcion = CONCAT(Descripcion, '\nMotivo: ', ?) WHERE idEntrega = ?");
        $stmt->bind_param("si", $motivo, $id);
        $stmt->execute();
    }
}

$resultado = $conn->query("SELECT idEntrega, Descripcion FROM Entrega WHERE Entregado = 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes Bartender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1f1c2c, #928dab);
            color: white;
        }
        .card {
            border-radius: 15px;
        }
        .btn-custom {
            border-radius: 30px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">📦 Órdenes Pendientes (Bartender)</h2>
    <div class="row">
        <?php if ($resultado->num_rows == 0): ?>
            <div class="col-12">
                <div class="alert alert-light text-dark text-center">No hay órdenes pendientes</div>
            </div>
        <?php endif; ?>
        <?php while ($orden = $resultado->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow bg-dark text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">🧾 Pedido #<?= $orden['idEntrega'] ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($orden['Descripcion'])) ?></p>
                        <form method="POST" onsubmit="mostrarModal();">
                            <input type="hidden" name="id" value="<?= $orden['idEntrega'] ?>">
                            <input type="hidden" name="accion" value="despachar">
                            <button class="btn btn-success btn-custom w-100 mt-2" type="submit">✅ Marcar como Listo</button>
                        </form>
                        <form method="POST" onsubmit="return rechazarConMotivo(this);">
                            <input type="hidden" name="id" value="<?= $orden['idEntrega'] ?>">
                            <input type="hidden" name="accion" value="rechazar">
                            <input type="hidden" name="motivo" value="">
                            <button class="btn btn-danger btn-custom w-100 mt-2" type="submit">❌ Rechazar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-success text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmacionLabel">🎉 Orden Enviada</h5>
      </div>
      <div class="modal-body">
        La orden fue marcada como lista y enviada al mesero correctamente.
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-light" onclick="window.location.href = window.location.href;">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
function rechazarConMotivo(form) {
    const motivo = prompt("Motivo del rechazo:");
    if (motivo && motivo.trim() !== "") {
        form.motivo.value = motivo.trim();
        return true;
    }
    return false;
}

// Mostrar modal si se acaba de despachar
<?php if ($ordenDespachada): ?>
    window.addEventListener("DOMContentLoaded", () => {
        const modal = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
        modal.show();
    });
<?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
