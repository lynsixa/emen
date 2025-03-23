<<<<<<< HEAD
=======

>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
<?php
session_start();
include('config/config.php');

/**
<<<<<<< HEAD
 * Función para obtener todos los productos de mi tienda
 */
function getProductData($con)
{
    $sqlProducts = ("SELECT 
            p.idProducto AS prodId,
            p.nombreProd,
            p.precio,
            f.foto1
        FROM 
            producto AS p
        INNER JOIN
            fotoproducto AS f
        ON 
            p.idProducto = f.idProducto;
    ");
    $queryProducts = mysqli_query($con, $sqlProducts);

    if (!$queryProducts) {
        error_log("Error en la consulta de productos: " . mysqli_error($con));
        return false;
    }
    return $queryProducts;
}

/**
 * Detalles del producto seleccionado
 */
function detalles_producto_seleccionado($con, $idProd)
{
    $sqlDetalleProducto = ("SELECT 
            p.idProducto AS prodId,
            p.nombreProd,
            p.descripcion,
            p.precio,
            f.foto1,
            f.foto2,
            f.foto3
        FROM 
            producto AS p
        INNER JOIN
            fotoproducto AS f
        ON 
            p.idProducto = f.idProducto
        WHERE 
            p.idProducto = '" . mysqli_real_escape_string($con, $idProd) . "'
        LIMIT 1;
    ");
    $queryProductoSeleccionado = mysqli_query($con, $sqlDetalleProducto);

    if (!$queryProductoSeleccionado) {
        error_log("Error en la consulta del producto seleccionado: " . mysqli_error($con));
        return false;
    }
    return $queryProductoSeleccionado;
}

/**
 * Función para validar si el carrito tiene algún producto
 */
function validando_carrito()
{
    if (empty($_SESSION['tokenStoragel'])) {  // Corregido con empty()
        return '
            <div class="row align-items-center">
                <div class="col-lg-12 text-center mt-5">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Ops.!</strong> Tu carrito está vacío.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-12 text-center mt-5 mb-5">
                    <a href="./" class="red_button btn_raza" style="padding: 5px 20px;">
                    <i class="bi bi-arrow-left-circle"></i>  Volver a la Tienda</a>
                </div>
            </div>';
=======
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
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
    }
}

/**
<<<<<<< HEAD
 * Retornando productos del carrito de compra
=======
 * Obtener productos del carrito
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
 */
function mi_carrito_de_compra($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
<<<<<<< HEAD
        $sqlCarritoCompra = ("SELECT 
                p.idProducto AS prodId,
                p.nombreProd AS nameProd,
                p.descripcion,
                p.Precio AS precio,
                f.foto1,
                pt.idpedidotemporal AS tempId,
                pt.producto_id,
                pt.cantidad,
                pt.tokenCliente
            FROM 
                producto AS p
            INNER JOIN
                fotoproducto AS f ON p.idProducto = f.idProducto
            INNER JOIN
                pedidostemporales AS pt ON p.idProducto = pt.producto_id
            WHERE 
                pt.tokenCliente = '" . mysqli_real_escape_string($con, $_SESSION['tokenStoragel']) . "'
        ");
        $queryCarrito = mysqli_query($con, $sqlCarritoCompra);

        if (!$queryCarrito) {
            error_log("Error en la consulta del carrito: " . mysqli_error($con));
            return false;
        }
        return $queryCarrito;
    } else {
        return [];  // Retorna un arreglo vacío si no hay productos en el carrito
    }
}

/**
 * Mostrar la cantidad de productos seleccionados en el icono de carrito
=======
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
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
 */
function iconoCarrito($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
        $sqlTotalProduct = "SELECT SUM(cantidad) AS totalProd 
<<<<<<< HEAD
                            FROM pedidostemporales 
                            WHERE tokenCliente = '" . mysqli_real_escape_string($con, $_SESSION['tokenStoragel']) . "' 
                            GROUP BY tokenCliente";
        $jqueryTotalProduct = mysqli_query($con, $sqlTotalProduct);

        if ($jqueryTotalProduct && mysqli_num_rows($jqueryTotalProduct) > 0) {
            $dataTotalProducto = mysqli_fetch_array($jqueryTotalProduct);
            return '<span id="checkout_items" class="checkout_items">' . $dataTotalProducto["totalProd"] . '</span>';
        } else {
            return '<span id="checkout_items" class="checkout_items">0</span>';
        }
    } else {
        return '<span id="checkout_items" class="checkout_items">0</span>';
    }
}

/**
 * Calcular el total acumulado de la deuda del carrito
=======
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
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
 */
function totalAcumuladoDeuda($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
<<<<<<< HEAD
        $SqlDeudaTotal = ("
            SELECT SUM(p.Precio * pt.cantidad) AS totalPagar 
            FROM producto AS p
            INNER JOIN pedidostemporales AS pt
            ON p.idProducto = pt.producto_id
            WHERE pt.tokenCliente = '" . mysqli_real_escape_string($con, $_SESSION["tokenStoragel"]) . "'
        ");
        $jqueryDeuda = mysqli_query($con, $SqlDeudaTotal);

        if ($jqueryDeuda && mysqli_num_rows($jqueryDeuda) > 0) {
            $dataDeuda = mysqli_fetch_array($jqueryDeuda);
            return number_format($dataDeuda['totalPagar'], 0, '', '.');
        }
    }
    return 0;  // Si no hay productos o deuda, retornamos 0
}
=======
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
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
