<?php
session_start();
include('../config/config.php');

// Establecer las cabeceras para indicar que la respuesta es en formato JSON
header('Content-Type: application/json');

/**
 * Aumentar cantidad del producto en el carrito
 */
if (isset($_POST["aumentarCantidad"])) {
    $idProducto         = $_POST['idProducto'];
    $tokenCliente       = $_POST['tokenCliente'];
    $cantidadProducto   = $_POST['aumentarCantidad'];

    $UpdateCant = "UPDATE pedidostemporales 
                   SET cantidad = '$cantidadProducto' 
                   WHERE tokenCliente = '$tokenCliente' 
                   AND idProducto = '$idProducto'";
    $result = mysqli_query($con, $UpdateCant);

    $responseData = array(
        'estado' => 'OK',
        'totalPagar' => totalAccionAumentarDisminuir($con, $tokenCliente)
    );
    echo json_encode($responseData);
}

/**
 * Agregar al carrito de compra el producto
 */
if (isset($_POST["accion"]) && $_POST["accion"] == "addCar") {
    $_SESSION['tokenStoragel'] = $_POST['tokenCliente'];
    $idProducto                = $_POST['idProducto'];
    $tokenCliente              = $_POST['tokenCliente'];

    $ConsultarProduct = "SELECT * FROM pedidostemporales 
                         WHERE tokenCliente = '$tokenCliente' 
                         AND idProducto = '$idProducto'";
    $jqueryProduct = mysqli_query($con, $ConsultarProduct);

    if (mysqli_num_rows($jqueryProduct) > 0) {
        // Si ya existe, se incrementa la cantidad
        $DataProducto = mysqli_fetch_array($jqueryProduct);
        $newCantidad = $DataProducto['cantidad'] + 1;

        $UdateCantidad = "UPDATE pedidostemporales 
                          SET cantidad = '$newCantidad' 
                          WHERE idProducto = '$idProducto' 
                          AND tokenCliente = '$tokenCliente'";
        mysqli_query($con, $UdateCantidad);
    } else {
        // Si no existe, se inserta un nuevo registro
        $InsertProduct = "INSERT INTO pedidostemporales (idProducto, cantidad, tokenCliente) 
                          VALUES ('$idProducto', '1', '$tokenCliente')";
        mysqli_query($con, $InsertProduct);
    }

    $SqlTotalProduct = "SELECT SUM(cantidad) AS totalProd 
                        FROM pedidostemporales 
                        WHERE tokenCliente = '{$_SESSION['tokenStoragel']}' 
                        GROUP BY tokenCliente";
    $jqueryTotalProduct = mysqli_query($con, $SqlTotalProduct);
    $DataTotalProducto = mysqli_fetch_array($jqueryTotalProduct);
    echo $DataTotalProducto['totalProd'];
}

/**
 * Disminuir cantidad de mi carrito de compra
 */
if (isset($_POST["accion"]) && $_POST["accion"] == "disminuirCantidad") {
    $_SESSION['tokenStoragel'] = $_POST['tokenCliente'];
    $idProducto = mysqli_real_escape_string($con, $_POST['idProducto']);
    $tokenCliente = mysqli_real_escape_string($con, $_POST['tokenCliente']);
    $cantidad_Disminuida = mysqli_real_escape_string($con, $_POST['cantidad_Disminuida']);

    if ($cantidad_Disminuida == 0) {
        $DeleteRegistro = "DELETE FROM pedidostemporales 
                           WHERE tokenCliente = '$tokenCliente' 
                           AND idProducto = '$idProducto'";
        mysqli_query($con, $DeleteRegistro);
    } else {
        $UpdateCant = "UPDATE pedidostemporales 
                       SET cantidad = '$cantidad_Disminuida' 
                       WHERE tokenCliente = '$tokenCliente' 
                       AND idProducto = '$idProducto'";
        mysqli_query($con, $UpdateCant);
    }

    $responseData = array(
        'totalProductos' => totalProductosSeleccionados($con, $tokenCliente),
        'totalPagar' => totalAccionAumentarDisminuir($con, $tokenCliente),
        'estado' => 'OK'
    );
    echo json_encode($responseData);
}

/**
 * Borrar producto del carrito
 */
if (isset($_POST["accion"]) && $_POST["accion"] == "borrarproductoModal") {
    $tokenCliente = $_POST['tokenCliente'];
    $idProducto = $_POST['idProducto'];

    $DeleteRegistro = "DELETE FROM pedidostemporales 
                       WHERE idProducto = '$idProducto' 
                       AND tokenCliente = '$tokenCliente'";
    mysqli_query($con, $DeleteRegistro);

    $respData = array(
        'totalProductos' => totalProductosSeleccionados($con, $tokenCliente),
        'totalPagar' => totalAccionAumentarDisminuir($con, $tokenCliente),
        'estado' => 'OK'
    );
    echo json_encode($respData);
}

/**
 * Total productos en mi carrito de compra
 */
function totalProductosSeleccionados($con, $tokenCliente) {
    $queryTotalProduct = "SELECT SUM(cantidad) AS totalProduct 
                          FROM pedidostemporales 
                          WHERE tokenCliente = '$tokenCliente'";
    $result = mysqli_query($con, $queryTotalProduct);
    $row = mysqli_fetch_array($result);
    return $row['totalProduct'] ?? 0;
}
?>
