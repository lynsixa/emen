
<?php
session_start();
include('config/config.php');

/**
 * Obtener todos los productos disponibles en la tienda
 */
function getProductData($con)
{
    $sqlProducts = "SELECT 
            p.idProducto AS prodId,
            c.nombre,
            p.precio,
            c.foto1
        FROM 
            producto AS p
        INNER JOIN
            categoria AS c
        ON 
            c.producto_idProducto = p.idProducto";
    $queryProducts = mysqli_query($con, $sqlProducts);
    
    return $queryProducts ?: false;
}

/**
 * Obtener detalles de un producto seleccionado
 */
function detalles_producto_seleccionado($con, $idProd)
{
    $sqlDetalleProducto = "SELECT 
            p.idProducto AS prodId,
            c.nombre,
            p.precio,
            c.descripcion,
            c.foto1, c.foto2, c.foto3
        FROM 
            producto AS p
        INNER JOIN
            categoria AS c
        WHERE 
            p.idProducto = '" . mysqli_real_escape_string($con, $idProd) . "' LIMIT 1";
    $queryProductoSeleccionado = mysqli_query($con, $sqlDetalleProducto);
    
    return $queryProductoSeleccionado ?: false;
}

/**
 * Verificar si el carrito está vacío
 */
function validando_carrito()
{
    if (empty($_SESSION['tokenStoragel'])) {
        return '<div class="alert alert-warning">Tu carrito está vacío.</div>';
    }
}

/**
 * Obtener productos del carrito
 */
function mi_carrito_de_compra($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
        $sqlCarrito = "SELECT 
                p.idProducto AS prodId,
                c.nombre AS nameProd,
                p.precio,
                c.foto1,
                cr.idPedidoTemporal AS cartId,
                cr.cantidad
            FROM producto AS p
            INNER JOIN categoria AS c ON c.producto_idProducto = p.idProducto
            INNER JOIN carrito AS cr ON p.idProducto = cr.producto_idProducto
            WHERE cr.tokenCliente = '" . mysqli_real_escape_string($con, $_SESSION['tokenStoragel']) . "'";
        $queryCarrito = mysqli_query($con, $sqlCarrito);
        
        return $queryCarrito ?: false;
    }
    return [];
}

/**
 * Contador de productos en el carrito
 */
function iconoCarrito($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
        $sqlTotalProduct = "SELECT SUM(cantidad) AS totalProd 
                            FROM carrito 
                            WHERE tokenCliente = '" . mysqli_real_escape_string($con, $_SESSION['tokenStoragel']) . "'";
        $queryTotalProduct = mysqli_query($con, $sqlTotalProduct);
        $dataTotalProducto = mysqli_fetch_array($queryTotalProduct);
        
        return '<span id="checkout_items" class="checkout_items">' . ($dataTotalProducto['totalProd'] ?? 0) . '</span>';
    }
    return '<span id="checkout_items" class="checkout_items">0</span>';
}

/**
 * Calcular el total del carrito
 */
function totalAcumuladoDeuda($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
        $sqlDeudaTotal = "SELECT SUM(p.precio * cr.cantidad) AS totalPagar 
                          FROM producto AS p
                          INNER JOIN carrito AS cr
                          ON p.idProducto = cr.producto_id
                          WHERE cr.tokenCliente = '" . mysqli_real_escape_string($con, $_SESSION["tokenStoragel"]) . "'";
        $queryDeuda = mysqli_query($con, $sqlDeudaTotal);
        $dataDeuda = mysqli_fetch_array($queryDeuda);
        
        return number_format($dataDeuda['totalPagar'] ?? 0, 0, '', '.');
    }
    return 0;
}