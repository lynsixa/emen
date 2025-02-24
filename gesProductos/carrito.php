<?php
session_start();
include('conexion.php'); // Incluye la conexión a la base de datos
include('modalEliminarProduct.php');
include('funciones/funciones_tienda.php');
include('header.php');

$conexion = new Conexion();
$con = $conexion->getConnection(); // Obtener conexión

$miCarrito = mi_carrito_de_compra($con);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="assets/images/icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/single_styles.css">
    <link rel="stylesheet" href="assets/styles/loader.css">
    <title>Carrito de Compras</title>
</head>

<?php
session_start();
include('config/config.php');

/**
 * Función para obtener los productos disponibles
 */
function getProductList($con)
{
    $sql = "SELECT 
                p.idProducto AS prodId,
                c.nombre,
                p.precio,
                c.foto1 AS imagen
            FROM 
                producto AS p
            INNER JOIN 
                categoria AS c
            ON 
                c.producto_idProducto = p.idProducto";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Error en la consulta de productos: " . mysqli_error($con));
    }

    return $result;
}

// Obtener productos de la base de datos
$productos = getProductList($con);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5 pt-5">
        <h3 class="text-center mb-4" style="border-bottom: solid 1px #ebebeb;">Lista de Productos</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead id="theadTableSpecial">
                    <tr>
                        <th scope="col">Imagen</th>
                        <th scope="col">Producto</th>
                        <th scope="col" class="text-center">Precio</th>
                        <th class="text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($productos)) { ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($row["imagen"]); ?>" alt="Foto del producto" style="width: 100px;">
                            </td>
                            <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                            <td class="text-center"><strong>$</strong> <?php echo number_format($row['precio'], 0, '', '.'); ?></td>
                            <td class="text-right">
                                <a href="detallesArticulo.php?id=<?php echo $row['prodId']; ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                                <a href="agregar_carrito.php?id=<?php echo $row['prodId']; ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-cart-plus"></i> Añadir al Carrito
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('includes/footer.html'); ?>
    <?php include('includes/js.html'); ?>
</body>
</html>


</html>