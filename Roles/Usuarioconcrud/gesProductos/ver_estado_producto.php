
<?php
include("../gesProductos/conexion.php");
// Ejemplo simulado:
$productos = [
    ['nombre' => 'Cerveza Artesanal', 'estado' => 'Disponible'],
    ['nombre' => 'Vino Tinto', 'estado' => 'Agotado'],
    ['nombre' => 'Cóctel Margarita', 'estado' => 'En preparación']
];
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
      background-color: #f8f9fa;
    }
    .estado-disponible { color: green; font-weight: bold; }
    .estado-agotado { color: red; font-weight: bold; }
    .estado-en-preparacion { color: orange; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-eye"></i> Estado de los Productos</h5>
        <a href="index.php" class="btn btn-light btn-sm">
          <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
      </div>
      <div class="card-body">
        <?php if (count($productos) > 0): ?>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>Producto</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($productos as $producto): ?>
                  <tr>
                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td>
                      <?php
                        $estado = strtolower($producto['estado']);
                        if ($estado === 'disponible') {
                          echo '<span class="estado-disponible">Disponible</span>';
                        } elseif ($estado === 'agotado') {
                          echo '<span class="estado-agotado">Agotado</span>';
                        } else {
                          echo '<span class="estado-en-preparacion">En preparación</span>';
                        }
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-muted">No hay productos para mostrar en este momento.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
