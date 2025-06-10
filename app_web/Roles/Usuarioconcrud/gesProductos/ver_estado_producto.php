<?php
include("../gesProductos/conexion.php");
session_start();

if (!isset($_SESSION['idUsuario'])) {
  header("Location: /proyecto/app_web/Roles/Login/vista/login.php");
  exit();
}

$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT 
            o.Descripcion AS nombreProducto,
            s.Despachado,
            e.Entregado
        FROM Orden o
        JOIN Solicitud s ON o.Solicitud_idSolicitud = s.idSolicitud
        JOIN Entrega e ON s.Entrega_idEntrega = e.idEntrega
        WHERE o.Usuario_idUsuario = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $fase = 1;
    if ($row['Despachado'] == 1) $fase = 2;
    if ($row['Entregado'] == 1) $fase = 3;

    $productos[] = [
        'nombre' => $row['nombreProducto'],
        'fase' => $fase
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Estado de los Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #000000,rgba(255, 230, 0, 0.2));
      color: #fff;
      min-height: 100vh;
    }

    .card {
      background-color: #1e1e1e;
      border: none;
    }

    .step {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 20px 0;
    }

    .circle {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #444;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      transition: 0.3s;
    }

    .circle.active {
      background-color: #ffeb3b;
      color: black;
    }

    .line {
      flex: 1;
      height: 5px;
      background-color: #444;
      margin: 0 10px;
      transition: 0.3s;
    }

    .line.active {
      background-color: #ffeb3b;
    }

    .label-fase {
      font-size: 0.9rem;
      color: #ccc;
      width: 33%;
      text-align: center;
    }

    .label-fase.active {
      font-weight: bold;
      color: #ffeb3b;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card shadow-lg">
      <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-eye"></i> Estado de los Productos</h5>
        <a href="index.php" class="btn btn-dark btn-sm">
          <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
      </div>
      <div class="card-body">
        <?php if (count($productos) > 0): ?>
          <?php foreach ($productos as $producto): ?>
            <div class="mb-4 p-3 rounded" style="background-color:rgb(80, 82, 77);">
              <h5><i class="bi bi-cup-straw"></i> <?= htmlspecialchars($producto['nombre']) ?></h5>
              <?php $fase = $producto['fase']; ?>
              <div class="step">
                <div class="circle <?= $fase >= 1 ? 'active' : '' ?>">
                  <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="line <?= $fase >= 2 ? 'active' : '' ?>"></div>
                <div class="circle <?= $fase >= 2 ? 'active' : '' ?>">
                  <i class="bi bi-emoji-smile-fill"></i>
                </div>
                <div class="line <?= $fase >= 3 ? 'active' : '' ?>"></div>
                <div class="circle <?= $fase >= 3 ? 'active' : '' ?>">
                  <i class="bi bi-check-circle-fill"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <span class="label-fase <?= $fase == 1 ? 'active' : '' ?>">Recibido</span>
                <span class="label-fase <?= $fase == 2 ? 'active' : '' ?>">Despachado</span>
                <span class="label-fase <?= $fase == 3 ? 'active' : '' ?>">Entregado</span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-warning">No hay productos para mostrar en este momento.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
