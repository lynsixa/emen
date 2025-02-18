<?php
session_start();
include('config/config.php');

/**
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
    }
}

/**
 * Retornando productos del carrito de compra
 */
function mi_carrito_de_compra($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
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
 */
function iconoCarrito($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
        $sqlTotalProduct = "SELECT SUM(cantidad) AS totalProd 
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
 */
function totalAcumuladoDeuda($con)
{
    if (!empty($_SESSION['tokenStoragel'])) {
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
