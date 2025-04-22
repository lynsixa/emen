<?php
require 'vendor/autoload.php';
require 'conexion.php';  // Asegúrate de que la conexión a la base de datos esté configurada correctamente.

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Verificamos qué botón se ha presionado
if (isset($_POST['descargar_usuarios'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Usuarios');

    // Encabezados
    $sheet->setCellValue('A1', 'Nombres');
    $sheet->setCellValue('B1', 'Apellidos');
    $sheet->setCellValue('C1', 'Documento');
    $sheet->setCellValue('D1', 'Correo');
    $sheet->setCellValue('E1', 'Rol');
    $sheet->setCellValue('F1', 'Tipo Documento');

    // Consulta de datos
    $sql = "SELECT 
                u.Nombres, u.Apellidos, u.Documento, u.Correo,
                r.Descripcion AS Rol,
                td.Descripcion AS TipoDocumento
            FROM Usuario u
            LEFT JOIN Roles r ON u.Roles_idRoles = r.idRoles
            LEFT JOIN `Tipo de documento` td ON u.`Tipo de documento_idTipodedocumento` = td.idTipodedocumento";

    $resultado = $conexion->query($sql);

    // Insertar datos
    $fila = 2;
    while ($row = $resultado->fetch_assoc()) {
        $sheet->setCellValue("A$fila", $row['Nombres']);
        $sheet->setCellValue("B$fila", $row['Apellidos']);
        $sheet->setCellValue("C$fila", $row['Documento']);
        $sheet->setCellValue("D$fila", $row['Correo']);
        $sheet->setCellValue("E$fila", $row['Rol']);
        $sheet->setCellValue("F$fila", $row['TipoDocumento']);
        $fila++;
    }

    // Cabeceras HTTP para archivo Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="informe_usuarios.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    // Limpiar el buffer antes de la salida
    ob_end_clean();
    $writer->save('php://output');
    exit;
}

if (isset($_POST['descargar_ordenes'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Órdenes');

    // Encabezados
    $sheet->setCellValue('A1', 'ID Orden');
    $sheet->setCellValue('B1', 'Fecha');
    $sheet->setCellValue('C1', 'Descripción Orden');
    $sheet->setCellValue('D1', 'Precio Final');
    $sheet->setCellValue('E1', 'Precio Producto');
    $sheet->setCellValue('F1', 'Categoría');
    $sheet->setCellValue('G1', 'Solicitud');
    $sheet->setCellValue('H1', 'Entrega');

    // Consulta de datos
    $sql = "
    SELECT 
        o.idOrden, 
        o.Fecha, 
        o.Descripcion AS DescripcionOrden, 
        o.PrecioFinal,
        p.Precio AS PrecioProducto, 
        c.Nombre AS Categoria,
        s.Descripcion AS Solicitud,
        e.Descripcion AS Entrega
    FROM Orden o
    LEFT JOIN Producto p ON o.Producto_idProducto = p.idProducto
    LEFT JOIN Categoria c ON p.idProducto = c.Producto_idProducto
    LEFT JOIN Solicitud s ON o.Solicitud_idSolicitud = s.idSolicitud
    LEFT JOIN Entrega e ON s.Entrega_idEntrega = e.idEntrega
    ";

    $resultado = $conexion->query($sql);

    // Insertar datos
    $fila = 2;
    while ($row = $resultado->fetch_assoc()) {
        $sheet->setCellValue("A$fila", $row['idOrden']);
        $sheet->setCellValue("B$fila", $row['Fecha']);
        $sheet->setCellValue("C$fila", $row['DescripcionOrden']);
        $sheet->setCellValue("D$fila", $row['PrecioFinal']);
        $sheet->setCellValue("E$fila", $row['PrecioProducto']);
        $sheet->setCellValue("F$fila", $row['Categoria']);
        $sheet->setCellValue("G$fila", $row['Solicitud']);
        $sheet->setCellValue("H$fila", $row['Entrega']);
        $fila++;
    }

    // Cabeceras HTTP para archivo Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="informe_ordenes.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);

    // Limpiar el buffer antes de la salida
    ob_end_clean();
    $writer->save('php://output');
    exit;
}
?>
